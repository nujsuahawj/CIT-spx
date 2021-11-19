<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Post;
use App\Models\Web\Service;
use App\Models\Web\Slider;
use App\Models\Web\Testimonial;
use App\Models\Web\Message;

class DashboardBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count_post = Post::select('id','del')->where('del',1)->count();
        $count_service = Service::select('id')->count();
        $count_testimonial = Testimonial::select('id')->count();
        $count_message = Message::select('id')->count();
        $posts = Post::select('image','title_la','title_en','des_la','des_en','published')->orderBy('id','desc')->where('published',1)->where('del',1)->take(3)->get();
        $message = Message::select('subject','name','status')->where('status',1)->take(3)->get();
        
        return view('backend.blogs.dashboardblog', compact('count_post','count_service','count_testimonial','count_message','posts','message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
