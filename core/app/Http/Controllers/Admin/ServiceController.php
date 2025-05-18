<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Services';
        $services  = Service::searchable(['name'])->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.services.index', compact('pageTitle', 'services'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'image'                     => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'name'                      => 'required|unique:services,name,' . $id,
            'city_min_fare'             => 'required|numeric|gt:0',
            'city_max_fare'             => 'required|numeric|gt:city_min_fare',
            'city_recommend_fare'       => 'required|numeric|gte:city_min_fare|lte:city_max_fare',
            'city_fare_commission'      => 'required|numeric|gt:0|lt:100',
            'intercity_min_fare'        => 'required|numeric|gt:0',
            'intercity_max_fare'        => 'required|numeric|gt:intercity_min_fare',
            'intercity_recommend_fare'  => 'required|numeric|gte:intercity_min_fare|lte:intercity_max_fare',
            'intercity_fare_commission' => 'required|numeric|gt:0|lt:100',
        ]);

        if ($id) {
            $service      = Service::findOrFail($id);
            $notification = 'Service updated successfully';
        } else {
            $service      = new Service();
            $notification = 'Service added successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $service->image = fileUploader($request->image, getFilePath('service'), getFileSize('service'), @$service->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $service->name                      = $request->name;
        $service->city_min_fare             = $request->city_min_fare;
        $service->city_max_fare             = $request->city_max_fare;
        $service->city_recommend_fare       = $request->city_recommend_fare;
        $service->city_fare_commission      = $request->city_fare_commission;
        $service->intercity_min_fare        = $request->intercity_min_fare;
        $service->intercity_max_fare        = $request->intercity_max_fare;
        $service->intercity_recommend_fare  = $request->intercity_recommend_fare;
        $service->intercity_fare_commission = $request->intercity_fare_commission;
        $service->save();

        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Service::changeStatus($id);
    }
}
