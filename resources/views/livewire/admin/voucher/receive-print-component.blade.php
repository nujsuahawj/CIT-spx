<style>
  .heading-1{
    font-size: 350%!important;
  }
  .heading-2{
    font-size: 280%!important;
  }

  @media print {
    footer { display:none; }
    #printarea { display:block; }
}
  </style>
<div  >
              <div class="row" style="padding: 0%">
                   <!-- logo  -->
                <div class="col-6">
                <br>
                  <img src="{{asset('images/logo2.png')}}" alt="" width="100%">
                </div>
                    <!-- contact  -->
              
                <div class="col-6 text-right" >
                  <br><br>
                   <h4 style="font-weight: 1000">{{__('lang.print_date')}}: {{date('d/m/Y h:i:s', time())}}</h4>
                   <h4 style="font-weight: 1000">{{__('lang.tran_date')}}: {{date('d/m/Y',strtotime($vch->valuedt))}}</h4>
                  <h4 style="font-weight: 1000">
                        @if (Config::get('app.locale') == 'lo')
                          {{ $branch->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $branch->company_name_en }}
                        @endif
                  </h4>
                  <h4 style="font-weight: 1000">{{__('lang.mobile')}}:{{$branch->phone}}</h4>            
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

                 <div class="col-6 text-left" style="border-left:5px solid #000; padding:0.5%; text-align:right; ">
                                    
                
                          <h1 style="font-weight: 1000 " class="heading-2 text-right"> {{number_format($vch->cod_amount) . $vch->currency_code }}</h1>                     
   
                     
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
              </div>
           </div>
  
           <div class="row ">
                <div class="col-6 text-center" style="padding:0.5%;" >
                  <!-- <h1 class="heading-1" style="font-weight: 1000">{{__('lang.sigstaff')}}</h1> -->
                  <h1><br></h1>
                  <h1><br></h1>
                  <h1><br></h1>
                  <h1><br></h1>
                 
                </div>          
              </div>    

            </div>
            <!-- /.invoice -->


  </div>
  
  @push('scripts')
      <script>

          window.addEventListener("load", window.print());
      </script>
  @endpush
  
  