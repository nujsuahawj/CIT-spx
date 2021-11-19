@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{__('blog.dashboardblog')}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboardblog.index')}}}">Home</a></li>
            <li class="breadcrumb-item active">{{__('blog.dashboardblog')}}</li>
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
              <h3>{{$count_post}}</h3>
              <p>{{__('blog.blogs')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('post.index')}}" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$count_service}}<sup style="font-size: 20px"></sup></h3>

              <p>{{__('blog.service')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('service.index')}}" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$count_testimonial}}</h3>

              <p>{{__('blog.testimonial')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('testimonial.index')}}" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$count_message}}</h3>

              <p>{{__('blog.message')}}</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{route('message.index')}}" class="small-box-footer">{{__('lang.detail')}} <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-md-7">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">{{__('blog.blogs')}}</h3>

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
                      <th>{{__('blog.image')}}</th>
                      <th>{{__('blog.title')}}</th>
                      <th>{{__('blog.status')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($posts as $item)
                    <tr>
                      <td>
                        <img src="{{$item->image}}" height="80" alt="">
                      </td>
                      <td>
                        @if (Config::get('app.locale') == 'lo')
                          {{$item->title_la}}
                        @elseif (Config::get('app.locale') == 'en')
                          {{$item->title_en}}
                        @endif
                      </td>
                      <td><span class="badge badge-success">
                        @if ($item->published == 1)
                          {{__('blog.active')}}
                        @endif
                      </span></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <!--<a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>-->
              <a href="{{route('post.index')}}" class="btn btn-sm btn-info float-right">{{__('lang.detail')}}</a>
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
        <div class="col-md-5">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">{{__('blog.message')}}</h3>

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
                      <th>{{__('blog.subject')}}</th>
                      <th>{{__('lang.name')}}</th>
                      <th>{{__('blog.status')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($message as $item)
                    <tr>
                      <td>{{$item->subject}}</td>
                      <td>{{$item->name}}</td>
                      <td><span class="badge badge-success">
                        @if ($item->status == 1)
                          {{__('blog.unread')}}
                        @endif
                      </span></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <!--<a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>-->
              <a href="{{route('message.index')}}" class="btn btn-sm btn-info float-right">{{__('lang.detail')}}</a>
            </div>
            <!-- /.card-footer -->
          </div>
        </div>
      </div>

    </div>
  </section>
@endsection