<?php

namespace App\Http\Controllers;

use App\Models\ChildActivity;
use App\Models\Fruit;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Signature;
use App\Models\Stock;
use App\Models\StockControl;
use App\Models\Timeline;
use App\Models\Tree;
use App\Models\Truck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class FruitStorageController extends Controller
{
    //view Fruit storage and its Activities
    public function FruitStorage()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 4)
            ->first();
        return Inertia::render('FruitStorage/FruitStorageActivities', [
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

        return Inertia::render('FruitCollection/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //View truck Fruit Arrival to Nursery,
    public function TruckArrivalToNursery($id)
    {
        $jobCard = JobCard::findOrFail($id);
        $current_activity_number = ChildActivity::find(Session::get('current_activity_id'))->child_number;
        $prev_activity_number = ($current_activity_number - 1);
        $prev_activity = ChildActivity::where('child_number','<',(string)$prev_activity_number)->orderBy('child_number','desc')->first();

        $jobCard->load([
            'childactivity.roles',
            'stocks' => function ($query) use ($prev_activity) {
                $query->with('user','truck','fruit.tree')->where(['child_activity_id' => $prev_activity->id]);
            }
        ]);


        return Inertia::render('FruitStorage/TruckArrival', [
            'Jobcard' => $jobCard,
        ]);

    }

    //update time when truck arrived
    public function TruckArrivalTimes(Request $request, $id)
    {
        $data = $request->validate([
            'arrival_date' => 'required',
            'selectedTrucks'  => 'required',
        ]);

        foreach($data['selectedTrucks'] as $key => $value){
            $stock = Stock::find($value);

            $st = $stock->update([
                'arrival_time' => Carbon::parse($data['arrival_date'])->format('Y-m-d H:i')
            ]);
        }

        $jobcard = JobCard::findOrFail($request->jobcard_id);

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

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function QuantityCheckAtNursery($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('FruitStorage/QuantityCheck', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    //store data for quantity check at nursery
    public function StoreQuantityCheckAtNursery(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'required',
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
            'quantity' => $request->quantity,
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //view quality check blade
    public function QualityCheckAtNursery($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $signed = Signature::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->pluck('role_id')->toArray();

        dd($jobCard);
        return Inertia::render('FruitStorage/QualityCheck', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Signed' => $signed,
        ]);
    }

    //store data for quality check at nursery
    public function StoreQualityCheckAtNursery(Request $request, $id)
    {
        $data = $request->validate([
            'quantityOk' => 'required',
            'quantityNotOk' => 'required',
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
            'quantity' => $request->quantityOk,
            'damage_seed' => $request->quantityNotOk,
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //sign for quality check by all Activity owners
    public function signQualityCheck(Request $request, $id)
    {
        $jobcard = JobCard::findOrFail($id);
        $signatures_required_in_this_activity = ChildActivity::find(Session::get('current_activity_id'))->roles->pluck('id')->toArray();

        $has_already_been_signed = Signature::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->pluck('role_id')->toArray();

        $has_not_been_signed = array_diff($signatures_required_in_this_activity, $has_already_been_signed);
        $allowed_to_sign = array_intersect($has_not_been_signed, auth()->user()->roles->pluck('id')->toArray());
        foreach ($allowed_to_sign as $key => $value) {
            Signature::Create([
                'user_id' => auth()->id(),
                'job_card_id' => $jobcard->id,
                'role_id' => $value,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        $signatures_provided_in_this_stage = Signature::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        if (count($signatures_required_in_this_activity) <= $signatures_provided_in_this_stage->count()) {

            $next_activity = ChildActivity::where('id', '>', $jobcard->current_child_id)->first();
            $current_date = Timeline::where(['job_card_id' => $jobcard->id, 'child_activity_id' => Session::get('current_activity_id')])
            ->whereDate('created_at', Carbon::today())
            ->first();
            if ($current_date) {
                $current_date->update(['end_date' => now()->format('Y-m-d, H:i:s')]);
            }

            $jobcard->update(['current_child_id' => $next_activity->id, 'current_parent_id' => $next_activity->parent_activity_id]);
        }

        return redirect()->route('FS activity', $jobcard->current_child_id)->with('success', 'Update Successfully');
    }

    //view quality check blade
    public function Disinfection($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $signed = Signature::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->pluck('role_id')->toArray();

        return Inertia::render('FruitStorage/Disinfection', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Signed' => $signed,
        ]);
    }

     //storage after disinfection
     public function StorageAfterDisinfection($id)
     {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);
 
         $signed = Signature::where([
             'job_card_id' => $jobCard->id,
             'child_activity_id' => Session::get('current_activity_id')
         ])->pluck('role_id')->toArray();
 
         return Inertia::render('FruitStorage/StorageAfterDisinfection', [
             'Jobcard' => $jobCard,
             'BeginDate' => $start_date,
             'Signed' => $signed,
         ]);
     }

     //store data for quantity check at nursery
    public function StoreQuantityAfterDisinfection(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'required',
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
            'quantity' => $request->quantity,
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        $stock_available = StockControl::where('job_card_id',$jobcard->id)
                        ->where('tree_id',$fruit->tree_id)
                        ->where('child_activity_id',Session::get('current_activity_id'))
                        ->first();

        if($stock_available){
            $stock_available->update([
                'quantity_available' => $stock_available->quantity_available + (int)$request->quantity
            ]);
        }else{
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
        ])->whereDate('created_at',Carbon::today())->first();

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
