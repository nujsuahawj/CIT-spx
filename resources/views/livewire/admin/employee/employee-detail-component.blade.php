<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <b>{{__('lang.employee_detail')}}</b>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.employee_detail')}}</li>
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
              </div>
              <div class="card-body">
                    <div class="row"> 
                        <div class="col-md-3">
                          <div class="row"> 
                            <div class="col-md-12" align="center">
                              ຮູບພາບ
                            </div>
                          </div>
                          <div class="row"> 
                            <div class="col-md-12" align="center">
                              <img src="{{asset($employees->photo)}}" height="200px" width="200px">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-9">
                          <table class="table table-striped" >
                            <tr>
                              <th width="30%" style="text-align: right;">{{__('lang.code')}}</th>
                              <td width="50%">{{$employees->code}}</td>
                            </tr>
                            <tr>
                              <th style="text-align: right;">{{__('lang.start_date')}}</th>
                              <td width="50%">{{date('d/m/Y',strtotime($employees->start_date))}}</td>
                            </tr>
                            <tr>
                              <th style="text-align: right;">{{__('lang.position')}}</th>
                              <td width="50%">{{$employees->salaryhname->name}}</td>
                            </tr>
                            <tr>
                              <th style="text-align: right;">{{__('lang.firstname')}} {{__('lang.and')}} {{__('lang.lastname')}}</th>
                              <td width="50%">{{$employees->firstname}} {{$employees->lastname}}</td>
                            </tr>
                            <tr>
                              <th style="text-align: right;">{{__('lang.phone')}}</th>
                              <td width="50%">{{$employees->phone}}</td>
                            </tr>
                            <tr>
                              <th style="text-align: right;">{{__('lang.address')}}</th>
                              <td width="50%">{{$employees->address}}</td>
                            </tr>
                            <tr>
                              <th style="text-align: right;">{{__('lang.village')}}, {{__('lang.district')}}, {{__('lang.province')}}</th>
                              <td width="50%">{{$employees->villagename->name}}, {{$employees->districtname->name}}, {{$employees->provincename->name}}</td>
                            </tr>
                            <tr>
                              <th style="text-align: right;">{{__('lang.card_detail')}}</th>
                              <td width="50%">{{$employees->card_id}} {{$employees->card_enddate}}</td>
                            </tr>
                          </table>
                        </div>
                    </div><!-- End row -->
                </div>
              <div class="card-footer" align="right">
                <a href="{{route('admin.employee')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
              </div>
            </div> <!-- End Col-md-12 -->
          </div> <!-- End row -->
        </div>
      </div>
    </section>
</div>
