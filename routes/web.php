<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalController;
use App\Http\Livewire\Admin\LoginComponent;
use App\Http\Livewire\Admin\DashboardComponent;
use App\Http\Livewire\Admin\User\UserCoponent;
use App\Http\Livewire\Admin\Address\ProvinceComponent;
use App\Http\Livewire\Admin\Address\DistrictComponent;
use App\Http\Livewire\Admin\Address\VillageComponent;
use App\Http\Livewire\Admin\Products\CatalogComponent;
use App\Http\Livewire\Admin\Products\ProductComponent;
use App\Http\Livewire\Admin\Sales\SaleComponent;
use App\Http\Livewire\Admin\Sales\CreateSaleComponent;
use App\Http\Livewire\Admin\Sales\SaleDetailComponent;
use App\Http\Livewire\Admin\Sales\EditSaleComponent;
use App\Http\Livewire\Admin\Sales\SalePrintComponent;
use App\Http\Livewire\Admin\Customer\CustomerTypeComponent;
use App\Http\Livewire\Admin\Customer\CustomerComponent;
use App\Http\Livewire\Admin\Expenses\ExpensesComponent;

//Route::get('localization/{local}',[LocalController::class, 'index']);
Route::get('localization/{local}' , function($local){
    Session::put('local', $local);
    return back();
});

//Frontend
Route::get('/', App\Http\Livewire\Frontend\HomeComponent::class)->name('home');
Route::get('/about', App\Http\Livewire\Frontend\AboutComponent::class)->name('about');
Route::get('/contact', App\Http\Livewire\Frontend\ContactComponent::class)->name('contact');
Route::get('/calculator', App\Http\Livewire\Frontend\CalculatorComponent::class)->name('calculator');
Route::get('/term_condition', App\Http\Livewire\Frontend\TermConditionComponent::class)->name('term_condition');
//Route::get('/page/{id}', App\Http\Livewire\Frontend\PageDetailComponent::class)->name('page.detail');
//Route::get('/blog', App\Http\Livewire\Frontend\BlogComponent::class)->name('blog');
//Route::get('/blog/{id}', App\Http\Livewire\Frontend\BlogDetailComponent::class)->name('blog.detail');


//Backend
Route::get('/loginadmin', LoginComponent::class)->name('login');

