<?php

namespace App\Http\Controllers;

use App\Models\ChildActivity;
use App\Models\Fruit;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Signature;
use App\Models\Stock;
use App\Models\Timeline;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class TransportToOtherSiteController extends Controller
{
    //view Seed traportation to other site and its Activities
    public function SeedTransportation()
    {
        $data = ParentActivity::with('childs')
            ->where('parent_number', 7)
            ->first();
        return Inertia::render('TransportToOtherSites/TransportToOtherSitesActivities', [
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

        return Inertia::render('TransportToOtherSites/Table', [
            'childData' => $child,
            'currentCards' => $currentCard,
        ]);
    }

    //request for transport means
    public function Transportation($id)
    {
        $jobCard = JobCard::findOrFail($id);
        $jobCard->load([
            'childactivity.roles'
        ]);

        $find_start_date = Timeline::where([
            'job_card_id' => $jobCard->id,
            'child_activity_id' => Session::get('current_activity_id')
        ])->whereDate('created_at',Carbon::today())->first();

        if ($find_start_date) {
            $start_date = $find_start_date->start_date;
        } else {
            $start_date = Carbon::now();
        }

        return Inertia::render('TransportToOtherSites/RequestArrivalTransportMeans', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

    //up    date signaturea
    public function UpdateSignatures($id)
    {
        request()->validate([
            'start_date' => 'required'
        ]);

        $jobcard = JobCard::findOrFail($id);

        Timeline::create([
            'start_date' => Carbon::parse(request()->start_date)->format('Y-m-d'),
            'child_activity_id' => Session::get('current_activity_id'), 'job_card_id' => $jobcard->id,
        ]);

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

        if (count($signatures_required_in_this_activity) == $signatures_provided_in_this_stage->count()) {

            $next_activity = ChildActivity::where('id', '>', $jobcard->current_child_id)->first();
            $current_date = Timeline::where(['job_card_id' => $jobcard->id, 'child_activity_id' => Session::get('current_activity_id')])
            ->whereDate('created_at', Carbon::today())
            ->first();
            if ($current_date) {
                $current_date->update(['end_date' => now()->format('Y-m-d, H:i:s')]);
            }
            $jobcard->update(['current_child_id' => $next_activity->id, 'current_parent_id' => $next_activity->parent_activity_id]);
        }

        return redirect()->route('TS activity', $jobcard->current_child_id)->with('success', 'Update Successfully');
    }

    //issue from storage
    public function StorageIssue($id)
    {
        $users = User::where('site', auth()->user()->site)->get();

        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('TransportToOtherSites/IssueFromStorage', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
            'Users' => $users,
        ]);
    }

    //weigh and package seed
    public function WeighAndPackage($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('TransportToOtherSites/WeighAndPackage', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
        ]);
    }

     //store weigh package and quality kgs
     public function StoreWeighAndPackage(Request $request, $id)
     {
         $data = $request->validate([
             'quantity' => 'required',
         ]);
 
         $fruit = Fruit::findOrFail($id);
 
         $jobcard = JobCard::findOrFail($fruit->job_card_id);
 
         $timeline = Timeline::where([
             'job_card_id' => $jobcard->id,
             'child_activity_id' => Session::get('current_activity_id')
         ])->first();
 
         if (!$timeline) {
             Timeline::create([
                 'start_date' => Carbon::now()->format('Y-m-d'),
                 'job_card_id' => $jobcard->id,
                 'child_activity_id' => Session::get('current_activity_id')
             ]);
         }
 
         Stock::create([
             'fruit_id' => $fruit->id,
             'job_card_id' => $jobcard->id,
             'quantity' => $data['quantity'],
             'child_activity_id' => Session::get('current_activity_id')
         ]);
 
         return redirect()->back()->with('success', 'Update Successfully');
     }

     //seed storaged
    public function SeedStorage($id)
    {
        $jobCard = $this->GetJobcard($id);
        $start_date = $this->GetDate($id);

        return Inertia::render('TransportToOtherSites/SeedStorage', [
            'Jobcard' => $jobCard,
            'BeginDate' => $start_date,
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
            'fruits.tree',
            'fruits.stocks' => function ($query) use ($jobCard) {
                $query->with('user')->where(['child_activity_id' => Session::get('current_activity_id')]);
            }
        ]);

        return $jobCard;
    }
}
