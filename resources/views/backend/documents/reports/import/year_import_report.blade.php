@extends('layouts.basedoc')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('doc.year_import_report')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">{{__('doc.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('doc.year_import_report')}}</li>
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
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">{{__('doc.year_import_report')}}: @php echo date("Y") @endphp {{__('doc.total')}}: <b>{{number_format($total_year_import)}} {{__('doc.items')}}</b></h3>
                        <a href="{{route('print_year_import_report')}}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-print"> {{__('doc.print')}}</i></a>
                      </div>
                    </h3>
                  </div>

                  <div class="card-body">
                    <table id="tableReport" class="table table-bordered table-striped">
                      <thead>
                        <tr align="center">
                          <th style="width: 10px">{{__('doc.no')}}</th>
                          <th>{{__('doc.doc_no')}}</th>
                          <th>{{__('doc.doc_type')}}</th>
                          <th>{{__('doc.short_title')}}</th>
                          <th>{{__('doc.from')}}</th>
                          <th>{{__('doc.no_doc')}}-{{__('doc.date')}}</th>
                        </tr>
                      </thead>
                        @php
                            $stt = 1;    
                        @endphp
                      <tbody>
                          
                          @foreach ($year_import as $item)
                          <tr>
                            <td style="text-align:center">{{$stt++}}</td>
                            <td style="text-align: center">{{$item->code}}</td>
                            <td>{{$item->typename->name}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->externalname->name}}</td>
                            <td style="text-align: center">{{$item->doc_no}}-{{date('d/m/Y', strtotime($item->doc_date))}}</td>
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
