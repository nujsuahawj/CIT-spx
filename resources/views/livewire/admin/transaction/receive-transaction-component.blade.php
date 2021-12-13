<div>
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('lang.receive_transaction')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
              <li class="breadcrumb-item active">{{__('lang.receive_transaction')}}</li>
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
                    <label><a  class="btn btn-primary btn-sm" href="{{route('transaction.create')}}">{{__('lang.create')}}</a></label>
                  </div>
                  <div class="col-md-3">
                    <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                  </div>
                  <div class="col-md-3">
                    <input wire:model="search_by_date" type="date" class="form-control" placeholder="{{__('lang.search')}}">
                  </div>
                  <div class="col-md-3">
                    <select wire:model.defer="search_by_brc" class="form-control @error('branch_id') is-invalid @enderror">
                      <option value="">{{__('lang.select')}}</option>
                    @foreach($branch as $item)
                      @if (Config::get('app.locale') == 'lo')
                        <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                      @elseif (Config::get('app.locale') == 'en')
                        <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                      @endif
                    @endforeach
                </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
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
                        <th>{{__('lang.paid_type')}}</th>
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
                        <td>
                                  @if($item->status == 'P')
                                    <div class="btn btn-warning btn-xs"> {{__('lang.pending')}} </div>
                                  @elseif($item->status == 'N')
                                    <div class="btn btn-warning btn-xs"> {{__('lang.normal')}} </div>
                                  @elseif($item->status == 'S')
                                    <div class="btn btn-success btn-xs"> {{__('lang.sending')}} </div>
                                  @elseif($item->status == 'ST')
                                    <div class="btn btn-info btn-xs"> {{__('lang.warehouse')}} </div>
                                  @elseif($item->status == 'STS')
                                    <div class="btn btn-warning btn-xs"> {{__('lang.sending')}} </div>
                                  @elseif($item->status == 'RJ')
                                    <div class="btn btn-danger btn-xs"> {{__('lang.reject')}} </div>
                                  @elseif($item->status == 'F')
                                    <div class="btn btn-info btn-xs"> {{__('lang.send_finish')}} </div>
                                  @elseif($item->status == 'SC')
                                    <div class="btn btn-primary btn-xs"> {{__('lang.send_goods_customer_finish')}} </div>
                                  @endif
                        </td>
                        <td>
                            @if($item->paid_by=='SD') 
                              <div class="btn btn-success btn-xs">{{__('lang.by_sender')}}</div>
                            @else 
                              <div class="btn btn-warning btn-xs">  {{__('lang.by_receiver')}}</div>
                            @endif
                        </td>
                        <td>{{date('d/m/Y h:i:s', strtotime($item->created_at))}}</td>
                        <td>
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="DetailReceive({{$item->id}})"><i class="fas fa-info-circle text-info"></i> {{__('lang.detail')}}</a>
                                  @if($item->status == 'N' || auth()->user()->rolename->name == 'admin')
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="showDestroy({{$item->id}})"><i class="fas fa fa-times-circle text-danger"></i> {{__('lang.reject')}}</a>
                                  @endif
                                  @if($item->status == 'N' || auth()->user()->rolename->name == 'admin')
                                    <a class="dropdown-item" href="{{route('voucher.printreceive',$item->code)}}"><i class="fas fa-print text-success"></i> {{__('lang.printreceive')}}</a>
                                    <a class="dropdown-item" href="{{route('voucher.printmatterail',$item->code)}}"><i class="fas fa-print text-success"></i> {{__('lang.printmatterail')}}</a>
                                  @endif
                                  </div>
                                </div>
                        </td>
                      </tr>
                      @endforeach
                      
                      </tbody>
                  </table>

                  <div class="float-right">
                    {{$receivetransaction->links()}}
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- /.modal-delete -->
    <div class="modal fade" id="modal-delete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.reject')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" wire:model="hiddenId">
            <h3>{{__('lang.do_you_want_to_reject') }}</h3>
            <h4><span style="color: red"> {{$rv_code}} </span></h4>
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="destroyReceiveTransaction({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.reject')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>

</div>

@push('scripts')
  <script>
    window.addEventListener('show-modal-delete', event => {
        $('#modal-delete').modal('show');
    })
    window.addEventListener('hide-modal-delete', event => {
        $('#modal-delete').modal('hide');
    })
  </script>
@endpush

