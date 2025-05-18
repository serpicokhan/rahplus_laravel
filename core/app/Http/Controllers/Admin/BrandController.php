<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Brands';
        $brands    = Brand::searchable(['name'])->orderBy('name')->orderBy('id', getOrderBy())->paginate(getPaginate());
        return view('admin.brand.index', compact('pageTitle', 'brands'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'  => 'required|unique:brands,name,' . $id,
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($id) {
            $brand        = Brand::findOrFail($id);
            $notification = 'Brand updated successfully';
        } else {
            $brand        = new Brand();
            $notification = 'Brand added successfully';
        }
        
        if ($request->hasFile('image')) {
            try {
                $brand->image = fileUploader($request->image, getFilePath('brand'), getFileSize('brand'), @$brand->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $brand->name = $request->name;
        $brand->save();

        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Brand::changeStatus($id);
    }
}
