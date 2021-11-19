@extends('layouts.settings.app-settings')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{__('lang.dashboardsetting')}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboardsetting.index')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.dashboardsetting')}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$count_branch}}</h3>

              <p>{{__('lang.branch')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('branch.index')}}" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>000<sup style="font-size: 20px"></sup></h3>

              <p>{{__('lang.warehouse')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$count_user}}</h3>

              <p>{{__('lang.user')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('user.index')}}" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$count_role}}</h3>

              <p>{{__('lang.role')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">{{__('lang.role')}}</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>{{__('lang.rolename')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($role as $item)
                    <tr>
                      <td>{{$item->name}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <!--<a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
              <a href="{{route('message.index')}}" class="btn btn-sm btn-info float-right">{{__('lang.detail')}}</a>-->
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
      </div>

    </div>
  </section>
@endsection