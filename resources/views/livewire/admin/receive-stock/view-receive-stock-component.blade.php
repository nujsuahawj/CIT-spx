<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.receive_stock')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.receive_stock')}}</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
  
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            
            <!--List users- table table-bordered table-striped -->
            <div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div align="center"><b>{{__('lang.enter_code_traffic')}}</b></div>
                </div>
                <div class="card-body">
                  <div class="form-group clearfix">
                      <div class="form-group">   
                          <div class="input-group">
                                <div class="input-group-prepend">
                                  <button type="button" class="btn btn-info">{{__('lang.bill_code')}}</button>
                                </div>
                              <input wire:model="code" wire:keydown.enter="acceptall" type="text" class="form-control  @error('code') is-invalid @enderror" >
                          </div>
                      @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                  </div>
                </div>
              </div> <!-- end card -->
              <div class="card">
                <div class="card-header">
                  <div align="center"><b>{{__('lang.bill_receive')}}</b></div>
                </div>
                <div class="card-body">
                  <div class="form-group clearfix">
                      <div class="form-group">   
                          <div class="input-group">
                                <div class="input-group-prepend">
                                  <button type="button" class="btn btn-info">{{__('lang.bill_code')}}</button>
                                </div>
                              <input wire:model="code_bill" type="text" class="form-control" >
                          </div>
                      </div>
                  </div>
                </div>
              </div> <!-- end card -->
            </div>

  
            <div class="col-md-9">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <a href="{{route('admin.list_receive_stock')}}" class="btn btn-warning btn-sm"><i class="fas fa-list-ol"></i> {{__('lang.list_receive_stock')}}</a>
                      <a href="{{route('admin.shipout_stock')}}" class="btn btn-info btn-sm"><i class="fas fa-list-ol"></i> {{__('lang.list_shipout_stock')}}</a>
                    </div>
                    <div class="col-md-4">
                       
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  @if(!empty($code))
                  @if(!empty($traffic_id))
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.code')}}</th>
                          <th>{{__('lang.traffic')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>{{__('lang.creator_data')}}</th>
                          <th>{{__('lang.branch')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        @foreach($shipout as $item)
                            <tr>
                              <td>{{$stt++}}</td>
                              <td>{{$item->rvcode}}</td>
                              <td>{{$item->trafficname->trf_code}}</td>
                              <td>{{date('d/m/Y h:i:s', strtotime($item->create_date))}}</td>
                              <td>{{$item->username->name}}</td>
                              <td>
                                @if ( Config::get('app.locale') == 'lo')
                                    {{$item->sendto->company_name_la}}
                                @elseif ( Config::get('app.locale') == 'en' )
                                    {{$item->sendto->company_name_en}}
                                @endif
                              </td>
                            <td width="2%" style="text-align: center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    @if(auth()->user()->rolename->name == 'stock')
                                    
                                      <!-- <a class="dropdown-item" href="javascript:void(0)" wire:click="accept({{$item->id}})"><i class="fas fa-check-circle text-success"> {{__('lang.accept')}}</i></a> -->
                                     
                                      <a class="dropdown-item" href="javascript:void(0)" wire:click="accept({{$item->id}})"><i class="fas fa-check-circle text-success"> {{__('lang.accept')}}</i></a>
                                      
                                    @endif
                                    
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="receivePrint({{$item->id}})"><i class="fas fa-print text-primary"> {{__('lang.printa4')}}</i></a>
                                  </div>
                                </div>
                            </td>
                          </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                  </div>
                  <div>
                  {{$shipout->links()}}
                  </div>
                  @endif
                @endif
                  
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>
  
  </div>
  
  @push('scripts')
    <script>

    </script>
  @endpush
  
  