<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Page;
use Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::where('del',1)->get();
        return view('backend.blogs.page.index', compact('page'));
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
        $page = Page::find($id);
        return view('backend.blogs.page.edit', compact('page'));
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
        $page = Page::find($id);

        $request->validate([
            'slug'=>'required'
        ],[ 
            'slug.required'=>'ໃສ່ Slug ກ່ອນ! ໃຫ້ເປັນພາສາອັງກິດ. ຕົວຢ່າງ: creat-new-slug'
        ]);

        if($request->has('image'))
        {
            /*
            //ບັນທຶກຮູບ ແລະ ວີດີໂອ ໄປເກັບໄວ້ຊ່ອງ public ໂດຍບໍ່ເກັບເຂົ້າຖານຂໍ້ມູນ
            $des_la = $request->des_la;
            $dom = new \DomDocument();
            //$dom->loadHtml($des_la);
            @$dom->loadHtml( mb_convert_encoding($des_la, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);     
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/page/" . 'en' . time().$k.'.png';
                        $path = public_path() . $image_name;
                        file_put_contents($path, $data);
                        $img->removeAttribute('src');
                        $img->setAttribute('src', $image_name);
                    }else
                    {
                        $image_name= "/" . $data;
                        $img->setAttribute('src', $image_name);
                    }
                }
            $des_la = $dom->saveHTML();

            $des_en = $request->des_en;
            $dom = new \DomDocument();
            @$dom->loadHtml( mb_convert_encoding($des_en, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/page/" . 'en' . time().$k.'.png';
                        $path = public_path() . $image_name;
                        file_put_contents($path, $data);
                        $img->removeAttribute('src');
                        $img->setAttribute('src', $image_name);
                    }else
                    {
                        $image_name= "/" . $data;
                        $img->setAttribute('src', $image_name);
                    }
                }
            $des_en = $dom->saveHTML();*/
            
            $image = $request->image;
            $imagename = time().$image->getClientOriginalName();
            $image->move('images/',$imagename);

            $page_data = [
                'image'=>'images/'.$imagename,
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'slug'=>$request->slug,
                'short_des_la'=>$request->short_des_la,
                'short_des_en'=>$request->short_des_en,
                'des_la'=>$request->des_la,
                'des_en'=>$request->des_en,
                'status'=>$request->status,
                'user_id'=> Auth::user()->id,
            ];
        }
        else
        {
            /*
            //ບັນທຶກຮູບ ແລະ ວີດີໂອ ໄປເກັບໄວ້ຊ່ອງ public ໂດຍບໍ່ເກັບເຂົ້າຖານຂໍ້ມູນ
            $des_la = $request->des_la;
            $dom = new \DomDocument();
            //$dom->loadHtml($des_la);
            @$dom->loadHtml( mb_convert_encoding($des_la, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);     
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/page/" . 'en' . time().$k.'.png';
                        $path = public_path() . $image_name;
                        file_put_contents($path, $data);
                        $img->removeAttribute('src');
                        $img->setAttribute('src', $image_name);
                    }else
                    {
                        $image_name= "/" . $data;
                        $img->setAttribute('src', $image_name);
                    }
                }
            $des_la = $dom->saveHTML();

            $des_en = $request->des_en;
            $dom = new \DomDocument();
            @$dom->loadHtml( mb_convert_encoding($des_en, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/page/" . 'en' . time().$k.'.png';
                        $path = public_path() . $image_name;
                        file_put_contents($path, $data);
                        $img->removeAttribute('src');
                        $img->setAttribute('src', $image_name);
                    }else
                    {
                        $image_name= "/" . $data;
                        $img->setAttribute('src', $image_name);
                    }
                }
            $des_en = $dom->saveHTML();*/

            $page_data = [
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'slug'=>$request->slug,
                'short_des_la'=>$request->short_des_la,
                'short_des_en'=>$request->short_des_en,
                'des_la'=>$request->des_la,
                'des_en'=>$request->des_en,
                'status'=>$request->status,
                'user_id'=> Auth::user()->id,
            ];
        }

        $page->update($page_data);
        return redirect(route('page.index'))->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        $page->del = 0;
        $page->save();
        return redirect()->back()->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }
}
