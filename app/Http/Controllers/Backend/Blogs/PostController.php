<?php

namespace App\Http\Controllers\Backend\Blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Post;
use App\Models\Web\Tag;
use App\Models\Web\PostCategory;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag = Tag::all();
        if(Auth::user()->rolename == 'admin')
            $posts = Post::where('del',1)->get();
        else
            $posts = Post::where('del',1)->where('user_id', Auth::user()->id)->get();
        
        return view('backend.blogs.post.index', compact('tag','posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_postcate = PostCategory::all();
        return view('backend.blogs.post.create', compact('all_postcate'));
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
            'image'=>'required',
            'slug'=>'required'
        ],[ 
            'image.required'=>'ເລືອກຮູບກ່ອນ!',
            'slug.required'=>'ໃສ່ Slug ກ່ອນ! ໃຫ້ເປັນພາສາອັງກິດ. ຕົວຢ່າງ: creat-new-slug'
        ]);

        $image = $request->image;
        $imagename = time().$image->getClientOriginalName();

        //ບັນທຶກຮູບ ແລະ ວີດີໂອ ໄປເກັບໄວ້ຊ່ອງ public ໂດຍບໍ່ເກັບເຂົ້າຖານຂໍ້ມູນ
        $des_la = $request->des_la;
        $dom = new \DomDocument();
        //$dom->loadHtml($des_la);
        $dom->loadHtml( mb_convert_encoding($des_la, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/upload/blogsdes/" . 'la' . time().$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
            }
        $des_la = $dom->saveHTML();

        $des_en = $request->des_en;
        $dom = new \DomDocument();
        //$dom->loadHtml($des_en);
        $dom->loadHtml( mb_convert_encoding($des_en, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/upload/blogsdes/" . 'en' . time().$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
            }
        $des_en = $dom->saveHTML();

        Post::create([
            'image'=>'upload/blogs/'.$imagename,
            'title_la'=>$request->title_la,
            'title_en'=>$request->title_en,
            'slug'=>$request->slug,
            'short_des_la'=>$request->short_des_la,
            'short_des_en'=>$request->short_des_en,
            'des_la'=>$des_la,
            'des_en'=>$des_en,
            'postcate_id'=>$request->postcate_id,
            'view'=>100,
            'user_id'=> Auth::user()->id,
            'branch_id'=> Auth::user()->branchname->id,
        ]);
        $image->move('upload/blogs/',$imagename);
        return redirect()->route('post.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
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
        $post = Post::find($id);
        $all_postcate = PostCategory::all();
        return view('backend.blogs.post.edit', compact('post','all_postcate'));
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
        $post = Post::find($id);
        $request->validate([
            'slug'=>'required'
        ],[ 
            'slug.required'=>'ໃສ່ Slug ກ່ອນ! ໃຫ້ເປັນພາສາອັງກິດ. ຕົວຢ່າງ: creat-new-slug'
        ]);

        if($request->has('image'))
        {
            $image = $request->image;
            $imagename = time().$image->getClientOriginalName();
            $image->move('upload/blogs/',$imagename);

            //ບັນທຶກຮູບ ແລະ ວີດີໂອ ໄປເກັບໄວ້ຊ່ອງ public ໂດຍບໍ່ເກັບເຂົ້າຖານຂໍ້ມູນ
            $des_la = $request->des_la;
            $dom = new \DomDocument();
            //$dom->loadHtml($des_la);
            //libxml_use_internal_errors(true);
            $dom->loadHtml( mb_convert_encoding($des_la, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            $bs64 = 'base64';
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/blogsdes/" . 'la' . time().$k.'.png';
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
            //$dom->loadHtml($des_en);
            //libxml_use_internal_errors(true);
            $dom->loadHtml( mb_convert_encoding($des_en, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);     
            $images = $dom->getElementsByTagName('img');
            $bs64 = 'base64';
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/blogsdes/" . 'en' . time().$k.'.png';
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
            $des_en = $dom->saveHTML();

            $post_data = [
                'image'=>'upload/blogs/'.$imagename,
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'slug'=>$request->slug,
                'short_des_la'=>$request->short_des_la,
                'short_des_en'=>$request->short_des_en,
                'des_la'=>$des_la,
                'des_en'=>$des_en,
                'postcate_id'=>$request->postcate_id,
                'user_id'=> Auth::user()->id,
                'branch_id'=> Auth::user()->branchname->id,
                'published'=> $request->publish
            ];
        }
        else
        {
            //ບັນທຶກຮູບ ແລະ ວີດີໂອ ໄປເກັບໄວ້ຊ່ອງ public ໂດຍບໍ່ເກັບເຂົ້າຖານຂໍ້ມູນ
            $des_la = $request->des_la;
            $dom = new \DomDocument();
            //$dom->loadHtml($des_la);
            //libxml_use_internal_errors(true);
            $dom->loadHtml( mb_convert_encoding($des_la, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);     
            $images = $dom->getElementsByTagName('img');
            $bs64 = 'base64';
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/blogsdes/" . 'en' . time().$k.'.png';
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
            //$dom->loadHtml($des_en);
            //$dom->loadHtml($des_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            //libxml_use_internal_errors(true);
            $dom->loadHtml( mb_convert_encoding($des_en, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');
            $bs64 = 'base64';
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                    if(strpos($data, $bs64) == true)
                    {
                        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                        $image_name= "/upload/blogsdes/" . 'en' . time().$k.'.png';
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
            $des_en = $dom->saveHTML();

            $post_data = [
                'title_la'=>$request->title_la,
                'title_en'=>$request->title_en,
                'slug'=>$request->slug,
                'short_des_la'=>$request->short_des_la,
                'short_des_en'=>$request->short_des_en,
                'des_la'=>$des_la,
                'des_en'=>$des_en,
                'postcate_id'=>$request->postcate_id,
                'user_id'=> Auth::user()->id,
                'branch_id'=> Auth::user()->branchname->id,
                'published'=> $request->publish
            ];
        }
        $post->update($post_data);
        return redirect(route('post.index'))->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->del = 0;
        $post->save();
        return redirect()->back()->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }
}
