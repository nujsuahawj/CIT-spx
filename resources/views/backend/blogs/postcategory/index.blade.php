@extends('layouts.app')
@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('blog.postcategory')}}</b> {{ Config::get('app.locale') }}
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.postcategory')}}</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">

        <!--Post Category -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <a href="{{route('postcategory.create')}}"><i class="fa fa-plus"> {{__('lang.add')}}</i></a>
                </div>
                <div class="card-body">
  
                  <!-- Sidebar Menu -->
                <nav>
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                    @foreach ($postcategory as $item)
                      <li class="nav-item menu-open">
                        <div class="d-flex justify-content-between">
                            <a href="javascript:void(0)" class="nav-link">

                                @if ( Config::get('app.locale') == 'lo')
                                    {{$item->name_la}}
                                @elseif ( Config::get('app.locale') == 'en' )
                                    {{$item->name_en}}
                                @endif

                            </a>
                          <div>
                              <form action="{{route('postcategory.destroy', $item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{route('postcategory.edit', $item->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                              </form>
                          </div>
                        </div>
                        @if ($item->subcatalog)
                          <ul class="nav nav-treeview">
                            @foreach ($item->subcatalog as $child)
                              <li class="nav-item">
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0)" class="nav-link">
                                        @if ( Config::get('app.locale') == 'lo')
                                            - {{$child->name_la}}
                                        @elseif ( Config::get('app.locale') == 'en' )
                                            - {{$child->name_en}}
                                        @endif
                                    </a>
                                    <div>
                                      <form action="{{route('postcategory.destroy', $child->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('postcategory.edit', $child->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')"><i class="fa fa-trash"></i></button>
                                      </form>
                                    </div>
                                </div>
                                @if ($child->subcatalog)
                                  <ul class="nav nav-treeview">
                                    @foreach ($child->subcatalog as $subchild)
                                      <li class="nav-item">
                                        <div class="d-flex justify-content-between">
                                            <a href="javascript:void(0)" class="nav-link">
                                                @if ( Config::get('app.locale') == 'lo')
                                                    -- {{$subchild->name_la}}
                                                @elseif ( Config::get('app.locale') == 'en' )
                                                    -- {{$subchild->name_en}}
                                                @endif
                                            </a>
                                            <div>
                                              <form action="{{route('postcategory.destroy', $subchild->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{route('postcategory.edit', $subchild->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                              </form>
                                            </div>
                                        </div>
                                      </li>
                                    @endforeach
                                  </ul>
                                @endif
                              </li>
                            @endforeach
                          </ul>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                </nav>
  
                </div>
            </div>
        </div>

      </div>
    </div>
</section>

@endsection