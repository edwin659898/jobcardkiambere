<?php

namespace App\Http\Controllers;

use App\Models\ChildActivity;
use App\Models\Fruit;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Signature;
use App\Models\Stock;
use App\Models\Timeline;
use App\Models\Tree;
use App\Models\Truck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class FruitCollectionController extends Controller
{
    //view Fruit collection and its Activities
    public function FruitCollection()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 3)
            ->first();
        return Inertia::render('FruitCollection/FruitCollectionActivities', [
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

        return Inertia::render('FruitCollection/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //View plan approval,
    public function PlanApproval($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $signed = Signature::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->pluck('role_id')->toArray();

        return Inertia::render('FruitCollection/PlanApproval', [
            'Jobcard' => $jobCard,
            'Signed' => $signed,
            'BeginDate' => $start_date,
        ]);
    }

    //update signature for Fruit Collection approval plan
    public function updatePlanApproval(Request $request, $id)
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
        ])->whereDate('created_at', Carbon::today())->pluck('role_id')->toArray();

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
            Timeline::where(['job_card_id' => $jobCard->id, 'child_activity_id' => Session::get('current_activity_id')])
                ->first()
                ->update(['end_date' => now()->format('Y-m-d,H:i:s')]);
            $jobCard->update(['current_child_id' => $next_activity->id, 'current_parent_id' => $next_activity->parent_activity_id]);
        }

        return redirect()->route('FC activity', $jobCard->current_child_id)->with('success', 'Update Successfully');
    }

    //view temaplate for gunny labelling
    public function LabelGunnyBag($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        $trees = Tree::select('id', 'tree_number')->get();

        return Inertia::render('FruitCollection/LabelGunnyBag', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Trees' => $trees,
        ]);
    }

    //store tree number during gunny labelling
    public function storeLabeledGunnyBags(Request $request, $id)
    {
        $data = $request->validate([
            'treeNumber' => 'required',
            'startDate' => 'required',
        ]);

        $jobcard = JobCard::findOrFail($id);

        $timeline = Timeline::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if (!$timeline) {
            Timeline::create([
                'start_date' => Carbon::parse($data['startDate'])->format('Y-m-d'),
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        foreach ($data['treeNumber'] as $key => $value) {
            Fruit::create([
                'tree_id' => $value['id'],
                'job_card_id' => $jobcard->id,
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Saved'
        );
    }

    //destroy added tree number during gunny bag labelling
    public function destroyTreeNumber($id)
    {
        Fruit::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'destroyed');
    }

    //this method basically completes all the activities
    public function CompleteLabelGunnyBags($id)
    {
        $jobcard = JobCard::findOrFail($id);
        $signatures_required_in_this_activity = ChildActivity::find(Session::get('current_activity_id'))->roles->pluck('id')->toArray();

        $has_already_been_signed = Signature::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->pluck('role_id')->toArray();
        $has_not_been_signed = array_diff($signatures_required_in_this_activity, $has_already_been_signed);
        $allowed_to_sign = array_intersect($has_not_been_signed, auth()->user()->roles->pluck('id')->toArray());
        foreach ($allowed_to_sign as $key => $value) {
            Signature::Create([
                'user_id' => auth()->id(),
                'job_card_id' => $jobcard->id,
                'role_id' => $value,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        $signatures_provided_in_this_stage = Signature::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        if (count($signatures_required_in_this_activity) <= $signatures_provided_in_this_stage->count()) {

            $next_activity = ChildActivity::where('id', '>', $jobcard->current_child_id)->first();
            $current_date = Timeline::where(['job_card_id' => $jobcard->id, 'child_activity_id' => Session::get('current_activity_id')])
            ->whereDate('created_at', Carbon::today())
            ->first();
            if ($current_date) {
                $current_date->update(['end_date' => now()->format('Y-m-d, H:i:s')]);
            }

        }

        return redirect()->route('Dashboard')->with('success', 'Update Successfully');
    }


    //view template for tree collection
    public function FruitCollectionFromTree($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('FruitCollection/RecordQuantity', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date
        ]);
    }

    //Sorting Out of the fruits
    public function FruitSorting($id)
    {

        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('FruitCollection/QualityCheck', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date
        ]);
    }

    //Sorting Out of the fruits
    public function FruitPackaging($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('FruitCollection/RecordQuantity', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date
        ]);
    }

    //view template for farm collection
    public function FruitCollectionFromFarm($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('FruitCollection/RecordQuantity', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date
        ]);
    }

    //view template for nursery transport
    public function FruitCollectionNurseryTransport($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);
        $trucks = Truck::where(['site' => $jobCard->site])->get();
 
        return Inertia::render('FruitCollection/NurseryTransport', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Trucks' => $trucks,
        ]);
    }

    public function TruckDeparture($id)
    {
        $jobCard = JobCard::findOrFail($id);
        $current_activity_number = ChildActivity::find(Session::get('current_activity_id'))->child_number;
        $prev_activity = ChildActivity::where('child_number','<',$current_activity_number)->orderBy('child_number','desc')->first();

        $jobCard->load([
            'childactivity.roles',
            'stocks' => function ($query) use ($prev_activity) {
                $query->with('user','truck','fruit.tree')->where(['child_activity_id' => $prev_activity->id]);
            }
        ]);


        return Inertia::render('FruitCollection/TruckDeparture', [
            'Jobcard' => $jobCard,
        ]);
    }

    public function updateTruckDepartureTime(Request $request)
    {
        $data = $request->validate([
            'departure_date' => 'required',
            'selectedTrucks'  => 'required',
        ]);

        foreach($data['selectedTrucks'] as $key => $value){
            $stock = Stock::find($value);

            $st = $stock->update([
                'departure_time' => Carbon::parse($data['departure_date'])->format('Y-m-d H:i')
            ]);
        }

        $jobcard = JobCard::findOrFail($request->jobcard_id);

        $timeline = Timeline::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if (!$timeline) {
            Timeline::create([
                'start_date' => Carbon::now()->format('Y-m-d, H:i:s'),
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        return redirect()->back()->with('success', 'Updated Successfully');
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
            'fruits.tree',
            'fruits.truck',
            'fruits.stocks' => function ($query) use ($jobCard) {
                $query->with('user','truck')->where(['child_activity_id' => Session::get('current_activity_id')]);
            }
        ]);

        return $jobCard;
    }

//     public function AssitToStore(Request $request, $id)
//     {
//         $data = $request->validate([
//             'quantity' => 'required',
//             'truck_number' => 'required',
//         ]);

//         $fruit = Fruit::findOrFail($id);

//         $jobcard = JobCard::findOrFail($fruit->job_card_id);

//         $timeline = Timeline::where([
//             'job_card_id' => $jobcard->id,
//             'child_activity_id' => Session::get('current_activity_id')
//         ])->whereDate('created_at', Carbon::today())->first();

//         if (!$timeline) {
//             Timeline::create([
//                 'start_date' => Carbon::now()->format('Y-m-d, H:i:s'),
//                 'job_card_id' => $jobcard->id,
//                 'child_activity_id' => Session::get('current_activity_id')
//             ]);
//         }

//         Stock::create([
//             'fruit_id' => $fruit->id,
//             'truck_id' => $data['truck_number'],
//             'quantity' => $data['quantity'],
//             'job_card_id' => $jobcard->id,
//             'child_activity_id' => Session::get('current_activity_id')
//         ]);

//         return redirect()->back()->with('success', 'Updated Successfully');
//     }
// }



//    //view template for tree collection
//    public function FruitCollectionFromTree($id)
//    {
//        $jobCard = $this->GetJobcard($id);
//        $start_date = $this->GetDate($id);

//        return Inertia::render('FruitCollection/RecordQuantity', [
//            'Jobcard' => $jobCard,
//            'BeginDate' => $start_date
//        ]);
//    }

//     //Sorting Out of the fruits
//     public function FruitSorting($id)
//     {

//         $jobCard = $this->GetJobcard($id);
//         $start_date = $this->GetDate($id);

//         return Inertia::render('FruitCollection/QualityCheck', [
//             'Jobcard' => $jobCard,
//             'BeginDate' => $start_date
//         ]);
//     }

//     //Sorting Out of the fruits
//     public function FruitPackaging($id)
//     {
//         $jobCard = $this->GetJobcard($id);
//         $start_date = $this->GetDate($id);

//         return Inertia::render('FruitCollection/RecordQuantity', [
//             'Jobcard' => $jobCard,
//             'BeginDate' => $start_date
//         ]);
//     }

//     //view template for farm collection
//     public function WeighingFruits($id)
//     {
//         $jobCard = $this->GetJobcard($id);
//         $start_date = $this->GetDate($id);

//         return Inertia::render('FruitCollection/RecordQuantity', [
//             'Jobcard' => $jobCard,
//             'BeginDate' => $start_date
//         ]);
//     }

//     //view template for nursery transport
//     public function FruitCollectionNurseryTransport($id)
//     {
//         $jobCard = $this->GetJobcard($id);
//         $start_date = $this->GetDate($id);
//         $trucks = Truck::where(['site' => $jobCard->site])->get();
 
//         return Inertia::render('FruitCollection/NurseryTransport', [
//             'Jobcard' => $jobCard,
//             'BeginDate' => $start_date,
//             'Trucks' => $trucks,
//         ]);
//     }

//     public function TruckDeparture($id)
//     {
//         $jobCard = JobCard::findOrFail($id);
//         $current_activity_number = ChildActivity::find(Session::get('current_activity_id'))->child_number;
//         $prev_activity = ChildActivity::where('child_number','<',$current_activity_number)->orderBy('child_number','desc')->first();

//         $jobCard->load([
//             'childactivity.roles',
//             'stocks' => function ($query) use ($prev_activity) {
//                 $query->with('user','truck','fruit.tree')->where(['child_activity_id' => $prev_activity->id]);
//             }
//         ]);


//         return Inertia::render('FruitCollection/TruckDeparture', [
//             'Jobcard' => $jobCard,
//         ]);
//     }

//     public function updateTruckDepartureTime(Request $request)
//     {
//         $data = $request->validate([
//             'departure_date' => 'required',
//             'selectedTrucks'  => 'required',
//         ]);

//         foreach($data['selectedTrucks'] as $key => $value){
//             $stock = Stock::find($value);

//             $st = $stock->update([
//                 'departure_time' => Carbon::parse($data['departure_date'])->format('Y-m-d H:i')
//             ]);
//         }

//         $jobcard = JobCard::findOrFail($request->jobcard_id);

//         $timeline = Timeline::where([
//             'job_card_id' => $jobcard->id,
//             'child_activity_id' => Session::get('current_activity_id')
//         ])->whereDate('created_at', Carbon::today())->first();

//         if (!$timeline) {
//             Timeline::create([
//                 'start_date' => Carbon::now()->format('Y-m-d, H:i:s'),
//                 'job_card_id' => $jobcard->id,
//                 'child_activity_id' => Session::get('current_activity_id')
//             ]);
//         }

//         return redirect()->back()->with('success', 'Updated Successfully');
//     }

//     private function GetDate($id)
//     {
//         $jobCard = JobCard::findOrFail($id);
//         $find_start_date = Timeline::where([
//             'job_card_id' => $jobCard->id,
//             'child_activity_id' => Session::get('current_activity_id')
//         ])->whereDate('created_at',Carbon::today())->first();

//         if ($find_start_date) {
//             $start_date = $find_start_date->start_date;
//         } else {
//             $start_date = Carbon::now();
//         }

//         return $start_date;
//     }

//     private function GetJobcard($id)
//     {
//         $jobCard = JobCard::findOrFail($id);
//         $jobCard->load([
//             'childactivity.roles',
//             'fruits.tree',
//             'fruits.truck',
//             'fruits.stocks' => function ($query) use ($jobCard) {
//                 $query->with('user','truck')->where(['child_activity_id' => Session::get('current_activity_id')]);
//             }
//         ]);

//         return $jobCard;
//     }

    public function AssitToStore(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'required',
            // nulluble
            'truck_number' => 'nullable',
        ]);

        $fruit = Fruit::findOrFail($id);

        $jobcard = JobCard::findOrFail($fruit->job_card_id);

        $timeline = Timeline::where([
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at', Carbon::today())->first();

        if (!$timeline) {
            Timeline::create([
                'start_date' => Carbon::now()->format('Y-m-d, H:i:s'),
                'job_card_id' => $jobcard->id,
                'child_activity_id' => Session::get('current_activity_id')
            ]);
        }

        Stock::create([
            'fruit_id' => $fruit->id,
            // not there
            // 'truck_id' => $data['truck_number'],
            'quantity' => $data['quantity'] ?? null,
            // ?? null, //up there
            'job_card_id' => $jobcard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ]);

        return redirect()->back()->with('success', 'Updated Successfully');
    }
}
