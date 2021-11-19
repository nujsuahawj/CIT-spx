@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('blog.postcategory')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('blog.postcategory')}}</li>
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
              <h4 class="card-title">{{__('lang.edit')}}</h4>
            </div>

            <form method="POST" action="{{route('postcategory.update', $postcategory->id)}}">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">{{__('blog.postcategory')}}</label>
                                <input type="text" name="name_la" value="{{$postcategory->name_la}}" class="form-control {{ $errors->has('name_la') ? ' is-invalid' : '' }}" placeholder="{{__('blog.postcategory')}}" autofocus>
                                @if ($errors->has('name_la'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('name_la') }}</strong></span>
                                @endif
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">{{__('blog.postcategory')}}</label>
                                <input type="text" name="name_en" value="{{$postcategory->name_en}}" class="form-control {{ $errors->has('name_en') ? ' is-invalid' : '' }}" placeholder="{{__('blog.postcategory')}}" autofocus>
                                @if ($errors->has('name_en'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('name_en') }}</strong></span>
                                @endif
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('blog.parent_id')}}</label>
                                <select class="form-control select2" name="parent_id" style="width: 100%;">  
                                  <option value="0" selected>{{__('lang.select')}}</option>                   
                                  @foreach($all_postcate as $item)
                                    @if ( Config::get('app.locale') == 'lo')
                                        <option 
                                            @if($postcategory->parent_id == $item->id)
                                                {{'selected'}}
                                            @endif
                                            value="{{$item->id}}">{{$item->name_la}}
                                        </option>
                                    @elseif ( Config::get('app.locale') == 'en')
                                        <option 
                                            @if($postcategory->parent_id == $item->id)
                                                {{'selected'}}
                                            @endif
                                            value="{{$item->id}}">{{$item->name_en}}
                                        </option>
                                    @endif
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('postcategory.index')}}" >{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection