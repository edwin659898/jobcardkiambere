<?php

namespace App\Http\Controllers;

use App\Exports\StocksExport;
use App\Models\ChildActivity;
use App\Models\Fruit;
use App\Models\JobCard;
use App\Models\ParentActivity;
use App\Models\Timeline;
use App\Models\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //
    public function index()
    {
        $Jobcards = JobCard::latest()->get();
        $parent_activities = ParentActivity::select('id', 'parent_title')->get();


        return Inertia::render('Report/Index', [
            'Jobcards' => $Jobcards,
            'ParentActivity' => $parent_activities,
        ]);
    }

    public function getReport($id, JobCard $item)
    {

        $jobcard = $item->load('Confirmedrecords');
        $parent_activity = ParentActivity::find($id);
        $trees = Tree::select('id', 'tree_number')->get();
        $fruit_id = null;
        if (request()->get('Tree') != '') {
            $fruit_id = Fruit::where('tree_id', request()->get('Tree'))
                ->where('job_card_id', $jobcard->id)
                ->first()->id;
        }

        $parent_activity->load(['childs' => function ($query) use ($item, $fruit_id) {
            $query->with('timelines', function ($query) use ($item) {
                $query->where('job_card_id', $item->id);
            });
            $query->with('signatures', function ($query) use ($item) {
                $query->with('user', 'role')->where('job_card_id', $item->id);
            });
            $query->with('bedPreparation', function ($query) use ($item) {
                $query->where('job_card_id', $item->id);
            });
            $query->with('stocks', function ($query) use ($item, $fruit_id) {
                $query->when(request()->get('Tree') != '', function ($query) use ($fruit_id) {
                    $query->where('fruit_id', $fruit_id);
                });
                $query->with('fruit.tree', 'fruit.truck', 'fruit')->where('job_card_id', $item->id);
            });
        }]);

        return Inertia::render('Report/'.$parent_activity->report_template_name, [
            'JobCard' => $jobcard,
            'ParentActivity' => $parent_activity,
            'Trees' => $trees,
            'Tree' => request()->get('Tree'),
        ]);
    }

    public function exportExcel(Request $request)
    {
        $child_ids = [];
        $activities = ChildActivity::where('parent_activity_id', request()->get('id'))->get();
        foreach ($activities as $activity) {
            array_push($child_ids, $activity->id);
        }
        $job_card_id = request()->get('item');
        $fruit_id = request()->get('Tree');
        Excel::download(new StocksExport($fruit_id, $child_ids, $job_card_id), 'report.xlsx');
        return redirect()->back();
    }
}
