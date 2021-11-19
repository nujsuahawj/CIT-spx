<div>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
  
              <!-- Main content -->
              <div class="invoice p-2 mb-2 mt-2">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <i class="fas fa-globe"></i> {{__('lang.invoice')}}
                      <small class="float-right">{{__('lang.date')}}: {{date('d/m/Y', strtotime(Carbon\Carbon::now()))}}</small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.bill_data')}}</strong><br>
                      {{__('lang.bill_no')}}: {{$sales->code}}<br>
                      {{__('lang.date_created')}}: {{date('d/m/Y h:m:s', strtotime($sales->created_at))}}<br>
                      {{__('lang.creator')}}: {{$sales->username->name}}<br>
                    </address>
                  </div>

                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.customer')}}</strong><br>
                      {{__('lang.customer_name')}}: {{$sales->cusname->name}}<br>
                      {{__('lang.phone')}}: {{$sales->cusname->phone}}<br>
                      {{__('lang.address')}}: {{$sales->cusname->address}}<br>
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
                        <th>{{__('lang.productname')}}</th>
                        <th>{{__('lang.qty')}}</th>
                        <th>{{__('lang.price')}}</th>
                        <th>{{__('lang.discount')}}</th>
                        <th>{{__('lang.amount')}}</th>
                        <th>{{__('lang.vat')}}</th>
                        <th>{{__('lang.subtotal')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php
                           $stt = 1; 
                        @endphp
                        @foreach ($saleDetails as $item)
                          <tr>
                            <td style="text-align: center">{{$stt++}}</td>
                            <td>{{$item->productname->name}} {{$item->productname->series_number}} {{$item->productname->power_number	}} {{$item->productname->note	}}</td>
                            <td style="text-align: center">{{$item->qty}}</td>
                            <td style="text-align: right">{{number_format($item->price)}}</td>
                            <td style="text-align: right">{{number_format($item->discount)}}</td>
                            <td style="text-align: right">{{number_format($item->amount)}}</td>
                            <td style="text-align: right">{{number_format($item->vat)}}</td>
                            <td style="text-align: right">{{number_format($item->total)}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2"></td>
                          <td style="text-align: center"><b>{{$sum_qty_sale_detail}}</b></td>
                          <td style="text-align: right"><b>{{number_format($sum_price_sale_detail)}}</b></td>
                          <td style="text-align: right"><b>{{number_format($sum_discount_sale_detail)}}</b></td>
                          <td style="text-align: right"><b>{{number_format($sum_amount_sale_detail)}}</b></td>
                          <td style="text-align: right"><b></b></td>
                          <td style="text-align: right"><b>{{number_format($sum_total_sale_detail)}}</b></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
  
                <div class="row">
                  <div class="col-6">
                    <div class="row">
                      <div class="col-6">
                        <img src="{{asset('admin/dist/img/credit/visa.png')}}" height="60" alt="Visa">
                      </div>
                      <div class="col-6">
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                          <b>{{__('lang.paid_by')}}: 
                            <label class="text-primary">
                              {{$sales->payname->name}}
                            </label>
                          </b>
                          <b>{{__('lang.shipping_status')}}:
                            <label class="text-primary">
                              {{$sales->shipname->name}}
                            </label>
                        </b><br>
                        </p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                          <b>{{$exchanges->currency_one}}: </b> {{number_format($exchanges->rate_one)}}= <b>{{number_format($sales->grand_total / $exchanges->rate_one)}}</b> {{$exchanges->currency_one}}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                          <b>{{$exchanges->currency_two}}: </b> {{number_format($exchanges->rate_two)}}= <b>{{number_format($sales->grand_total / $exchanges->rate_two)}}</b> {{$exchanges->currency_two}}
                      </div>
                    </div>
                  </div>

                  <!-- /.col -->
                  <div class="col-6">
                    <div class="table-responsive">
                      <table class="table">
                        @if (($sales->discount) > 0)
                        <tr>
                          <th style="width:50%">{{__('lang.discount_more')}}:</th>
                          <td class="text-right">{{number_format($sales->discount)}}</td>
                        </tr>
                        @endif
                        @if (($sales->vat) > 0)
                        <tr>
                          <th>{{__('lang.vat')}} 10%:</th>
                          <td class="text-right">{{number_format($sales->vat)}}</td>
                        </tr>
                        @endif
                        <tr>
                          <th>{{__('lang.grand_total')}}:</th>
                          <td class="text-right"><b>{{number_format($sales->grand_total)}}</b></td>
                        </tr>
                        <tr>
                          <th>{{__('lang.paid')}}:</th>
                          <td class="text-right"><b>{{number_format($sales->paid)}}</b></td>
                        </tr>
                        @if (($sales->debit) > 0)
                        <tr>
                          <th>{{__('lang.debit')}}:</th>
                          <td class="text-right"><b>{{number_format($sales->debit)}}</b></td>
                        </tr> 
                        @endif
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>

                @if (!empty($sales->note))
                <div class="row">
                  <div class="col-12">
                    <b>{{__('lang.note')}}:</b> {{ $sales->note }} <br>
                  </div>
                </div>
                @endif

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    <a href="{{route('admin.printa4_sale', $sales->id)}}" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                    <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> {{__('lang.printsmall')}}</a>
                    <a href="{{route('admin.sale')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>

                  </div>
                </div>
              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
