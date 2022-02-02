<?php

namespace App\Http\Controllers\Webside;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $categories_with_post = Category::with([
            'posts'=>function ($qu) {
                $qu->latest()->limit(2);
        }])->get();
        return view('webside.index',compact('categories_with_post'));
    }
}
