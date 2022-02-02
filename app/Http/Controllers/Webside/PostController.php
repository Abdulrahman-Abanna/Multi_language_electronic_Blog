<?php

namespace App\Http\Controllers\Webside;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return view('webside.post', compact('post'));
    }
}
