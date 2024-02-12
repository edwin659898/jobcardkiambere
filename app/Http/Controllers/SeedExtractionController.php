<?php

namespace App\Http\Controllers;

use App\Models\ChildActivity;
use App\Models\Fruit;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Stock;
use App\Models\StockControl;
use App\Models\Timeline;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class SeedExtractionController extends Controller
{
    //view Seed Extraction and its Activities
    public function SeedExtraction()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 6)
            ->first();
        return Inertia::render('SeedExtraction/SeedExtractionActivities', [
            'data' => $data,
        ]);
    }

    //check jobcards available in specific activity
    public function ChildActivity($id)
    {
        Session::put('current_activity_id', $id);
        $child = ChildActivity::findOrFail($id);
        $user_roles = auth()->user()->roles()->pluck('role')->toArray();
        $activity_role = $child->roles()->pluck('role')->toArray();
        abort_unless(count(array_intersect($user_roles, $activity_role)) > 0, 403);
        $parent = $child->parent;
        $currentCard = JobCard::all();

        return Inertia::render('SeedExtraction/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //issue from stock
    public function StockIssue($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedExtraction/IssueFromStock', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    //store data for stock issue
    public function StoreIssuedStock(Request $request, $id)
    {

        $data = $request->validate([
            'quantity' => 'required',
        ]);

        $fruit = Fruit::findOrFail($id);

        $jobcard = JobCard::findOrFail($fruit->job_card_id);

        $stock_available = StockControl::where('job_card_id', $jobcard->id)
            ->where('tree_id', $fruit->tree_id)
            ->where('child_activity_id', '<', Session::get('current_activity_id'))
            ->orderBy('child_activity_id', 'Desc')
            ->first();

        abort_if(
            !$stock_available || $stock_available->quantity_available < $request->quantity,
            403,
            'Quantity cannot be more than stock available'
        );

        $timeline = Timeline::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if (!$timeline) {
            Timeline::create([
                'start_date' => Carbon::now()->format('Y-m-d, H:i:s'),
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        Stock::create([
            'fruit_id' => $fruit->id,
            'job_card_id' => $jobcard->id,
            'quantity' => $request->quantity,
            'issued_by' => auth()->id(),
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        $stock_available->update([
            'quantity_available' => $stock_available->quantity_available - (int)$request->quantity
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //store data for stock issue
    public function ReceivedQuantity(Request $request, $id)
    {

        $data = $request->validate([
            'quantity' => 'required',
        ]);


        Stock::find($id)->update([
            'damage_seed' => $request->quantity,
            'received_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //view fruit distribution depulp and dry
    public function DistributionCrackingAndWeighing($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedExtraction/DistributionOfNuts', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    //view seed sorting
    public function SeedSorting($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedExtraction/SeedSorting', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }


    //store quantity of nut storage
    public function StoreSeedSorting(Request $request, $id)
    {

        $data = $request->validate([
            'Goodquantity' => 'required',
            'Badquantity' => 'required',
        ]);

        $fruit = Fruit::findOrFail($id);

        $jobcard = JobCard::findOrFail($fruit->job_card_id);

        $timeline = Timeline::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if (!$timeline) {
            Timeline::create([
                'start_date' => Carbon::now()->format('Y-m-d, H:i:s'),
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        Stock::create([
            'fruit_id' => $fruit->id,
            'job_card_id' => $jobcard->id,
            'quantity' => $data['Goodquantity'],
            'damage_seed' => $data['Badquantity'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //issue from stock
    public function IssueForStorage($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedExtraction/StorageIssue', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    public function StoreIssueForStorage(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'required',
        ]);


        $stock = Stock::find($id);

        $stock->update([
            'damage_seed' => $request->quantity,
            'received_by' => auth()->id(),
        ]);

        $fruit = Fruit::findOrFail($stock->fruit_id);

        $jobcard = JobCard::findOrFail($stock->job_card_id);


        $timeline = Timeline::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if (!$timeline) {
            Timeline::create([
                'start_date' => Carbon::now()->format('Y-m-d, H:i:s'),
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        $stock_available = StockControl::where('job_card_id', $jobcard->id)
            ->where('tree_id', $fruit->tree_id)
            ->where('child_activity_id', Session::get('current_activity_id'))
            ->first();

        if ($stock_available) {
            $stock_available->update([
                'quantity_available' => $stock_available->quantity_available + (int)$request->quantity
            ]);
        } else {
            StockControl::create([
                'quantity_available' => (int)$request->quantity,
                'tree_id' => $fruit->tree_id,
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        return redirect()->back()->with('success', 'Update Successfully');
    }

    private function GetDate($id)
    {
        $jobCard = JobCard::findOrFail($id);
        $find_start_date = Timeline::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if ($find_start_date) {
            $start_date = $find_start_date->start_date;
        } else {
            $start_date = Carbon::now();
        }

        return $start_date;
    }

    private function GetJobcard($id)
    {
        $jobCard = JobCard::findOrFail($id);
        $jobCard->load([
            'childactivity.roles',
            'fruits.tree',
            'fruits.stocks' => function ($query) use ($jobCard) {
                $query->with('user')->where(['child_activity_id' => Session::get('current_activity_id')]);
            }
        ]);

        return $jobCard;
    }
}
