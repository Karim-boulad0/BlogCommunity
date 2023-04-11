<?php

namespace App\Http\Controllers\API;

use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryAdminController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    public function store(Request $request)
    {
        Category::create($request->except('image', '_token'));
        if ($request->file('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $pathimage = $request->file('image')->storeAs('image', Str::uuid() . $image, 'setting');
            Category::create([
                'image' => $pathimage
            ]);
        }
        $catgeory = Category::get();
        return  CategoryCollection::make($catgeory);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        dd($id);
    }


    public function update(Request $request, Category $categoryadmin)
    {
        $id = $categoryadmin->id;
        $categoryadmin->update($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;

            $categoryadmin->update(['image' => $path]);
        }
        $categorys = Category::find($id)->get();
        return  CategoryCollection::make($categorys);
    }


    public function destroy(Category $categoryadmin)
    {
        $this->authorize('viewAny', $this->setting);
        Category::where('id', $categoryadmin->id)->delete();
        return $categoryadmin;
    }
}
