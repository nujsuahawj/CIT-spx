<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.list')}}{{__('lang.send_goods_customer')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.list')}}{{__('lang.send_goods_customer')}}</li>
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
                      <a href="{{route('admin.send_customer')}}" class="btn btn-warning btn-sm"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
                    </div>
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-3">
                        <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                    <div align="center"><h4><u><b>{{__('lang.list')}}{{__('lang.send_goods_customer')}}</b></u></h4></div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th>{{__('lang.no')}}</th>
                            <th>{{__('lang.code')}}</th>
                            <th>{{__('lang.branch_sent')}}</th>
                            <th>{{__('lang.customer_send')}}</th>
                            <th>{{__('lang.branch_receive')}}</th>
                            <th>{{__('lang.customer_receive')}}</th>
                            <th>{{__('lang.amount')}}</th>
                            <th>{{__('lang.status')}}</th>
                            <th>{{__('lang.emp_send_goods_customer')}}</th>
                            <th>{{__('lang.date_send_goods_customer')}}</th>
                            <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        @foreach ($receive as $item)
                      <tr>
                        <td>{{$stt++}}</td>
                        <td>{{$item->code}}</td>
                        <td>
                            @if (Config::get('app.locale') == 'lo')
                            {{ $item->branch_sends->company_name_la }}
                            @elseif (Config::get('app.locale') == 'en')
                            {{ $item->branch_sends->company_name_en }}
                            @endif
                        </td>
                        <td>{{$item->customername_send->name}}</td>
                        <td>
                            @if (Config::get('app.locale') == 'lo')
                            {{ $item->branch_receive_name->company_name_la }}
                            @elseif (Config::get('app.locale') == 'en')
                            {{ $item->branch_receive_name->company_name_en }}
                            @endif
                        </td>
                        <td>{{$item->customername_receive->name}}</td>
                        <td >{{number_format($item->amount)}}</td>
                        <td>
                                  @if($item->status == 'SC')
                                    <div class="btn btn-primary btn-xs"> {{__('lang.send_goods_customer_finish')}} </div>
                                  @endif
                        </td>
                        <td>{{$item->delivername->name}}</td>
                        <td>{{date('d/m/Y h:i:s',strtotime($item->deliver_date))}}</td>
                        <td>
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="DetailReceive({{$item->id}})"><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                  </div>
                                </div>
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
  
  