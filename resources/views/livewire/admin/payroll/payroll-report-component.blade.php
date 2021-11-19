<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <select wire:model="branch_search" class="form-control">
                                        <option value="0" selected>{{__('lang.select')}}</option>
                                          @foreach($allbranch as $item)
                                            @if (Config::get('app.locale') == 'lo')
                                              <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                                            @elseif (Config::get('app.locale') == 'en')
                                              <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                                            @endif
                                          @endforeach
                                    </select>
                                </div>
                                 <div class="col-md-2">
                                    <select wire:model="months" class="form-control">
                                        <option value="" selected>{{__('lang.select_month')}}</option>
<!--                                           @foreach($month as $item)
                                              <option value="{{ $item->month }}">{{ $item->month }}</option>
                                          @endforeach -->
                                           <option value="1">01</option>
                                           <option value="2">02</option>
                                           <option value="3">03</option>
                                           <option value="4">04</option>
                                           <option value="5">05</option>
                                           <option value="6">06</option>
                                           <option value="7">07</option>
                                           <option value="8">08</option>
                                           <option value="9">09</option>
                                           <option value="10">10</option>
                                           <option value="11">11</option>
                                           <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select wire:model="years" class="form-control">
                                        <option value="" selected>{{__('lang.select_year')}}</option>
<!--                                           @foreach($year as $item)
                                              <option value="{{ $item->year }}">{{ $item->year }}</option>
                                          @endforeach -->
                                          <option value="2021">2021</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-5">
                                    <button class="btn btn-info" id="print"><i class="fas fa-print"> {{__('lang.print')}}</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="right_content">
                                <div class="row">
                                    <div class="col-md-12" align="center">
                                        <h3>{{__('lang.report_payroll')}}</h3>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr style="text-align: center; background-color: #F4D03F;">
                                                    <th>{{__('lang.no')}}</th>
                                                    <th>{{__('lang.month')}} {{__('lang.and')}} {{__('lang.year')}}</th>
                                                    <th>{{__('lang.firstname')}} {{__('lang.and')}} {{__('lang.lastname')}}</th>
                                                    <th>{{__('lang.position')}}</th>
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
                                                        {{$item->month}} / {{$item->year}}
                                                    </td>
                                                    <td align="center">
                                                        {{$item->employeename->firstname}} {{$item->employeename->lastname}}
                                                    </td>
                                                    <td align="center">
                                                        {{$item->employeename->salaryhname->name}}
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
                                                <tr style="background-color: #AED6F1;">
                                                    <td colspan="5" style="text-align: right"><h5><b>{{__('lang.subtotal')}}:</b></h5></td>
                                                    <td style="text-align: right"><h6><b>{{number_format($sum_total_amount)}} {{__('lang.lak')}}</b></h6></td>
                                                    <td style="text-align: right"><h6><b>{{number_format($sum_total_bonus)}} {{__('lang.lak')}}</b></h6></td>
                                                    <td style="text-align: right"><h6><b>{{number_format($sum_total_amount+$sum_total_bonus)}} {{__('lang.lak')}}</b></h6></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
 });
</script>
@endpush
