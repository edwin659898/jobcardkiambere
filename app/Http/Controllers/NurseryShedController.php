<?php

namespace App\Http\Controllers;

use App\Models\ChildActivity;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Signature;
use App\Models\Timeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class NurseryShedController extends Controller
{
    //view nursery shed construction activities
    public function NurseryShed()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 11)
            ->first();
        return Inertia::render('NurseryShed/NurseryShedActivities', [
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

        return Inertia::render('NurseryShed/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //site identification
    public function Planning($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $signed = Signature::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->pluck('role_id')->toArray();

        return Inertia::render('NurseryShed/Planning', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Signed' => $signed,
        ]);
    }
    
        //update signature for Fruit Collection approval plan
        public function updatePlanning(Request $request, $id)
        {
            $data = $request->validate([
                'signature' => ['required'],
            ]);
    
            $jobCard = JobCard::findOrFail($id);
    
            $timeline = Timeline::where(['job_card_id' => $id, 'child_activity_id' => Session::get('current_activity_id')])->whereDate('created_at', Carbon::today())->first();
            if ($timeline == null) {
                Timeline::create([
                    'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
                    'child_activity_id' => Session::get('current_activity_id'), 'job_card_id' => $jobCard->id,
                ]);
            }
    
            $current_signatures = Signature::where([
                'job_card_id' => $jobCard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ])->pluck('role_id')->toArray();
    
            $request_signatures = $request->signature;
    
            $new_signatures = array_diff($request_signatures, $current_signatures);
            foreach ($new_signatures as $key => $value) {
                Signature::Create([
                    'user_id' => auth()->id(),
                    'job_card_id' => $jobCard->id,
                    'role_id' => $value,
                    'child_activity_id' => Session::get('current_activity_id')
                ]);
            }
    
            $signature_no = ChildActivity::find(Session::get('current_activity_id'))->roles->pluck('id')->count();
    
            if ($signature_no == count($request->signature)) {
                $next_activity = ChildActivity::where('id', '>', $jobCard->current_child_id)->first();
                $current_date = Timeline::where(['job_card_id' => $jobCard->id, 'child_activity_id' => Session::get('current_activity_id')])
                    ->whereDate('created_at',Carbon::today())    
                    ->first();
                if($current_date){
                    $current_date->update(['end_date' => now()->format('Y-m-d, H:i:s')]);
                }
                
                $jobCard->update(['current_child_id' => $next_activity->id, 'current_parent_id' => $next_activity->parent_activity_id]);
            }
    
            return redirect()->route('Dashboard')->with('success', 'Update Successfully');
        }

    //site identification
    public function SiteIdentificationForConstruction($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('NurseryShed/SiteIdentification', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Compartment Name',
        ]);
    }

    //material acquisition and pole sourcing for shed construction
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('NurseryShed/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //Shed construction
    public function ShedConstruction($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('NurseryShed/ShedConstruction', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //Communication
    public function Communication($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('NurseryShed/SiteIdentification', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Topic',
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
                $query->where(['child_activity_id' => Session::get('current_activity_id')]);
            }
        ]);

        return $jobCard;
    }
}
