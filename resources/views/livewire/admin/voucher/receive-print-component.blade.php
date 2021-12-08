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
<div style="background-color: #fff;">

<div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
  <div class="row">
    <div class="col-2" style="text-align:right;">
    <img src="{{asset('images/logo.png')}}" alt="" width="80%">
    </div>
    <div class="col-10">
       <h1><b>&emsp;&emsp;{{__('lang.title_la')}} {{__('lang.title')}}</b></h1><br>
       <h1><b>&emsp;&emsp;&emsp;&emsp;{{date('d/m/Y H:i:s', strtotime($receive->created_at))}}</b></h1>
    </div>
  </div>
</div> <!-- End Div Scope -->
<div class="row">
  <div class="col-12" style="text-align:center;">
    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($receive->code, 'C128B',5,90)}}"  alt="barcode"/><br>
    <h2  style="font-size: 48px"><b>SPX-{{$receive->code}}</b></h2>
  </div>
</div> <!-- End Row -->
<div class="row" style="border: 5px solid #000; font-weight:bolder;">
  <div class="col-8" style="padding:1%; border-left:5px solid #000;" >
    <h1>{{__('lang.customer_send')}}</h2>
    <h1>&emsp;&emsp; {{$receive->customername_send->name}}</h1>
    <h1>&emsp;&emsp; {{$receive->customername_send->phone}}</h1>
  </div>
  <div class="col-4" style="border-left:5px solid #000; border-right:5px solid #000; padding:1%; background-color: #000; text-align:center;">
    <h2  style="font-size: 72px; color: #fff; "><b>{{$receive->branch_receive_name->code}}</b></h2>
  </div>             
</div> <!-- End Row -->
<div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
  <div class="row">
    <div class="col-12">
      <h1>{{__('lang.customer_receive')}}</h1>
      <h1>&emsp;&emsp; {{$receive->customername_receive->name}}</h1>
      <h1>&emsp;&emsp; {{$receive->customername_receive->phone}}</h1>
      <h1>&emsp;&emsp; {{$receive->branch_receive_name->company_name_la}} @if(!empty($receive->customername_receive->vil_id)) / {{__('lang.villages')}} {{$receive->customername_receive->villname->name}} @endif</h1>
    </div>
  </div>
</div> <!-- End Div Scope -->
<div class="col-12 p-2 mb-2 mt-2 position top-0 start-50 translate-middle " style="border: 5px solid #000; font-weight:bolder;">
  <div class="row">
    <div class="col-6">
      <h2>&emsp;&emsp;{{__('lang.qty')}}</h2>
      @if($count_mtl == 1)
      <h2>&emsp;&emsp;{{__('lang.size')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.weigh')}}</h2>
      @endif
      <h2>&emsp;&emsp;{{__('lang.amount_fak')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.innork_fak')}}</h2>
      <h2>&emsp;&emsp;COD</h2>
      <h2>&emsp;&emsp;{{__('lang.insurance')}} 3 %</h2>
      <h2>&emsp;&emsp;{{__('lang.packing')}}</h2>
      <h2>&emsp;&emsp;{{__('lang.sum')}}</h2>
    </div>
    <div class="col-3" style="text-align: right">
      <h2>&emsp;&emsp;{{$count_mtl}}</h2>
      @if($count_mtl == 1)
      <h2>&emsp;&emsp;{{$mtl->large + $mtl->height + $mtl->longs}}</h2>
      <h2>&emsp;&emsp;{{$mtl->weigh}}</h2>
      @endif
      <h2>&emsp;&emsp;{{number_format($receive->amount)}}</h2>
      <h2>&emsp;&emsp; 0</h2>
      <h2>&emsp;&emsp;{{number_format($receive->cod_amount)}}</h2>
      <h2>&emsp;&emsp;{{number_format($receive->insur_amount)}}</h2>
      <h2>&emsp;&emsp;{{number_format($receive->pack_amount)}}</h2>
      <h2>&emsp;&emsp;{{number_format($receive->amount + $receive->pack_amount + $receive->cod_amount + $receive->insur_amount)}}</h2>
    </div>
    <div class="col-3">
      <h2>&emsp;&emsp;{{__('lang.list')}}</h2>
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
    <h2>{{__('lang.branch_sent')}} : {{$receive->branch_sends->company_name_la}}</h2>
    <h2>{{__('lang.tel_branch')}} : {{$receive->branch_sends->phone}}</h2>
    <h2>{{__('lang.branch_receive')}} : {{$receive->branch_receive_name->company_name_la}}</h2>
    <h2>{{__('lang.tel_branch')}} : {{$receive->branch_receive_name->phone}}</h2>
  </div>
  <div class="col-4" style="text-align: center">
    <h2  style="font-size: 48px"><b>{{__('lang.tel_help')}}</b></h2><br>
    <h2  style="font-size: 48px"><b>020 56717773</b></h2>
  </div>
</div>
@if($count_mtl != 1)
  <br> <br>
@endif
</div>

  @push('scripts')
      <script>

          window.addEventListener("load", window.print());
      </script>
  @endpush
  
  