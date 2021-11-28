<div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-2 mb-2 mt-2">

            <!-- Main Header -->
            <div class="row">
              
            </div>

            <div class="row">
              <div class="col-12 text-center">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <div align="center"><b><u>{{__('lang.bill_receive_product')}}</u></b></div>
                      <small class="float-right">{{__('lang.date')}}: {{date('d/m/Y', strtotime(Carbon\Carbon::now()))}}</small>
                    </h4>
              </div>
            </div>
            <!-- /.Customer Detail -->
              <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.bill_data')}}</strong><br>
                      {{__('lang.bill_no')}}: {{$logistic->logisname->code}}<br>
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
                      {{__('lang.traffic_code')}}: {{$logistic->logisname->trf_code}}<br>
                      {{__('lang.to')}}: 
                        @if (Config::get('app.locale') == 'lo')
                          {{ $logistic->sendto->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $logistic->sendto->company_name_en }}
                        @endif
                      <br>
                      {{__('lang.name')}} {{__('lang.and')}} {{__('lang.plate')}}: {{$logistic->logisname->trafficname->vihiclename->plate_number}}<br>
                    </address>
                  </div>
                </div>

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
                      <tfoot>

                      </tfoot>
                    </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <hr>
            <br>
            <div class="row" align="center">
                <div class="col-md-6">
                    <b><u>{{__('lang.customer_receive')}}</u></b>
                </div>
                <div class="col-md-6">
                    <b><u>{{__('lang.customer_shipout')}}</u></b>
                </div>
            </div>
            <div class="row">

            </div>
            <br><br><br><br><br><br><br><br>

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                    <a href="{{route('admin.print_receive', $logistic->id)}}" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                <a href="{{route('admin.list_receive_stock')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
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

