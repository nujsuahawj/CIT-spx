@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.tag')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.tag')}}</li>
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
              <h4 class="card-title">{{__('lang.edit')}}</h4>
            </div>

            <form method="POST" action="{{route('tag.update', $tags->id)}}">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_la">{{__('blog.tagname')}} ({{__('lang.lao')}})</label>
                            <input type="text" name="name_la" value="{{$tags->name_la}}" class="form-control {{ $errors->has('name_la') ? ' is-invalid' : '' }}" placeholder="{{__('lang.departname')}}" autofocus>
                            @if ($errors->has('name_la'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('name_la') }}</strong></span>
                            @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group"> 
                            <label for="name_en">{{__('blog.tagname')}} ({{__('lang.en')}})</label>
                            <input type="text" name="name_en" value="{{$tags->name_en}}" class="form-control {{ $errors->has('name_en') ? ' is-invalid' : '' }}" placeholder="{{__('lang.departname')}}" >
                            @if ($errors->has('name_en'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('name_en') }}</strong></span>
                            @endif
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group"> 
                          <label for="slug">{{__('blog.slug')}}</label>
                          <input type="text" name="slug" value="{{$tags->slug}}" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="{{__('lang.departname')}}">
                          @if ($errors->has('slug'))
                            <span class="invalid-feedback"> <strong>{{ $errors->first('slug') }}</strong></span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('tag.index')}}" >{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection