<?php

namespace App\Http\Middleware;

use App\Models\ChildActivity;
use App\Models\UnitOfMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'app' => [
                'url' => config('APP_URL').'/admin/dist/img/AdminLTELogo.png',
            ],
            'success' => $request->session()->get('success'),
            'uom' => UnitOfMeasure::pluck('name','id'),
            'ActivityTitle' => ChildActivity::find(Session::get('current_activity_id'))->child_title ?? 'Activity'
        ]);
    }
}
