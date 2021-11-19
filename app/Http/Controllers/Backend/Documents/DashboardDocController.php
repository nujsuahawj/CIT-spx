<?php

namespace App\Http\Controllers\Backend\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Doc\DocExport;
use App\Models\Doc\DocImport;
use App\Models\Doc\DocLocal;
use App\Models\Doc\Department;
use App\Models\Doc\DocType;
use App\Models\Doc\DocStorage;
use App\Models\User;

class DashboardDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $im_count = DocImport::where('del',1)->count();
        $ex_count = DocExport::where('del',1)->count();
        $local_count = DocLocal::where('del',1)->count();
        $not_comment_count = DocImport::where('del',1)->count();

        $depart_count = Department::where('del',1)->count();
        $doctype_count = DocType::select('id')->count();
        $storage_count = DocStorage::select('id')->count();
        $user_count = User::where('del',1)->count();

        //Import Chart
        $import_chart = DocImport::select(DB::raw('count(doc_no) as count'))
                ->whereYear('date', date('Y'))->where('del',1)->groupBy(DB::raw('Month(date)'))
                ->pluck('count');
        $months = DocImport::select(DB::raw('Month(date) as month'))
                ->whereYear('date', date('Y'))->groupBy(DB::raw('Month(date)'))
                ->pluck('month');

        $datas_import = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months as $index => $month)
        {
            $datas_import[$month-1] = $import_chart[$index];
        }

        //Export Chart
        $export_chart = DocExport::select(DB::raw('count(code) as count'))
                ->whereYear('date', date('Y'))->where('del',1)->groupBy(DB::raw('Month(date)'))
                ->pluck('count');
        $months_export = DocExport::select(DB::raw('Month(date) as month'))
                ->whereYear('date', date('Y'))->groupBy(DB::raw('Month(date)'))
                ->pluck('month');

        $datas_export = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months_export as $index => $month)
        {
            $datas_export[$month-1] = $export_chart[$index];
        }
        return view('backend.documents.dashboarddoc', compact('im_count','ex_count','local_count','not_comment_count','depart_count','doctype_count','storage_count','user_count',
            'datas_import','datas_export'
        ));
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
        //
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
        //
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
