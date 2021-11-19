@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.texttitle')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.texttitle')}}</li>
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
              <h4 class="card-title">{{__('lang.edit')}}</h4>
            </div>

            <form method="POST" action="{{route('texttitle.update', $texttitle->id)}}">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="title_la">{{__('blog.texttitle')}} ({{__('lang.lao')}})</label>
                            <input type="text" name="title_la" value="{{$texttitle->title_la}}" class="form-control {{ $errors->has('title_la') ? ' is-invalid' : '' }}" placeholder="{{__('lang.departname')}}" autofocus>
                            @if ($errors->has('title_la'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('title_la') }}</strong></span>
                            @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group"> 
                            <label for="title_en">{{__('blog.texttitle')}} ({{__('lang.en')}})</label>
                            <input type="text" name="title_en" value="{{$texttitle->title_en}}" class="form-control {{ $errors->has('title_en') ? ' is-invalid' : '' }}" placeholder="{{__('lang.departname')}}" >
                            @if ($errors->has('title_en'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('title_en') }}</strong></span>
                            @endif
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="des_la">{{__('blog.des')}} ({{__('lang.lao')}})</label>
                              <textarea type="text" name="des_la"class="form-control {{ $errors->has('des_la') ? ' is-invalid' : '' }}" placeholder="{{__('lang.departname')}}"> {{$texttitle->des_la}} </textarea>
                              @if ($errors->has('des_la'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('des_la') }}</strong></span>
                              @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                              <label for="des_en">{{__('blog.des')}} ({{__('lang.en')}})</label>
                              <textarea type="text" name="des_en" class="form-control {{ $errors->has('des_en') ? ' is-invalid' : '' }}" placeholder="{{__('lang.departname')}}" > {{$texttitle->des_en}} </textarea>
                              @if ($errors->has('des_en'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('des_en') }}</strong></span>
                              @endif
                            </div>
                        </div>
                      </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>{{__('lang.status')}}</label>
                            <select class="form-control" name="status">
                                <option value="1" {{ $texttitle->status == 1 ? 'selected' : '' }}>{{ __('blog.active') }}</option>
                                <option value="0" {{ $texttitle->status == 0 ? 'selected' : '' }}>{{ __('blog.inactive') }}</option>
                            </select>
                          </div>
                      </div>
                    </div>
                  </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('texttitle.index')}}" >{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection