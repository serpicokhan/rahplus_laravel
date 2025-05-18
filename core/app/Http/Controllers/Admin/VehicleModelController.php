<?php

namespace App\Http\Controllers\Admin;

use App\Models\VehicleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class VehicleModelController extends Controller
{
    public function index()
    {
        $pageTitle     = 'All Vehicle Model';
        $vehicleModels = VehicleModel::searchable(['name'])->orderBy('name')->orderBy('id', getOrderBy())->paginate(getPaginate());
        $brands        = Brand::active()->get();
        return view('admin.model.index', compact('pageTitle', 'vehicleModels', 'brands'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'  => 'required',
            'brand' => 'required|integer|exists:brands,id'
        ]);

        $exists = VehicleModel::where('id', '!=', $id)->where('brand_id', $request->brand)->where('name', $request->name)->exists();

        if ($exists) {
            $notify[] = ['error', "The model has already been taken"];
            return back()->withNotify($notify);
        }

        if ($id) {
            $vehicleModel = VehicleModel::findOrFail($id);
            $notification = 'Vehicle model updated successfully';
        } else {
            $vehicleModel           = new VehicleModel();
            $notification           = 'Vehicle model added successfully';
            $vehicleModel->brand_id = $request->brand;
        }

        $vehicleModel->name     = $request->name;
        $vehicleModel->save();

        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return VehicleModel::changeStatus($id);
    }
}
