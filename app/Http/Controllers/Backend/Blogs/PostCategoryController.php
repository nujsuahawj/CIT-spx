<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\PostCategory;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postcategory = PostCategory::with('subcatalog')->where('parent_id',0)->get();
        return view('backend.blogs.postcategory.index',compact('postcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_postcate = PostCategory::all();
        return view('backend.blogs.postcategory.create', compact('all_postcate'));
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
            'name_la'=>'required'
        ],[
            'name_la.required'=>'ໃສ່ຊື່ໝວດໝູ່ຂ່າວສານກ່ອນ!'
        ]);
        PostCategory::create($request->all());
        return redirect()->route('postcategory.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
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
        $all_postcate = PostCategory::all();
        $postcategory = PostCategory::find($id);
        return view('backend.blogs.postcategory.edit', compact('all_postcate','postcategory'));
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
        $postcategory = PostCategory::find($id);
        $request->validate([
            'name_la'=>'required'
        ],[
            'name_la.required'=>'ໃສ່ຊື່ໝວດໝູ່ຂ່າວສານກ່ອນ!'
        ]);
        $postcategory->update($request->all());
        return redirect()->route('postcategory.index')->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postcategory = PostCategory::find($id);
        $postcategory->delete();
        return redirect()->route('postcategory.index')->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
    }
}
