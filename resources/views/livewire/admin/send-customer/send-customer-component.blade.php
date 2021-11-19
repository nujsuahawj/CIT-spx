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
          <div class="row">
                   <!-- logo  -->
                   <div class="col-6">
                <br>
                  <img src="{{asset('images/logo2.png')}}" alt="" width="100%">
                </div>
                    <!-- contact  -->
              
                <div class="col-6 text-right" >
                  <br><br>
                   <h4>{{__('lang.print_date')}}: {{date('d/m/Y h:i:s', time())}}</h4>
                   <h4 >{{__('lang.tran_date')}}: {{date('d/m/Y',strtotime($vch->valuedt))}}</h4>
                  <h4>
                        @if (Config::get('app.locale') == 'lo')
                          {{ $branch->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $branch->company_name_en }}
                        @endif
                  </h4>
                  <h4>{{__('lang.mobile')}}:{{$branch->phone}}</h4>            
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center" style="font-size: 72px"><b><u>{{__('lang.invoice')}}</u></b></div>
              </div>
            <!-- Main content -->
            <div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
              <div class="row">
                <!-- Bill Bar code -->
                <div class="col-12 text-center" >
                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($vch->code, 'C128B',5,90)}}"  alt="barcode"/> 
                </div>
              </div>
              <div class="row" style="border-bottom:5px solid #000; padding:0.5%;">
                <!-- recieve  -->
                <div class="col-12 text-center">
                </div>
              </div>
              <div class="row" style="border-bottom:5px solid #000; padding:0.5%;">
                <!-- Bill Bar code -->
                <div class="col-12 text-center" >
                   <h1  style="font-size: 72px"><b>{{$vch->code}}</b></h1>
                </div>
              </div>
              <div class="row" style="border-bottom:5px solid #000; padding:0.5%;">
                <!-- recieve  -->
                <div class="col-12 text-center">
                   <h1><b>{{__('lang.by_sender')}}:{{$vch->bs}} >>> {{__('lang.by_receiver')}}:{{$vch->bc}}</b></h3>
                   <h1 class="heading-1" style="font-weight: 1000"></h1>
                </div>
              </div>
              <div class="row" style="border-bottom:5px solid #000; padding:0.5%;">
                <!-- recieve  -->
                <div class="col-6" style="padding:1%;" >
                  <h1>{{__('lang.sender_info')}}</h1>
                  <h1>{{__('lang.name')}} : {{$vch->cs}}</h1>
                  <h1>{{__('lang.phone')}} : {{$vch->csp}}</h1>
                 
                </div>
                <div class="col-6" style="border-left:5px solid #000; padding:1%; ">
                  <h1>{{__('lang.recieve_info')}}</h1>
                  <h1>{{__('lang.name')}} : {{$vch->cr}}</h1>
                  <h1>{{__('lang.phone')}} : {{$vch->crp}}</h1>
    
                </div>             
              </div>

              <div class="row" style="border-bottom:5px solid #000; padding:0.5%;">
                <!-- recieve  -->
                <div class="col-6" style="padding:1%;" >
                  <h1><b>{{__('lang.qty')}}{{__('lang.products')}} :</b></h1><br>
                  <h1 style="text-align:right"><div style="font-size: 48px"><b>{{number_format($count_product)}}</b> {{__('lang.product')}}</div></h1>
                </div>
                <div class="col-6" style="border-left:5px solid #000; padding:1%; ">
                  <h1><b>{{__('lang.subtotal')}} :</b></h1> <br>
                  <h1 style="text-align:right"><div style="font-size: 48px"><b>{{number_format($sum_product)}}</b> {{__('lang.lak')}}</div></h1>
                </div>             
              </div>
              <div class="row " style="border-bottom:5px solid #000;">
                  <div class="col-6 text-center" style="padding:0.5%;">
                     <h1 class="heading-2" style="font-weight: 1000">** {{__('lang.insurance')}}{{__('lang.product')}} 3 % **</h1>
                  </div>
                 <div class="col-6 text-left" style="border-left:5px solid #000; padding:0.5%; ">
                          <h1 style="font-weight: 1000 " class=" text-right">{{number_format($vch->insur_amount)}} {{__('lang.lak')}}</h1>                     
                 </div>
              </div>
              @if($vch->service_type=='COD')  
              <div class="row " style="border-bottom:5px solid #000;">
                  <div class="col-6 text-center" style="padding:0.5%;">
                     <h1 class="heading-2" style="font-weight: 1000">** {{__('lang.cod_cost')}} **</h1>
                    
                  </div>

                 <div class="col-2 text-left" style="border-left:5px solid #000; padding:0.5%; ">
                                    
                       @foreach ($mtl as $pcod)
                          <h1 style="font-weight: 1000 " class="text-right"> {{number_format($vch->cod_amount) . $vch->currency_code }}</h1>                     
                       @endforeach
                     
                 </div>
              </div>
              @endif

              <div class="row " style="border-bottom:5px solid #000;">
                  <div class="col-6 text-center" style="padding:0.5%;">
                     <h1 class="heading-2 text-right" style="font-weight: 1000">{{__('lang.grandtotal')}} :</h1>
                  </div>
                 <div class="col-6 text-left" style="border-left:5px solid #000; padding:0.5%; ">
                          <h1 style="font-weight: 1000 " class="heading-2 text-right">{{number_format($sum_product+$vch->cod_amount+$vch->insur_amount)}} {{__('lang.lak')}}</h1>                     
                 </div>
              </div> <!-- end row -->
            </div>
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
  
  