Route::group(['middleware'=> 'adminLogin'], function(){

    //Condition
    Route::get('/dashboard', DashboardComponent::class)->name('admin.dashboard');
    Route::get('/user', UserCoponent::class)->name('admin.user');
    Route::get('/province', ProvinceComponent::class)->name('admin.province');
    Route::get('/district', DistrictComponent::class)->name('admin.district');
    Route::get('/village', VillageComponent::class)->name('admin.village');
    Route::get('/exchange', App\Http\Livewire\Admin\Settings\ExchangeComponent::class)->name('admin.exchange');
    Route::get('/customertype', App\Http\Livewire\Admin\Settings\CustomerTypeComponent::class)->name('admin.customertype');
    Route::get('/branchtype', App\Http\Livewire\Admin\Settings\BranchTypeComponent::class)->name('admin.branchtype');
    Route::get('/goodstype', App\Http\Livewire\Admin\Settings\GoodsTypeComponent::class)->name('admin.goodstype');
    Route::get('/producttype', App\Http\Livewire\Admin\Settings\ProductTypeComponent::class)->name('admin.producttype');
    Route::get('/vihicletype', App\Http\Livewire\Admin\Settings\VihicleTypeComponent::class)->name('admin.vihicletype');
    Route::get('/calculateprice', App\Http\Livewire\Admin\Settings\CalculatePriceComponent::class)->name('admin.calculateprice');
    Route::get('/cod_rate', App\Http\Livewire\Admin\Settings\CodRateComponent::class)->name('admin.cod_rate');
    Route::get('/payment', App\Http\Livewire\Admin\Settings\PaymentComponent::class)->name('admin.payment');
    Route::get('/payment_type', App\Http\Livewire\Admin\Settings\PaymentTypeComponent::class)->name('admin.payment_type');
    Route::get('/insurance', App\Http\Livewire\Admin\Settings\InsuranceComponent::class)->name('admin.insurance');
    Route::get('/shipping_status', App\Http\Livewire\Admin\Settings\ShippingStatusComponent::class)->name('admin.shipping_status');
    Route::get('/packet', App\Http\Livewire\Admin\Settings\PacketComponent::class)->name('admin.packet');

    Route::get('/dividend', App\Http\Livewire\Admin\Settings\DividendComponent::class)->name('admin.dividend');
    Route::get('/vat', App\Http\Livewire\Admin\Settings\VatComponent::class)->name('admin.vat');
    Route::get('/pay_devidend', App\Http\Livewire\Admin\PayDevidend\PayDevidendComponent::class)->name('admin.pay_devidend');
    Route::get('/report_pay_devidend/{id}', App\Http\Livewire\Admin\PayDevidend\ReportPayDevidendComponent::class)->name('admin.report_pay_devidend');
    
    //transaction
    Route::get('/receive', App\Http\Livewire\Admin\Transaction\ReceiveTransactionComponent::class)->name('transaction.receive');
    Route::get('/receive/create', App\Http\Livewire\Admin\Transaction\CreateReceiveTransactionComponent::class)->name('transaction.create');
    Route::get('/receive/detail/{id}', App\Http\Livewire\Admin\Transaction\DetailReceiveTransactionComponent::class)->name('transaction.detail_receive_transaction');

    Route::get('/send_customer', App\Http\Livewire\Admin\SendCustomer\SendCustomerComponent::class)->name('admin.send_customer');
    Route::get('/list_send_customer', App\Http\Livewire\Admin\SendCustomer\ListSendCustomerComponent::class)->name('admin.list_send_customer');

    //Contract
    Route::get('/unit_contract', App\Http\Livewire\Admin\Contract\UnitContractComponent::class)->name('admin.unit_contract');
    Route::get('/unit_contract/download/{id}', [App\Http\Livewire\Admin\Contract\UnitContractComponent::class,'download'])->name('admin.download_contract');

    //CallGood
    Route::get('/call_good', App\Http\Livewire\Admin\CallGood\CallGoodComponent::class)->name('admin.call_good');

    //ewallet
    Route::get('/ewallet', App\Http\Livewire\Admin\Ewallet\ViewEwalletComponent::class)->name('ewallet.view_ewallet');
    Route::get('/ewaltran', App\Http\Livewire\Admin\Ewallet\EwTranComponent::class)->name('ewallet.vuew_ewtran');
    Route::get('/codclearing', App\Http\Livewire\Admin\Ewallet\CodClearComponent::class)->name('ewallet.view_clearing');
    Route::get('/ewalstm', App\Http\Livewire\Admin\Ewallet\EwStateComponent::class)->name('ewallet.vuew_ewstm');


    //traffic
    Route::get('/traffic', App\Http\Livewire\Admin\Traffic\ViewTrafficComponent::class)->name('admin.traffic');
    Route::get('/traffic/create', App\Http\Livewire\Admin\Traffic\CreateTrafficComponent::class)->name('admin.create_traffic');
    Route::get('/traffic/edit/{id}', App\Http\Livewire\Admin\Traffic\EditTrafficComponent::class)->name('admin.edit_traffic');
    Route::get('/traffic/detail/{id}', App\Http\Livewire\Admin\Traffic\DetailTrafficComponent::class)->name('admin.detail_traffic');

    //shipout
    Route::get('/shipout', App\Http\Livewire\Admin\Shipout\ViewShipoutComponent::class)->name('admin.shipout');
    Route::get('/shipout/sub', App\Http\Livewire\Admin\Shipout\SubShipoutComponent::class)->name('admin.sub_shipout');
    Route::get('/shipout/create', App\Http\Livewire\Admin\Shipout\CreateShipoutComponent::class)->name('admin.create_shipout');
    Route::get('/shipout/edit/{id}', App\Http\Livewire\Admin\Shipout\EditShipoutComponent::class)->name('admin.edit_shipout');
    Route::get('/shipout/detail/{id}', App\Http\Livewire\Admin\Shipout\DetailShipoutComponent::class)->name('admin.detail_shipout');
    Route::get('/printa4_shipout/{id}', App\Http\Livewire\Admin\Shipout\PrintShipoutComponent::class)->name('admin.printa4_shipout');

    //Receive Stock
    Route::get('/receive_stock', App\Http\Livewire\Admin\ReceiveStock\ViewReceiveStockComponent::class)->name('admin.receive_stock');
    Route::get('/list_receive_stock', App\Http\Livewire\Admin\ReceiveStock\ListReceiveStockComponent::class)->name('admin.list_receive_stock');
    Route::get('/print_view_receive_stock/{id}', App\Http\Livewire\Admin\ReceiveStock\PrintViewReceiveStockComponent::class)->name('admin.print_view_receive_stock');
    Route::get('/detail_receive/{id}', App\Http\Livewire\Admin\ReceiveStock\DetailReceiveComponent::class)->name('admin.detail_receive');
    Route::get('/print_receive/{id}', App\Http\Livewire\Admin\ReceiveStock\PrintReceiveComponent::class)->name('admin.print_receive');
    Route::get('/shipout_stock', App\Http\Livewire\Admin\ReceiveStock\ViewShipoutStockComponent::class)->name('admin.shipout_stock');
    Route::get('/shipout_stock/create', App\Http\Livewire\Admin\ReceiveStock\CreateShipoutStockComponent::class)->name('admin.create_shipout_stock');
    Route::get('/shipout_stock/detail/{id}', App\Http\Livewire\Admin\ReceiveStock\DetailShipoutStockComponent::class)->name('admin.detail_shipout_stock');

    //Receive Branch
    Route::get('/receive_branch', App\Http\Livewire\Admin\ReceiveBranch\ViewReceiveBranchComponent::class)->name('admin.receive_branch');
    Route::get('/print_view_receive_branch/{id}', App\Http\Livewire\Admin\ReceiveBranch\PrintViewReceiveBranchComponent::class)->name('admin.print_view_receive_branch');
    Route::get('/list_receive_branch', App\Http\Livewire\Admin\ReceiveBranch\ListReceiveBranchComponent::class)->name('admin.list_receive_branch');
    Route::get('/detail_receive_branch/{id}', App\Http\Livewire\Admin\ReceiveBranch\DetailReceiveBranchComponent::class)->name('admin.detail_receive_branch');
    Route::get('/print_receive_branch/{id}', App\Http\Livewire\Admin\ReceiveBranch\PrintReceiveBranchComponent::class)->name('admin.print_receive_branch');

    //vihicle
    Route::get('/vihicle', App\Http\Livewire\Admin\Vihicle\ViewVihicleComponent::class)->name('vihicle.vihicle');
    Route::get('/vihicle/create', App\Http\Livewire\Admin\Vihicle\VihicleComponent::class)->name('vihicle.create');

    //expenses
    Route::get('/expense', App\Http\Livewire\Admin\Expenses\ExpensesComponent::class)->name('expenses.expense');
    
    //customer
    Route::get('/view-customer', App\Http\Livewire\Admin\Customer\CustomerComponent::class)->name('customer.view');

    //employee
    Route::get('/employee', App\Http\Livewire\Admin\Employee\EmployeeComponent::class)->name('admin.employee');
    Route::get('/employee_detail/{id}', App\Http\Livewire\Admin\Employee\EmployeeDetailComponent::class)->name('admin.employee_detail');
    Route::get('/payroll', App\Http\Livewire\Admin\Payroll\PayrollComponent::class)->name('admin.payroll');
    Route::get('/create_payroll', App\Http\Livewire\Admin\Payroll\CreatePayrollComponent::class)->name('admin.create_payroll');
    Route::get('/edit_payroll/{id}', App\Http\Livewire\Admin\Payroll\EditPayrollComponent::class)->name('admin.edit_payroll');
    Route::get('/payroll_detail/{id}', App\Http\Livewire\Admin\Payroll\PayrollDetailComponent::class)->name('admin.payroll_detail');
    Route::get('/printa4_payroll/{id}', App\Http\Livewire\Admin\Payroll\PayrollPrintComponent::class)->name('admin.printa4_payroll');
    Route::get('/report_payroll', App\Http\Livewire\Admin\Payroll\PayrollReportComponent::class)->name('admin.report_payroll');

    //Sale
    Route::get('/sale', SaleComponent::class)->name('admin.sale');
    Route::get('/create_sale', CreateSaleComponent::class)->name('admin.create_sale');
    Route::get('/edit_sale/{id}', EditSaleComponent::class)->name('admin.edit_sale');
    Route::get('/sale_datail/{id}', SaleDetailComponent::class)->name('admin.sale_detail');
    Route::get('/printa4_sale/{id}', SalePrintComponent::class)->name('admin.printa4_sale');

    //Report
    Route::get('/report_separate_goods', App\Http\Livewire\Admin\Report\ReportSeparateGoods::class)->name('admin.report_separate_goods');
    Route::get('/report_receive_goods', App\Http\Livewire\Admin\Report\ReportReceiveGoods::class)->name('admin.report_receive_goods');
    
    //Documents
    Route::resource('/dashboarddoc', App\Http\Controllers\Backend\Documents\DashboardDocController::class);

    //Blogs
    //Route::get('/blog', App\Http\Livewire\Admin\Blog\BlogComponent::class)->name('admin.blog');
    Route::resource('/dashboardblog', App\Http\Controllers\Backend\Blogs\DashboardBlogController::class);
    Route::resource('/post', App\Http\Controllers\Backend\Blogs\PostController::class);
    Route::resource('/service', App\Http\Controllers\Backend\Blogs\ServiceController::class);
    Route::resource('/page', App\Http\Controllers\Backend\Blogs\PageController::class);
    Route::resource('/postcategory', App\Http\Controllers\Backend\Blogs\PostCategoryController::class);
    Route::resource('/tag', App\Http\Controllers\Backend\Blogs\TagController::class);
    Route::resource('/texttitle', App\Http\Controllers\Backend\Blogs\TextTitleController::class);
    Route::resource('/slider', App\Http\Controllers\Backend\Blogs\SliderController::class);
    Route::resource('/testimonial', App\Http\Controllers\Backend\Blogs\TestimonialController::class);
    Route::resource('/message',App\Http\Controllers\Backend\Blogs\MessageController::class);

    //Settings
    Route::resource('/dashboardsetting', App\Http\Controllers\Backend\Settings\DashboardSettingController::class);
    Route::resource('/branch', App\Http\Controllers\Backend\Settings\BranchController::class);
    Route::resource('/user', App\Http\Controllers\Backend\Settings\UserController::class);
    Route::get('/branchs', App\Http\Livewire\Admin\Settings\BranchsComponnet::class)->name('settings.branchs-componnet');
    Route::get('/users', App\Http\Livewire\Admin\Settings\UsersComponent::class)->name('settings.users-component');

    //voucher
    Route::get('/printReceive/{service_id}', App\Http\Livewire\Admin\Voucher\ReceivePrintComponent::class,"services")->name('voucher.printreceive');
    Route::get('/printmatterail/{service_id}', App\Http\Livewire\Admin\Voucher\MatterailPrintComponent::class,"services")->name('voucher.printmatterail');

    

    //Documents
    Route::resource('/dashboarddoc', App\Http\Controllers\Backend\Documents\DashboardDocController::class);
    Route::resource('/import_doc', App\Http\Controllers\Backend\Documents\Doc\ImportDocumentController::class);
    Route::get('/import_doc/download/{id}', [App\Http\Controllers\Backend\Documents\Doc\ImportDocumentController::class,'download'])->name('download_import');
    Route::get('/import_doc/update_comment/{id}', [App\Http\Controllers\Backend\Documents\Doc\ImportDocumentController::class,'update_comment'])->name('update_comment');

    Route::resource('/export_doc', App\Http\Controllers\Backend\Documents\Doc\ExportDocumentController::class);
    Route::get('/export_doc/download/{id}', [App\Http\Controllers\Backend\Documents\Doc\ExportDocumentController::class,'download'])->name('download_export');

    Route::resource('/local_doc', App\Http\Controllers\Backend\Documents\Doc\LocalDocumentController::class);
    Route::get('/local_doc/download/{id}', [App\Http\Controllers\Backend\Documents\Doc\LocalDocumentController::class,'download'])->name('download_local');

    Route::resource('/doc_type', App\Http\Controllers\Backend\Documents\Doc\DocumentTypeController::class);
    Route::resource('/storage_file', App\Http\Controllers\Backend\Documents\Doc\StorageFileController::class);
    Route::resource('/doc_type', App\Http\Controllers\Backend\Documents\Doc\DocumentTypeController::class);
    Route::resource('/depart', App\Http\Controllers\Backend\Documents\DpartController::class);

    //Report Import Doc
    Route::get('/daily_import_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'daily_import_report'])->name('daily_import_report');
    Route::get('/print_daily_import_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'print_daily_import_report'])->name('print_daily_import_report');

    Route::get('/month_import_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'month_import_report'])->name('month_import_report');
    Route::get('/print_month_import_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'print_month_import_report'])->name('print_month_import_report');

    Route::get('/year_import_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'year_import_report'])->name('year_import_report');
    Route::get('/print_year_import_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'print_year_import_report'])->name('print_year_import_report');

    Route::get('/customize_import_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'customize_import_report'])->name('customize_import_report');
    Route::get('/customize_import_report_print', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'customize_import_report_print'])->name('customize_import_report_print');

    //Report Export Doc
    Route::get('/daily_export_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'daily_export_report'])->name('daily_export_report');
    Route::get('/print_daily_export_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'print_daily_export_report'])->name('print_daily_export_report');

    Route::get('/month_export_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'month_export_report'])->name('month_export_report');
    Route::get('/print_month_export_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'print_month_export_report'])->name('print_month_export_report');
    
    Route::get('/year_export_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'year_export_report'])->name('year_export_report');
    Route::get('/print_year_export_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'print_year_export_report'])->name('print_year_export_report');

    Route::get('/customize_export_report', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'customize_export_report'])->name('customize_export_report');
    Route::get('/customize_export_report_print', [App\Http\Controllers\Backend\Documents\Reports\ReportsController::class,'customize_export_report_print'])->name('customize_export_report_print');

});

