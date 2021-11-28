<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid">
      <a href="{{route('admin.dashboard')}}" class="navbar-brand">
        <img src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <!--<span class="brand-text font-weight-light">{{__('lang.title')}}</span>-->
      </a>

      <!-- Left navbar links -->
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">
        
          <!--Modules-->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.modules')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            @if(auth()->user()->rolename->name == 'staff'  || auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
              <li><a href="" target="_blank" class="dropdown-item">{{__('lang.module_email')}}</a></li>
              <li><a href="{{route('service.index')}}" class="dropdown-item">{{__('lang.module_website')}}</a></li>
              <li><a href="{{route('dashboarddoc.index')}}" class="dropdown-item">{{__('lang.module_document')}}</a></li>
              
              <!-- Module System-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{__('lang.module_setting')}}</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li><a href="{{route('admin.exchange')}}" class="dropdown-item">{{__('lang.rate_exchange')}}</a></li>
                  <li><a href="{{route('admin.village')}}" class="dropdown-item">{{__('lang.village')}}</a></li>
                  <li><a href="{{route('admin.district')}}" class="dropdown-item">{{__('lang.district')}}</a></li>
                  <li><a href="{{route('admin.province')}}" class="dropdown-item">{{__('lang.province')}}</a></li>
                  <li><a href="{{route('admin.branchtype')}}" class="dropdown-item">{{__('lang.branch_type')}}</a></li>
                  <li><a href="{{route('vihicle.vihicle')}}" class="dropdown-item">{{__('lang.vihicle')}}</a></li>
                  <li><a href="{{route('admin.vihicletype')}}" class="dropdown-item">{{__('lang.vihicletype')}}</a></li>
                  <li><a href="{{route('admin.dividend')}}" class="dropdown-item">{{__('lang.dividend')}}</a></li>
                  <li><a href="{{route('admin.insurance')}}" class="dropdown-item">{{__('lang.insurance')}}</a></li>
                  <li><a href="{{route('admin.vat')}}" class="dropdown-item">{{__('lang.tax')}}</a></li>
                  
                  <li><a href="{{route('admin.goodstype')}}" class="dropdown-item">{{__('lang.goods_type')}}</a></li>
                  <li><a href="{{route('admin.producttype')}}" class="dropdown-item">{{__('lang.product_type')}}</a></li>
                  <li><a href="{{route('admin.calculateprice')}}" class="dropdown-item">{{__('lang.calculateprice')}}</a></li>
                  <li><a href="{{route('admin.cod_rate')}}" class="dropdown-item">{{__('lang.cod_rate')}}</a></li>
                  <li><a href="{{route('admin.payment_type')}}" class="dropdown-item">{{__('lang.payment_type')}}</a></li>
                  <li><a href="{{route('admin.payment')}}" class="dropdown-item">{{__('lang.payments')}}</a></li>
                  <li><a href="{{route('admin.shipping_status')}}" class="dropdown-item">{{__('lang.shipping_status')}}</a></li>
                </ul>
              </li>
              <li><a href="{{route('dashboardsetting.index')}}" class="dropdown-item">{{__('lang.module_system')}}</a></li>
              <li class="dropdown-divider"></li>
              @endif
              <li><a href="{{route('admin.unit_contract')}}" class="dropdown-item">{{__('lang.unit_contract')}}</a></li>
              <!-- <li><a href="{{route('admin.pay_devidend')}}" class="dropdown-item">{{__('lang.pay_dividend')}}</a></li> -->
              @if(auth()->user()->rolename->name == 'staff'  || auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
              <!-- <li><a href="" class="dropdown-item">{{__('lang.ewallet')}}</a></li> -->
              @endif
            </ul> 
          </li>
        
          <!--Service-->
        @if(auth()->user()->rolename->name == 'unit'  || auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.service')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('transaction.receive')}}" class="dropdown-item">{{__('lang.receive_goods')}}</a></li>
              <li><a href="{{route('admin.send_customer')}}" class="dropdown-item">{{__('lang.send_goods_customer')}}</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="" class="dropdown-item">{{__('lang.delivery')}}</a></li>
              <li><a href="{{route('admin.call_good')}}" class="dropdown-item">{{__('lang.list_call_good')}}</a></li>
              <!-- <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{__('lang.ewallet')}}</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                    <li><a href="{{route('ewallet.vuew_ewtran')}}" class="dropdown-item">{{__('lang.Transaction')}}</a></li>
                    <li><a href="{{route('ewallet.view_ewallet')}}" class="dropdown-item">{{__('lang.account').__('lang.ewallet')}} </a></li>
                    <li><a href="{{route('ewallet.view_clearing')}}" class="dropdown-item">{{__('lang.cod_clearing')}} </a></li>
                    <li><a href="{{route('ewallet.vuew_ewstm')}}" class="dropdown-item">{{__('lang.statement')}} </a></li>
                </ul>
              </li> -->

              <!-- <li><a href="" class="dropdown-item">{{__('lang.cod_service')}}</a></li> -->
              <li><a href="" class="dropdown-item">{{__('lang.online_order')}}</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="{{route('expenses.expense')}}" class="dropdown-item">{{__('lang.other_income_expenses')}}</a></li>
            </ul>
          </li>
        @endif
          <!--Transection-->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.transection')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              @if(auth()->user()->rolename->name == 'stock' || auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
              <li><a href="{{route('admin.traffic')}}" class="dropdown-item">{{__('lang.traffic')}}</a></li>
              @endif
              @if(auth()->user()->rolename->name == 'unit'  || auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
              <li><a href="{{route('admin.shipout')}}" class="dropdown-item">{{__('lang.shipout_goods')}}</a></li>
              @endif
              @if(auth()->user()->rolename->name == 'stock' || auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
              <!-- <li><a href="{{route('admin.receive_stock')}}" class="dropdown-item">{{__('lang.receive_stock')}}</a></li> -->
              @endif
              @if(auth()->user()->rolename->name == 'unit' || auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
              <li><a href="{{route('admin.receive_branch')}}" class="dropdown-item">{{__('lang.receive_branch')}}</a></li>
              @endif
            </ul>
          </li>
          
          <!--Employee-->
          @if(auth()->user()->rolename->name == 'manger' || auth()->user()->rolename->name == 'admin')
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.employee')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('admin.employee')}}" class="dropdown-item">{{__('lang.all_employee')}}</a></li>
              <li><a href="{{route('admin.payroll')}}" class="dropdown-item">{{__('lang.payroll')}}</a></li>
              <li><a href="{{route('admin.report_payroll')}}" class="dropdown-item">{{__('lang.employee_report')}}</a></li>
            </ul>
          </li>
          @endif
          <!--Report-->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.report')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="" class="dropdown-item">{{__('lang.reports')}}</a></li>
              <li><a href="" class="dropdown-item">{{__('lang.income_report')}}</a></li>
              <li><a href="" class="dropdown-item">{{__('lang.expenses_report')}}</a></li>
              <li><a href="" class="dropdown-item">{{__('lang.reveive_goods_report')}}</a></li>
              <li><a href="" class="dropdown-item">{{__('lang.shipout_goods_report')}}</a></li>
              <li><a href="" class="dropdown-item">{{__('lang.condition_report')}}</a></li>
              <li><a href="{{route('admin.report_separate_goods')}}" class="dropdown-item">{{__('lang.separate_goods_report')}}</a></li>
            </ul>
          </li>
        </ul>

      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{$count_callgood}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">{{$count_callgood}} {{__('lang.list')}}</span>
            @foreach ($callgood as $item)
            <div class="dropdown-divider"></div>
            <a href="{{route('admin.call_good')}} " class="dropdown-item">
              <i class="fas fa-bell mr-3"></i> {{$item->goodTypename->name}} {{__('lang.weigh')}} {{number_format($item->weight)}} (kg) <br>
              <span class="float-right text-muted text-sm">{{__('lang.appointment_date')}}: {{date('d/m/Y',strtotime($item->appoinment_time))}}</span>
            </a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a href="{{route('admin.call_good')}}" class="dropdown-item dropdown-footer">{{__('lang.detail')}}</a>
          </div>
        </li> -->

        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="">
            <i class="fas fa-language"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right p-0">
            <a class="nav-link" data-toggle="nav-item" href="{{url('localization/lo')}}">
              <i class="flag-icon flag-icon-la"></i> {{__('lang.lao')}}
            </a>
            <a class="nav-link" data-toggle="nav-item" href="{{url('localization/en')}}">
              <i class="flag-icon flag-icon-us"></i> {{__('lang.eng')}}
            </a>
          </div>
        </li>

        <!--Logout-->
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{asset(auth()->user()->image)}}" class="user-image img-circle elevation-2" alt="User Image">
            <!--<span class="d-none d-md-inline">{{Auth::user()->email}}</span>-->
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-primary">
              <img src="{{asset(auth()->user()->image)}}" class="img-circle elevation-2" alt="User Image">
              <p>
                <!-- <p>{{__('lang.phone')}}: {{Auth::user()->phone}}</p> -->
                <p>{{__('lang.rolename')}}: {{Auth::user()->rolename->name}}</p>
                <p>{{__('lang.branch')}}: 
                  @if ( Config::get('app.locale') == 'lo')
                      {{Auth::user()->branchname->company_name_la}}
                  @elseif ( Config::get('app.locale') == 'en' )
                      {{Auth::user()->branchname->company_name_en}}
                  @endif</p>
              </p>
            </li>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <livewire:admin.logout-component />
            </li>
          </ul>
        </li>

      </ul>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
    </div>
  </nav>