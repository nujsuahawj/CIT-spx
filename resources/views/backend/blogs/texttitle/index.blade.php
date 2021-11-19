@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.texttitle')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.texttitle')}}</li>
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
              <!--<a href="{{route('texttitle.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-add"></i>{{__('lang.add')}}</a>-->
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr style="text-align: center">
                  <th width="5%" style="text-align: center">{{__('lang.no')}}</th>
                  <th>{{__('blog.texttitle')}}</th>
                  <th>{{__('blog.des')}}</th>
                  <th>{{__('blog.status')}}</th>
                  <th style="text-align: center">{{__('lang.action')}}</th>
                </tr>
                </thead>
                <tbody>
                @php
                  $stt = 1;    
                @endphp

                @foreach ($texttitle as $item)
                <tr>
                    <td style="text-align: center">{{$stt++}}</td>
                    <td>
                        @if ( Config::get('app.locale') == 'lo')
                            {{$item->title_la}}
                        @elseif ( Config::get('app.locale') == 'en' )
                            {{$item->title_en}}
                        @endif
                    </td>
                    <td>
                        @if ( Config::get('app.locale') == 'lo')
                            {{$item->des_la}}
                        @elseif ( Config::get('app.locale') == 'en' )
                            {{$item->des_en}}
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if ($item->status == 1)
                            <label class="text-success">{{__('blog.active')}}</label>
                        @else
                            <label class="text-danger">{{__('blog.inactive')}}</label>
                        @endif
                    </td>
                    <td style="text-align: center">
                        <a href="{{ route('texttitle.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                        <!--
                        <form action=" {{ route('texttitle.destroy', $item->id) }} " method="POST">
                        @csrf
                        @method('DELETE')
                            <a href="{{ route('texttitle.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')"><i class="fas fa-trash"></i></button>
                        </form>-->
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