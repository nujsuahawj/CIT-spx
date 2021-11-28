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
@foreach($mtl as $item)
<div>

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

  <div class="row" style="border: 5px solid #000; font-weight:bolder;">
    <div class="col-9" style="padding:1%; border-left:5px solid #000;" >
      <h1>{{__('lang.customer_receive')}}</h1>
      <h1>&emsp;&emsp; {{$item->receivename->customername_receive->name}}</h1>
      <h1>&emsp;&emsp; {{$item->receivename->customername_receive->phone}}</h1>
      <h1>&emsp;&emsp; {{__('lang.branch')}} {{$item->receivename->branch_receive_name->company_name_la}} / {{__('lang.villages')}} {{$item->receivename->branch_receive_name->villname->name}}</h1>
    </div>
    <div class="col-3" style="border-left: 5px solid #000; border-right:5px solid #000; text-align: center">
      <h1>{{__('lang.signal_receive')}}</h1>
    </div>
  </div><!-- End Row -->

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
<div class="row" style="border: 5px solid #000; font-weight:bolder;">
    <div class="col-9" style="padding:1%; border-left:5px solid #000;" >
      <h1>Comment</h1>
      <br>
      <br>
      <br>
    </div>
    <div class="col-3" style="border-left: 5px solid #000; border-right:5px solid #000; text-align: center">
      <h1>{{__('lang.signal_ex')}}</h1>
      <br>
      <br>
    </div>
  </div><!-- End Row -->

</div>
@endforeach
  
  @push('scripts')
      <script>
          window.addEventListener("load", window.print());
      </script>
  @endpush
  
  