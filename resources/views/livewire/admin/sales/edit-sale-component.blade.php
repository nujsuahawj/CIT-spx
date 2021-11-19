<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="row">
                                        
                                        <input type="hidden" wire:model="hidenId">
                                        <!--
                                        <div class="col-md-7">
                                            <input wire:model="product_id" list="productsList" class="form-control" autofocus placeholder="{{__('lang.select_product')}}">
                                            <datalist id="productsList">
                                                @foreach ($products as $item)
                                                    <option value="{{$item->id}}">{{$item->code}} - {{$item->name}} - {{number_format($item->sale_price)}}</option>
                                                @endforeach
                                            </datalist>
                                            @error('product_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                        </div>-->
                                        {{$product_id}}
                                        <div class="col-md-9" wire:ignore>
                                            <select wire:model="product_id" class="form-control" id="selectProduct">
                                                <option value="" selected>{{__('lang.select_product')}}</option>
                                                @foreach ($products as $item)
                                                    <option value="{{$item->id}}">{{$item->code}} - {{$item->name}} - {{number_format($item->sale_price)}}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <button wire:click="addTolist" type="button" class="btn btn-info">{{__('lang.add')}}</button>
                                        </div>
                                    </div>

                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!--
                                        <input wire:model="customer_id" list="customerList" class="form-control" placeholder="{{__('lang.select_customer')}}">
                                        <datalist id="customerList">
                                                @foreach ($customer as $item)
                                                    <option value="{{$item->id}}">{{$item->name}} - {{$item->phone}} - {{$item->address}}</option>
                                                @endforeach
                                        </datalist>-->
                                        
                                        <div wire:ignore>
                                            <select wire:model="customer_id" class="form-control" id="selectCustomer">
                                                @foreach ($customer as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}  {{$item->phone}}  {{$item->address}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        
                                    </div>
                                </div>
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
                                        <th>{{__('lang.productname')}}</th>
                                        <th>{{__('lang.qty')}}</th>
                                        <th>{{__('lang.price')}}</th>
                                        <!--<th>{{__('lang.discount')}}/{{__('lang.unit')}}</th>-->
                                        <th>{{__('lang.amount')}}</th>
                                        <th>{{__('lang.vat')}} (%)</th>
                                        <th width="15%">{{__('lang.subtotal')}}</th>
                                        <th width="15%">{{__('lang.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $stt = 1;    
                                    @endphp
                
                                    @foreach ($saleDetails as $item)
                                    <tr>
                                        <td style="text-align: center">{{$stt++}}</td>
                                        <td>{{$item->productname->code}} - {{$item->productname->name}}</td>
                                        <td style="text-align: center">
                                            <div>
                                                @if ($item->qty > 0)
                                                    <a href="javascript:void(0)" wire:click="decrement({{$item->id}})"><i class="fas fa-minus"></i></a>
                                                @endif
                                                    {{$item->qty}}
                                                    <a href="javascript:void(0)" wire:click="increment({{$item->id}})"><i class="fas fa-plus"></i></a>
                                            </div>
                                            
                                        </td>
                                        <td style="text-align: right">{{number_format($item->price)}}</td>
                                        <!--<td style="text-align: right">{{number_format($item->discount)}}</td>-->
                                        <td style="text-align: right">{{number_format($item->amount)}}</td>
                                        <td style="text-align: center">{{number_format($item->vat)}}</td>
                                        <td style="text-align: right">{{number_format($item->total)}}</td>
                                        <td style="text-align: center">
                                            <a href="javascript:void(0)" wire:click="editPrice({{$item->id}})"><i class="fas fa-edit mr-2"></i></a>
                                            <a href="javascript:void(0)" wire:click="showdeleteProlist({{$item->id}})"><i class="fas fa-trash text-danger"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center"><h6><b>{{number_format($sum_total_qty)}}</b></h6></td>
                                            <td style="text-align: right"><h6><b>{{number_format($sum_total_price)}}</b></h6></td>
                                            <td style="text-align: right"><h6><b>{{number_format($sum_total_amount)}}</b></h6></td>
                                            <td style="text-align: right"></td>
                                            <td style="text-align: right"><h6><b>{{number_format($sum_total_tran)}}</b></h6></td>
                                            <td>{{__('lang.lak')}}</td>
                                        </tr>

                                        <!--Total-->
                                        <tr>
                                            <td colspan="6" style="text-align: right"><h6>{{__('lang.discount')}}:</h6></td>
                                            <td width="15%" style="vertical-align: bottom">
                                                <h6><b><input wire:model="discount_all" type="text" class="form-control money"></b></h6>
                                            </td>
                                            <td width="15%">{{__('lang.amount')}}: <label wire:model="amount_all">{{number_format($sum_total_tran - $discount_all)}}</label></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right"><h6>{{__('lang.vat')}} (VAT %):</h6></td>
                                            <td width="15%" style="text-align: right">
                                                <h6><b><input wire:model="vat_all" type="number" class="form-control"></b></h6>
                                            </td>
                                            <td width="15%">{{__('lang.amount')}}: {{number_format((($sum_total_tran - $discount_all) * $vat_all)/100)}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right"><h5>{{__('lang.grand_total')}}:</h5></td>
                                            <td width="15%" style="text-align: right">
                                                <input wire:model="grand_total" type="number" class="form-control">
                                            </td>
                                            <td width="15%"><label><h5><b>{{number_format(((($sum_total_tran - $discount_all)*$vat_all)/100)+($sum_total_tran - $discount_all))}}</b></h5></label></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right"><h6>{{__('lang.paid')}}:</h6></td>
                                            <td width="15%" style="text-align: right">
                                                <h6><b><input wire:model="paid_all" type="number" class="form-control"></b></h6>
                                            </td>
                                            <td width="15%">
                                                <h6>{{__('lang.return_money')}}: 
                                                    @if ($paid_all - $grand_total <= 0)
                                                        {{'0'}}
                                                    @else
                                                        {{number_format($paid_all - (((($sum_total_tran - $discount_all)*$vat_all)/100)+($sum_total_tran - $discount_all)))}}
                                                    @endif
                                                </h6>
                                                <h6>{{__('lang.debit')}}: 
                                                    @if ($paid_all - $grand_total > 0)
                                                        {{'0'}}
                                                    @else
                                                        {{number_format((((($sum_total_tran - $discount_all)*$vat_all)/100)+($sum_total_tran - $discount_all))-$paid_all)}}
                                                    @endif
                                                    
                                                </h6>
                                            </td>
                                        </tr>

                                        <!--Exchange-->
                                        <tr>
                                            <td colspan="5" style="text-align: right"><h6>{{$exchanges->currency_one}}:</h6></td>
                                            <td style="text-align: center">{{number_format($exchanges->rate_one)}}</td>
                                            <td style="text-align: right"><h6><b>{{number_format((((($sum_total_tran - $discount_all)*$vat_all)/100)+($sum_total_tran - $discount_all)) / $exchanges->rate_one)}}</b></h6></td>
                                            <td>
                                                <div class="row">
                                                    <select wire:model="payment_id" class="form-control">
                                                        @foreach ($payments as $item)
                                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: right"><h6>{{$exchanges->currency_two}}:</h6></td>
                                            <td style="text-align: center">{{number_format($exchanges->rate_two)}}</td>
                                            <td style="text-align: right"><h6><b>{{number_format((((($sum_total_tran - $discount_all)*$vat_all)/100)+($sum_total_tran - $discount_all)) / $exchanges->rate_two)}}</b></h6></td>
                                            <td>
                                                <div class="row">
                                                    <select wire:model="shipping_id" class="form-control">
                                                        @foreach ($shippings as $item)
                                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <div class="row">
                                                    <label>{{__('lang.note')}}</label>
                                                    <textarea wire:model="note" type="text" class="form-control"></textarea>
                                                </div>
                                            </td>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button wire:click="saveSale" class="btn btn-success"><i class="fas fa-money-bill-alt"> {{__('lang.process_paid')}}</i></button>
                                    <button wire:click="editExchange({{$exchanges->id}})" class="btn btn-info"><i class="fas fa-money-bill-wave"> {{__('lang.exchange')}}</i></button>
                                    <a href="{{route('admin.sale')}}" class="btn btn-warning">{{__('lang.back')}}</a>
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

            <!--Modal Edit Price -->
            <div class="modal fade" id="modalEdit" wire:ignore>
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">{{__('lang.edit')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" wire:model="hidenId">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('lang.qty')}}{{$hidenId}}</label>
                                        <input wire:model="qty" type="number" class="form-control">
                                        @error('qty') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('lang.price')}}</label>
                                        <input wire:model="price" type="number" class="form-control">
                                        @error('price') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('lang.discount')}}/{{__('lang.unit')}}</label>
                                        <input wire:model="discount" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('lang.vat')}}</label>
                                        <input wire:model="vat" type="number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('lang.series_number')}}</label>
                                        <input wire:model="series_number" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('lang.power_number')}}</label>
                                        <input wire:model="power_number" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('lang.note')}}</label>
                                        <textarea wire:model="note" type="text" class="form-control"> </textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button wire:click="updatePrice" type="button" class="btn btn-primary">{{__('lang.save')}}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('lang.cancel')}}</button>
                        </div>
                </div>
                </div>
            </div>
            <!--Modal Delete Product From List -->
            <div class="modal fade" id="modalDelList">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">{{__('lang.delete')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                        <div class="modal-body">
                            <input type="hidden" wire:model="hidenId">
                            <div class="row">
                                <h3><p>{{__('lang.do_you_want_to_delete')}}</p></h3>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button wire:click="deleteProlist" type="button" class="btn btn-primary">{{__('lang.delete')}}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('lang.cancel')}}</button>
                        </div>
                </div>
                </div>
            </div>

            <!--Modal Edit Exchange -->
            <div class="modal fade" id="modalEditExchange" wire:ignore>
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">{{__('lang.exchange')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" wire:model="hidenId">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('lang.currency_name')}}</label>
                                    <input wire:model="currency_one" type="text" class="form-control">
                                    @error('currency_one') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('lang.rate')}}</label>
                                    <input wire:model="rate_one" type="text" class="form-control">
                                    @error('rate_one') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('lang.currency_name')}}</label>
                                    <input wire:model="currency_two" type="text" class="form-control">
                                    @error('currency_two') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('lang.rate')}}</label>
                                    <input wire:model="rate_two" type="text" class="form-control">
                                    @error('rate_two') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>                
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button wire:click="updateExchange({{$exchanges->id}})" type="button" class="btn btn-primary">{{__('lang.save')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('lang.cancel')}}</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')

<script>
    window.addEventListener('show-modal', event => {
        $('#modalEdit').modal('show');
    })
    window.addEventListener('close-modal', event => {
        $('#modalEdit').modal('hide');
    })
    //Delete Product From List
    window.addEventListener('show-modal-delete', event => {
        $('#modalDelList').modal('show');
    })
    window.addEventListener('close-modal-delete', event => {
        $('#modalDelList').modal('hide');
    })
    //Exchange
    window.addEventListener('show-modal-exchange', event => {
        $('#modalEditExchange').modal('show');
    })
    window.addEventListener('close-modal-exchange', event => {
        $('#modalEditExchange').modal('hide');
    })
</script>

<script>
    $(document).ready(function() {
        $('#selectProduct').select2();
        $('#selectProduct').on('change', function (e) {
            var data = $('#selectProduct').select2("val");
            @this.set('product_id', data);
        });

        $('#selectCustomer').select2();
        $('#selectCustomer').on('change', function (e) {
            var data = $('#selectCustomer').select2("val");
            @this.set('customer_id', data);
        });
    });
  </script>

@section('scripts')
    <script type="text/javascript">
        $('.money').simpleMoneyFormat();
    </script>
@endsection

@endpush
