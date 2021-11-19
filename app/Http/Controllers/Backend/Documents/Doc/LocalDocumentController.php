<?php

namespace App\Http\Controllers\Backend\Documents\Doc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doc\DocExport;
use App\Models\Doc\DocImport;
use App\Models\Doc\DocLocal;
use App\Models\Doc\Department;
use App\Models\Doc\DocType;
use App\Models\Doc\DocStorage;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocalDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $local_doc = DocLocal::orderBy('id','desc')->where('del',1)->get();
        return view('backend.documents.localdoc.index', compact('local_doc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doc_type = DocType::get();
        $storage = DocStorage::get();
        return view('backend.documents.localdoc.create', compact('doc_type','storage'));
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
            'date'=>'required',
            'doc_type'=>'required',
            'short_title'=>'required',
            'storage_file_id'=>'required',
            'file'=>'required'
        ],[
            'date.required'=>'ເລືອກວັນທີກ່ອນ!',
            'doc_type.required'=>'ເລືອກປະເພດເອກະສານກ່ອນ!',
            'short_title.required'=>'ກະລຸນາໃສ່ເນື້ອໃນເອກະສານ!',
            'storage_file_id.required'=>'ເລືອກບ່ອນເກັບມ້ຽນກ່ອນ!',
            'file.required'=>'ເລືອກຟາຍເອກະສານກ່ອນ!',
        ]);

        $file = $request->file;
        $filename = time().$file->getClientOriginalName();

        $local_doc = DocLocal::create([
            'date'=>$request->date,
            'type_id'=>$request->doc_type,
            'title'=>$request->short_title,
            'storage_id'=>$request->storage_file_id,
            'file'=>'files/doc/local/'.$filename,
            'user_id'=> auth()->user()->id,
            'branch_id'=> auth()->user()->branchname->id,
        ]);

        $file->move('files/doc/local/',$filename);

        return redirect()->route('local_doc.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $local_doc = DocLocal::find($id);
        return view('backend.documents.localdoc.show', compact('local_doc'));
    }

    public function download($id)
    {
        $dl_local = DocLocal::find($id);
        /*
        $download_path = $dl_local->file;
        return( Response::download( $download_path ));
        */
        return response()->file($dl_local->file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $local_doc = DocLocal::find($id);
        $doc_type = DocType::get();
        $storage = DocStorage::get();

        return view('backend.documents.localdoc.edit', compact('local_doc','doc_type','storage'));
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
        $request->validate([
            'date'=>'required',
            'doc_type'=>'required',
            'short_title'=>'required',
            'storage_file_id'=>'required'
        ],[
            'date.required'=>'ເລືອກວັນທີກ່ອນ!',
            'doc_type.required'=>'ເລືອກປະເພດເອກະສານກ່ອນ!',
            'short_title.required'=>'ກະລຸນາໃສ່ເນື້ອໃນເອກະສານ!',
            'storage_file_id.required'=>'ເລືອກບ່ອນເກັບມ້ຽນກ່ອນ!'
        ]);
        $local_doc = DocLocal::find($id);

        if($request->has('file'))
        {
        
            $file = $request->file;
            $filename = time().$file->getClientOriginalName();
            $file->move('files/doc/local/',$filename);

            $local_data = [
                'date'=>$request->date,
                'type_id'=>$request->doc_type,
                'title'=>$request->short_title,
                'storage_id'=>$request->storage_file_id,
                'file'=>'files/doc/local/'.$filename,
                'user_id'=> auth()->user()->id,
                'branch_id'=> auth()->user()->branchname->id,
            ];
        } else
        {
            $local_data = [
                'date'=>$request->date,
                'type_id'=>$request->doc_type,
                'title'=>$request->short_title,
                'storage_id'=>$request->storage_file_id,
                'user_id'=> auth()->user()->id,
                'branch_id'=> auth()->user()->branchname->id,
            ];
        }

        $local_doc->update($local_data);
        return redirect()->route('local_doc.index')->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $local_doc = DocLocal::find($id);

        $local_doc->del = 0;
        $local_doc->save();
        return redirect()->route('local_doc.index')->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
    }
}
