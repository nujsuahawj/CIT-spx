<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid">
      <a href="{{route('admin.dashboard')}}" class="navbar-brand">
        <img src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{__('lang.title')}}</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Left navbar links -->
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">

          <li class="nav-item">
            <a href="{{route('dashboardsetting.index')}}" class="nav-link">{{__('lang.dashboardsetting')}}</a>
          </li>
          <li class="nav-item">
            <a href="{{route('branch.index')}}" class="nav-link">{{__('lang.branch')}}</a>
          </li>
          <li class="nav-item">
            <a href="{{route('user.index')}}" class="nav-link">{{__('lang.user')}}</a>
          </li>

          <!--Settings
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.settings')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="" class="dropdown-item">{{__('lang.role')}}</a></li>
              <li><a href="" class="dropdown-item">{{__('lang.user')}}</a></li>
            </ul>
          </li>-->

        </ul>

      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

        <!-- Notifications Dropdown Menu 
        <li class="nav-item dropdown">
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
        <li class="nav-item">
          <a class="nav-link" data-toggle="nav-item" href="{{url('localization/lo')}}">
            <i class="flag-icon flag-icon-la"></i>
          </a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" data-toggle="nav-item" href="{{url('localization/en')}}">
            <i class="flag-icon flag-icon-us"></i>
          </a>
        </li>
        <!--
        <li class="nav-item ">
          <a class="nav-link" data-toggle="nav-item" href="{{url('localization/cn')}}">
            <i class="flag-icon flag-icon-cn"></i>
          </a>
        </li>-->

        <!--Logout
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline">{{Auth::user()->email}}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <li class="user-header bg-primary">
              <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
  
              <p>
                <p>{{__('lang.phone')}}: {{Auth::user()->phone}}</p>
                <p>{{__('lang.rolename')}}: {{Auth::user()->rolename->name}}</p>
              </p>
            </li>
            <li class="user-footer">
              <livewire:admin.logout-component />
            </li>
          </ul>
        </li>-->

      </ul>
    </div>
  </nav>