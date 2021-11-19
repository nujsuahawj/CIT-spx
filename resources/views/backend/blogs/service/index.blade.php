@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.service')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.service')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <a href="{{route('service.create')}}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.add')}}"><i class="fas fa-add"></i>{{__('lang.add')}}</a>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr style="text-align: center">
                  <th width="5%" style="text-align: center">{{__('lang.no')}}</th>
                  <th>{{__('blog.service_icon')}}</th>
                  <th>{{__('blog.title')}}</th>
                  <th>{{__('blog.des')}}</th>
                  <th>{{__('blog.status')}}</th>
                  <th style="text-align: center">{{__('lang.action')}}</th>
                </tr>
                </thead>
                <tbody>
                @php
                  $stt = 1;    
                @endphp

                @foreach ($service as $item)
                <tr>
                    <td style="text-align: center">{{$stt++}}</td>
                    <td style="text-align: center">{{$item->service_icon}}</td>
                    <td>
                        @if ( Config::get('app.locale') == 'lo')
                            {{$item->title_la}}
                        @elseif ( Config::get('app.locale') == 'en' )
                            {{$item->title_en}}
                        @endif
                    <td>
                        @if ( Config::get('app.locale') == 'lo')
                            {{$item->des_la}}
                        @elseif ( Config::get('app.locale') == 'en' )
                            {{$item->des_en}}
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if ($item->status == 0)
                           <label class="text-danger">{{__('blog.unpublish')}}</label>
                        @else
                            <label class="text-success">{{__('blog.published')}}</label>
                        @endif
                    </td>
                    <td style="text-align: center">
                        <form action=" {{ route('service.destroy', $item->id) }} " method="POST">
                        @csrf
                        @method('DELETE')
                            <a href="{{ route('service.edit', $item->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.edit')}}"><i class="fas fa-pencil-alt"></i></a>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.delete')}}"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection