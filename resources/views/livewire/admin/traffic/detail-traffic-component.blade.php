<div>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
  
              <!-- Main content -->
              <div class="invoice p-2 mb-2 mt-2">

              <div class="row">
              <div class="col-md-12 text-center"><h4> ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ </h4> </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center"> <h4> ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ </h4></div>
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
                          {{ $traff->branchname->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $traff->branchname->company_name_en }}
                        @endif
                   </h4>
                   <h4>{{__('lang.phone')}}: {{$traff->branchname->phone}}</h4>
                </div>
              </div>

                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <center><b><u>{{__('lang.traffic_bill')}}</u></b></center>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <center><b> {{__('lang.daily')}} {{date('d/m/Y', strtotime($traff->created_at))}}</b></center>
                    </div>
                </div>

                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.bill_data')}}</strong><br>
                      
                      {{__('lang.bill_no')}}: {{$traff->trf_code}}<br>
                      {{__('lang.date_created')}}: {{date('d/m/Y h:i:s', strtotime($traff->created_at))}}<br>
                      {{__('lang.creator')}}: {{$traff->username->name}}<br>
                    </address>
                  </div>
                  <div class="col-sm-3"></div>
                  <div class="col-sm-3 text-right invoice-col">
                    <address>
                      <strong>{{__('lang.vihicle_traffic')}}</strong><br>
                      {{__('lang.vihicletype')}}: {{$traff->vihiclename->vihicletypename->name}}

                      <br>
                      {{__('lang.plate')}}: {{$traff->vihiclename->plate_number}}<br>
                      {{__('lang.employee_traffic')}}:<br> 
                      @php $stt = 1; @endphp
                      @foreach($staff as $item)
                      {{$stt++}}. {{$item->employeename->firstname}} {{$item->employeename->lastname}}<br>
                      @endforeach
                    </address>
                  </div>
                </div>
                <!-- /.row -->
  
                <div class="row">
                    <div class="col-md-12" align="center"> <b> </b> </div>
                </div>      

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center">
                                <th>{{__('lang.no')}}</th>
                                <th>{{__('lang.traffic_detail')}}</th>
                                <th>{{__('lang.money')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt = 1; @endphp
                            @foreach($expend as $item)
                              <tr>
                                <td style="text-align: center">  {{$stt++}} </td>
                                <td style="text-align: center">  {{$item->expend_name}} </td>
                                <td style="text-align: right">  {{number_format($item->amount)}} {{__('lang.LAK')}} </td>
                              </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: right"><h5><b>{{__('lang.subtotal')}}:</b></h5></td>
                                <td style="text-align: right"><h5><b>{{number_format($sum_expend)}} {{__('lang.LAK')}}</b></h5><hr></td>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
  
                <div class="row">
                  <div class="col-md-6" align="center"> 
                    <h5>{{__('lang.barcode')}}</h5>
                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($traff->trf_code, 'C128',1.4,22)}}" alt="barcode" />
                    <h5>{{$traff->trf_code}}</h5>
                  </div>
                  <div class="col-md-6" align="center"> <h5><b><u>{{__('lang.user_approved')}}</u></b></h5> </div>
                </div>

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    <a href="" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                    <a href="{{route('admin.traffic')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>

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