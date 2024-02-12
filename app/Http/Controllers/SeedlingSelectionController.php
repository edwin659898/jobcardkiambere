<?php

namespace App\Http\Controllers;

use App\Models\BedPreparation;
use App\Models\ChildActivity;
use App\Models\Crate;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Timeline;
use App\Models\Tree;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class SeedlingSelectionController extends Controller
{
    //view seedling selection out and its Activities
    public function SeedlingSelection()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 16)
            ->first();
        return Inertia::render('SeedlingSelection/SeedlingSelectionActivities', [
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

        return Inertia::render('SeedlingSelection/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //material acquisition in SeedlingSelection
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedlingSelection/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //this method works for all other activities in SeedlingSelection
    public function AllOtherActivities($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedlingSelection/AllOtherActivities', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Compartment',
        ]);
    }

    public function SelectSeeds($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $crate_numbers = Crate::where('site', $jobCard->site)->pluck('name');

       $trees = Tree::select('id', 'tree_number')->get();

        return Inertia::render('SeedlingSelection/SelectSeeds', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Crates' => $crate_numbers,
            'Trees' => $trees,
        ]);
    }

    public function StoreSelectSeeds(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'uom' => 'required',
            'quantity' => 'required',
            'treeNumber' => 'required',
            'name' => 'required',
        ]);

        $jobcard = JobCard::findOrFail($id);

        $timeline = Timeline::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if (!$timeline) {
            Timeline::create([
                'start_date' => Carbon::parse($request->start_date)->format('Y-m-d h:i'),
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'name' => $request->name,
            'quantity' => $data['quantity'],
            'tree_id' => $data['treeNumber']['id'],
            'uom' => $data['uom'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

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
            'bedPrep' => function ($query) use ($jobCard) {
               $query->with('tree')->where(['child_activity_id' => Session::get('current_activity_id')]);
            }
        ]);

        return $jobCard;
    }
}
