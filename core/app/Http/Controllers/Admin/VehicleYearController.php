<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleYear;

class VehicleYearController extends Controller
{
    public function index()
    {
        $pageTitle    = 'All Vehicle Year';
        $vehicleYears = VehicleYear::searchable(['name'])->orderBy('name')->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.year.index', compact('pageTitle', 'vehicleYears'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'  => ['required', 'digits:4', "unique:vehicle_years,name, . $id", 'before_or_equal:' . date('Y')],
        ],[
            'name.before_or_equal' => "The year not to be the future year"
        ]);

        if ($id) {
            $vehicleYear = VehicleYear::findOrFail($id);
            $notification = 'Vehicle year updated successfully';
        } else {
            $vehicleYear = new VehicleYear();
            $notification = 'Vehicle year added successfully';
        }

        $vehicleYear->name = $request->name;
        $vehicleYear->save();

        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return VehicleYear::changeStatus($id);
    }
}
