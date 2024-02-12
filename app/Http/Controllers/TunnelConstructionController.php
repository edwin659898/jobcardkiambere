<?php

namespace App\Http\Controllers;

use App\Models\BedPreparation;
use App\Models\ChildActivity;
use App\Models\JobCard;
use App\Models\JobCardRecord;
use App\Models\ParentActivity;
use App\Models\Record;
use App\Models\Signature;
use App\Models\Timeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class TunnelConstructionController extends Controller
{
        //view tunnel construction
        public function SeedlingBedConstruction()
        {
            $data = ParentActivity::with('childs')
                ->where('parent_number', 12)
                ->first();
            return Inertia::render('TunnelConstruction/TunnelConstructionActivities', [
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

        return Inertia::render('TunnelConstruction/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //material acquisition and withies sourcing
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('TunnelConstruction/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //Transport withies to nursery and tunnels construction
    public function TransportWithies($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('TunnelConstruction/TransportWithies', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //Transport withies to nursery and tunnels construction
    public function LabelSeedlingBeds($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('TunnelConstruction/LabelSeedlingBeds', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    public function StoreLabelSeedlingBeds(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
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
            'name' => $data['name'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

     //Communication
     public function Communication($id)
     {
        $jobCard = JobCard::findOrFail($id);

        $document_required = Record::where('child_activity_id' , Session::get('current_activity_id'))->get();

        $jobCard->load([
            'signatures.role',
            'signatures.user',
            'Confirmedrecords.activityChild',
            'childactivity.roles',
            'signatures' => function ($query) use ($jobCard) {
                $query->where(['job_card_id' => $jobCard->id,'child_activity_id' => Session::get('current_activity_id')]);
            },
        ]);

        $signed = Signature::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->pluck('role_id')->toArray();

        $confirmed_records = JobCardRecord::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->pluck('record_id')->toArray();

        $confirmed_records_locations = JobCardRecord::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->pluck('location')->toArray();

        $find_start_date = Timeline::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->first();

        if ($find_start_date) {
            $start_date = $find_start_date->start_date;
        } else {
            $start_date = Carbon::now();
        }

         return Inertia::render('TunnelConstruction/Communication', [
             'Jobcard' => $jobCard,
             'BeginDate' => $start_date,
             'Signed' => $signed,
             'Records' => $confirmed_records,
             'ConfirmedLocations' => $confirmed_records_locations,
             'DocsRequired' => $document_required
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
