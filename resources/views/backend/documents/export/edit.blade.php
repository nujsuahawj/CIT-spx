@extends('layouts.basedoc')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('doc.export_doc')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="">{{__('doc.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('doc.export_doc')}}</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="col-lg-12">
          <div class="card card-default">

            <div class="card-header">
              <h3 class="card-title"><h4 class="card-title">{{__('doc.edit')}}</h4></h3>
  
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>

            <form method="POST" action="{{route('export_doc.update', $export_doc->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="card-body">
                  
                  <div class="row">
                    <div class="col-md-12">

                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="doc_no">{{__('doc.doc_no')}}</label>
                              <input type="text" class="form-control {{ $errors->has('doc_no') ? ' is-invalid' : '' }}" name="doc_no" value="{{$export_doc->code}}" placeholder="{{__('doc.doc_no')}}">
                              @if ($errors->has('doc_no'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('doc_no') }}</strong></span>
                              @endif
                            </div>
                          </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="date">{{__('doc.date')}}</label>
                            <input type="date" class="form-control {{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{$export_doc->date}}" placeholder="{{__('doc.date')}}">
                            @if ($errors->has('date'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('date') }}</strong></span>
                            @endif
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                              <label>{{__('doc.doc_typename')}}</label>
                              <select class="form-control select2 {{ $errors->has('doc_type') ? ' is-invalid' : '' }}" name="doc_type" style="width: 100%;">   
                                <option value="" selected>{{__('doc.select')}}</option>                 
                                @foreach($doc_type as $type)
                                    <option 
                                        @if($export_doc->type_id == $type->id)
                                            {{'selected'}}
                                        @endif
                                        value="{{$type->id}}">{{$type->name}}
                                    </option>
                                @endforeach
                              </select>
                              @if ($errors->has('doc_type'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('doc_type') }}</strong></span>
                              @endif
                            </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="short_title">{{__('doc.short_title')}}</label>
                                <input type="text" class="form-control {{ $errors->has('short_title') ? ' is-invalid' : '' }}" name="short_title" value="{{$export_doc->title}}" placeholder="{{__('doc.short_title')}}">
                                @if ($errors->has('short_title'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('short_title') }}</strong></span>
                                @endif
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('doc.departname')}}</label>
                                <select class="form-control select2 {{ $errors->has('depart_id') ? ' is-invalid' : '' }}" name="depart_id" style="width: 100%;">  
                                  <option value="" selected>{{__('doc.select')}}</option>                   
                                  @foreach($depart as $dp)
                                    <option 
                                        @if($export_doc->external_id == $dp->id)
                                            {{'selected'}}
                                        @endif
                                        value="{{$dp->id}}">{{$dp->name}}
                                    </option>
                                  @endforeach
                                </select>
                                @if ($errors->has('depart_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('depart_id') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('doc.storage_filename')}}</label>
                                <select class="form-control select2 {{ $errors->has('storage_file_id') ? ' is-invalid' : '' }}" name="storage_file_id" style="width: 100%;">    
                                  <option value="" selected>{{__('doc.select')}}</option>                 
                                  @foreach($storage as $store)
                                    <option 
                                        @if($export_doc->storage_id == $store->id)
                                            {{'selected'}}
                                        @endif
                                        value="{{$store->id}}">{{$store->name}}
                                    </option>
                                  @endforeach
                                </select>
                                @if ($errors->has('storage_file_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('storage_file_id') }}</strong></span>
                                @endif
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="file">{{__('doc.file')}}</label>
                            <input type="file" class="form-control" name="file" id="file">
                          </div>
                        </div>
                      </div>

                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('doc.save')}}</button>
                    <a class="btn btn-warning" href="{{route('export_doc.index')}}" >{{__('doc.back')}}</a>
                </div>
            </form>
            
          </div>

      </div>
    </div>
  </section>
@endsection