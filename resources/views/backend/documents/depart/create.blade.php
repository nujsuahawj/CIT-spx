@extends('layouts.basedoc')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('doc.depart')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="">{{__('doc.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('doc.depart')}}</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">{{__('doc.add')}}</h4>
            </div>

            <!--
            @if(count($errors)>0)
              <div class="card-body">
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <i class="icon fas fa-ban"> {{__('doc.error')}}</i></br>
                  @foreach($errors->all() as $error)
                  {{$error}} </br>
                  @endforeach
                </div>
              </div>
            @endif -->

            <form method="POST" action="{{route('depart.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                      <label for="name">{{__('doc.departname')}}</label>
                      <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{__('doc.departname')}}" autofocus>
                      @if ($errors->has('name'))
                        <span class="invalid-feedback"> <strong>{{ $errors->first('name') }}</strong></span>
                      @endif
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('doc.save')}}</button>
                    <a class="btn btn-warning" href="{{route('depart.index')}}" >{{__('doc.back')}}</a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection