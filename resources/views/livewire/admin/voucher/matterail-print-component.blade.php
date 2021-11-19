<style>
  .heading-1{
    font-size: 380%!important;
  }
  .heading-2{
    font-size: 330%!important;
  }

  @media print {
    footer { display:none; }
    #printarea { display:block; }
}
  </style>
@foreach ($mtl as $item)
<div id="printarea">

    <section class="content"  >
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

          <div class="row">
                <div class="col-6">
                <br><br>
                  <img src="{{asset('images/logo2.png')}}" alt="" width="100%">
                </div>
                <div class="col-6 text-right">
                <br><br>
                  <h4 style="font-weight: 1000">{{__('lang.print_date')}}: {{date('d/m/Y h:i:s', time())}}</h4>
                   <h4 style="font-weight: 1000">{{__('lang.tran_date')}}: {{date('d/m/Y h:i:s', time())}}</h4>
                  <h4 style="font-weight: 1000">
                        @if (Config::get('app.locale') == 'lo')
                          {{ $branch->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $branch->company_name_en }}
                        @endif
                  </h4>
                  <h4 style="font-weight: 1000">{{__('lang.mobile')}}:{{$branch->phone}}</h4>  
                </div>
                <div class="col-1 text-center">
                  
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center" style="font-size: 72px"><b><u>{{__('lang.billmatterail')}}</u></b></div>
              </div>
            <!-- Main content -->
            <div class="invoice p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 1px solid #000;"> 
               <!-- contact  -->
              <div class="row">      
                  <div class="col-12 text-center">
                      <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($item->receive_id, 'C128B',5,90)}}"  alt="barcode"/> 
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
                   <h1  style="font-size: 72px"><b>{{$item->receive_id}}</b></h1>
                </div>
              </div>
          
              <div class="row" style="border-bottom:1px solid #000;">
                <!-- Bill Bar code -->
                <div class="col-6 text-center" style="padding:0.5%;">
                  <h1 style="font-weight: 1000" class="heading-1">{{__('lang.cus_send')}}</h1>
                   <h1 style="font-weight: 1000" class="heading-1">{{$vch->cs}}</h1>
                   <h1 style="font-weight: 1000" class="heading-1">{{__('lang.tel')}}: {{$vch->ps}}</h1>
                </div>
                 <!-- date print -->
                <div class="col-6 text-center" style="border-left:1px solid #000; padding:0.5%;" >
                  <h1 style="font-weight: 1000" class="heading-1">{{__('lang.cus_receive')}}</h1>
                  <h1 style="font-weight: 1000" class="heading-1">{{$vch->cr}}</h1>
                  <h1 style="font-weight: 1000" class="heading-1">{{__('lang.tel')}}:{{$vch->pr}}</h1>          
                </div>
              </div>

              <div class="row" style="padding:0.5%; border-bottom:1px solid #000;">
                <!-- send  -->
                <div class="col-12 text-center">
                   <h1 style="font-weight: 1000" class="heading-2">{{__('lang.by_sender')}}:{{$vch->bs}} <br> >>> <br> {{__('lang.by_receiver')}}:{{$vch->bc}} </h1>
                </div>
              </div>

              <div class="row" style="border-bottom:1px solid #000; ">
                <div class="col-12 table-responsive">
                  <table class="table table-striped" >
                    <thead>
                    <tr>
                    
                      <th><h1 style="font-weight: 1000">{{__('lang.product')}}</h1></th>
                      <th><h1 style="font-weight: 1000">cm</h1></th>
                      <th><h1 style="font-weight: 1000">kg</h1></th>
                      <th><h1 style="font-weight: 1000">{{__('lang.paid_type')}}</h1></th>
                      <th><h1 style="font-weight: 1000">{{__('lang.amount')}}</h1></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td><h1 style="font-weight: 1000">{{$item->pd}}</h1></td>
                      <td><h1 style="font-weight: 1000">{{$item->large + $item->height + $item->longs}}</h1></td>
                      <td><h1 style="font-weight: 1000">{{$item->weigh}}</h1></td>
                      <td><h1 style="font-weight: 1000">@if($item->paid_type=='SD') {{__('lang.paid')}} @else {{__('lang.notpay')}} @endif</h1></td>
                      <td class="text-right"><h1 style="font-weight: 1000">{{number_format($item->amount,2,",",".")}}</h1></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row " style="border-bottom:1px solid #000;">
                 <div class="col-4 text-right" style=" padding:1%; " >

                 </div>
                 <div class="col-4 text-right" style=" padding:1%; ">
                  <h1 class="heading-2" style="font-weight: 1000">{{__('lang.kib')}}/LAK:</h1>
                  <!-- <h1 class="heading-2" style="font-weight: 1000">{{__('lang.bath')}}/THB:</h1>
                  <h1 class="heading-2" style="font-weight: 1000">{{__('lang.usd')}}/USD:</h1> -->
                 </div>
                 <div class="col-4 text-right" style=" padding:1%; " >
                  <h1 class="heading-2" style="font-weight: 1000" class="h">@if($item->currency_code=='LAK') {{number_format($item->amount,2,",",".")}} 
                    @elseif($item->currency_code=='THB'){{number_format($item->amount * $ex->rate_one,2,",",".") }} 
                    @else{{number_format($item->amount * $ex->rate_two,2,",",".") }}@endif</h1>

                <!-- <h1 class="heading-2" style="font-weight: 1000">@if($item->currency_code=='LAK') {{number_format($item->amount / $ex->rate_one,2,",",".")}} 
                    @elseif($item->currency_code=='THB'){{number_format($item->amount,2,",",".") }} 
                    @else{{number_format($item->amount * ( ($ex->rate_two + $ex->rate_one)/2 ),2,",",".") }}@endif</h1>

                <h1 class="heading-2" style="font-weight: 1000">@if($item->currency_code=='LAK') {{number_format($item->amount / $ex->rate_two,2,",",".")}} 
                    @elseif($item->currency_code=='THB'){{number_format($item->amount * ( ($ex->rate_two + $ex->rate_one)/2 ),2,",",".") }} 
                    @else{{number_format($item->amount,2,",",".") }} @endif</h1> -->
                </div>
              </div>

              <div class="row">
                <div class="col-4 text-center" style=" padding:1%; " >
                 
                  <h1 class="heading-2" style="font-weight: 1000">{{__('lang.price')}} COD</h1>
           
                </div>
                <div class="col-4 text-right" style=" padding:1%; ">
                  <h1 class="heading-2" style="font-weight: 1000">{{__('lang.kib')}}/LAK:</h1>
                  <!-- <h1 class="heading-2" style="font-weight: 1000">{{__('lang.bath')}}/THB:</h1>
                  <h1 class="heading-2" style="font-weight: 1000">{{__('lang.usd')}}/USD:</h1> -->
                </div>
                <div class="col-4 text-right" style=" padding:1%; " >
                  <h1 class="heading-2" style="font-weight: 1000">@if($item->currency_code=='LAK') {{number_format($item->cod_amount,2,",",".")}} 
                    @elseif($item->currency_code=='THB'){{number_format($item->cod_amount * $ex->rate_one,2,",",".") }} 
                    @else{{number_format($item->cod_amount * $ex->rate_two,2,",",".") }}@endif</h2>

                <!-- <h1 class="heading-2" style="font-weight: 1000">@if($item->currency_code=='LAK') {{number_format($item->cod_amount / $ex->rate_one,2,",",".")}} 
                    @elseif($item->currency_code=='THB'){{number_format($item->cod_amount,2,",",".") }} 
                    @else{{number_format($item->cod_amount * ( ($ex->rate_two + $ex->rate_one)/2 ),2,",",".") }}@endif</h2>

                <h1 class="heading-2" style="font-weight: 1000">@if($item->currency_code=='LAK') {{number_format($item->cod_amount / $ex->rate_two,2,",",".")}} 
                    @elseif($item->currency_code=='THB'){{number_format($item->cod_amount * ( ($ex->rate_two + $ex->rate_one)/2 ),2,",",".") }} 
                    @else{{number_format($item->cod_amount,2,",",".") }} @endif</h2> -->
               </div>
             </div>        
           </div>

  
              <!-- this row will not appear when printing -->
            </div>
            <!-- /.invoice -->
          

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
</div>
  <br>
  <br>
  @endforeach
  
  @push('scripts')
      <script>
          window.addEventListener("load", window.print());
      </script>
  @endpush
  
  