<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    public function index()
    {
        $category = Category::with('children')->where('parent', 0)->orWhere('parent', null)->get();
        return  CategoryCollection::make($category); // collection badal make la an  jeyini kaza chi
    }
    public function categories_with_posts()
    {
        $categories_with_posts = Category::with(['posts' => function ($q) {
            $q->with('user')->with('category')->limit(5);
        }])->get();
        return  CategoryCollection::make($categories_with_posts);
    }
}
