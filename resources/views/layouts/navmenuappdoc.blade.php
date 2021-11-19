<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid">
      <a href="{{route('admin.dashboard')}}" class="navbar-brand">
        <img src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{__('doc.title')}}</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Left navbar links -->
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">

          <li class="nav-item">
            <a href="{{route('dashboarddoc.index')}}" class="nav-link">{{__('doc.dashboard')}}</a>
          </li>

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('doc.documents')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('import_doc.index')}}" class="dropdown-item">{{__('lang.import_doc')}}</a></li>
              <li><a href="{{route('export_doc.index')}}" class="dropdown-item">{{__('lang.export_doc')}}</a></li>
              <li><a href="{{route('local_doc.index')}}" class="dropdown-item">{{__('lang.local_doc')}}</a></li>
            </ul>
          </li>


          <!--doc-->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.reports')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <!--<li><a href="{{route('post.index')}}" class="dropdown-item">{{__('doc.post')}}</a></li>-->
              <li><a href="{{route('daily_import_report')}}" class="dropdown-item">{{__('doc.daily_import_report')}}</a></li>
              <li><a href="{{route('month_import_report')}}" class="dropdown-item">{{__('doc.month_import_report')}}</a></li>
              <li><a href="{{route('year_import_report')}}" class="dropdown-item">{{__('doc.year_import_report')}}</a></li>
              <li><a href="{{route('customize_import_report')}}" class="dropdown-item">{{__('doc.customize_import_report')}}</a></li>
              <li><a href="{{route('daily_export_report')}}" class="dropdown-item">{{__('doc.daily_export_report')}}</a></li>
              <li><a href="{{route('month_export_report')}}" class="dropdown-item">{{__('doc.month_export_report')}}</a></li>
              <li><a href="{{route('year_export_report')}}" class="dropdown-item">{{__('doc.year_export_report')}}</a></li>
              <li><a href="{{route('customize_export_report')}}" class="dropdown-item">{{__('doc.customize_export_report')}}</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('doc.condition_settings')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('doc_type.index')}}" class="dropdown-item">{{__('lang.doc_type')}}</a></li>
              <li><a href="{{route('storage_file.index')}}" class="dropdown-item">{{__('lang.storage_file')}}</a></li>
              <li><a href="{{route('depart.index')}}" class="dropdown-item">{{__('lang.depart')}}</a></li>
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
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li> -->

        <!-- Language Dropdown Menu -->
        <!-- <li class="nav-item">
          <a class="nav-link" data-toggle="nav-item" href="{{url('localization/lo')}}">
            <i class="flag-icon flag-icon-la"></i>
          </a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" data-toggle="nav-item" href="{{url('localization/en')}}">
            <i class="flag-icon flag-icon-us"></i>
          </a>
        </li> -->

      </ul>
    </div>
  </nav>