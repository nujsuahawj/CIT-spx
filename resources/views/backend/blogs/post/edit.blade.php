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
              <h4 class="card-title">{{__('lang.edit')}}</h4>
            </div>

            <form method="POST" action="{{route('post.update', $post->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <img src="{{asset($post->image)}}" height="50%" width="50%">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="image">{{__('blog.image')}}</label>
                          <input type="file" name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                          @if ($errors->has('image'))
                              <span class="invalid-feedback"> <strong>{{ $errors->first('image') }}</strong></span>
                          @endif
                        </div>
                      </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="title_la">{{__('blog.post')}} ({{__('lang.lao')}})</label>
                                <input type="text" name="title_la" value="{{$post->title_la}}" class="form-control {{ $errors->has('title_la') ? ' is-invalid' : '' }}" placeholder="{{__('blog.title')}}">
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
                                        <option 
                                            @if ($post->postcate_id == $item->id)
                                                {{'selected'}}
                                            @endif
                                            value="{{$item->id}}">{{$item->name_la}}
                                        </option>
                                    @elseif ( Config::get('app.locale') == 'en')
                                        <option
                                            @if ($post->postcate_id == $item->id)
                                                {{'selected'}}
                                            @endif 
                                            value="{{$item->id}}">{{$item->name_en}}
                                        </option>
                                    @endif
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="title_en">{{__('blog.post')}} ({{__('lang.en')}})</label>
                                <input type="text" name="title_en" value="{{$post->title_en}}" class="form-control {{ $errors->has('title_en') ? ' is-invalid' : '' }}" placeholder="{{__('blog.title')}}" >
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
                                <input type="text" name="slug" value="{{$post->slug}}" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="{{__('blog.slug')}}" >
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
                              <textarea type="text" name="short_des_la" class="form-control {{ $errors->has('short_des_la') ? ' is-invalid' : '' }}" placeholder="{{__('blog.short_des')}}" >{{$post->short_des_la}}</textarea>
                              @if ($errors->has('short_des_la'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('short_des_la') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="short_des_en">{{__('blog.short_des')}} ({{__('lang.en')}})</label>
                            <textarea type="text" name="short_des_en" class="form-control {{ $errors->has('short_des_en') ? ' is-invalid' : '' }}" placeholder="{{__('blog.short_des')}}" >{{$post->short_des_en}}</textarea>
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
                                <textarea name="des_la" class="form-group summernote">{{$post->des_la}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="des_en">{{__('blog.des')}} ({{__('lang.en')}})</label>
                                <textarea name="des_en" class="form-group summernote">{{$post->des_en}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('lang.status')}}</label>
                            <select class="form-control" name="publish">
                                <option value="1" {{$post->published == 1 ? 'selected' : ''}}>{{ __('blog.published') }}</option>
                                <option value="0" {{$post->published == 0 ? 'selected' : ''}}>{{ __('blog.unpublish') }}</option>
                            </select>
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