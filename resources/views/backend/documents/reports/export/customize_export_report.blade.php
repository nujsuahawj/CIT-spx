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

                            <form action="{{route('customize_export_report_print')}}" method="GET">
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

        </div>
      </section>
@endsection
@section('scripts')

@endsection