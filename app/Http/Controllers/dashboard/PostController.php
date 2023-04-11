<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    protected $postmodel;

    public function __construct(Post $post)
    {
        $this->postmodel = $post;
    }
    public function index()
    {
        return view('dashboard.posts.index');
    }
    public function getPostsDatatable()
    {
        $posts = Post::select('*')->with('category');
        return DataTables($posts)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                if (auth()->user()->can('update', $row)) {
                    $btn = '
            <a href="' . Route('dashboard.posts.edit', $row->id) . '" class = "edit btn btn-success btn-sm">
            <i class="fa fa-edit"></i></a>

            <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"
            data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';

                    return $btn;
                }
            })
            ->addColumn('category_name', function ($row) {
                return  $row->category->translate(app()->getLocale())->content;
            })
            // ->addColumn('title', function ($row) {
            //     return  $row->category->translate(app()->getLocale())->title;
            // })


            // ->addColumn('title', function ($row) {
            //     return $row->translate(app()->getLocale())->title;
            // })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.posts.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $posts = Post::create($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;
            $posts->update([
                'image' => $path,
                'user_id' => auth()->user()->id
            ]);
        }
        return redirect()->route('dashboard.posts.index');
    }


    public function delete(Request $request)
    {
        if (is_numeric($request->id)) {
            Post::where('id', $request->id)->delete();
        }

        return redirect()->route('dashboard.posts.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::find($id);
        $this->authorize('update', $posts); // ma bi5alik ella iza enta mkaryato ll post
        $categories = Category::all();

        return view('dashboard.posts.edit', compact('categories', 'posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->except('image', '_token'));
        $this->authorize('update', $post);
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;
            $post->update(['image' => $path]);
        }

        return redirect()->route('dashboard.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
