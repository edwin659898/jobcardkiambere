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

class SeedPropagationController extends Controller
{
    //view bed preperation to other site and its Activities
    public function SeedPropergation()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 9)
            ->first();
        return Inertia::render('SeedPropergation/SeedPropergationActivities', [
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

        return Inertia::render('SeedPropergation/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //this method works for application of chemicals to sand
    public function PrepareSolution($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $chemicals = Chemical::pluck('name');

        return Inertia::render('SeedPropergation/PrepareSolution', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Chemicals' => $chemicals,
        ]);
    }

    //identify poin t of sand collection
    public function MaterialAcquisition($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedPropergation/MaterialAcquisition', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Item',
        ]);
    }

    //this method works for all other sand activities sand transport to application of chemicals to sand
    public function AllOtherActivities($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('SeedPropergation/AllOtherActivities', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Name' => 'Compartment',
        ]);
    }

    //this method works for watering with fungicide
    public function WateringWithFungicide($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $chemicals = Chemical::pluck('name','id');
        $searchTerm = "Marking of the seed beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
            ->where('child_activity_id', $child_activity->id)->select('id','name')->get();

        return Inertia::render('SeedPropergation/WaterWithFungicide', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Chemicals' => $chemicals,
            'BedNumbers' => $seed_bed_numbers
        ]);
    }

    //store sand and water testing findings
    public function StoreWateringWithFungicide(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'chemical_uom' => 'required',
            'chemical_quantity' => 'required',
            'chemical_name' => 'required',
            'seed_bed_number.*' => 'required',
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

        $data = BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'name' => $data['chemical_name'],
            'quantity' => $data['chemical_quantity'],
            'uom' => $data['chemical_uom'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        foreach($request->seed_bed_number as $seedbed){
            $request->seed_bed_number[0] == $seedbed 
            ?  $data->update(['extra_information' => $data->extra_information.' '.$seedbed['name']]) 
            : $data->update(['extra_information' => $data->extra_information.', '.$seedbed['name']]);
        }

        return redirect()->back()->with('success', 'Update Successfully');
    }

    public function MoistureAndAirRegulation($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $searchTerm = "Marking of the seed beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
            ->where('child_activity_id', $child_activity->id)->pluck('name');

        return Inertia::render('SeedPropergation/MoistureAirRegulation', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
        ]);
    }

    //store sand and water testing findings
    public function StoreMoistureAndAirRegulation(Request $request, $id)
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

    //store sand and water testing findings
    public function CloseMoistureAndAirRegulation(Request $request, $id)
    {
        $activity_data = BedPreparation::find($id)->touch();

        return redirect()->back()->with('success', 'Update Successfully');
    }

    public function MakingFarrows($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $searchTerm = "Marking of the seed beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
            ->where('child_activity_id', $child_activity->id)->select('id','name')->get();

        return Inertia::render('SeedPropergation/MakingFarrows', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
        ]);
    }

    //store sand and water testing findings
    public function StoreMakingFarrows(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'name.*' => 'required',
            'uom' => 'required',
            'quantity' => 'required',
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

        $data = BedPreparation::create([
            'job_card_id' => $jobcard->id,
            'quantity' => $data['quantity'],
            'uom' => $data['uom'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        foreach($request->name as $seedbed){
            $request->name[0] == $seedbed ? $data->update(['name' => $data->name.' '.$seedbed['name']]) :
            $data->update(['name' => $data->name.', '.$seedbed['name']]);
        }

        return redirect()->back()->with('success', 'Update Successfully');
    }

    //this method works for nipping and Sitting
    public function NippingAndSlitting($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $trees = Tree::select('id', 'tree_number')->get();

        return Inertia::render('SeedPropergation/NippingAndSlitting', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Trees' => $trees
        ]);
    }

    //store sand and water testing findings
    public function StoreNippingAndSlitting(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'uom' => 'required',
            'treeNumber' => 'required',
            'Goodquantity' => 'required',
            'Badquantity' => 'required',
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
            'quantity' => $data['Goodquantity'],
            'extra_information' => $data['Badquantity'],
            'uom' => $data['uom'],
            'name' => $data['treeNumber']['tree_number'],
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Update Successfully');
    }


    public function SeedSoaking($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $trees = Tree::select('id', 'tree_number')->get();

        return Inertia::render('SeedPropergation/Soaking', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Trees' => $trees,
        ]);
    }

    public function SeedSowing($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $searchTerm = "Marking of the seed beds";
        $child_activity = ChildActivity::where('child_title', 'LIKE', '%' . $searchTerm . '%')->first();

        $seed_bed_numbers = BedPreparation::where('job_card_id', $jobCard->id)
            ->where('child_activity_id', $child_activity->id)->pluck('name');

        $trees = Tree::select('id', 'tree_number')->get();

        return Inertia::render('SeedPropergation/Sowing', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'BedNumbers' => $seed_bed_numbers,
            'Trees' => $trees,
        ]);
    }

    //store sand and water testing findings
    public function StoreSeedSoakingAndSowing(Request $request, $id)
    {
        $data = $request->validate([
            'start_date' => 'required',
            'uom' => 'required',
            'quantity' => 'required',
            'name' => 'nullable',
            'treeNumber' => 'required',
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
        ])->whereDate('created_at', Carbon::today())->first();

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
