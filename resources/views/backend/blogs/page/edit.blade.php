@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.page')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.page')}}</li>
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

            <form method="POST" action="{{route('page.update', $page->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="card-body">

                    <div class="row">
                      <div class="col-md-12">
                          <div class="text-center">
                              <img src="{{asset($page->image)}}" height="20%" width="20%">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="image">{{__('blog.image')}}</label>
                          <input type="file" name="image" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title_la">{{__('blog.page')}} ({{__('lang.lao')}})</label>
                                <input type="text" name="title_la" value="{{$page->title_la}}" class="form-control {{ $errors->has('title_la') ? ' is-invalid' : '' }}" placeholder="{{__('blog.title')}}">
                                @if ($errors->has('title_la'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('name_la') }}</strong></span>
                                @endif
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title_en">{{__('blog.page')}} ({{__('lang.en')}})</label>
                                <input type="text" name="title_en" value="{{$page->title_en}}" class="form-control {{ $errors->has('title_en') ? ' is-invalid' : '' }}" placeholder="{{__('blog.title')}}" >
                                @if ($errors->has('title_en'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('title_en') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug">{{__('blog.slug')}}</label>
                                <input type="text" name="slug" value="{{$page->slug}}" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="{{__('blog.slug')}}" >
                                @if ($errors->has('slug'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('slug') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>{{__('lang.status')}}</label>
                              <select class="form-control" name="status">
                                  <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>{{ __('blog.active') }}</option>
                                  <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>{{ __('blog.inactive') }}</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="short_des_la">{{__('blog.short_des')}} ({{__('lang.lao')}})</label>
                              <textarea name="short_des_la" class="form-control">{{$page->short_des_la}}</textarea>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="short_des_en">{{__('blog.short_des')}} ({{__('lang.en')}})</label>
                              <textarea name="short_des_en" class="form-control">{{$page->short_des_en}}</textarea>
                          </div>
                      </div>
                  </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_la">{{__('blog.des')}} ({{__('lang.lao')}})</label>
                                <textarea name="des_la" class="form-control summernote">{{$page->des_la}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_en">{{__('blog.des')}} ({{__('lang.en')}})</label>
                                <textarea name="des_en" class="form-control summernote">{{$page->des_en}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.save')}}">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('page.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.back')}}">{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
