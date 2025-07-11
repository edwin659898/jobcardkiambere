<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportController extends Controller
{
    public function index()
    {
        $trucks = Truck::query()
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($truck) => [
                'id' => $truck->id,
                'transport' => $truck->transport,
                'name' => $truck->truck_number,
                'description' => $truck->description,
                'site' => $truck->site,
            ]);;

        return Inertia::render('TransportMedia/Index', [
            'TransportMedias' => $trucks,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'transport' => 'required',
            'name' => 'required',
            'site' => 'required',
            'description' => 'required',
            'phone' => 'required'
        ]);

        Truck::create([
            'transport' => $request->transport,
            'truck_number' => $request->name,
            'description' => $request->description,
            'site' => $request->site,
            'phone'=> $request->phone,
        ]);

        return redirect()->back()->with('success', 'Transport Media  created Successfully');
    }

    public function destroy($id)
    {
        Truck::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Transport Media destroyed Successfully');
    }
}
