<div>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header"> 
                  <div class="row">
                    <div class="col-md-4" wire:ignore>
                        <div class="form-group">
                            <select wire:model="product_id" id="selectProduct" class="form-control" @error('product_id') is-invalid @enderror">
                              <option value="" selected>{{__('lang.select')}}</option>
                                @foreach($products as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} {{ number_format($item->buy_price) }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button wire:click="addProduct" type="button" class="btn btn-primary">{{__('lang.select')}}</button>
                    </div>
                    <div class="col-md-4" wire:ignore>
                        <div class="form-group">
                            <select wire:model="member_id" id="selectMember" class="form-control" @error('member_id') is-invalid @enderror">
                              <option value="0" selected>{{__('lang.select')}}</option>
                                @foreach($members as $item)
                                    <option value="{{ $item->id }}">{{ $item->firstname }} {{ $item->lastname }} {{ $item->phone }}</option>
                                @endforeach
                            </select>
                            @error('member_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="button">{{__('lang.select')}}</button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                      <tr style="text-align: center">
                        <th>{{__('lang.no')}}</th>
                        <th>{{__('lang.product_name')}}</th>
                        <th>{{__('lang.qty')}}</th>
                        <th>{{__('lang.price')}}</th>
                        <th>{{__('lang.discount')}}</th>
                        <th>{{__('lang.sub_amount')}}</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                        $stt = 1;    
                      @endphp
    
                      @foreach ($transection as $item)
                        <tr>
                            <td style="text-align: center">{{$stt++}}</td>
                            <td>{{$item->productname->name}}</td>
                            <td style="text-align: center">
                              <div>
                                @if ($item->qty > 0)
                                    <a href="javascript:void(0)" wire:click="decrement({{$item->id}})"><i class="fas fa-minus"></i></a>
                                @endif
                                    {{$item->qty}}
                                    <a href="javascript:void(0)" wire:click="increment({{$item->id}})"><i class="fas fa-plus"></i></a>
                            </div> 
                            </td>
                            <td style="text-align: right">{{number_format($item->buying_price)}}</td>
                            <td style="text-align: right">{{number_format($item->discount)}}</td>
                            <td style="text-align: right; color: blue"">{{number_format($item->amount)}}</td>
                            <td style="text-align: center">
                                <a href="javascript:void(0)" wire:click="showeditPrice({{$item->id}})"><i class="fas fa-edit mr-2"></i></a>
                                <a href="javascript:void(0)" wire:click="showdeleteProduct({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
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
                          <td style="text-align: right"><h6><b>{{number_format($sum_total_discount)}}</b></h6></td>
                          <td style="text-align: right"><h6><b>{{number_format($sum_amount)}}</b></h6></td>
                          <td></td>
                        </tr>
                        <!--Discount all-->
                        <tr>
                          <td colspan="5" style="text-align: right"><h6>{{__('lang.discount')}}:</h6></td>
                          <td width="15%" style="vertical-align: bottom">
                              <h6><b><input wire:model="discount_all" type="number" class="form-control"></b></h6>
                          </td>
                          <td width="15%">{{__('lang.amount')}}: <label wire:model="amount_all">{{number_format($sum_amount - $discount_all)}}</label></td>
                        </tr>
                        <!--Vat all-->
                        <tr>
                          <td colspan="5" style="text-align: right"><h6>{{__('lang.vat')}} (VAT %):</h6></td>
                          <td width="15%" style="text-align: right">
                              <h6><b><input wire:model="vat_all" type="number" class="form-control"></b></h6>
                          </td>
                          <td width="15%">{{__('lang.amount')}}: {{number_format((($sum_amount - $discount_all) * $vat_all)/100)}}</td>
                        </tr>
                        <!--Grand total-->
                        <tr>
                          <td colspan="5" style="text-align: right"><h4>{{__('lang.grand_total')}}:</h4></td>
                          <td width="15%" style="text-align: right">
                              <label wire:model="grand_total"><h4><b>{{number_format(((($sum_amount - $discount_all)*$vat_all)/100)+($sum_amount - $discount_all))}}</b></h4></label>
                          </td>
                          <td width="15%">
                            {{$exchanges->currency_one}}: {{number_format((((($sum_amount - $discount_all)*$vat_all)/100)+($sum_amount - $discount_all)) / $exchanges->rate_one, 2)}} <br>
                            {{$exchanges->currency_two}}: {{number_format((((($sum_amount - $discount_all)*$vat_all)/100)+($sum_amount - $discount_all)) / $exchanges->rate_two, 2)}}
                          </td>
                        </tr>
                        <!--Status and Paid-->
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                <div class="form-group">
                                    <select wire:model="payment_id" class="form-control" @error('payment_id') is-invalid @enderror">
                                        @foreach($payment_status as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </td>
                            <td  style="text-align: right"><h6>{{__('lang.paid')}}:</h6></td>
                            <td width="15%" style="text-align: right">
                                <h6><b><input wire:model="paid_all" type="number" class="form-control"></b></h6>
                            </td>
                            <td width="15%">
                                <h6>
                                    @if ($paid_all > (((($sum_amount - $discount_all)*$vat_all)/100)+($sum_amount - $discount_all)))
                                    <label class="text-primary"> {{__('lang.return_back')}}: {{number_format($paid_all - (((($sum_amount - $discount_all)*$vat_all)/100)+($sum_amount - $discount_all)))}} </label>
                                    @else
                                    <label class="text-danger"> {{__('lang.overdue')}}:{{number_format((((($sum_amount - $discount_all)*$vat_all)/100)+($sum_amount - $discount_all)) - $paid_all)}} </label>
                                    @endif
                                </h6>
                            </td>
                        </tr>
                      </tfoot>
                      
                    </table>
                  </div>

                  <div class="row">
                    <div class="col-md-12 text-right">
                        <button wire:click="savePurchase" class="btn btn-primary"><i class="fas fa-save"> {{__('lang.save')}}</i></button>
                        <button wire:click="showeditExchange({{$item->id}})" class="btn btn-info"><i class="fas fa-money-bill-wave"></i></button>
                        <a href="{{route('admin.purchase')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

    <!--Modal Edit Price -->
    <div class="modal fade" id="modal-edit-price" wire:ignore>
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
                <input type="hidden" wire:model="hiddenId">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('lang.qty')}}{{$hiddenId}}</label>
                        <input wire:model="qty" type="number" class="form-control">
                        @error('qty') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('lang.buying_price')}}</label>
                        <input wire:model="buying_price" type="number" class="form-control">
                        @error('buying_price') <span style="color: red" class="error">{{ $message }}</span> @enderror
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
                        <label>{{__('lang.note')}}</label>
                        <textarea wire:model="note" type="text" class="form-control"> </textarea>
                    </div>
                </div>
            </div>
            
          </div>
          <div class="modal-footer justify-content-between">
              <button wire:click="editPrice" type="button" class="btn btn-primary">{{__('lang.save')}}</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">{{__('lang.cancel')}}</button>
          </div>   
      </div>
      </div>
    </div>

    <!-- /.delete Product from lists -->
    <div class="modal fade" id="modal-product-list">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('lang.delete')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
              <h3>{{__('lang.do_you_want_to_delete')}}</h3>
            </div>
            <div class="modal-footer justify-content-between">
              <button wire:click="deleteProduct({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
            </div>
          </div>
        </div>
    </div>

    <!--Modal Edit Exchange -->
    <div class="modal fade" id="modal-edit-exchange" wire:ignore>
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
                          <label>{{__('lang.currency_one')}}</label>
                          <input wire:model="currency_one" type="text" class="form-control">
                          @error('currency_one') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>{{__('lang.rate_one')}}</label>
                          <input wire:model="rate_one" type="text" class="form-control">
                          @error('rate_one') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                  </div>
              </div> 
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>{{__('lang.currency_two')}}</label>
                          <input wire:model="currency_two" type="text" class="form-control">
                          @error('currency_two') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>{{__('lang.rate_two')}}</label>
                          <input wire:model="rate_two" type="text" class="form-control">
                          @error('rate_two') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                  </div>
              </div>                
          </div>
          <div class="modal-footer justify-content-between">
              <button wire:click="updateExchange" type="button" class="btn btn-primary">{{__('lang.save')}}</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">{{__('lang.cancel')}}</button>
          </div>
      </div>
      </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('show-modal-product-list', event =>{
            $('#modal-product-list').modal('show');
        })
        window.addEventListener('hide-modal-product-list', event =>{
            $('#modal-product-list').modal('hide');
        })
        window.addEventListener('show-modal-edit-price', event =>{
            $('#modal-edit-price').modal('show');
        })
        window.addEventListener('hide-modal-edit-price', event =>{
            $('#modal-edit-price').modal('hide');
        })
        window.addEventListener('show-modal-edit-exchange', event =>{
            $('#modal-edit-exchange').modal('show');
        })
        window.addEventListener('hide-modal-edit-exchange', event =>{
            $('#modal-edit-exchange').modal('hide');
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#selectProduct').select2();
            $('#selectProduct').on('change', function (e) {
                var data = $('#selectProduct').select2("val");
                @this.set('product_id', data);
            });
        });
        $(document).ready(function() {
            $('#selectMember').select2();
            $('#selectMember').on('change', function (e) {
                var data = $('#selectMember').select2("val");
                @this.set('member_id', data);
            });
        });
    </script>

    <script type="text/javascript">
        $('.money').simpleMoneyFormat();
    </script>
@endpush
