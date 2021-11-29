<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.send_goods_customer')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.send_goods_customer')}}</li>
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
                  <div align="center"><b>{{__('lang.bill_code')}}</b></div>
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
                      <a href="{{route('admin.list_send_customer')}}" class="btn btn-warning btn-sm"><i class="fas fa-list-ol"></i> {{__('lang.list')}}{{__('lang.send_goods_customer')}}</a>
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
                          <th>{{__('lang.cusname_send')}}</th>
                          <th>{{__('lang.cusname_receive')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $stt = 1; @endphp
                        @if(!empty($receive))
                        @foreach($receive as $receive)
                        <tr>
                            <td>{{$stt}}</td>
                            <td>{{$receive->code}}</td>
                            <td>{{$receive->customername_send->name}}</td>
                            <td>{{$receive->customername_receive->name}}</td>
                            <td>
                                  @if($receive->status == 'P')
                                    <div class="btn btn-warning btn-xs"> {{__('lang.pending')}} </div>
                                  @elseif($receive->status == 'N')
                                    <div class="btn btn-warning btn-xs"> {{__('lang.normal')}} </div>
                                  @elseif($receive->status == 'S')
                                    <div class="btn btn-success btn-xs"> {{__('lang.sending')}} </div>
                                  @elseif($receive->status == 'ST')
                                    <div class="btn btn-danger btn-xs"> {{__('lang.warehouse')}} </div>
                                  @elseif($receive->status == 'F')
                                    <div class="btn btn-info btn-xs"> {{__('lang.send_finish')}} </div>
                                  @elseif($receive->status == 'SC')
                                    <div class="btn btn-primary btn-xs"> {{__('lang.send_goods_customer_finish')}} </div>
                                  @endif
                        </td>
                        <td>
                        @if($receive->status == 'F')
                        <button wire:click="send({{$receive->id}})" type="button" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top">
                             <i class="fa fa-gift"></i></button>
                        @endif
                        </td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                  </div>
                  
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h4 class="modal-title">{{__('lang.send_goods_customer')}}</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            @if(!empty($branch))
@foreach($mtl as $item)
<div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
<div class="row">
  <div class="col-md-12">

<div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
  <div class="row">
    <div class="col-2" style="text-align:right;">
    <img src="{{asset('images/logo.png')}}" alt="" width="80%">
    </div>
    <div class="col-10">
       <h1><b>&emsp;&emsp;{{__('lang.title_la')}} {{__('lang.title')}}</b></h1><br>
       <h1><b>&emsp;&emsp;&emsp;&emsp;{{date('d/m/Y h:i:s', strtotime($item->receivename->created_at))}}</b></h1>
    </div>
  </div>
</div> <!-- End Div Scope -->
<div class="row">
  <div class="col-12" style="text-align:center;">
    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($item->receivename->code, 'C128B',5,90)}}"  alt="barcode"/><br>
    <h2  style="font-size: 48px"><b>{{$item->receivename->code}}</b></h2>
  </div>
</div> <!-- End Row -->
<div class="row" style="border: 5px solid #000; font-weight:bolder;">
  <div class="col-8" style="padding:1%; border-left:5px solid #000;" >
    <h1>{{__('lang.customer_send')}}</h2>
    <h1>&emsp;&emsp; {{$item->receivename->customername_send->name}}</h1>
    <h1>&emsp;&emsp; {{$item->receivename->customername_send->phone}}</h1>
  </div>
  <div class="col-4" style="border-left:5px solid #000; border-right:5px solid #000; padding:1%; background-color: #000; text-align:center;">
    <h2  style="font-size: 100px; color: #fff; "><b>{{$item->receivename->branch_sends->code}}</b></h2>
  </div>             
</div> <!-- End Row -->
<div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
  <div class="row">
    <div class="col-12">
      <h1>{{__('lang.customer_receive')}}</h1>
      <h1>&emsp;&emsp; {{$item->receivename->customername_receive->name}}</h1>
      <h1>&emsp;&emsp; {{$item->receivename->customername_receive->phone}}</h1>
      <h1>&emsp;&emsp; {{__('lang.branch')}} {{$item->receivename->branch_receive_name->company_name_la}} / {{__('lang.villages')}} {{$item->receivename->branch_receive_name->villname->name}}</h1>
    </div>
  </div>
</div> <!-- End Div Scope -->
<div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
  <div class="row">
    <div class="col-6">
      <h2>&emsp;&emsp;{{__('lang.qty')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.size')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.weigh')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.amount_fak')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.inlao_fak')}}</h2>
      <h2>&emsp;&emsp;COD</h2>
      <h2>&emsp;&emsp;{{__('lang.insurance')}} 3 %</h2>
      <h2>&emsp;&emsp;{{__('lang.packing')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.sum')}}</h2>
    </div>
    <div class="col-4" style="text-align: right">
      <h2>&emsp;&emsp;1/1</h2>
      <h2>&emsp;&emsp;{{$item->large + $item->height + $item->longs}}</h2>
      <h2>&emsp;&emsp;{{$item->weigh}}</h2>
      <h2>&emsp;&emsp;{{number_format($item->amount)}}</h2>
      <h2>&emsp;&emsp;{{number_format($item->amount)}}</h2>
      <h2>&emsp;&emsp;{{number_format($item->cod_amount)}}</h2>
      <h2>&emsp;&emsp;{{number_format($item->insur_amount)}}</h2>
      <h2>&emsp;&emsp;0</h2>
      <h2>&emsp;&emsp;{{number_format($item->amount + $item->cod_amount + $item->insur_amount)}}</h2>
    </div>
    <div class="col-2">
      <h2>&emsp;&emsp;</h2>
      <h2>&emsp;&emsp;Cm</h2>
      <h2>&emsp;&emsp;Kg</h2>
      <h2>&emsp;&emsp;{{__('lang.lak')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.lak')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.lak')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.lak')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.lak')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.lak')}}</h2>
    </div>
  </div>
</div> <!-- End Div Scope -->
<div class="row">
  <div class="col-8">
    <h2>{{__('lang.branch_sent')}} : {{__('lang.branch')}} {{$item->receivename->branch_sends->company_name_la}}</h2>
    <h2>{{__('lang.tel_branch')}} : {{$item->receivename->branch_sends->phone}}</h2>
    <h2>{{__('lang.branch_receive')}} : {{__('lang.branch')}} {{$item->receivename->branch_receive_name->company_name_la}}</h2>
    <h2>{{__('lang.tel_branch')}} : {{$item->receivename->branch_receive_name->phone}}</h2>
  </div>
  <div class="col-4" style="text-align: center">
    <h2  style="font-size: 48px"><b>{{__('lang.tel_help')}}</b></h2><br>
    <h2  style="font-size: 48px"><b>XXXX</b></h2>
  </div>
</div>

@endforeach
    </div>
  </div> <!-- end row all -->
</div> <!-- End Div Scope -->
            @endif
          </div> <!-- end card body -->
          <div class="modal-footer justify-content-between">
              <button wire:click="confirm({{$hidenId}})" type="button" class="btn btn-success">{{__('lang.ok')}}</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">{{__('lang.cancel')}}</button>
          </div>
       </div>
    </div>
</div>
  
  </div>
  
  @push('scripts')
    <script>
        window.addEventListener('show-modal-detail', event => {
            $('#modal-detail').modal('show');
        })
        window.addEventListener('hide-modal-detail', event => {
            $('#modal-detail').modal('hide');
        })
    </script>
  @endpush
  
  