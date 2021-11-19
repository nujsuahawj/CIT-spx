<?php

namespace App\Http\Controllers\Backend\Documents\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doc\DocExport;
use App\Models\Doc\DocImport;
use App\Models\Doc\DocLocal;
use App\Models\Doc\Department;
use App\Models\Doc\DocType;
use App\Models\Doc\DocStorage;
use App\Models\Settings\Branch;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
//Import Daily
    public function daily_import_report()
    {      
        $daily_import = DocImport::whereDate('date', Carbon::today())->where('del',1)->get();
        $total_daily_import = DocImport::whereDate('date', Carbon::today())->where('del',1)->count();
        return view('backend.documents.reports.import.daily_import_report', compact('daily_import','total_daily_import'));
    }
    public function print_daily_import_report()
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();
        $daily_import = DocImport::whereDate('date', Carbon::today())->where('del',1)->get();
        $total_daily_import = DocImport::whereDate('date', Carbon::today())->where('del',1)->count();
        return view('backend.documents.reports.import.daily_import_report_print', compact('branch','daily_import','total_daily_import'));
    }
    //Import Month
    public function month_import_report()
    {
        $month_import = DocImport::whereMonth('date', date('m'))->where('del',1)->get();
        $total_month_import = DocImport::whereMonth('date', date('m'))->where('del',1)->count();
        return view('backend.documents.reports.import.month_import_report', compact('month_import','total_month_import'));
    }
    public function print_month_import_report()
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();
        $month_import = DocImport::whereMonth('date', date('m'))->where('del',1)->get();
        $total_month_import = DocImport::whereMonth('date', date('m'))->where('del',1)->count();
        return view('backend.documents.reports.import.month_import_report_print', compact('branch','month_import','total_month_import'));
    }
    //Import Year
    public function year_import_report()
    {
        $year_import = DocImport::whereYear('date', date('Y'))->where('del',1)->get();
        $total_year_import = DocImport::whereYear('date', date('Y'))->where('del',1)->count();
        return view('backend.documents.reports.import.year_import_report', compact('year_import','total_year_import'));
    }
    public function print_year_import_report()
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();
        $year_import = DocImport::whereYear('date', date('Y'))->where('del',1)->get();
        $total_year_import = DocImport::whereYear('date', date('Y'))->where('del',1)->count();
        return view('backend.documents.reports.import.year_import_report_print', compact('branch','year_import','total_year_import'));
    }

    //Customize import report
    public function customize_import_report(Request $request)
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();
        $import_search = DocImport::query()->whereBetween('date',[$request->from_date, $request->to_date])
            ->orWhere('type_id','=', $request->doc_type)
            ->orWhere('external_id','=', $request->doc_depart)
            ->get();

        $doc_type = DocType::get();
        $doc_depart = Department::where('del',1)->get();
        return view('backend.documents.reports.import.customize_import_report', compact('import_search','doc_type','doc_depart'));
    }
    public function customize_import_report_print(Request $request)
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();

        $import_search = DocImport::query()->whereBetween('date',[$request->from_date, $request->to_date])
            ->orWhere('type_id','=', $request->doc_type)
            ->orWhere('external_id','=', $request->doc_depart)
            ->get();

        $doc_type = DocType::get();
        $doc_depart = Department::where('del',1)->get();
        return view('backend.documents.reports.import.customize_import_report_print', compact('branch','import_search','doc_type','doc_depart'));
    }


    //Export Daily
    public function daily_export_report()
    {
        $daily_export = DocExport::whereDate('date', Carbon::today())->where('del',1)->get();
        $total_daily_export = DocExport::whereDate('date', Carbon::today())->where('del',1)->count();
        return view('backend.documents.reports.export.daily_export_report', compact('daily_export','total_daily_export'));
    }
    public function print_daily_export_report()
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();
        $daily_export = DocExport::whereDate('date', Carbon::today())->where('del',1)->get();
        $total_daily_export = DocExport::whereDate('date', Carbon::today())->where('del',1)->count();
        return view('backend.documents.reports.export.daily_export_report_print', compact('branch','daily_export','total_daily_export'));
    }
    //Export Month
    public function month_export_report()
    {
        $month_export = DocExport::whereMonth('date', date('m'))->where('del',1)->get();
        $total_month_export = DocExport::whereMonth('date', date('m'))->where('del',1)->count();
        return view('backend.documents.reports.export.month_export_report', compact('month_export','total_month_export'));
    }
    public function print_month_export_report()
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();
        $month_export = DocExport::whereMonth('date', date('m'))->where('del',1)->get();
        $total_month_export = DocExport::whereMonth('date', date('m'))->where('del',1)->count();
        return view('backend.documents.reports.export.month_export_report_print', compact('branch','month_export','total_month_export'));
    }
    //Export Year
    public function year_export_report()
    {
        $year_export = DocExport::whereYear('date', date('Y'))->where('del',1)->get();
        $total_year_export = DocExport::whereYear('date', date('Y'))->where('del',1)->count();
        return view('backend.documents.reports.export.year_export_report', compact('year_export','total_year_export'));
    }
    public function print_year_export_report()
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();
        $year_export = DocExport::whereYear('date', date('Y'))->where('del',1)->get();
        $total_year_export = DocExport::whereYear('date', date('Y'))->where('del',1)->count();
        return view('backend.documents.reports.export.year_export_report_print', compact('branch','year_export','total_year_export'));
    }

    //Customize export report
    public function customize_export_report(Request $request)
    {
        
        $doc_type = DocType::get();
        $doc_depart = Department::where('del',1)->get();
        return view('backend.documents.reports.export.customize_export_report', compact('doc_type','doc_depart'));
    }
    public function customize_export_report_print(Request $request)
    {
        $branch = Branch::where('id', Auth()->user()->branchname->id)->first();

        $export_search = DocExport::query()->whereBetween('date',[$request->from_date, $request->to_date])
            ->orWhere('type_id','=', $request->doc_type)
            ->orWhere('external_id','=', $request->doc_depart)
            ->get();

        $doc_type = DocType::get();
        $doc_depart = Department::where('del',1)->get();
        return view('backend.documents.reports.export.customize_export_report_print', compact('branch','export_search','doc_type','doc_depart'));
    }
}
