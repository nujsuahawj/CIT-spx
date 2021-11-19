@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.post')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.post')}}</li>
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

            <form method="POST" action="{{route('post.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="image">{{__('blog.image')}}</label>
                          <input type="file" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">
                          @if ($errors->has('image'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('image') }}</strong></span>
                          @endif
                        </div>
                      </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="title_la">{{__('blog.post')}} ({{__('lang.lao')}})</label>
                                <input type="text" name="title_la" class="form-control {{ $errors->has('title_la') ? ' is-invalid' : '' }}" placeholder="{{__('blog.title')}}">
                                @if ($errors->has('title_la'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('name_la') }}</strong></span>
                                @endif
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('blog.postcategory')}}</label>
                                <select class="form-control select2" name="postcate_id" style="width: 100%;">  
                                  <option value="" selected>{{__('lang.select')}}</option>                   
                                  @foreach($all_postcate as $item)
                                    @if ( Config::get('app.locale') == 'lo')
                                        <option value="{{$item->id}}">{{$item->name_la}}</option>
                                    @elseif ( Config::get('app.locale') == 'en')
                                        <option value="{{$item->id}}">{{$item->name_en}}</option>
                                    @endif
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="title_en">{{__('blog.post')}} ({{__('lang.en')}})</label>
                                <input type="text" name="title_en" class="form-control {{ $errors->has('title_en') ? ' is-invalid' : '' }}" placeholder="{{__('blog.title')}}" >
                                @if ($errors->has('title_en'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('title_en') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="slug">{{__('blog.slug')}}</label>
                                <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="{{__('blog.slug')}}" >
                                @if ($errors->has('slug'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('slug') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="short_des_la">{{__('blog.short_des')}} ({{__('lang.lao')}})</label>
                              <textarea type="text" name="short_des_la" class="form-control {{ $errors->has('short_des_la') ? ' is-invalid' : '' }}" placeholder="{{__('blog.short_des')}}" ></textarea>
                              @if ($errors->has('short_des_la'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('short_des_la') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="short_des_en">{{__('blog.short_des')}} ({{__('lang.en')}})</label>
                            <textarea type="text" name="short_des_en" class="form-control {{ $errors->has('short_des_en') ? ' is-invalid' : '' }}" placeholder="{{__('blog.short_des')}}" ></textarea>
                            @if ($errors->has('short_des_en'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('short_des_en') }}</strong></span>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_la">{{__('blog.des')}} ({{__('lang.lao')}})</label>
                                <textarea name="des_la" class="form-group summernote"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_en">{{__('blog.des')}} ({{__('lang.en')}})</label>
                                <textarea name="des_en" class="form-group summernote"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('post.index')}}" >{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
  <script>
    
  </script>
@endsection