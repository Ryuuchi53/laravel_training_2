<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')->paginate(5);

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

    public function store(Request $request)
    {
        $model = $request->input('model');
        $color = $request->input('color');
        $make = $request->input('make');
        $year = $request->input('year');
        $brand = $request->input('brand');
        $license_plate = $request->input('license_plate');

        $vehicle = new Vehicle();
        $vehicle->model = $model;
        $vehicle->color = $color;
        $vehicle->make = $make;
        $vehicle->year = $year;
        $vehicle->brand = $brand;
        $vehicle->license_plate = $license_plate;
        $vehicle->created_by = auth()->user()->id;
        $vehicle->save();

        return redirect()->route('vehicles.index')->with('success', 'Kenderaan berjaya ditambah');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $model = $request->input('model');
        $color = $request->input('color');
        $make = $request->input('make');
        $year = $request->input('year');
        $brand = $request->input('brand');
        $license_plate = $request->input('license_plate');

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->model = $model;
        $vehicle->color = $color;
        $vehicle->make = $make;
        $vehicle->year = $year;
        $vehicle->brand = $brand;
        $vehicle->license_plate = $license_plate;
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
