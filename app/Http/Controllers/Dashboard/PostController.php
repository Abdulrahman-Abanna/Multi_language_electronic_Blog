<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Trait\uploadimage;
use App\Models\Post;
use Yajra\DataTables\Utilities\Request;
use App\Models\Category;
use Yajra\DataTables\DataTables;


class PostController extends Controller
{
    use uploadimage;
    protected $postmodel;
    /*this construct to use it in every place */
     public function __construct(Post $post)
     {
        $this->postmodel=$post;
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index');
    }
        public function getposts()
        {
            $data=Post::select('*')->with('category');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                if (auth()->user()->can('update',$row)) {
                return $btn='
                <a href="'.Route('dashboard.posts.edit',$row->id).'" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                <a id="deletebtn" data-id="'.$row->id.'"class="edit btn btn-danger btn-sm" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>
                ';
                }else {
                    return;
                }
            })
            ->addColumn('category_id',function($row){
                return $row->category->translate(app()->getLocale())->title;
            })
            ->addColumn('title',function($row){
                return $row->translate(app()->getLocale())->title;
            })
            ->rawColumns(['action','title','category_id'])
            ->make(true);
        }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $categories=Category::all();
        if (count($categories)>0) {
            return view('dashboard.posts.add',compact('categories'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post=Post::create($request->except('image','_token'));
        $post->update(['user_id'=>auth()->user()->id]);
        if ($request->has('image')) {
            $post->update(['image'=>$this->upload($request->image)]);
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
    public function edit(Post $post)
    {
        $this->authorize('update',$post);
        $categories=Category::all();
        return view('dashboard.posts.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
    {
        $this->authorize('update',$post);
        $post->update($request->except('image','_token'));
        $post->update(['user_id'=>auth()->user()->id]);
        if ($request->has('image')) {
            $post->update(['image'=>$this->upload($request->image)]);
        }
        return redirect()->Route('dashboard.posts.edit',compact('post'));
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
    public function delete(Request $request)
    {
        $this->authorize('delete',$this->postmodel->find($request->id));
        Post::where('id',$request->id)->delete();
        return redirect()->route('dashboard.posts.index');
    }
}
