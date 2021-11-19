<div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                    <a href="{{route('admin.create_sale')}}" class="btn btn-primary btn-sm">{{__('lang.add')}}</a>{{$customer_id}}
                  </div>
                  <div class="col-md-2" wire:ignore>
                    <select wire:model="customer_id" class="form-control" id="selectCustomer">
                      <option value="" selected>{{__('lang.all_customer')}}</option>
                      @foreach ($customers as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-2">
                    <input type="date" wire:model="from_date" class="form-control">
                  </div>
                  <div class="col-md-2">
                    <input type="text" wire:model="search" class="form-control" placeholder="{{__('lang.code')}}">
                  </div>
                </div>
              </div>
                  <!--
                  <div class="card-header">
                      <div class="row">
                          <div class="col-md-2">
                              <div class="d-flex justify-content-between">
                                  <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                                  {{__('lang.sale_detail')}}
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="row">
                                  <div class="col-md-3">
                                      <input type="date" class="form-control">
                                  </div>
                                  <div class="col-md-3">
                                      <input type="date" class="form-control">
                                  </div>
                                  <div class="col-md-4">
                                      <input type="text" class="form-control" placeholder="{{__('lang.search')}}">
                                  </div>
                                  <div class="col-md-2">
                                      <button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-2">

                          </div>
                      </div>
                  </div>
                  -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                      <thead>
                        <tr style="text-align: center">
                          <th>{{__('lang.code')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>{{__('lang.customername')}}</th>
                          <th>{{__('lang.grand_total')}}</th>
                          <th>{{__('lang.paid')}}</th>
                          <th>{{__('lang.debit')}}</th>
                          <th>{{__('lang.payment')}}</th>
                          <th>{{__('lang.shipping_status')}}</th>
                          <th>{{__('lang.creator')}}</th>
                          @if(Auth()->user()->rolename->name == 'admin')
                          <th></th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
   
                        @foreach ($sales as $item)
                        <tr>
                          <td><a href="javascript:void(0)" wire:click="saleDetail({{$item->id}})">{{$item->code }}</a></td>
                          <td><a href="javascript:void(0)" wire:click="saleDetail({{$item->id}})">{{date('d/m/Y H:m:s', strtotime($item->created_at))}}</a></td>
                          <td><a href="javascript:void(0)" wire:click="saleDetail({{$item->id}})">{{$item->cusname->name}}</a></td>
                          <td style="text-align: right">{{number_format($item->grand_total)}}</td>
                          <td style="text-align: right">{{number_format($item->paid)}}</td>
                          <td style="text-align: right; color:red">{{number_format($item->debit)}}</td>
                          <td style="text-align: center">{{$item->payname->name}}</td>
                          <td>
                            @if ($item->shipping_id == 1)
                              <p style="text-align: center; color:red">{{$item->shipname->name}}</p>
                            @elseif($item->shipping_id == 2)
                              <p style="text-align: center; color:rgb(18, 221, 187)">{{$item->shipname->name}}</p>
                            @else
                              <p style="text-align: center; color:rgba(106, 106, 250, 0.829)">{{$item->shipname->name}}</p>
                            @endif
                          </td>
                          <td style="text-align: center">{{$item->username->name}}</td>

                          @if(Auth()->user()->rolename->name == 'admin')
                          <td width="2%" style="text-align: center">
                              <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="editSale({{$item->id}})"><i class="fas fa-pencil-alt text-warning"> {{__('lang.edit')}}</i></a>
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="saleDetail({{$item->id}})"><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="printA4Sale({{$item->id}})"><i class="fas fa-print text-primary"> {{__('lang.printsmall')}}</i></a>
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="printA4Sale({{$item->id}})"><i class="fas fa-print text-primary"> {{__('lang.printa4')}}</i></a>
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="showDelete({{$item->id}})"><i class="fas fa-trash text-danger"> {{__('lang.delete')}}</i></a>
                                </div>
                              </div>
                          </td>
                          @endif
                        </tr>
                        @endforeach
                        
                      </tbody>
                  </table>

                  {{$sales->links()}}

                </div>
              </div>
            </div>
        </div>
      </div>

      <!--Modal Delete Product From List -->
      <div class="modal fade" id="modalDelete">
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
                          <h5><p style="color: red">{{__('lang.do_you_want_to_delete_your_data_will_delete_all')}}</p></h5>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button wire:click="deleteSale" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
                      <button type="button" class="btn btn-info" data-dismiss="modal">{{__('lang.cancel')}}</button>
                  </div>
          </div>
        </div>
      </div>

    </div>
</section>

</div>

@push('scripts')
    <script>
      window.addEventListener('show-modal-delete', event=>{
        $('#modalDelete').modal('show');
      })
      window.addEventListener('close-modal-delete', event=>{
        $('#modalDelete').modal('hide');
      })
    </script>

    <script>
      $(document).ready(function() {
          $('#selectCustomer').select2();
          $('#selectCustomer').on('change', function (e) {
              var data = $('#selectCustomer').select2("val");
              @this.set('customer_id', data);
          });
      });
    </script>
@endpush
