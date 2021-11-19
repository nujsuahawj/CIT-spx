<div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-2 mb-2 mt-2">

            <!-- Main Header -->
            <div class="row">
                <div class="col-md-12 text-center"><h4> ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ </h4></div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center"><h4> ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ </h4></div>
              </div>
              <div class="row">
                <div class="col-md-4 text-center">
                  <img src="{{asset('images/logosls.png')}}" width="70%">
                </div>
                <div class="col-md-8 text-right">
                <br><br>
                   <h4>{{__('lang.print_date')}}: {{date('d/m/Y', time())}}</h4>
                   <h4>{{__('lang.tran_date')}}: {{date('d/m/Y', time())}}</h4>
                   <h4>{{__('lang.branch')}}:
                        @if (Config::get('app.locale') == 'lo')
                          {{ $pay->branchname->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $pay->branchname->company_name_en }}
                        @endif
                   </h4>
                   <h4>{{__('lang.phone')}}: {{$pay->branchname->phone}}</h4>
                </div>
              </div>
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <div align="center"><h4><b><u>{{__('lang.report')}}{{__('lang.pay_dividend')}}</u></b></h4></div>
                    </h4>
                  </div>
                </div>
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <div align="center"><h4><b>{{__('lang.daily')}} {{date('d/m/Y', strtotime($pay->created_at))}}</b></h4></div>
                    </h4>
                  </div>
                </div>
                <br>
                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr style="text-align: center">
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.name')}}{{__('lang.branch')}}</th>
                          <th>{{__('lang.qty')}}{{__('lang.list')}}</th>
                          <th>{{__('lang.subtotal')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php $stt = 1; @endphp
                        <tr>
                            <td style="text-align:center"><h5>{{$stt++}}</h5></td>
                            <td style="text-align:center"><h5>
                            @if (Config::get('app.locale') == 'lo')
                                {{ $pay->branchname->company_name_la }}
                            @elseif (Config::get('app.locale') == 'en')
                                {{ $pay->branchname->company_name_en }}
                            @endif
                            </h5></td>
                            <td style="text-align:center"><h5>{{$pay->count}} {{__('lang.list')}}</h5></td>
                            <td style="text-align:right"><h5>{{number_format($pay->amount)}} {{__('lang.lak')}}</h5></td>
                        </tr>
                          
                      </tbody>
                      <tfoot>

                      </tfoot>
                    </table>
                  </div>
                </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4">
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">{{__('lang.dividend')}} {{$pay->devidend}} %:</th>
                      <td class="text-right"><b>{{number_format(($pay->amount*$pay->devidend)/100)}} {{__('lang.lak')}}</b></td>
                    </tr>
                    <tr>
                      <th>{{__('lang.vat')}} {{$pay->vat}} %:</th>
                      <td class="text-right"><b>{{number_format(((($pay->amount*$pay->devidend)/100)*$pay->vat)/100)}} {{__('lang.lak')}}</b></td>
                    </tr>
                    <tr>
                      <th>{{__('lang.grand_total')}}:</th>
                      <td class="text-right"><b>{{number_format($pay->money)}} {{__('lang.lak')}}</b></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            
            <hr>
            <br>
            <div class="row" align="center">
                <div class="col-md-6">
                    <!-- <b><u>{{__('lang.customer_receive')}}</u></b> -->
                </div>
                <div class="col-md-6">
                    <b><u>{{__('lang.reporter')}}</u></b>
                </div>
            </div>
            <div class="row">

            </div>
            <br><br><br><br><br><br><br><br>

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="{{route('admin.report_pay_devidend', $pay->id)}}" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                <a href="{{route('admin.pay_devidend')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
      
</div>

@push('scripts')
    <script>
        window.addEventListener("load", window.print());
    </script>
@endpush

