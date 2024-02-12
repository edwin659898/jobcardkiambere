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

class SecondHardeningController extends Controller
{
    //view second hardening out and its Activities
    public function SecondHardening()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 15)
            ->first();
        return Inertia::render('SecondHardening/SecondHardeningActivities', [
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

        return Inertia::render('SecondHardening/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

     //material acquisition in SecondHardening
     public function MaterialAcquisition($id)
     {
         $jobCard = $this->GetJobcard($id);
         $start_date = $this->GetDate($id);
 
         return Inertia::render('SecondHardening/MaterialAcquisition', [
             'Jobcard' => $jobCard,
             'BeginDate' => $start_date,
             'Name' => 'Item',
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
 
         return Inertia::render('SecondHardening/CoveringAndOpening', [
             'Jobcard' => $jobCard,
             'BeginDate' => $start_date,
             'BedNumbers' => $seed_bed_numbers,
         ]);
     }
 
     //this method works for all other activities in SecondHardening
     public function AllOtherActivities($id)
     {
         $jobCard = $this->GetJobcard($id);
         $start_date = $this->GetDate($id);
 
         $searchTerm = "Labelling of the seedling beds";
         $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();
 
         $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
                 ->where('child_activity_id', $child_activity->id)->pluck('name');
 
         return Inertia::render('SecondHardening/AllOtherActivities', [
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
 
         return Inertia::render('SecondHardening/Sorting', [
             'Jobcard' => $jobCard,
             'BeginDate' => $start_date,
             'BedNumbers' => $seed_bed_numbers,
             'Trees' => $trees,
         ]);
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
 
         return Inertia::render('SecondHardening/ChemicalApplication', [
             'Jobcard' => $jobCard,
             'BeginDate' => $start_date,
             'BedNumbers' => $seed_bed_numbers,
             'Chemicals' => $chemicals,
         ]);
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
