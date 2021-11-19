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
            
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-12">
                <div class="form-group">
                    <div class="input-group">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-info">{{__('lang.bill_code')}}</button>
                          </div>
                        <input wire:model="code" type="text" class="form-control  @error('code') is-invalid @enderror"  readonly>
                    </div>
                @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">   
                    <div class="input-group">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-info">{{__('lang.list_traffic')}}</button>
                          </div>
                        <input wire:model="traff_code" wire:keydown.enter="addtraff" type="text" class="form-control  @error('traff_code') is-invalid @enderror">
                        <input wire:model="traffic_id" type="hidden" class="form-control">
                    </div>
                @error('traffic_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
                <hr>
                <div class="form-group clearfix">
                    <h5><b>{{__('lang.bill_receive')}}:</b></h5> 

                    <div class="form-group">   
                        <div class="input-group">
                              <div class="input-group-prepend">
                                <button wire:click="showbillReceiveDetail()" type="button" class="btn btn-info">{{__('lang.bill_receive')}}</button>
                              </div>
                            <input wire:model="billReceive" wire:keydown.enter="addbillReceive" type="text" class="form-control  @error('billReceive') is-invalid @enderror">
                        </div>
                    @error('billReceive') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                    </div> <!-- End Col-12 --> 
                  </div> <!-- End Row -->
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-6" align="center">
                      <button wire:click="save()" type="button" class="btn btn-primary"> <i class="fas fa-save"></i> {{__('lang.save')}}</button>  
                    </div>
                    <div class="col-md-6" align="center">
                      <a href="{{route('admin.shipout')}}"  type="button" class="btn btn-warning" ><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
                    </div>
                  </div>
                </div>
              </div><!-- End card -->
            </div>

            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-9">
                      <h4> {{__('lang.list_bill_receive')}}</h4>
                    </div>

                    <div class="col-md-3">
                        <input wire:model="search_detail" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.receive_code')}}</th>
                          <th>{{__('lang.to')}}{{__('lang.branch')}}</th>
                          <th>{{__('lang.created_at')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        @foreach($transaction as $item)
                            <tr>
                                <td>{{$stt++}}</td>
                                <td>{{$item->rvcode}}</td>
                                <td>
                                    @if ( Config::get('app.locale') == 'lo')
                                        {{$item->sendto->company_name_la}}
                                    @elseif ( Config::get('app.locale') == 'en' )
                                        {{$item->sendto->company_name_en}}
                                    @endif
                                </td>
                                <td>{{date('d/m/Y', strtotime($item->add_date))}}</td>
                                <td>
                                    <button wire:click="showDestroyTran({{$item->id}})" type="button" class="btn btn-danger btn-sm"><i class="fa fa-minus" aria-hidden="true"></i> </button>
                                    <button wire:click="showDetailReceive({{$item->id}})" type="button" class="btn btn-info btn-sm"><i class="fa fa-list-alt" aria-hidden="true"></i> </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
  
                    <div class="float-right">
                      {{$transaction->links()}}
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>

    <!-- /.modal-receive_transaction -->
    <div wire:ignore.self class="modal fade" id="modal-bill-receive-detail">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.receive_transaction')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                </div>
            </div>
            <br>
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
                        <th>{{__('lang.created_at')}}</th>
                        <th>{{__('lang.action')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                        $stt = 1;    
                      @endphp
  
                      @foreach ($receivetransaction as $item)
                      <tr>
                        <td>{{$stt++}}</td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->brs}}</td>
                        <td>{{$item->css}}</td>
                        <td>{{$item->brr}}</td>
                        <td>{{$item->crr}}</td>
                        <td >{{number_format($item->amount,2,",",".")}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <button wire:click="addReceive({{$item->id}})" type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                        </td>
                      </tr>
                      @endforeach
                      
                      </tbody>
                  </table>

                  <div>
                    {{$receivetransaction->links()}}
                  </div>

                </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('lang.close')}}</button>
            <button wire:click="addall()" type="button" class="btn btn-success float-right" data-dismiss="modal">>>> {{__('lang.select_all')}}</button>
          </div>
        </div>
      </div>
    </div>

    <!-- /.modal-list-receive -->
    <div wire:ignore.self class="modal fade" id="modal-receive-detail">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.list_receive')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.code')}}</th>
                          <th>{{__('lang.goods_type')}}</th>
                          <th>{{__('lang.product_type')}}</th>
                          <th>{{__('lang.large')}}</th>
                          <th>{{__('lang.height')}}</th>
                          <th>{{__('lang.longs')}}</th>
                          <th>{{__('lang.weigh')}}</th>
                          <th>{{__('lang.calculator_type')}}</th>
                          <th>{{__('lang.amount')}}</th>
                          <th>{{__('lang.paid_type')}}</th>
                          <th>{{__('lang.cod_service_amount')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                        $stt = 1;    
                      @endphp
                      @foreach ($matterail as $item)
                      <tr>
                        <td>{{$stt++}}</td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->gname}}</td>
                        <td>{{$item->pname}}</td>
                        <td>{{$item->large}}</td>
                        <td>{{$item->height}}</td>
                        <td>{{$item->longs}}</td>
                        <td>{{$item->weigh}}</td>
                        <td>{{$item->calname}}</td>
                        <td>{{number_format($item->amount)}}</td>
                        <td>@if($item->paid_type=='SD') {{__('lang.by_sender')}}@else {{__('lang.by_receiver')}}@endif</td>
                        <td>{{number_format($item->cod_amount)}}</td>
                      </tr>
                      @endforeach   
                      </tbody>
                  </table>
                </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('lang.close')}}</button>
           
          </div>
        </div>
      </div>
    </div>

    <!-- /.modal-traffic -->
    @if(!empty($traffic_id))
    <div wire:ignore.self class="modal fade" id="modal-traffic">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.vihicles')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4><b>{{__('lang.bill_no')}}: <i class="text-primary">{{$traff->trf_code}}</i> <br>
                      {{__('lang.vihicletype')}}: <i class="text-primary">{{$traff->vihiclename->vihicletypename->name}} </i><br>
                      {{__('lang.plate')}}: <i class="text-primary">{{$traff->vihiclename->plate_number}}</i><br>
                      {{__('lang.employee_traffic')}}:<br> 
                      @foreach($staff as $item)
                      @php $stt = 1; @endphp
                      <i class="text-primary"> {{$stt++}}. {{$item->employeename->firstname}} {{$item->employeename->lastname}}</i><br>
                      @endforeach
                      </h4>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger float-right" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- /.modal-delete -->
    <div class="modal fade" id="modal-delete-transaction">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.delete')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" wire:model="hiddenIdTran">
            <h3>{{__('lang.do_you_want_to_delete') }}</h3>
            <h4><i class="text-danger"><b>{{$tranCode}}</b></i></h4>
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="destroyTran({{$hiddenIdTran}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  
  </div>
  
  @push('scripts')
    <script>
        window.addEventListener('show-modal-traffic', event=>{
            $('#modal-traffic').modal('show');
        })
        window.addEventListener('hide-modal-traffic', event=>{
            $('#modal-traffic').modal('hide');
        })
        window.addEventListener('show-modal-delete', event=>{
            $('#modal-delete-transaction').modal('show');
        })
        window.addEventListener('hide-modal-delete', event=>{
            $('#modal-delete-transaction').modal('hide');
        })
        window.addEventListener('show-modal-bill-receive-detail', event => {
            $('#modal-bill-receive-detail').modal('show');
        })
        window.addEventListener('hide-modal-bill-receive-detail', event => {
            $('#modal-bill-receive-detail').modal('hide');
        })
        window.addEventListener('show-modal-receive-detail', event => {
            $('#modal-receive-detail').modal('show');
        })
        window.addEventListener('hide-modal-receive-detail', event => {
            $('#modal-receive-detail').modal('hide');
        })
    </script>
  @endpush
  
  