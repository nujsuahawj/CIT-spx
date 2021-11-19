@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.tag')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.tag')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <a href="{{route('tag.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-add"></i>{{__('lang.add')}}</a>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%" style="text-align: center">{{__('lang.no')}}</th>
                  <th>{{__('blog.tagname')}}</th>
                  <th>{{__('blog.slug')}}</th>
                  <th width="20%" style="text-align: center">{{__('lang.action')}}</th>
                </tr>
                </thead>
                <tbody>
                @php
                  $stt = 1;    
                @endphp

                @foreach ($tags as $item)
                <tr>
                    <td>{{$stt++}}</td>
                    <td>
                        @if ( Config::get('app.locale') == 'lo')
                            {{$item->name_la}}
                        @elseif ( Config::get('app.locale') == 'en' )
                            {{$item->name_en}}
                        @endif
                    </td>
                    <td>{{$item->slug}}</td>
                    <td style="text-align: center">
                        <form action=" {{ route('tag.destroy', $item->id) }} " method="POST">
                        @csrf
                        @method('DELETE')

                            <a href="{{ route('tag.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')"><i class="fas fa-trash"></i></button>

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