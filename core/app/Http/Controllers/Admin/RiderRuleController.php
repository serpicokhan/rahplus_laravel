<?php

namespace App\Http\Controllers\Admin;

use App\Models\RiderRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiderRuleController extends Controller
{

    public function index()
    {
        $pageTitle = 'All Rules';
        $rules     = RiderRule::searchable(['name'])->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.rider_rule.index', compact('pageTitle', 'rules'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => "required|unique:rider_rules,name,$id"
        ]);

        if ($id) {
            $rules        = RiderRule::findOrFail($id);
            $notification = 'Rider rule updated successfully';
        } else {
            $rules        = new RiderRule();
            $notification = 'Rider rule added successfully';
        }

        $rules->name = $request->name;
        $rules->save();

        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return RiderRule::changeStatus($id);
    }
}
