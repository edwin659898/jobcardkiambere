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
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class PrickingOutController extends Controller
{
    //view pricking out and its Activities
    public function Pricking()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 13)
            ->first();
        return Inertia::render('PrickingOut/PrickingOutActivities', [
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

        return Inertia::render('PrickingOut/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //material acquisition in PrickingOut
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('PrickingOut/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //this method works for all other activities in PrickingOut
    public function AllOtherActivities($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $trees = Tree::select('id', 'tree_number')->get();

        return Inertia::render('PrickingOut/AllOtherActivities', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Trees' => $trees,
        ]);
    }

    public function ChemicalPreperation($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $chemicals = Chemical::pluck('name','id');


        return Inertia::render('PrickingOut/ChemicalPreparation', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Chemicals' => $chemicals,
        ]);
    }

    public function PlantSeedsToPottingTubes($id)
    {
        $jobCard = JobCard::findOrFail($id);
        $jobCard->load([
            'childactivity.roles',
        ]);

        $data = BedPreparation::where('child_activity_id' , Session::get('current_activity_id'))
            ->where('job_card_id' , $id)->get();

        $groupedData = $data->groupBy('extra_information');

        $combinedData = [];

        foreach ($groupedData as $groupId => $group) {
            
            $combinedData = $groupedData->map(function ($group) {
                return [
                    'seed_bed_name' => $group[0]['name'],
                    'seed_bed_uom' => $group[0]['uom'],
                    'seed_bed_quantity' => $group[0]['quantity'],
                    'tree_number_name' => $group[1]['name'],
                    'tree_number_uom' => $group[1]['uom'],
                    'tree_number_quantity' => $group[1]['quantity'],
                    'date' => $group[1]['created_at'],
                ];
            });

        }

        $start_date = $this->GetDate($id);

        $trees = Tree::select('id', 'tree_number')->get();

        $searchTerm = "Labelling of the seedling beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
                ->where('child_activity_id', $child_activity->id)->pluck('name');

        return Inertia::render('PrickingOut/PlantInPottingTubes', [
            'Jobcard' => $jobCard,
            'BedPrepActivities' => $combinedData,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
            'Trees' => $trees,
        ]);
    }

    public function StorePlantSeedsToPottingTubes(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'uom' => 'required',
            'quantity' => 'required',
            'name' => 'nullable',
            'treeNumber' => 'required',
            'tree_uom' => 'required',
            'tree_quantity' => 'required',
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

        $random = rand(100,1000);

        BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'name' => $request->name,
            'quantity' => $data['quantity'],
            'extra_information' => $random,
            'uom' => $data['uom'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'name' => $request->treeNumber['tree_number'],
            'quantity' => $data['tree_quantity'],
            'extra_information' => $random,
            'uom' => $data['tree_uom'],
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
