@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.message_detail')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboardblog.index')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.message')}}</li>
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
              <h3 class="card-title"><b>{{$message->subject}}</b></h3>
            </div>

            <form method="POST" action="{{route('message.update', $message->id)}}">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <p>{{$message->message}}</p>
                            <p><b>{{$message->name}} - {{date('d/m/Y h:i:s', strtotime($message->created_at))}} </b></p>
                          </div>
                      </div>
                    </div>
                  </div>
                <div class="card-footer">
                    <a class="btn btn-warning" href="{{route('message.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.back')}}">{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection