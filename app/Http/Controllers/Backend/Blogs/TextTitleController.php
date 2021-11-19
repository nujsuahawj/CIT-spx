<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\TextTitle;

class TextTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $texttitle = TextTitle::all();
        return view('backend.blogs.texttitle.index', compact('texttitle'));
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
        $texttitle = TextTitle::find($id);
        return view('backend.blogs.texttitle.edit', compact('texttitle'));
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
        $texttitle = TextTitle::find($id);
        $request->validate([
            'title_la'=>'required',
            'title_en'=>'required'
        ],[
            'title_la.required' => 'ໃສ່ຂໍ້ຄວາມໜ້າເວັບ Lao ກ່ອນ',
            'title_en.required' => 'ໃສ່ຂໍ້ຄວາມໜ້າເວັບ Eng ກ່ອນ'
        ]);
        $texttitle->update($request->all());
        return redirect()->route('texttitle.index')->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
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
