<div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-2 mb-2 mt-2">

            <!-- Main Header -->
            <div class="row">
              <div class="col-md-12 text-center"><h4> ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ </h4> </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center"> <h4> ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ </h4></div>
            </div>
            <div class="row">
              <div class="col-md-4 text-center">
                <img src="{{asset('images/logo.png')}}" width="70%">
              </div>
              <div class="col-md-8 text-right">
              <br><br>
                   <h4>{{__('lang.print_date')}}: {{date('d/m/Y', time())}}</h4>
                   <h4>{{__('lang.tran_date')}}: {{date('d/m/Y', time())}}</h4>
                   <h4>{{__('lang.branch')}}:
                        @if (Config::get('app.locale') == 'lo')
                          {{ $rc_tran->branch_create->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $rc_tran->branch_create->company_name_en }}
                        @endif
                   </h4>
                   <h4>{{__('lang.phone')}}: {{$rc_tran->branch_create->phone}}</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-12 text-center">
                    <h4>
                      <input type="hidden" wire:model="hidenId">
                      <div align="center"><b><u>{{__('lang.detail_receive_transaction')}}</u></b></div>
                      
                    </h4>
              </div>
            </div>
            <!-- /.Customer Detail -->
              <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.bill_data')}}</strong><br>
                      {{__('lang.bill_no')}}: {{$rc_tran->code}}<br>
                      {{__('lang.date_created')}}: {{date('d/m/Y', strtotime($rc_tran->valuedt))}}<br>
                      {{__('lang.creator')}}: {{$rc_tran->username->name}}<br>
                      {{__('lang.to_branch')}}: 
                        @if (Config::get('app.locale') == 'lo')
                          {{ $rc_tran->branch_receive_name->company_name_la }}
                        @elseif (Config::get('app.locale') == 'en')
                          {{ $rc_tran->branch_receive_name->company_name_en }}
                        @endif<br>
                    </address>
                  </div>
                  <div class="col-sm-3"></div>
                  <div class="col-sm-3 text-right invoice-col" >
                    <address>
                      <strong>{{__('lang.sender_info')}} {{__('lang.and')}} {{__('lang.recieve_info')}}</strong><br>
                      {{__('lang.sender_info')}}: {{$rc_tran->customername_send->name}}<br>
                      {{__('lang.phone')}}: {{$rc_tran->customername_send->phone}}<br>
                      {{__('lang.recieve_info')}}: {{$rc_tran->customername_receive->name}}<br>
                      {{__('lang.phone')}}: {{$rc_tran->customername_receive->phone}}
                      
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
                          <th>{{__('lang.receive_code')}}</th>
                          <th>{{__('lang.goods_type')}}</th>
                          <th>{{__('lang.weigh')}}</th>
                          <th>{{__('lang.paid_type')}}</th>
                          <th>{{__('lang.amount')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php
                           $stt = 1; 
                        @endphp
                        @foreach ($mat as $item)
                        <tr align="center">
                            <td>{{$stt++}}</td>
                            <td>{{$item->receive_id}}</td>
                            <td>{{$item->goodname->name}}</td>
                            <td>{{$item->weigh}}</td>
                            <td>@if($item->paid_by=='SD') {{__('lang.by_sender')}}@else {{__('lang.by_receiver')}}@endif</td>
                            <td align="right">{{number_format($item->amount)}}</td>
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
            <div class="row">
                <div class="col-md-9" align="right">
                    <h4><b>{{__('lang.total_amount')}} :</b></h4>
                </div>
                <div class="col-md-3" align="right">
                    <h4><b>{{number_format($rc_tran->amount)}} {{__('lang.LAK')}}</b></h4>
                    <hr>
                </div>
            </div>
            
            <br><br><br><br><br><br><br><br>

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="{{route('transaction.detail_receive_transaction', $rc_tran->id)}}" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                <a href="{{route('transaction.receive')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
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

