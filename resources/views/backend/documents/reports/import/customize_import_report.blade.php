@extends('layouts.basedoc')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('doc.customize_import_report')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">{{__('doc.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('doc.customize_import_report')}}</li>
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
                        <div class="card-body">

                            <!--<?php print_r($import_search) ?>-->

                            <form action="{{route('customize_import_report_print')}}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('doc.doc_typename')}}</label>
                                            <select class="form-control select2" name="doc_type" style="width: 100%;">    
                                              <option value="" selected>{{__('doc.select')}}</option>                
                                              @foreach($doc_type as $item)
                                                  <option value="{{$item->id}}">{{$item->name}}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('doc.depart')}}</label>
                                            <select class="form-control select2" name="doc_depart" style="width: 100%;">    
                                              <option value="" selected>{{__('doc.select')}}</option>                
                                              @foreach($doc_depart as $item)
                                                  <option value="{{$item->id}}">{{$item->name}}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('doc.from_date')}}</label>
                                            <input type="date" name="from_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('doc.to_date')}}</label>
                                            <input type="date" name="to_date" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 mt-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info btn-lg"><i class="fas fa-print"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!--
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{__('doc.customize_import_report')}} </h3>
                            <a href="{{route('customize_import_report_print')}}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-print"> {{__('doc.print')}}</i></a>
                        </div>
                        </h3>
                    </div>

                    <div class="card-body">
                        <table id="tableReport" class="table table-bordered table-striped">
                        <thead>
                            <tr align="center">
                            <th style="width: 10px">{{__('doc.no')}}</th>
                            <th>{{__('doc.doc_no')}}</th>
                            <th>{{__('doc.date')}}</th>
                            <th>{{__('doc.doc_type')}}</th>
                            <th>{{__('doc.short_title')}}</th>
                            <th>{{__('doc.from')}}</th>
                            <th>{{__('doc.no_doc')}}-{{__('doc.date')}}</th>
                            <th>{{__('doc.comment')}}</th>
                            <th>{{__('doc.by')}}</th>
                            </tr>
                        </thead>
                            @php
                                $stt = 1;    
                            @endphp
                        <tbody>
                            
                            @foreach ($import_search as $item)
                                <tr>
                                    <td style="text-align:center">{{$stt++}}</td>
                                    <td style="text-align: center">{{$item->doc_no}}</td>
                                    <td style="text-align:center">{{date('d/m/Y', strtotime($item->date))}} </td>
                                    <td>{{$item->doc_typename->name}}</td>
                                    <td>{{$item->short_title}}</td>
                                    <td>{{$item->depart_id_name->name}}</td>
                                    <td style="text-align:center">{{$item->no_doc}}-{{date('d/m/Y', strtotime($item->date_doc))}}</td>
                                    <td>
                                    @if (!empty($item->comment))
                                        {{$item->comment}}
                                    @else
                                        {{__('doc.not_comment')}}
                                    @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if (!empty($item->cm_user_id))
                                        {{$item->user_comment->name}}
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
            -->

        </div>
      </section>
@endsection
@section('scripts')

@endsection