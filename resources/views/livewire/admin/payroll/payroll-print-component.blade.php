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
                      <center>{{__('lang.payroll_report')}}</center>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <center><b> {{__('lang.for_month')}} {{$payrolls->month}}/{{$payrolls->year}} </b></center>
                    </div>
                </div>

                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <address>
                      <strong>{{__('lang.bill_data')}}</strong><br>
                      {{__('lang.bill_no')}}: {{$payrolls->code}}<br>
                      {{__('lang.date_created')}}: {{date('d/m/Y h:i:s', strtotime($payrolls->created_at))}}<br>
                      {{__('lang.creator')}}: {{$payrolls->username->name}}<br>
                    </address>
                  </div>

                  <div class="col-sm-6 invoice-col" align="right">
                    <address>
                      <strong>{{__('lang.approved_data')}}</strong><br>
                      {{__('lang.branch_approved')}}:
                            @if ( Config::get('app.locale') == 'lo')
                                {{$payrolls->branchname->company_name_la}}
                            @elseif ( Config::get('app.locale') == 'en' )
                                {{$payrolls->branchname->company_name_en}}
                            @endif
                      <br>
                      {{__('lang.date_approved')}}: {{date('d/m/Y  h:i:s', strtotime($payrolls->approve_date))}}<br>
                      {{__('lang.user_approved')}}: {{$payrolls->approvedname->name}}<br>
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
                                <th>{{__('lang.firstname')}} {{__('lang.and')}} {{__('lang.lastname')}}</th>
                                <th>{{__('lang.branch')}}</th>
                                <th>{{__('lang.money')}}</th>
                                <th>{{__('lang.bonus')}}</th>
                                <th width="15%">{{__('lang.subtotal')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                $stt = 1;    
                                @endphp
                                @foreach ($payrolldetails as $item)
                            <tr>
                                <td align="center">{{$stt++}}</td>
                                <td align="center">
                                    {{$item->employeename->firstname}} {{$item->employeename->lastname}}
                                </td>
                                <td style="text-align: center;">
                                    @if ( Config::get('app.locale') == 'lo')
                                        {{$item->branchname->company_name_la}}
                                    @elseif ( Config::get('app.locale') == 'en' )
                                        {{$item->branchname->company_name_en}}
                                    @endif
                                </td>
                                <td style="text-align: right">{{number_format($item->amount)}}</td>
                                <td style="text-align: right">{{number_format($item->bonus)}}</td>
                                <td style="text-align: right">{{number_format($item->amount+$item->bonus)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right"><h5><b>{{__('lang.subtotal')}}:</b></h5></td>
                                <td style="text-align: right"><h6><b>{{number_format($sum_total_amount)}} {{__('lang.lak')}}</b></h6></td>
                                <td style="text-align: right"><h6><b>{{number_format($sum_total_bonus)}} {{__('lang.lak')}}</b></h6></td>
                                <td style="text-align: right"><h6><b>{{number_format($sum_total_amount+$sum_total_bonus)}} {{__('lang.lak')}}</b></h6></td>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
  

                @if (!empty($payrolls->note))
                <div class="row">
                  <div class="col-12">
                    <b>{{__('lang.note')}}:</b> {{ $payrolls->note }} <br>
                  </div>
                </div>
                @endif

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    <a href="{{route('admin.printa4_payroll', $payrolls->id)}}" rel="noopener" target="_blank" class="btn btn-info"><i class="fas fa-print"></i> {{__('lang.printa4')}}</a>
                    <a href="{{route('admin.payroll')}}" class="btn btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>

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