@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.message')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboardblog.index')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.message')}}</li>
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
              <!--<a href="{{route('message.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-add"></i>{{__('lang.add')}}</a>-->
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr style="text-align: center">
                  <th width="5%" style="text-align: center">{{__('lang.no')}}</th>
                  <th>{{__('lang.name')}}</th>
                  <th>{{__('lang.phone')}}</th>
                  <th>{{__('blog.message')}}</th>
                  <th>{{__('blog.status')}}</th>
                  <th style="text-align: center">{{__('lang.action')}}</th>
                </tr>
                </thead>
                <tbody>
                @php
                  $stt = 1;    
                @endphp

                @foreach ($message as $item)
                <tr>
                    <td style="text-align: center">{{$stt++}}</td>
                    <td><a href="{{ route('message.show', $item->id) }}">{{$item->name}}</a></td>
                    <td><a href="{{ route('message.show', $item->id) }}">{{$item->phone}}</a></td>
                    <td><a href="{{ route('message.show', $item->id) }}">{{$item->message}}</a></td>
                    <td style="text-align: center">
                        @if ($item->status == 1)
                            <label class="text-warning">{{__('blog.unread')}}</label>
                        @else
                            <label class="text-success">{{__('blog.read')}}</label>
                        @endif
                    </td>
                    <td style="text-align: center">
                        <form action=" {{ route('message.destroy', $item->id) }} " method="POST">
                        @csrf
                        @method('DELETE')
                            <a href="{{ route('message.show', $item->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.show')}}"><i class="fas fa-eye"></i></a>
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