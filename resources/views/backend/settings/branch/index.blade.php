@extends('layouts.settings.app-settings')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('lang.branch')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboardsetting.index')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.branch')}}</li>
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
              <a href="{{route('branch.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-add"></i>{{__('lang.add')}}</a>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr style="text-align: center">
                  <th width="5%" style="text-align: center">{{__('lang.no')}}</th>
                  <th>{{__('lang.logo')}}</th>
                  <th>{{__('lang.code')}}</th>
                  <th>{{__('lang.company_name')}}</th>
                  <th>{{__('lang.address')}}</th>
                  <th>{{__('lang.phone')}}</th>
                  <th>{{__('lang.branch_type')}}</th>
                  <th>{{__('lang.dividend')}}</th>
                  <th>{{__('lang.tax')}}</th>
                  <th>{{__('lang.status')}}</th>
                  <th style="text-align: center">{{__('lang.action')}}</th>
                </tr>
                </thead>
                <tbody>
                @php
                  $stt = 1;    
                @endphp

                @foreach ($branch as $item)
                <tr>
                    <td style="text-align: center">{{$stt++}}</td>
                    <td style="text-align: center"><img src="{{asset($item->logo)}}" height="50"></td>
                    <td style="text-align: center">{{$item->code}}</td>
                    <td>
                        @if ( Config::get('app.locale') == 'lo')
                            {{$item->company_name_la}}
                        @elseif ( Config::get('app.locale') == 'en' )
                            {{$item->company_name_en}}
                        @endif
                    <td>
                        @if ( Config::get('app.locale') == 'lo')
                            {{$item->address_la}}
                        @elseif ( Config::get('app.locale') == 'en' )
                            {{$item->address_en}}
                        @endif
                    </td>
                    <td style="text-align: center">{{$item->phone}}</td>
                    <td style="text-align: center">
                      @if (!empty($item->branch_type_id))
                        {{$item->branchtypename->name}}
                      @endif
                    </td>
                    <td style="text-align: center">
                      @if (!empty($item->dividend_id))
                        {{$item->dividendname->percent}}
                      @endif
                    </td>
                    <td style="text-align: center">
                      @if (!empty($item->tax_id))
                        {{$item->taxname->percent}}
                      @endif
                    </td>
                    <td style="text-align: center">
                        @if ($item->active == 0)
                           <label class="text-danger">{{__('blog.inactive')}}</label>
                        @else
                            <label class="text-success">{{__('blog.active')}}</label>
                        @endif
                    </td>
                    <td style="text-align: center">
                        <form action=" {{ route('branch.destroy', $item->id) }} " method="POST">
                        @csrf
                        @method('DELETE')
                            <a href="{{ route('branch.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
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