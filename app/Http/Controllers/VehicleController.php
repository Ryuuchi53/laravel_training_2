<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');

        $vehicles = Vehicle::where(function ($query) {
            $query->when(request()->filled('name'), function ($query) {
                $query->where('model', 'like', '%' . request()->name . '%')
                    ->orWhere('color', 'like', '%' . request()->name . '%')
                    ->orWhere('brand', 'like', '%' . request()->name . '%')
                    ->orWhere('make', 'like', '%' . request()->name . '%')
                    ->orWhere('license_plate', 'like', '%' . request()->name . '%');
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('vehicles.index', compact('vehicles'));
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.show', compact('vehicle'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(StoreVehicleRequest $request)
    {
        $validated = $request->validated();

        $vehicle = new Vehicle();
        $vehicle->model = $validated['model'];
        $vehicle->color = $validated['color'];
        $vehicle->make = $validated['make'];
        $vehicle->year = $validated['year'];
        $vehicle->brand = $validated['brand'];
        $vehicle->license_plate = $validated['license_plate'];
        $vehicle->created_by = auth()->user()->id;
        $vehicle->save();

        return redirect()->route('vehicles.index')->with('success', 'Kenderaan berjaya ditambah');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(UpdateVehicleRequest $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->fill($request->validated());
        $vehicle->save();

        return redirect()->route('vehicles.index')->with('success', 'Kenderaan berjaya dikemaskini');
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Kenderaan berjaya dipadam');
    }
}
