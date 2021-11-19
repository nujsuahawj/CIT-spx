@extends('layouts.settings.app-settings')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('lang.branch')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboardsetting.index')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.branch')}}</li>
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

            <form method="POST" action="{{route('branch.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="code">{{__('lang.code')}} ({{__('lang.lao')}})</label>
                                <input type="text" name="code" value="{{$code}}" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" placeholder="{{__('lang.branchname')}}">
                                @if ($errors->has('code'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('code') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                            <label for="logo">{{__('lang.logo')}}</label>
                            <input type="file" name="logo" class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}">
                            @if ($errors->has('logo'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('logo') }}</strong></span>
                            @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                            <label for="company_photo">{{__('lang.company_photo')}}</label>
                            <input type="file" name="company_photo" class="form-control {{ $errors->has('company_photo') ? ' is-invalid' : '' }}">
                            @if ($errors->has('company_photo'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('logo') }}</strong></span>
                            @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="company_name_la">{{__('lang.branchname')}} ({{__('lang.lao')}})</label>
                                <input type="text" name="company_name_la" class="form-control {{ $errors->has('company_name_la') ? ' is-invalid' : '' }}" placeholder="{{__('lang.branchname')}}">
                                @if ($errors->has('company_name_la'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('company_name_la') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="company_name_en">{{__('lang.branchname')}} ({{__('lang.eng')}})</label>
                                <input type="text" name="company_name_en" class="form-control {{ $errors->has('company_name_en') ? ' is-invalid' : '' }}" placeholder="{{__('lang.branchname')}}">
                                @if ($errors->has('company_name_en'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('company_name_en') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address_la">{{__('lang.address')}} ({{__('lang.lao')}})</label>
                                <input type="text" name="address_la" class="form-control {{ $errors->has('address_la') ? ' is-invalid' : '' }}" placeholder="{{__('lang.address')}}">
                                @if ($errors->has('address_la'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('address_la') }}</strong></span>
                                @endif
                              </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address_en">{{__('lang.address')}} ({{__('lang.en')}})</label>
                                <input type="text" name="address_en" class="form-control {{ $errors->has('address_en') ? ' is-invalid' : '' }}" placeholder="{{__('lang.address')}}" >
                                @if ($errors->has('address_en'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('address_en') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">{{__('lang.phone')}}</label>
                                <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{__('lang.phone')}}" >
                                @if ($errors->has('phone'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('phone') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('lang.province')}}</label>
                                <select class="form-control select2 {{ $errors->has('pro_id') ? ' is-invalid' : '' }}" name="pro_id" style="width: 100%;">   
                                  <option value="" selected>{{__('lang.select')}}</option>                   
                                  @foreach($province as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                                </select>
                                @if ($errors->has('pro_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('pro_id') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('lang.district')}}</label>
                                <select class="form-control select2 {{ $errors->has('dis_id') ? ' is-invalid' : '' }}" name="dis_id" style="width: 100%;">   
                                  <option value="" selected>{{__('lang.select')}}</option>                   
                                  @foreach($district as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                                </select>
                                @if ($errors->has('dis_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('dis_id') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('lang.village')}}</label>
                                <select class="form-control select2 {{ $errors->has('vill_id') ? ' is-invalid' : '' }}" name="vill_id" style="width: 100%;">   
                                  <option value="" selected>{{__('lang.select')}}</option>                   
                                  @foreach($village as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                                </select>
                                @if ($errors->has('vill_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('vill_id') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('lang.branch_type')}}</label>
                                <select class="form-control select2 {{ $errors->has('branch_type_id') ? ' is-invalid' : '' }}" name="branch_type_id" style="width: 100%;">   
                                  <option value="" selected>{{__('lang.select')}}</option>                   
                                  @foreach($branch_type as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                                </select>
                                @if ($errors->has('branch_type_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('branch_type_id') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('lang.dividend')}}</label>
                                <select class="form-control select2 {{ $errors->has('dividend_id') ? ' is-invalid' : '' }}" name="dividend_id" style="width: 100%;">   
                                  <option value="" selected>{{__('lang.select')}}</option>                   
                                  @foreach($dividends as $item)
                                      <option value="{{$item->id}}">{{$item->name}} {{$item->percent}}</option>
                                  @endforeach
                                </select>
                                @if ($errors->has('dividend_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('dividend_id') }}</strong></span>
                                @endif
                              </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('lang.tax')}}</label>
                                <select class="form-control select2 {{ $errors->has('tax_id') ? ' is-invalid' : '' }}" name="tax_id" style="width: 100%;">   
                                  <option value="" selected>{{__('lang.select')}}</option>                   
                                  @foreach($taxs as $item)
                                      <option value="{{$item->id}}">{{$item->name}} {{$item->percent}}</option>
                                  @endforeach
                                </select>
                                @if ($errors->has('tax_id'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('tax_id') }}</strong></span>
                                @endif
                              </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sign1">{{__('lang.sign1')}}</label>
                                <input type="text" name="sign1" class="form-control {{ $errors->has('sign1') ? ' is-invalid' : '' }}" placeholder="{{__('lang.sign1')}}" >
                                @if ($errors->has('sign1'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('sign1') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sign2">{{__('lang.sign2')}}</label>
                                <input type="text" name="sign2" class="form-control {{ $errors->has('sign2') ? ' is-invalid' : '' }}" placeholder="{{__('lang.sign2')}}" >
                                @if ($errors->has('sign2'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('sign2') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sign3">{{__('lang.sign3')}}</label>
                                <input type="text" name="sign3" class="form-control {{ $errors->has('sign3') ? ' is-invalid' : '' }}" placeholder="{{__('lang.sign3')}}" >
                                @if ($errors->has('sign3'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('sign3') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sign4">{{__('lang.sign4')}}</label>
                                <input type="text" name="sign4" class="form-control {{ $errors->has('sign4') ? ' is-invalid' : '' }}" placeholder="{{__('lang.sign4')}}" >
                                @if ($errors->has('sign4'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('sign4') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="whatsapp">{{__('lang.whatsapp')}}</label>
                                <input type="text" name="whatsapp" class="form-control {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" placeholder="{{__('lang.whatsapp')}}" >
                                @if ($errors->has('whatsapp'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('whatsapp') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facebook_fanpage">{{__('lang.facebook_fanpage')}}</label>
                                <input type="text" name="facebook_fanpage" class="form-control {{ $errors->has('facebook_fanpage') ? ' is-invalid' : '' }}" placeholder="{{__('lang.facebook_fanpage')}}" >
                                @if ($errors->has('facebook_fanpage'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('facebook_fanpage') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="youtube">{{__('lang.youtube')}}</label>
                                <input type="text" name="youtube" class="form-control {{ $errors->has('youtube') ? ' is-invalid' : '' }}" placeholder="{{__('lang.youtube')}}" >
                                @if ($errors->has('youtube'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('youtube') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="google_map">{{__('lang.google_map')}}</label>
                                <input type="text" name="google_map" class="form-control {{ $errors->has('google_map') ? ' is-invalid' : '' }}" placeholder="{{__('lang.google_map')}}" >
                                @if ($errors->has('google_map'))
                                  <span class="invalid-feedback"> <strong>{{ $errors->first('google_map') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="longitude">{{__('lang.longitude')}}</label>
                              <input type="text" name="longitude" class="form-control {{ $errors->has('longitude') ? ' is-invalid' : '' }}" placeholder="{{__('lang.longitude')}}" >
                              @if ($errors->has('longitude'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('longitude') }}</strong></span>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="latitude">{{__('lang.latitude')}}</label>
                              <input type="text" name="latitude" class="form-control {{ $errors->has('latitude') ? ' is-invalid' : '' }}" placeholder="{{__('lang.latitude')}}" >
                              @if ($errors->has('latitude'))
                                <span class="invalid-feedback"> <strong>{{ $errors->first('latitude') }}</strong></span>
                              @endif
                          </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bill_header">{{__('lang.des')}} ({{__('lang.bill_header')}})</label>
                                <textarea name="bill_header" class="form-group summernote"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bill_footer">{{__('lang.des')}} ({{__('lang.bill_footer')}})</label>
                                <textarea name="bill_footer" class="form-group summernote"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('lang.active')}}</label>
                                <select class="form-control" name="active">
                                    <option value="1">{{ __('blog.active') }}</option>
                                    <option value="0">{{ __('blog.inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                    <a class="btn btn-warning" href="{{route('branch.index')}}" >{{__('lang.back')}}</a>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
