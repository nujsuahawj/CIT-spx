@extends('layouts.settings.app-settings')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.user')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboardsetting.index')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.user')}}</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
  
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <a href="{{route('user.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-add"></i>{{__('lang.add')}}</a>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr style="text-align: center">
                      <th>{{__('lang.no')}}</th>
                      <th>{{__('lang.image')}}</th>
                      <th>{{__('lang.firstname')}} {{__('lang.and')}} {{__('lang.lastname')}}</th>
                      <th>{{__('lang.phone')}}</th>
                      <th>{{__('lang.address')}}</th>
                      <th>{{__('lang.email')}}</th>
                      <th>{{__('lang.branch')}}</th>
                      <th>{{__('lang.rolename')}}</th>
                      <th>{{__('lang.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $stt = 1;    
                    @endphp

                    @foreach ($user as $item)
                    <tr>
                      <td style="text-align: center" width="5%">{{$stt++}}</td>
                      <td style="text-align: center"><img src="{{asset($item->image)}}" height="50"></td>
                      <td>{{$item->name}}</td>
                      <td>{{$item->phone}}</td>
                      <td>{{$item->address}}</td>
                      <td>{{$item->email}}</td>
                      <td style="text-align: center">
                        @if (!empty($item->branch_id))
                          {{$item->branchname->company_name_la}}
                        @endif
                      </td>
                      <td style="text-align: center">
                        @if (!empty($item->role_id))
                          {{$item->rolename->name}}
                        @endif
                      </td>
                      <td style="text-align: center">
                        @if(Auth()->user()->rolename->name == 'admin')
                        <form action=" {{ route('user.destroy', $item->id) }} " method="POST">
                          @csrf
                          @method('DELETE')

                          @if ($item->rolename->name != 'admin')
                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')"><i class="fas fa-trash"></i></button>
                          @else
                          <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                          @endif
                         
                        </form>
                        @endif

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