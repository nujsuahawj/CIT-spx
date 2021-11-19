<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.shipout_goods')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.shipout_goods')}}</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
  
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            
            <!--List users- table table-bordered table-striped -->
  
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-3">
                      <a href="{{route('admin.shipout')}}" class="btn btn-warning btn-sm"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
                    </div>
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-3">
                        <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                    <div align="center"><h4><u><b>{{__('lang.sub_list')}}</b></u></h4></div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                              <th>{{__('lang.no')}}</th>
                              <th>{{__('lang.receive_code')}}</th>
                              <th>{{__('lang.product_code')}}</th>
                              <th>{{__('lang.goods_type')}}</th>
                              <th>{{__('lang.weigh')}}</th>
                              <th>{{__('lang.amount')}}</th>
                              <th>{{__('lang.paid_type')}}</th>
                              <th>{{__('lang.to')}}</th>
                              <th>{{__('lang.status')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        @foreach ($matterails as $item)
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$item->rvcode}}</td>
                            <td>{{$item->code}}</td>
                            <td>{{$item->goodname->name}}</td>
                            <td>{{$item->weigh}}</td>
                            <td>{{number_format($item->amount)}}</td>
                            <td>@if($item->paid_type=='SD') {{__('lang.by_sender')}}@else {{__('lang.by_receiver')}}@endif</td>
                            <td>
                              @if ( Config::get('app.locale') == 'lo')
                                  {{$item->logisdetailname->sendto->company_name_la}}
                              @elseif ( Config::get('app.locale') == 'en' )
                                  {{$item->logisdetailname->sendto->company_name_en}}
                              @endif
                            </td>
                            <td>
                              @if($item->status == 'P')
                                <div class="btn btn-danger btn-xs"> {{__('lang.pending')}} </div>
                              @elseif($item->status == 'N')
                                <div class="btn btn-info btn-xs"> {{__('lang.normal')}} </div>
                              @elseif($item->status == 'S')
                                <div class="btn btn-warning btn-xs"> {{__('lang.sending')}} </div>
                              @elseif($item->status == 'ST')
                                <div class="btn btn-info btn-xs"> {{__('lang.warehouse')}} </div>
                              @elseif($item->status == 'F')
                                <div class="btn btn-success btn-xs"> {{__('lang.send_finish')}} </div>
                              @endif
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
  
                    <div>
              
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>
  </div>
  
  @push('scripts')
    <script>
          $('.select2').select2();
    </script>
  @endpush
  
  