<?php

namespace App\Http\Controllers;

use App\Models\BedPreparation;
use App\Models\Chemical;
use App\Models\ChildActivity;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Timeline;
use App\Models\Tree;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class FirstHardeningController extends Controller
{
    //view first hardening out and its Activities
    public function FirstHardening()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 14)
            ->first();
        return Inertia::render('FirstHardening/FirstHardeningActivities', [
            'data' => $data,
        ]);
    }

    //check jobcards available in specific activity
    public function ChildActivity($id)
    {
        Session::put('current_activity_id', $id);
        $child = ChildActivity::findOrFail($id);
        // $user_roles = auth()->user()->roles()->pluck('role')->toArray();
        $activity_role = $child->roles()->pluck('role')->toArray();
        // abort_unless(count(array_intersect($user_roles, $activity_role)) > 0, 403);
        $parent = $child->parent;
        $currentCard = JobCard::all();

        return Inertia::render('FirstHardening/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //material acquisition in FirstHardening
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('FirstHardening/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    public function CoveringAndOpening($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $searchTerm = "Labelling of the seedling beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
                ->where('child_activity_id', $child_activity->id)->pluck('name');

        return Inertia::render('FirstHardening/CoveringAndOpening', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
        ]);
    }

    //this method works for all other activities in FirstHardening
    public function AllOtherActivities($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $searchTerm = "Labelling of the seedling beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
                ->where('child_activity_id', $child_activity->id)->pluck('name');

        return Inertia::render('FirstHardening/AllOtherActivities', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
        ]);
    }

    public function Sorting($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $searchTerm = "Labelling of the seedling beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
                ->where('child_activity_id', $child_activity->id)->pluck('name');

        $trees = Tree::select('id', 'tree_number')->get();

        return Inertia::render('FirstHardening/Sorting', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
            'Trees' => $trees,
        ]);
    }

    public function StoreSorting(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'uom' => 'required',
            'quantityOk' => 'required',
            'quantityNotOk' => 'required',
            'name' => 'required',
            'treeNumber' => 'required'
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
            'quantity' => $data['quantityOk'],
            'extra_information' => $data['quantityNotOk'],
            'uom' => $data['uom'],
            'tree_id' => $data['treeNumber']['id'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    public function ChemicalSpraying($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $chemicals = Chemical::pluck('name');
        $searchTerm = "Labelling of the seedling beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
                ->where('child_activity_id', $child_activity->id)->pluck('name');

        return Inertia::render('FirstHardening/ChemicalApplication', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
            'Chemicals' => $chemicals,
        ]);
    }

    public function StoreChemicalSpraying(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'uom' => 'required',
            'quantity' => 'required',
            'seed_bed_number' => 'required',
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
            'extra_information' => $data['seed_bed_number'],
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
