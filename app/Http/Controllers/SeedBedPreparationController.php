<?php

namespace App\Http\Controllers;

use App\Models\BedPreparation;
use App\Models\Chemical;
use App\Models\ChildActivity;
use App\Models\Compartment;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Timeline;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class SeedBedPreparationController extends Controller
{
    //view bed preperation to other site and its Activities
    public function BedPreparation()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 8)
            ->first();
        return Inertia::render('SeedBedPreparation/BedPreparationActivities', [
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

        return Inertia::render('SeedBedPreparation/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //identify poin t of sand collection
    public function PointOfSandCollection($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);
        $compartment = Compartment::where('site',$jobCard->site)->pluck('name');

        return Inertia::render('SeedBedPreparation/IdentifySandCollectionPoint', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Compartments' => $compartment,
        ]);
    }

    //store point of sand collection
    public function StorePointOfSandCollection(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'compartment_name' => 'required',
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
            'name' => strtoupper($data['compartment_name']),
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    public function destroyCompartment($id)
    {
        BedPreparation::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'destroyed Successfully');
    }

    //sand testing
    public function sandAndWaterTesting($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedBedPreparation/SandTesting', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    //store sand and water testing findings
    public function StoreSandAndWaterTesting(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'status' => 'required',
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
            'name' => $data['status'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //identify poin t of sand collection
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);
        $users = User::where('site', auth()->user()->site)->get();

        return Inertia::render('SeedBedPreparation/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
            'Users' => $users
        ]);
    }

    //store material acquisition
    public function StoreMaterialAcquisition(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'item_name' => 'required',
            'quantity' => 'required',
            'type' => 'required',
            // 'received_by' => [
            //     'required_if:type,==,Item'
            // ],
            'uom' => 'required',
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

        $data['issued_by'] = $data['type'] == 'Item' ? auth()->id() : null;

        BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'uom' => $data['uom'],
            'quantity' => $data['quantity'],
            //'received_by' => $data['received_by'],
            'issued_by' => $data['issued_by'],
            'name' => strtoupper($data['item_name']),
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //sand harvesting
    public function SandHarvesting($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);
        $compartment = Compartment::where('site',$jobCard->site)->pluck('name');;

        return Inertia::render('SeedBedPreparation/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Compartments' => $compartment,
        ]);
    }

    //this method works for all other sand activities
    public function SandTransportToNursery($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedBedPreparation/SandTransportToNursery', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Compartment',
        ]);
    }

    //store all other sand activities sand transport to application of chemicals to sand
    public function StoreSandTransportToNursery(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'quantity' => 'required',
            'uom' => 'required',
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
            'name' => $request->item_name,
            'job_card_id' => $jobcard->id,
            'uom' => $data['uom'],
            'quantity' => $data['quantity'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //this method works for application of chemicals to sand
    public function SandChemicalApplication($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $chemicals = Chemical::pluck('name');

        return Inertia::render('SeedBedPreparation/SandChemicalApplication', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Chemicals' => $chemicals,
        ]);
    }
    

    //view marking of seed beda
    public function MarkSeedBeds($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedBedPreparation/MarkSeedBeds', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    //store point of sand collection
    public function StoreMarkSeedBeds(Request $request, $id)
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
            'name' => strtoupper($data['name']),
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
