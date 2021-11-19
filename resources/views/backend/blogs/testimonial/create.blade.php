@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.testimonial')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.testimonial')}}</li>
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
              <h4 class="card-title">{{__('lang.add')}}</h4>
            </div>

            <form method="POST" action="{{route('testimonial.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="image">{{__('blog.image')}}</label>
                          <input type="file" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" required>
                          @if ($errors->has('image'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('image') }}</strong></span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('lang.status')}}</label>
                            <select class="form-control" name="status">
                                <option value="1">{{ __('blog.active') }}</option>
                                <option value="0">{{ __('blog.inactive') }}</option>
                            </select>
                          </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">{{__('lang.firstname')}} ({{__('lang.lastname')}})</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('name'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('des_la') }}</strong></span>
                            @endif
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="position">{{__('lang.position')}}</label>
                              <input name="position" class="form-control">
                          </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_la">{{__('blog.des')}} ({{__('lang.lao')}})</label>
                                <textarea type="text" name="des_la" class="form-control {{ $errors->has('des_la') ? ' is-invalid' : '' }}" > </textarea>
                                @if ($errors->has('des_la'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('des_la') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_en">{{__('blog.des')}} ({{__('lang.en')}})</label>
                                <textarea name="des_en" class="form-control"> </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.save')}}">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('testimonial.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.back')}}">{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
