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
            'name' => 'required',
            'site' => 'required',
            'description' => 'required',
        ]);

        Truck::create([
            'truck_number' => $request->name,
            'description' => $request->description,
            'site' => $request->site,
        ]);

        return redirect()->back()->with('success', 'Transport Media  created Successfully');
    }

    public function destroy($id)
    {
        Truck::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Transport Media destroyed Successfully');
    }
}
