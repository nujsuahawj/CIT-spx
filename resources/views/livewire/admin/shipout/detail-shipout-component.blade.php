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
                          {{ $logistic->branchname->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $logistic->branchname->company_name_en }}
                        @endif
                   </h4>
                   <h4>{{__('lang.phone')}}: {{$logistic->branchname->phone}}</h4>
                </div>
              </div>
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <div align="center"><h4><b><u>{{__('lang.bill_receive_product')}}</u></b></h4></div>
                      
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.bill_data')}}</strong><br>
                      {{__('lang.bill_no')}}: {{$logistic->code}}<br>
                      {{__('lang.date_created')}}: {{date('d/m/Y h:i:s', strtotime($logistic->create_date))}}
                        <br>
                    </address>
                  </div>
                  <div class="col-sm-2"></div>
                  <div class="col-sm-4 invoice-col" >
                    <address>
                      <strong>{{__('lang.traffic_data')}}</strong><br>
                      {{__('lang.traffic_code')}}: {{$logistic->trafficname->trf_code}}<br>
                      {{__('lang.name')}} {{__('lang.and')}} {{__('lang.plate')}}: {{$logistic->trafficname->vihiclename->name}} {{$logistic->trafficname->vihiclename->plate_number}}<br>
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
                        @php $stt = 1; @endphp
                        @foreach ($branch as $item)
                        <tr>
                          <td colspan="5">
                            @if (Config::get('app.locale') == 'lo')
                              <b>{{ $item->sendto->company_name_la }}</b> 
                            @elseif (Config::get('app.locale') == 'en')
                              <b>{{ $item->sendto->company_name_en }}</b>
                            @endif
                          </td>
                          <td colspan="5" align="right">
                                  @if($item->status == 'P')
                                   <b> {{__('lang.status')}}: {{__('lang.pending')}} </b>
                                  @elseif($item->status == 'N')
                                   <b> {{__('lang.status')}}: {{__('lang.normal')}} </b>
                                  @elseif($item->status == 'S')
                                   <b> {{__('lang.status')}}: {{__('lang.sending')}} </b>
                                  @elseif($item->status == 'ST')
                                   <b> {{__('lang.status')}}: {{__('lang.warehouse')}} </b>
                                  @elseif($item->status == 'F')
                                   <b> {{__('lang.status')}}: {{__('lang.send_finish')}} </b>
                                  @endif
                          </td>
                        </tr>
                          @foreach ($matterail as $child)
                            @if ($item->sendto_unit == $child->sendto_unit)

                              <tr align="center">
                                  <td>{{$stt++}}</td>
                                  <td>{{$child->receive_id}}</td>
                                  <td>{{$child->goodname->name}}</td>
                                  <td>{{$child->productname->name}}</td>
                                  <td>{{$child->large}}</td>
                                  <td>{{$child->height}}</td>
                                  <td>{{$child->longs}}</td>
                                  <td>{{$child->weigh}}</td>
                                  <td>@if($child->paid_type=='SD') {{__('lang.by_sender')}}@else {{__('lang.by_receiver')}}@endif</td>
                                  <td>{{number_format($child->amount)}}</td>
                              </tr>

                            @endif
                          @endforeach
                        @endforeach
                      </tbody>
                      <tfoot>

                      </tfoot>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <hr>
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    <a href="{{route('admin.printa4_shipout', $logistic->id)}}" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                    <a href="{{route('admin.shipout')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>

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
