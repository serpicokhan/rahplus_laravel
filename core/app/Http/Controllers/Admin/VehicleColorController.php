<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleColor;

class VehicleColorController extends Controller
{
    public function index()
    {
        $pageTitle    = 'All Vehicle Color';
        $vehicleColors = VehicleColor::searchable(['name'])->orderBy('name')->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.color.index', compact('pageTitle', 'vehicleColors'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|unique:vehicle_colors,name,' . $id,
        ]);

        if ($id) {
            $vehicleColor  = VehicleColor::findOrFail($id);
            $notification = 'Vehicle color updated successfully';
        } else {
            $vehicleColor  = new VehicleColor();
            $notification = 'Vehicle color added successfully';
        }

        $vehicleColor->name = $request->name;
        $vehicleColor->save();

        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return VehicleColor::changeStatus($id);
    }
}
