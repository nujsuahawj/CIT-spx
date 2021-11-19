<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.ewallet')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.ewallet')}}</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
  
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            
            
            <!--List users- table table-bordered table-striped -->
  
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-3">
                      @if(Auth()->user()->branchname->id==1)
                      <label> <a wire:click="showAddCalculatePrice" class="btn btn-primary" href="javascript:void(0)"><i class="fa fa-plus"></i>{{__('lang.add').__('lang.account')}}</a></label>
                      @endif
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                      <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search').__('lang.account')}}">
                    </div>
                    <div class="col-md-3">
                      <input wire:model="search_by_name" type="text" class="form-control" placeholder="{{__('lang.search').__('lang.branch')}}">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.acno')}}</th>
                          <th>{{__('lang.acname')}}</th>
                          <th>{{__('lang.branch')}}</th>
                          <th>{{__('lang.currency')}}</th>
                          <th>{{__('lang.balance')}}</th>
                          <th>{{__('lang.income')}}</th>
                          <th>{{__('lang.expend')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.created_at')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($ewallet as $item)
                        <tr>
                          <td>{{$stt++}}</td>
                          <td>{{$item->acno}}</td>
                          <td>{{$item->acname}}</td>
                          <td>{{$item->company_name_la}}</td>
                          <td>{{$item->currency_code}}</td>
                          <td>{{number_format($item->balance,2,",",".")}}</td>
                          <td>{{number_format($item->income,2,",",".")}}</td>
                          <td>{{number_format($item->expend,2,",",".")}}</td>
                          <td>
                                    @if($item->status == 'N')
                                      <div class="btn btn-success btn-xs"> {{__('lang.active')}} </div>
                                    @elseif($item->status == 'C')
                                      <div class="btn btn-warning btn-xs"> {{__('lang.inactive')}} </div>
                                    @elseif($item->status == 'B')
                                      <div class="btn btn-warning btn-xs"> {{__('lang.inactive')}} </div>
                                    @endif
                          </td>
                          <td>{{$item->created_at}}</td>
                          <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                @if(Auth()->user()->branchname->id==1)
                                       <a class="dropdown-item" href="javascript:void(0)" wire:click="showCash({{$item->id}})"><i class="fa fa-credit-card text-primary"> {{__('lang.cash_in')}}</i></a>
                                    @if(Auth()->user()->rolename->name == 'admin' && $item->status == 'N')
                                        <a class="dropdown-item" href="javascript:void(0)" wire:click="showDestroy({{$item->id}})"><i class="fas fa-trash text-danger"> {{__('lang.delete').__('lang.account')}}</i></a>
                                    @else
                                        <a class="dropdown-item" href="javascript:void(0)" wire:click="showDestroy({{$item->id}})"><i class="fa fa-check text-primary"> {{__('lang.active').__('lang.account')}}</i></a>
                                    @endif
                                @endif
                                    </div>
                                  </div>
                          </td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
  
                    <div>
                      {{$ewallet->links()}}
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>
  
 
    <!-- /.modal-add ewallet -->
    <div wire:ignore.self class="modal fade" id="modal-add-ewallet">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.add')}}({{__('lang.account')}}) </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
  
          <form>

            <div class="row">
              <div class="col-md-12">
                    <div class="form-group">   
                      <div class="input-group">
                        <div class="input-group-prepend">
                             <button type="button" class="btn btn-info">{{__('lang.account')}}</button>
                        </div>
                            <input wire:model="acno" type="text" class="form-control  @error('acno') is-invalid @enderror"  readonly>
                      </div>
                      @error('cuscode') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
               <div class="form-group">
                 <label>{{__('lang.branch')}}</label>  
                   <select wire:model="branch_id" class="form-control">
                     <option value="" selected>{{__('lang.select')}}</option>
                       @foreach($branch as $item)
                          <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                       @endforeach
                   </select>
                   @error('branch_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
               </div>
             </div>
           </div>
            <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>{{__('lang.acname')}}</label>
                          <input wire:model="acname" type="text" class="form-control @error('acname') is-invalid @enderror">
                          @error('acname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                    </div>
            </div>

            
  
          </form>
  
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="store" type="button" class="btn btn-success">{{__('lang.save')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
    <!-- /end modal-add calculate price -->

        <!-- /.modal-delete account-->
        <div class="modal fade" id="modal-delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{__('lang.delete')}}({{$ac}})</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
                <h3>{{__('lang.do_you_want_to_delete')}}({{$an}})</h3>
              </div>
              <div class="modal-footer justify-content-between">
                <button wire:click="destroy({{$hiddenId}})" type="button" class="btn btn-success">
                  @if($st=='N'){{__('lang.delete')}} @else {{__('lang.active').__('lang.account')}} @endif
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">{{__('lang.close')}}</button>
              </div>
            </div>
          </div>
        </div>

        <!-- /.modal-add-cash-->
        <div wire:ignore.self  class="modal fade" id="modal-add-cash">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{__('lang.increase_cash')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
                        <div class="row">
                          <div class="col-md-12">
                                <div class="form-group">   
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info">{{__('lang.account')}}</button>
                                    </div>
                                        <input wire:model="facno" type="text" class="form-control  @error('facno') is-invalid @enderror"  readonly>
                                  </div>
                                  @error('facno') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                                <div class="form-group">   
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info">{{__('lang.account')}}</button>
                                    </div>
                                        <input wire:model="facname" type="text" class="form-control  @error('facname') is-invalid @enderror"  readonly>
                                  </div>
                                  @error('facname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>{{__('lang.amount')}}</label>
                                <input wire:model="amount" type="number" class="form-control @error('amount') is-invalid @enderror">
                                @error('amount') <span style="color: red" class="error">{{ $message }}</span> @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>{{__('lang.document')}}</label>
                                <input wire:model="document" type="text" class="form-control @error('document') is-invalid @enderror">
                                @error('document') <span style="color: red" class="error">{{ $message }}</span> @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>{{__('lang.description')}}</label>
                                <input wire:model="description" type="text" class="form-control @error('description') is-invalid @enderror">
                                @error('description') <span style="color: red" class="error">{{ $message }}</span> @enderror
                            </div>
                          </div>
                        </div>
                </form>
               
              </div>
              <div class="modal-footer justify-content-between">
                <button wire:click="recordcash({{$idup}})" type="button" class="btn btn-primary">{{__('lang.save')}}</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">{{__('lang.close')}}</button>
              </div>
            </div>
          </div>
        </div>




  </div>
  
  @push('scripts')
  <script>
    //Add distance,cal_type
    window.addEventListener('show-modal-add-ewallet', event => {
      $('#modal-add-ewallet').modal('show');
      $("#modal-add-ewallet").modal({ backdrop : "static", keyboard: false});
    })
    window.addEventListener('hide-modal-add', event =>{
      $('#modal-add-ewallet"').modal('hide');
    })
    //Edit distance,cal_type
    window.addEventListener('show-modal-edit', event => {
      $('#modal-edit').modal('show');
    })
    window.addEventListener('hide-modal-edit', event =>{
      $('#modal-edit').modal('hide');
    })
    //Delete distance,cal_type
    window.addEventListener('show-modal-delete', event => {
      $('#modal-delete').modal('show');
    })
    window.addEventListener('hide-modal-delete', event =>{
      $('#modal-delete').modal('hide');
    })

    //Add cash
    window.addEventListener('show-modal-cash', event => {
      $('#modal-add-cash').modal('show');
      $("#modal-add-cash").modal({ backdrop : "static", keyboard: false});
    })
    window.addEventListener('hide-modal-cash', event => {
      $('#modal-add-cash').modal('hide');
    })
    //Edit cal_price
    window.addEventListener('show-modal-edit-customer', event => {
      $('#modal-edit-customer').modal('show');
    })
    window.addEventListener('hide-modal-edit-customer', event => {
      $('#modal-edit-customer').modal('hide');
    })
    //Delete cal_price
    window.addEventListener('show-modal-delete-customer', event => {
      $('#modal-delete-customer').modal('show');
    })
    window.addEventListener('hide-modal-delete-customer', event => {
      $('#modal-delete-customer').modal('hide');
    })
  </script>

  <script type="text/javascript">
    $('.money').simpleMoneyFormat();


    $("#dist").select2({ dropdownParent: "#modal-add-customer" });?
  


    
  </script>
@endpush
  
  
  