<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonial = Testimonial::orderBy('id','desc')->get();
        return view('backend.blogs.testimonial.index', compact('testimonial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.testimonial.create');
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
            'name'=>'required',
            'position'=>'required',
            'des_la'=>'required'
        ],[
            'name.required'=>'ໃສ່ຊື່ຜູ້ປະກອບຄວາມເຫັນກ່ອນ!',
            'position.required'=>'ໃສ່ຕຳແໜ່ງງານກ່ອນ!',
            'des_la.required'=>'ໃສ່ລາຍລະອຽດ ເປັນພາສາລາວ ກ່ອນ!'
        ]);

        $image = $request->image;
        $imagename = time().$image->getClientOriginalName();

        Testimonial::create([
            'image' => 'upload/testimonial/'.$imagename,
            'name' => $request->name,
            'position' => $request->position,
            'des_la'=> $request->des_la,
            'des_en'=> $request->des_en,
            'status'=> $request->status
        ]);
        $image->move('upload/testimonial/', $imagename);
        return redirect()->route('testimonial.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
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
        $testimonial = Testimonial::find($id);
        return view('backend.blogs.testimonial.edit', compact('testimonial'));
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
        $testimonial = Testimonial::find($id);
        $request->validate([
            'name'=>'required',
            'position'=>'required',
            'des_la'=>'required'
        ],[
            'name.required'=>'ໃສ່ຊື່ຜູ້ປະກອບຄວາມເຫັນກ່ອນ!',
            'position.required'=>'ໃສ່ຕຳແໜ່ງງານກ່ອນ!',
            'des_la.required'=>'ໃສ່ລາຍລະອຽດ ເປັນພາສາລາວ ກ່ອນ!'
        ]);

        if($request->has('image'))
        {
            $image = $request->image;
            $imagename = time().$image->getClientOriginalName();
            $image->move('upload/testimonial/', $imagename);
            $data_testi = [
                'image' => 'upload/testimonial/'.$imagename,
                'name' => $request->name,
                'position' => $request->position,
                'des_la'=> $request->des_la,
                'des_en'=> $request->des_en,
                'status'=> $request->status
            ];
        }else
        {
            $data_testi = [
                'name' => $request->name,
                'position' => $request->position,
                'des_la'=> $request->des_la,
                'des_en'=> $request->des_en,
                'status'=> $request->status
            ];
        }
        $testimonial->update($data_testi);
        return redirect()->route('testimonial.index')->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);

        if(file_exists($testimonial->image)) {
             unlink($testimonial->image);
             $testimonial->delete();
        }
        else
        {
            $testimonial->delete();
        }
        return redirect()->back()->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
    }
}
