<?php

namespace App\Http\Controllers;

use App\Models\BedPreparation;
use App\Models\ChildActivity;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Timeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class PottingController extends Controller
{
    //view bed preperation to other site and its Activities
    public function Potting()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 10)
            ->first();
        return Inertia::render('Potting/PottingActivities', [
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

        return Inertia::render('Potting/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //material acquisition in potting
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('Potting/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //this method works for all other activities in potting
    public function AllOtherActivities($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('Potting/AllOtherActivities', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Compartment',
        ]);
    }

    public function TransportAndMixingSubstrate($id)
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
                    'soil_uom' => $group[0]['uom'],
                    'soil_quantity' => $group[0]['quantity'],
                    'top_soil_uom' => $group[1]['uom'],
                    'top_soil_quantity' => $group[1]['quantity'],
                    'date' => $group[1]['created_at'],
                ];
            });

        }

        $start_date = $this->GetDate($id);

        return Inertia::render('Potting/TransportAndMixSubstrate',
            [
                'Jobcard' => $jobCard,
                'BedPrepActivities' => $combinedData,
                'BeginDate' => $start_date,
            ]
        );
    }

    public function StoreTransportAndMixingSubstrate(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'soil_uom' => 'required',
            'soil_quantity' => 'required',
            'soil' => 'required',
            'top_soil_uom' => 'required',
            'top_soil_quantity' => 'required',
            'top_soil' => 'required',
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

        $random_number = rand(100,1000);

        BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'name' => $data['soil'],
            'quantity' => $data['soil_quantity'],
            'uom' => $data['soil_uom'],
            'child_activity_id' => Session::get('current_activity_id'),
            'extra_information' => $random_number
        ]);

        BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'name' => $data['top_soil'],
            'quantity' => $data['top_soil_quantity'],
            'uom' => $data['top_soil_uom'],
            'child_activity_id' => Session::get('current_activity_id'),
            'extra_information' => $random_number
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    public function PotsArrangementInSeedlingBed($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('Potting/ArrangingPots', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    public function StorePotsArrangementInSeedlingBed(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'uom' => 'required',
            'quantity' => 'required',
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
                $query->where(['child_activity_id' => Session::get('current_activity_id')]);
            }
        ]);

        return $jobCard;
    }
}
