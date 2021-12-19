<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <b>{{__('lang.reveive_goods_report')}}</b>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.reveive_goods_report')}}</li>
              </ol>
            </div>
          </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                                </div> <!-- end div-col -->
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button class="btn btn-info" id="print"><i class="fas fa-print"></i> {{__('lang.print')}}</button>
                                    </div>
                                </div><!-- end div-col -->
                            </div><!-- end div-row -->

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="right_content">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h4>{{__('lang.hearder-title1')}}</h4>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h4>{{__('lang.hearder-title2')}}</h4>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h4>-----------*****----------</h4>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <img src="{{asset('images/logo2.png')}}" alt="" width="70%">
                                            </div>
                                            <div class="col-6 text-right" ><br>
                                                <h4>{{__('lang.print_date')}}: {{date('d/m/Y h:i:s', time())}}</h4>
                                                <h4>
                                                        @if (Config::get('app.locale') == 'lo')
                                                        {{__('lang.branch')}}: {{ auth()->user()->branchname->company_name_la }}
                                                        @elseif (Config::get('app.locale') == 'en')
                                                        {{__('lang.branch')}}: {{ auth()->user()->branchname->company_name_en }}
                                                        @endif
                                                </h4>
                                                <h4>{{__('lang.mobile')}}: {{auth()->user()->branchname->phone}}</h4>            
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h3><b><u>{{__('lang.reveive_goods_report')}}</u></b></h3>
                                            </div>
                                        </div> <!-- end row -->
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                    <th>{{__('lang.no')}}</th>
                                                    <th>{{__('lang.bill_no')}}</th>
                                                    <th>{{__('lang.branch_sent')}}</th>
                                                    <th>{{__('lang.customer_send')}}</th>
                                                    <th>{{__('lang.branch_receive')}}</th>
                                                    <th>{{__('lang.customer_receive')}}</th>
                                                    <th>{{__('lang.amount')}}</th>
                                                    <th>{{__('lang.cod_cost')}}</th>
                                                    <th>{{__('lang.packing')}}</th>
                                                    <th>{{__('lang.insurance')}}</th>
                                                    <th>{{__('lang.status')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php $stt = 1; @endphp
                                                @foreach ($receivetransaction as $item)
                                                <tr>
                                                  <td>{{$stt++}}</td>
                                                  <td>{{$item->code}}</td>
                                                  <td>{{$item->brs}}</td>
                                                  <td>{{$item->css}}</td>
                                                  <td>{{$item->brr}}</td>
                                                  <td>{{$item->crr}}</td>
                                                  <td >{{number_format($item->amount,2,",",".")}}</td>
                                                  <td >{{number_format($item->cod_amount,2,",",".")}}</td>
                                                  <td >{{number_format($item->pack_amount,2,",",".")}}</td>
                                                  <td >{{number_format($item->insur_amount,2,",",".")}}</td>
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
                                                </tr>
                                               @endforeach 
                                                </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div>    <!-- end right content -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
 <script>

$('#print').click(function(){
   
        printDiv();
        function printDiv() {
        var printContents = $(".right_content").html();
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    location.reload();
 });
</script>
@endpush