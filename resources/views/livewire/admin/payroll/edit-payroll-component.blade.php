<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="hidden" wire:model="hidenId">
                                    <input wire:model="month" type="date" class="form-control @error('month') is-invalid @enderror">
                                    @error('month') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                @if(Auth()->user()->rolename->name == 'admin')
                                <div class="col-md-3">
                                    <select wire:model="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                                        <option value="" selected>{{__('lang.select')}}</option>
                                          @foreach($allbranch as $item)
                                            @if (Config::get('app.locale') == 'lo')
                                              <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                                            @elseif (Config::get('app.locale') == 'en')
                                              <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                                            @endif
                                          @endforeach
                                    </select>
                                    @error('branch_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <button wire:click="addTolist" class="btn btn-info"><i class="fas fa-money-bill-alt"> {{__('lang.payroll')}}</i></button>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>{{__('lang.no')}}</th>
                                        <th>{{__('lang.firstname')}} {{__('lang.and')}} {{__('lang.lastname')}}</th>
                                        <th>{{__('lang.branchname')}}</th>
                                        <th>{{__('lang.money')}}</th>
                                        <th>{{__('lang.bonus')}}</th>
                                        <th width="15%">{{__('lang.subtotal')}}</th>
                                        <th width="15%">{{__('lang.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $stt = 1;    
                                    @endphp
                                     @foreach ($payrolldetails as $item)
                                        <tr>
                                            <td>{{$stt++}}</td>
                                            <td>
                                                {{$item->employeename->firstname}} {{$item->employeename->lastname}}
                                            </td>
                                            <td align="center">
                                                @if ( Config::get('app.locale') == 'lo')
                                                    {{$item->branchname->company_name_la}}
                                                @elseif ( Config::get('app.locale') == 'en' )
                                                    {{$item->branchname->company_name_en}}
                                                @endif
                                            </td>
                                            <td style="text-align: right">{{number_format($item->amount)}}</td>
                                            <td style="text-align: right">{{number_format($item->bonus)}}</td>
                                            <td style="text-align: right">{{number_format($item->amount + $item->bonus)}}</td>
                                            <td align="center">
                                                <a href="javascript:void(0)" wire:click="showBonus({{$item->id}})"><i class="fa fa-cube text-danger"></i></a>
                                            </td>
                                        </tr>
                                     @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" style="text-align: right"><h5><b>{{__('lang.grand_total')}}:</b></h5></td>
                                            <td style="text-align: right"><h6><b>{{number_format($sum_total_amounts)}}</b></h6></td>
                                            <td style="text-align: right"><h6><b>{{number_format($sum_total_bonuse)}}</b></h6></td>
                                            <td style="text-align: right"><h6><b>{{number_format($sum_total_amounts+$sum_total_bonuse)}}</b></h6></td>
                                            <td style="text-align: center"><h6><b>{{__('lang.lak')}}</b></h6></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button wire:click="savePayroll" class="btn btn-success"><i class="fas fa-money-bill-alt"> {{__('lang.process_paid')}}</i></button>
                                    <a href="{{route('admin.payroll')}}" class="btn btn-warning">{{__('lang.back')}}</a>
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- /.modal-edit Employee-->
  <div wire:ignore.self class="modal fade" id="modal-bonus">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.edit')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <form>
            <input type="hidden" wire:model="hiddenIdd">

            <div class="form-group">
                <label>{{__('lang.qty')}}{{__('lang.bonus')}}</label>
                <input wire:model="bonus" type="text" class="form-control money">
            </div>
            <div class="form-group">
                <label>{{__('lang.note')}}</label>
                <input wire:model="note" type="text" class="form-control">
            </div>
        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="saveBonus" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

@push('scripts')
  <script>
    $('.money').simpleMoneyFormat();
    //Bonus
    window.addEventListener('show-modal-bonus', event => {
      $('#modal-bonus').modal('show');
    })
    window.addEventListener('hide-modal-bonus', event => {
      $('#modal-bonus').modal('hide');
    })

  </script>

@endpush
