<?php

namespace App\Http\Controllers\Admin;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ZoneController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Zones';
        $zones     = Zone::searchable(['name'])->orderBy('name')->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.zone.index', compact('pageTitle', 'zones'));
    }

    public function create($id = 0)
    {
        $pageTitle   = 'Add Zone';
        $coordinates = [];
        return view('admin.zone.create', compact('pageTitle', 'coordinates'));
    }
    public function edit($id = 0)
    {
        $pageTitle   = 'Edit Zone';
        $zone        = Zone::findOrFail($id);
        $coordinates = $zone->coordinates;

        return view('admin.zone.create', compact('zone', 'pageTitle', 'coordinates'));
    }

    public function save(Request $request, $id = 0)
    {
        $isRequired = $id ? 'nullable' : 'required';
        $request->validate([
            'name'        => 'required|max:40|unique:zones,name,' . $id,
            'country'     => ['required', Rule::in(collect(gs('operating_country'))->keys()->toArray())],
            'coordinates' => [$isRequired],
        ]);


        if ($id) {
            $notification = 'Zone updated successfully';
            $zone         = Zone::findOrFail($id);
        } else {
            $notification  = 'Zone added successfully';
            $zone          = new Zone();
        }

        $zone->name        = $request->name;
        $zone->country     = $request->country;

        if ($request->coordinates) {

            $coordinates          = explode('),', trim($request->coordinates, '()'));
            $formattedCoordinates = [];

            foreach ($coordinates as  $coordinate) {
                list($latitude, $longitude) = explode(',', $coordinate);
                $formattedCoordinates[] = [
                    'lat' => str_replace("(", "", $latitude),
                    'lang' => $longitude
                ];
            }
            $zone->coordinates = $formattedCoordinates;
        }
        $zone->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Zone::changeStatus($id);
    }
}
