@extends('layouts.basedoc')
@section('content')
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">{{__('doc.doc_typename')}}: {{$local_doc->typename->name}}</h3>
                    </div>
                    <div class="card-body">
                      <strong><i class="fas fa-location-arrow mr-1"></i>{{__('doc.date')}}</strong>
                      <p class="text-muted">
                        {{date('d/m/Y', strtotime($local_doc->date)) }}
                      </p>
      
                      <hr>
      
                      <strong><i class="fas fa-map-marker-alt mr-1"></i> {{__('doc.doc_typename')}}</strong>
                      <p class="text-muted">{{$local_doc->typename->name}}</p>
      
                      <hr>
      
                      <strong><i class="fas fa-clock mr-1"></i>{{__('doc.short_title')}}</strong>
                      <p class="text-muted"> {{$local_doc->title}} </p>
      
                      <hr>
      
                      <strong><i class="far fa-file-alt mr-1"></i> {{__('doc.storage_filename')}}</strong>
                      <p class="text-muted"> {{$local_doc->storagename->name}}</p>

                      <hr>
      
                      <strong><i class="fas fa-book mr-1"></i>{{__('doc.username')}} - {{__('doc.branchname')}}</strong>
                      <p class="text-muted"> {{$local_doc->username->name}} 
                      @if (Config::get('app.locale') == 'lo')
                            {{ $local_doc->branchname->company_name_la }}
                          @elseif (Config::get('app.locale') == 'en')
                            {{ $local_doc->branchname->company_name_en }}
                          @endif</p>

                      <hr>

                      <strong><i class="fas fa-book mr-1"></i>{{__('doc.file')}}</strong>
                      <p><a href="{{route('download_local', $local_doc->id)}}" target="_blank" class="btn btn-success">{{__('doc.download')}}</a> <a class="btn btn-warning" href="{{route('local_doc.index')}}" >{{__('doc.back')}}</a></p>

                    </div>
                  </div>
                </div>

              </div>
            </div>
          </section>
@endsection