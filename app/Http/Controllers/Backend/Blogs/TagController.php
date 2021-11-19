<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id','desc')->get();
        return view('backend.blogs.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_la'=>'required',
            'slug'=>'required'
        ],[
            'name_la.required'=>'ໃສ່ຊື່ແທັກພາສາລາວກ່ອນ',
            'slug.required'=>'ກະລຸນາໃສ່ Slug ກ່ອນ. ຕົວຢ່າງ: tag-news'
        ]);
        Tag::create([
            'name_la' => $request->name_la,
            'name_en' => $request->name_en,
            'slug' => $request->slug
        ]);
        return redirect(route('tag.index'))->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
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
        $tags = Tag::find($id);
        return view('backend.blogs.tag.edit', compact('tags'));
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
        $tags = Tag::find($id);
        $request->validate([
            'name_la'=>'required',
            'slug'=>'required'
        ],[
            'name_la.required'=>'ໃສ່ຊື່ແທັກພາສາລາວກ່ອນ',
            'slug.required'=>'ກະລຸນາໃສ່ Slug ກ່ອນ. ຕົວຢ່າງ: tag-news'
        ]);
        $tags->update([
            'name_la' => $request->name_la,
            'name_en' => $request->name_en,
            'slug' => $request->slug
        ]);
        return redirect(route('tag.index'))->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tags = Tag::find($id);
        $tags->delete();
        return redirect()->back()->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
    }
}
