@extends('layouts.basedoc')
@section('content')
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">{{__('doc.doc_typename')}}</h3>
                    </div>
                    <div class="card-body">
                      <strong><i class="fas fa-location-arrow mr-1"></i> {{__('doc.doc_no')}} - {{__('doc.date')}}</strong> - {{__('doc.doc_typename')}}
                      <p class="text-muted">
                        {{$import_doc->code}} - {{date('d/m/Y', strtotime($import_doc->date)) }} - {{$import_doc->typename->name}}
                      </p>
      
                      <hr>

                      <strong><i class="fas fa-location-arrow mr-1"></i> {{__('doc.no_doc')}} - {{__('doc.date_doc')}}</strong>
                      <p class="text-muted">{{$import_doc->doc_no}} - {{date('d/m/Y', strtotime($import_doc->doc_date)) }}</p>
      
                      <hr>
      
                      <strong><i class="fas fa-clock mr-1"></i>{{__('doc.short_title')}}</strong>
                      <p class="text-muted"> {{$import_doc->title}} </p>
      
                      <hr>
      
                      <strong><i class="far fa-file-alt mr-1"></i> {{__('doc.external_partsname')}} - {{__('doc.storage_filename')}}</strong>
                      <p class="text-muted"> {{$import_doc->externalname->name}} - {{$import_doc->storagename->name}}</p>

                      <hr>

                    </div>
                  </div>
                </div>

              </div>
            </div>
          </section>
@endsection