<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }



    public function index()
    {
        return view('dashboard.categories.index');
    }
    public function getCategoriesDatatable()
    {
        $categories = Category::where('parent','>=',0)->with('parents');
        return DataTables($categories)
            ->addIndexColumn()
            ->addColumn('parent', function ($row) {
                return ($row->parent ==  0) ? trans('words.main category') :   $row->parents->translate(app()->getLocale())->title;
            })
            ->addColumn('action', function ($row) {
                if($row->parent_id == 0){
                if (Auth()->user()->status == 'admin') {
                    $btn = '
            <a href="' . Route('dashboard.Category.edit', $row->id) . '" class = "edit btn btn-success btn-sm">
            <i class="fa fa-edit"></i></a>
            <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"
            data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
                    return $btn;
                }}
            })
            ->make(true);
    }
    public function create()
    {
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.add', compact('categories'));
    }
    public function store(Request $request)
    {
        Category::create($request->except('image', '_token'));
        $image = $request->file('image')->getClientOriginalName();
        $pathimage = $request->file('image')->storeAs('image', Str::uuid() . $image, 'setting');
        Category::create([
            'image' => $pathimage
        ]);
        return redirect()->route('dashboard.Category.index');
    }
    public function delete(Request $request)
    {
        if (is_numeric($request->id)) {
            Category::where('parent', $request->id)->delete();
            Category::where('id', $request->id)->delete();
        }

        return redirect()->route('dashboard.Category.index');
    }
    public function show($id)
    {
        //
    }
    public function edit(Category $Category)
    {
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.edit', compact('Category', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $Category)
    {
        $Category->update($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;

            $Category->update(['image' => $path]);
        }
        return redirect()->route('dashboard.Category.index');
    }
    public function destroy($id)
    {
        //
    }
}
