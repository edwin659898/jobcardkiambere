<?php

namespace App\Http\Controllers;

use App\Models\ChildActivity;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Timeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class SeedlingHardeningController extends Controller
{
        //view seedling hardening out and its Activities
        public function SeedHardening()
        {
            $data = ParentActivity::with('childs')
                ->where('parent_number', 14)
                ->first();
            return Inertia::render('SeedlingHardening/SeedlingHardeningActivities', [
                'data' => $data,
            ]);
        }
    
        //check jobcards available in specific activity
        public function ChildActivity($id)
        {
            $child = ChildActivity::findOrFail($id);
            $user_roles = auth()->user()->roles()->pluck('role')->toArray();
            $activity_role = $child->roles()->pluck('role')->toArray();
            abort_unless(count(array_intersect($user_roles, $activity_role)) > 0, 403);
            $parent = $child->parent;
            $currentCard = JobCard::where(['current_parent_id' => $parent->id, 'current_child_id' => $child->id])
                ->get();
    
            return Inertia::render('SeedlingHardening/Table', [
                'childData' => $child,
                'currentCards' => $currentCard,
            ]);
        }
    
        //material acquisition in PrickingOut
        public function MaterialAcquisition($id)
        {
            $jobCard = $this->GetJobcard($id);
            $start_date = $this->GetDate($id);
    
            return Inertia::render('SeedlingHardening/MaterialAcquisition', [
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
    
            return Inertia::render('SeedlingHardening/AllOtherActivities', [
                'Jobcard' => $jobCard,
                'BeginDate' => $start_date,
                'Name' => 'Compartment',
            ]);
        }
    
        private function GetDate($id)
        {
            $jobCard = JobCard::findOrFail($id);
            $find_start_date = Timeline::where([
                'job_card_id' => $jobCard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ])->first();
    
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
                'childactivity.bedPreparation' => function ($query) use ($jobCard) {
                    $query->where(['job_card_id' => $jobCard->id]);
                }
            ]);
    
            return $jobCard;
        }
}
