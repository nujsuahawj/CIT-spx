@extends('layouts.settings.app-settings')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('lang.user')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboardsetting.index')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.user')}}</li>
          </ol>
        </div>
      </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="col-lg-12">
          <div class="card card-default">

            <div class="card-header">
              <h3 class="card-title"><h4 class="card-title">{{__('lang.edit')}}</h4></h3>
  
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>          
            
            <form method="POST" action="{{route('user.update', $user->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <img src="{{asset($user->image)}}" height="100">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="username">{{__('lang.username')}}</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user->name}}" placeholder="{{__('lang.username')}}">
                        @if ($errors->has('name'))
                          <span class="invalid-feedback"> <strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="phone">{{__('lang.phone')}}</label>
                        <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{$user->phone}}" placeholder="{{__('lang.phone')}}">
                        @if ($errors->has('phone'))
                          <span class="invalid-feedback"> <strong>{{ $errors->first('phone') }}</strong></span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="email">{{__('lang.email')}}</label>
                          <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" placeholder="{{__('lang.email')}}">
                          @if ($errors->has('email'))
                            <span class="invalid-feedback"> <strong>{{ $errors->first('email') }}</strong></span>
                          @endif
                        </div>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="password">{{__('lang.password')}}</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{__('lang.password')}}">
                        @if ($errors->has('password'))
                          <span class="invalid-feedback"> <strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="password_confirmation">{{__('lang.confirmpassword')}}</label>
                        <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="{{__('lang.confirmpassword')}}">
                        @if ($errors->has('password_confirmation'))
                          <span class="invalid-feedback"> <strong>{{ $errors->first('password_confirmation') }}</strong></span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="address">{{__('lang.address')}}</label>
                        <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{$user->address}}" placeholder="{{__('lang.address')}}">
                        @if ($errors->has('address'))
                          <span class="invalid-feedback"> <strong>{{ $errors->first('address') }}</strong></span>
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>{{__('lang.rolename')}}</label>
                        <select class="form-control select2 {{ $errors->has('role_id') ? ' is-invalid' : '' }}" name="role_id" style="width: 100%;">   
                          <option value="" selected>{{__('lang.select')}}</option>                   
                          @foreach($role as $item)
                              <option 
                                  @if ($user->role_id == $item->id)
                                      {{'selected'}}
                                  @endif
                                  value="{{$item->id}}">{{$item->name}}
                              </option>
                          @endforeach
                        </select>
                        @if ($errors->has('role_id'))
                          <span class="invalid-feedback"> <strong>{{ $errors->first('role_id') }}</strong></span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>{{__('lang.employee')}}</label>
                          <select class="form-control select2 {{ $errors->has('emp_id') ? ' is-invalid' : '' }}" name="emp_id" style="width: 100%;">  
                            <option value="" selected>{{__('lang.select')}}</option>                   
                            @foreach($employee as $item)
                                <option 
                                    @if ($user->emp_id == $item->id)
                                        {{'selected'}}
                                    @endif
                                    value="{{$item->id}}">{{$item->firstname}} {{$item->lastname}} {{$item->phone}}
                                </option>
                            @endforeach
                          </select>
                          @if ($errors->has('emp_id'))
                            <span class="invalid-feedback"> <strong>{{ $errors->first('emp_id') }}</strong></span>
                          @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>{{__('lang.branch')}}</label>
                          <select class="form-control select2 {{ $errors->has('branch_id') ? ' is-invalid' : '' }}" name="branch_id" style="width: 100%;">  
                            <option value="" selected>{{__('lang.select')}}</option>                   
                            @foreach($branch as $item)
                                <option 
                                    @if ($user->branch_id == $item->id)
                                        {{'selected'}}
                                    @endif
                                    value="{{$item->id}}">{{$item->company_name_la}}
                                </option>
                            @endforeach
                          </select>
                          @if ($errors->has('branch_id'))
                            <span class="invalid-feedback"> <strong>{{ $errors->first('branch_id') }}</strong></span>
                          @endif
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="image">{{__('lang.image')}}</label>
                        <input type="file" name="image" class="form-control">
                      </div>
                    </div>
                  </div>
                
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('settings.users-component')}}" >{{__('lang.back')}}</a>
                </div>
            </form>
            
          </div>

      </div>
    </div>
  </section>
@endsection