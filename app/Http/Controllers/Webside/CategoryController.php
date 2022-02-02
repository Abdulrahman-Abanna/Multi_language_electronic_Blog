<?php

namespace App\Http\Controllers\Webside;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $category = $category->load('childern');
        $posts = Post::where('category_id', $category->id)->paginate(2);

        return view('webside.category', compact('category', 'posts'));
    }
}
