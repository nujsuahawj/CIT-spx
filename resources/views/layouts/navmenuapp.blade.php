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
          <!--
          <li class="nav-item">
            <a href="{{route('dashboardblog.index')}}" class="nav-link">{{__('blog.dashboardblog')}}</a>
          </li>
          <li class="nav-item">
            <a href="{{route('post.index')}}" class="nav-link">{{__('blog.post')}}</a>
          </li>-->
          <li class="nav-item">
            <a href="{{route('service.index')}}" class="nav-link">{{__('blog.service')}}</a>
          </li>
          <li class="nav-item">
            <a href="{{route('slider.index')}}" class="nav-link">{{__('blog.slider')}}</a>
          </li>

          <!--Blog-->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.frontend')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <!--<li><a href="{{route('service.index')}}" class="dropdown-item">{{__('blog.service')}}</a></li>
              <li><a href="{{route('slider.index')}}" class="dropdown-item">{{__('blog.slider')}}</a></li>-->
              <li><a href="{{route('page.index')}}" class="dropdown-item">{{__('blog.page')}}</a></li>
              <li><a href="{{route('testimonial.index')}}" class="dropdown-item">{{__('blog.testimonial')}}</a></li>
              <li><a href="{{route('message.index')}}" class="dropdown-item">{{__('blog.message')}}</a></li>
            </ul>
          </li>

          <!--Settings
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false" class="nav-link dropdown-toggle">{{__('lang.settings')}}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('postcategory.index')}}" class="dropdown-item">{{__('blog.postcategory')}}</a></li>
              <li><a href="{{route('tag.index')}}" class="dropdown-item">{{__('blog.tag')}}</a></li>
              <li><a href="{{route('texttitle.index')}}" class="dropdown-item">{{__('blog.texttitle')}}</a></li>
            </ul>
          </li>-->

        </ul>

      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{ $messages }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">{{ $messages }} {{__('blog.message')}}</span>
            <div class="dropdown-divider"></div>
            <div class="dropdown-divider"></div>
            <a href="{{route('message.index')}}" class="dropdown-item dropdown-footer">{{__('lang.detail')}}</a>
          </div>
        </li>

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
            </li>
            <li class="user-footer">
              <livewire:admin.logout-component />
            </li>
          </ul>
        </li>-->

      </ul>
    </div>
  </nav>