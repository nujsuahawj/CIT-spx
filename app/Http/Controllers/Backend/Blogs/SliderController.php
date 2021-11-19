<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id','desc')->get();
        return view('backend.blogs.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.slider.create');
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
            'title_la'=>'required'
        ],[
            'title_la.required'=>'ໃສ່ພາດຫົວເລື່ອງກ່ອນ!'
        ]);

        $image = $request->image;
        $imagename = time().$image->getClientOriginalName();

        Slider::create([
            'image'=>'upload/slider/'.$imagename,
            'title_la'=>$request->title_la,
            'title_en'=>$request->title_en,
            'des_la'=>$request->des_la,
            'des_en'=>$request->des_en,
            'status'=>$request->status
        ]);
        $image->move('upload/slider/', $imagename);
        return redirect()->route('slider.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
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
        $slider = Slider::find($id);
        return view('backend.blogs.slider.edit', compact('slider'));
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
        $slider = Slider::find($id);
        $request->validate([
            'title_la'=>'required'
        ],[
            'title_la.required'=>'ໃສ່ພາດຫົວເລື່ອງກ່ອນ!'
        ]);
        
        if($request->has('image'))
        {
            $image = $request->image;
            $imagename = time().$image->getClientOriginalName();
            $image->move('upload/slider/', $imagename);
            $slider_data = [
                'image'=>'upload/slider/'.$imagename,
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'des_la'=>$request->des_la,
                'des_en'=>$request->des_en,
                'status'=>$request->status
            ];
        }else
        {
            $slider_data = [
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'des_la'=>$request->des_la,
                'des_en'=>$request->des_en,
                'status'=>$request->status
            ];
        }
        $slider->update($slider_data);
        return redirect(route('slider.index'))->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        if(file_exists($slider->image)) {
            unlink($slider->image);
            $slider->delete();
        }
        else
        {
            $slider->delete();
        }
        return redirect()->back()->with('success','ລຶບຂໍ້ມູນສຳເລັດ!'); 
    }
}
