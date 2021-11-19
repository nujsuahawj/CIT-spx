<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.receive_branch')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.receive_branch')}}</li>
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
                        <input wire:model="code" type="text" class="form-control  @error('code') is-invalid @enderror" >
                    </div>
                @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
                </div>
              </div>
            </div>

  
            <div class="col-md-9">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <a href="{{route('admin.list_receive_branch')}}" class="btn btn-warning btn-sm"><i class="fas fa-list-ol"></i> {{__('lang.list_receive')}}</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  @if(!empty($traffic_id))
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.receive_code')}}</th>
                          <th>{{__('lang.from')}}{{__('lang.branch')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>{{__('lang.status')}}</th>
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
                               <td>
                                    @if ( Config::get('app.locale') == 'lo')
                                        {{$item->sender->company_name_la}}
                                    @elseif ( Config::get('app.locale') == 'en' )
                                        {{$item->sender->company_name_en}}
                                    @endif
                               </td>
                               <td>{{date('d/m/Y h:i:s', strtotime($item->created_at))}}</td>
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
                            <td width="2%" style="text-align: center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    @if($item->status == 'S')
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
  
  