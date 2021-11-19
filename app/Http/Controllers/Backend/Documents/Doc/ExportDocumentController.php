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

class ExportDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export_doc = DocExport::orderBy('id','desc')->where('del',1)->get();
        return view('backend.documents.export.index', compact('export_doc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doc_type = DocType::get();
        $depart = Department::where('del',1)->get();
        $storage = DocStorage::get();

        return view('backend.documents.export.create', compact('doc_type','depart','storage'));
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
            'doc_no'=>'required',
            'date'=>'required',
            'doc_type'=>'required',
            'short_title'=>'required',
            'depart_id'=>'required',
            'storage_file_id'=>'required',
            'file'=>'required'
        ],[
            'doc_no.required'=>'ກະລຸນາໃສ່ເລກທີຂາອອກກ່ອນ!',
            'doc_no.unique'=>'ເລກທີນີ້ໄດ້ມີແລ້ວ!',
            'date.required'=>'ເລືອກວັນທີກ່ອນ!',
            'doc_type.required'=>'ເລືອກປະເພດເອກະສານກ່ອນ!',
            'short_title.required'=>'ກະລຸນາໃສ່ເນື້ອໃນເອກະສານ!',
            'depart_id.required'=>'ເລືອກພະແນກການກ່ອນ!',
            'storage_file_id.required'=>'ເລືອກບ່ອນເກັບມ້ຽນກ່ອນ!',
            'file.required'=>'ເລືອກຟາຍເອກະສານກ່ອນ!',
        ]);


        $file = $request->file;
        $filename = time().$file->getClientOriginalName();

        $export_doc = DocExport::create([
            'code'=>$request->doc_no,
            'date'=>$request->date,
            'type_id'=>$request->doc_type,
            'title'=>$request->short_title,
            'external_id'=>$request->depart_id,
            'storage_id'=>$request->storage_file_id,
            'file'=>'files/doc/export/'.$filename,
            'user_id'=> auth()->user()->id,
            'branch_id'=> auth()->user()->branchname->id,
        ]);

        $file->move('files/doc/export/',$filename);

        return redirect()->route('export_doc.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $export_doc = DocExport::find($id);
        return view('backend.documents.export.show', compact('export_doc'));
    }

    public function download($id)
    {
        $dl_export = DocExport::find($id);
        return response()->file($dl_export->file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $export_doc = DocExport::find($id);
        $doc_type = DocType::get();
        $depart = Department::where('del',1)->get();
        $storage = DocStorage::get();

        return view('backend.documents.export.edit', compact('export_doc','doc_type','depart','storage'));
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
            'doc_no'=>'required',
            'date'=>'required',
            'doc_type'=>'required',
            'short_title'=>'required',
            'depart_id'=>'required',
            'storage_file_id'=>'required'
        ],[
            'doc_no.required'=>'ກະລຸນາໃສ່ເລກທີຂາອອກກ່ອນ!',
            'date.required'=>'ເລືອກວັນທີກ່ອນ!',
            'doc_type.required'=>'ເລືອກປະເພດເອກະສານກ່ອນ!',
            'short_title.required'=>'ກະລຸນາໃສ່ເນື້ອໃນເອກະສານ!',
            'depart_id.required'=>'ເລືອກພະແນກການກ່ອນ!',
            'storage_file_id.required'=>'ເລືອກບ່ອນເກັບມ້ຽນກ່ອນ!'
        ]);
        $export_doc = DocExport::find($id);

        if($request->has('file'))
        {
        
            $file = $request->file;
            $filename = time().$file->getClientOriginalName();
            $file->move('files/doc/export/',$filename);

            $export_data = [
                'code'=>$request->doc_no,
                'date'=>$request->date,
                'type_id'=>$request->doc_type,
                'title'=>$request->short_title,
                'external_id'=>$request->depart_id,
                'storage_id'=>$request->storage_file_id,
                'file'=>'files/doc/export/'.$filename,
                'user_id'=> auth()->user()->id,
                'branch_id'=> auth()->user()->branchname->id,
            ];
        } else
        {
            $export_data = [
                'code'=>$request->doc_no,
                'date'=>$request->date,
                'type_id'=>$request->doc_type,
                'title'=>$request->short_title,
                'external_id'=>$request->depart_id,
                'storage_id'=>$request->storage_file_id,
                'user_id'=> auth()->user()->id,
                'branch_id'=> auth()->user()->branchname->id,
            ];
        }

        $export_doc->update($export_data);
        return redirect()->route('export_doc.index')->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $export_doc = DocExport::find($id);
        $export_doc->del = 0;
        $export_doc->save();
        return redirect()->route('export_doc.index')->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
    }
}
