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

class ImportDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $import_doc = DocImport::orderBy('id','desc')->where('del',1)->get();
        return view('backend.documents.import.index', compact('import_doc'));
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
        return view('backend.documents.import.create', compact('doc_type','depart','storage'));
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
            'doc_no'=>'required|unique:doc_imports',
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
            'depart_id.required'=>'ເລືອກພາກສ່ວນສົ່ງກ່ອນ!',
            'storage_file_id.required'=>'ເລືອກບ່ອນເກັບມ້ຽນກ່ອນ!',
            'file.required'=>'ເລືອກຟາຍເອກະສານກ່ອນ!',
        ]);


        $file = $request->file;
        $filename = time().$file->getClientOriginalName();

        $import_doc = DocImport::create([
            'code'=>$request->doc_no,
            'date'=>$request->date,
            'type_id'=>$request->doc_type,
            'doc_no'=>$request->no_doc,
            'doc_date'=>$request->date_doc,
            'title'=>$request->short_title,
            'external_id'=>$request->depart_id,
            'storage_id'=>$request->storage_file_id,
            'file'=>'files/doc/import/'.$filename,
            'user_id'=> Auth::user()->id,
            'branch_id'=> Auth::user()->branchname->id,
        ]);

        $file->move('files/doc/import/',$filename);

        return redirect()->route('import_doc.index')->with('success','ເພີ່ມຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $import_doc = DocImport::find($id);
        return view('backend.documents.import.show', compact('import_doc'));
    }

    public function download($id)
    {
        $dl_import = DocImport::find($id);
        return response()->file($dl_import->file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $import_doc = DocImport::find($id);
        $doc_type = DocType::get();
        $depart = Department::where('del',1)->get();
        $storage = DocStorage::get();

        return view('backend.documents.import.edit', compact('import_doc','doc_type','depart','storage'));
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
            'depart_id.required'=>'ເລືອກພາກສ່ວນສົ່ງກ່ອນ!',
            'storage_file_id.required'=>'ເລືອກບ່ອນເກັບມ້ຽນກ່ອນ!'
        ]);
        $import_doc = DocImport::find($id);

        if($request->has('file'))
        {
        
            $file = $request->file;
            $filename = time().$file->getClientOriginalName();
            $file->move('files/doc/import/',$filename);

            $import_data = [
                'code'=>$request->doc_no,
                'date'=>$request->date,
                'type_id'=>$request->doc_type,
                'doc_no'=>$request->no_doc,
                'doc_date'=>$request->date_doc,
                'title'=>$request->short_title,
                'external_id'=>$request->depart_id,
                'storage_id'=>$request->storage_file_id,
                'file'=>'files/doc/import/'.$filename,
                'user_id'=> auth()->user()->id,
                'branch_id'=> auth()->user()->branchname->id,
            ];
        } else
        {
            $import_data = [
                'code'=>$request->doc_no,
                'date'=>$request->date,
                'type_id'=>$request->doc_type,
                'doc_no'=>$request->no_doc,
                'doc_date'=>$request->date_doc,
                'title'=>$request->short_title,
                'external_id'=>$request->depart_id,
                'storage_id'=>$request->storage_file_id,
                'user_id'=> auth()->user()->id,
                'branch_id'=> auth()->user()->branchname->id,
            ];
        }

        $import_doc->update($import_data);
        return redirect()->route('import_doc.index')->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    //Update Comment Import
    public function update_comment(Request $request, $id)
    {
        $import_doc = DocImport::find($id);
        $import_date= [
            $import_doc->cm_status = 1,
            $import_doc->comment = $request->comment,
            $import_doc->cm_user_id = Auth::user()->id,
            $import_doc->cm_time = Carbon::now(),
            $import_doc->is_new = 1
        ];

        $import_doc->update($import_date);
        return redirect()->back()->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $import_doc = DocImport::find($id);
        $import_doc->del = 0;
        $import_doc->save();
        return redirect()->route('import_doc.index')->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
    }
}
