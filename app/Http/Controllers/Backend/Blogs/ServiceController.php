<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::where('status',1)->get();
        return view('backend.blogs.service.index', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.service.create');
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

        //$image = $request->image;
        //$imagename = time().$image->getClientOriginalName();

        Service::create([
            //'image'=>'upload/service/'.$imagename,
            'service_icon'=>$request->service_icon,
            'title_la'=>$request->title_la,
            'title_en'=>$request->title_en,
            'des_la'=>$request->des_la,
            'des_en'=>$request->des_en,
            'status'=>$request->status
        ]);
        //$image->move('upload/service/', $imagename);
        return redirect()->route('service.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
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
        $service = Service::find($id);
        return view('backend.blogs.service.edit', compact('service'));
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
        $service = Service::find($id);
        $request->validate([
            'title_la'=>'required'
        ],[
            'title_la.required'=>'ໃສ່ພາດຫົວເລື່ອງກ່ອນ!'
        ]);
        /*
        if($request->has('image'))
        {
            $image = $request->image;
            $imagename = time().$image->getClientOriginalName();
            $image->move('upload/service/', $imagename);
            $service_data = [
                'image'=>'upload/service/'.$imagename,
                'service_icon'=>$request->service_icon,
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'des_la'=>$request->des_la,
                'des_en'=>$request->des_en,
                'status'=>$request->status
            ];
        }else
        {
            $service_data = [
                'service_icon'=>$request->service_icon,
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'des_la'=>$request->des_la,
                'des_en'=>$request->des_en,
                'status'=>$request->status
            ];
        }*/

        $service_data = [
            //'image'=>'upload/service/'.$imagename,
            'service_icon'=>$request->service_icon,
            'title_la'=>$request->title_la,
            'title_en'=>$request->title_en,
            'des_la'=>$request->des_la,
            'des_en'=>$request->des_en,
            'status'=>$request->status
        ];
        $service->update($service_data);
        return redirect(route('service.index'))->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if(file_exists($service->image)) {
            unlink($service->image);
            $service->delete();
        }
        else
        {
            $service->delete();
        }
        return redirect()->back()->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
    }
}
