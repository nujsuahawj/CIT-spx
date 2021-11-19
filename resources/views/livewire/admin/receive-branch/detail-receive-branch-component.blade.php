<div>
  <div class="row">
    <div class="col-md-12">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
  
              <!-- Main content -->
              <div class="invoice p-2 mb-2 mt-2">
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
                          {{ $logistic->sendto->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $logistic->sendto->company_name_en }}
                        @endif
                   </h4>
                   <h4>{{__('lang.phone')}}: {{$logistic->sendto->phone}}</h4>
                </div>
              </div>
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <div align="center">{{__('lang.bill_receive_product')}}</div>
                      
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.bill_data')}}</strong><br>
                      {{__('lang.bill_no')}}: {{$logistic->rvcode}}<br>
                      {{__('lang.date_created')}}: {{date('d/m/Y h:i:s', strtotime($logistic->logisname->create_date))}}<br>
                      {{__('lang.creator')}}:
                      @if (Config::get('app.locale') == 'lo')
                          {{ $logistic->sender->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $logistic->sender->company_name_en }}
                        @endif<br>
                    </address>
                  </div>
                  <div class="col-sm-3"></div>
                  <div class="col-sm-3 invoice-col" >
                    <address>
                      <strong>{{__('lang.traffic_data')}}</strong><br>
                      {{__('lang.traffic_code')}}: {{$logistic->trafficname->trf_code}}<br>
                      {{__('lang.to')}}: 
                        @if (Config::get('app.locale') == 'lo')
                          {{ $logistic->sendto->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $logistic->sendto->company_name_en }}
                        @endif
                      <br>
                      {{__('lang.plate')}}: {{$logistic->logisname->trafficname->vihiclename->plate_number}}<br>
                    </address>
                  </div>
                </div>
                <!-- /.row -->
  
                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr style="text-align: center">
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.code')}}</th>
                          <th>{{__('lang.goods_type')}}</th>
                          <th>{{__('lang.product_type')}}</th>
                          <th>{{__('lang.large')}}</th>
                          <th>{{__('lang.height')}}</th>
                          <th>{{__('lang.longs')}}</th>
                          <th>{{__('lang.weigh')}}</th>
                          <th>{{__('lang.paid_type')}}</th>
                          <th>{{__('lang.amount')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php
                           $stt = 1; 
                        @endphp
                        @foreach ($matterail as $item)
                        <tr align="center">
                            <td>{{$stt++}}</td>
                            <td>{{$item->code}}</td>
                            <td>{{$item->gname}}</td>
                            <td>{{$item->pname}}</td>
                            <td>{{$item->large}}</td>
                            <td>{{$item->height}}</td>
                            <td>{{$item->longs}}</td>
                            <td>{{$item->weigh}}</td>
                            <td>@if($item->paid_type=='SD') {{__('lang.by_sender')}}@else {{__('lang.by_receiver')}}@endif</td>
                            <td>{{number_format($item->amount)}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <hr>
                <!-- /.row -->
                <div class="row" align="center">
                    <div class="col-md-6">
                        <b><u>{{__('lang.customer_receive')}}</u></b>
                    </div>
                    <div class="col-md-6">
                        <b><u>{{__('lang.customer_shipout')}}</u></b>
                    </div>
                  <!-- /.col -->
                </div>
                </div>

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    <a href="{{route('admin.print_receive_branch', $logistic->id)}}" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                    <a href="{{route('admin.list_receive_branch')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>

                  </div>
                </div>
              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    </div>
  </div>
    
</div>
