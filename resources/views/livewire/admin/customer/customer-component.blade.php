<div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('lang.customer')}}</b>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.customer')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!--CustomerType -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                  <a wire:click="create" class="btn btn-primary"  href="javascript:void(0)"><i class="fa fa-plus"></i>{{__('lang.add')}}</a>
                </div>
                <div class="card-body">
  
                  <!-- Sidebar Menu -->
                <nav>
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                    @foreach ($customertypes as $item)
                      <li class="nav-item menu-open">
                        <div class="d-flex justify-content-between">
                          <a class="nav-link">{{$item->name}}</a>
                          
                          <div>
                            @if($item->status==1)<span class="badge rounded-pill bg-success">{{__('lang.enable')}}</span>@else<span class="badge rounded-pill bg-warning">{{__('lang.disable')}}</span>@endif
                            <a href="javascript:void(0)" wire:click="edit({{$item->id}})"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" wire:click="showDestroyCustomerType({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                          </div>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                </nav>
  
                </div>
            </div>
        </div>

        <!--customers -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-6">
                      <a wire:click="showAddCustomer" class="btn btn-primary" href="javascript:void(0)"><i class="fa fa-plus"></i>{{__('lang.add')}}</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3"> 
                @if(Auth::user()->branch_id == 1)
                  <select wire:model="branch_search" class="form-control">
                    <option value="0" selected>{{__('lang.select')}}</option>
                      @foreach($branch as $item)
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                        @endif
                        
                      @endforeach
                  </select>
                @endif
                </div>
                <div class="col-md-6">
                  <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr style="text-align: center">
                    <th>{{__('lang.code')}}</th>
                    <th>{{__('lang.customername')}}</th>
                    <th>{{__('lang.phone')}}</th>
                    <th>{{__('lang.location')}}</th>
                    <th>{{__('lang.bod')}}</th>
                    <th>{{__('lang.custype')}}</th>
                    <th>{{__('lang.branch')}}</th>
                    <th>{{__('lang.note')}}</th>
                    <th>{{__('lang.action')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php
                    $stt = 1;    
                  @endphp

                  @foreach ($customers as $item)
                  <tr>
                    <td>{{$item->code}}</td>
                    <td>{{$item->name}}</td>
                    <td style="text-align: right">{{($item->phone)}}</td>
                    <td style="text-align: right">{{($item->proname.' - '.$item->disname.' - '.$item->vilname)}}</td>
                    <td style="text-align: right">{{($item->bod)}}</td>
                    <td style="text-align: right">{{($item->custype->name)}}</td>
                    <td style="text-align: right">
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{ $item->branch->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{ $item->branch->company_name_en }}</option>
                        @endif
                    </td>
                    <td style="text-align: right">{{($item->note)}}</td>
                    <td style="text-align: center">
                        <a href="javascript:void(0)" wire:click="showEditCustomer({{$item->id}})"><i class="fa fa-edit mr-2"></i></a>
                        <a href="javascript:void(0)" wire:click="showDestroyCustomer({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  
                  </tbody>
                </table>

                <div class="d-flex justify-content-between">
                  {{$customers->links()}}
                  {{__('lang.total_customer')}}: {{$count_all_customers}} {{__('lang.items')}}
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- /.modal-add CustomerType -->
  <div wire:ignore.self class="modal fade" id="modal-add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.add')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.custypename')}}</label>
                  <input wire:model="name" type="text" class="form-control  @error('name') is-invalid @enderror">
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.parent_id')}}</label>
                  <input wire:model="parent_id" type="number" class="form-control @error('parent_id') is-invalid @enderror">
                  @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="form-group" >
            <div class="form-check">
              <label >{{__('lang.status')}}: </label>
            </div>
          <div class="form-check form-check-inline" >
            <input class="form-check-input" type="radio" name="status" value="1" wire:model="status">
            <label class="form-check-label" for="flexRadioDefault1">
              {{__('lang.enable')}}
            </label>
          </div>
          <div class="form-check form-check-inline" >
            <input class="form-check-input" type="radio" name="status" value="2" wire:model="status">
            <label class="form-check-label" for="flexRadioDefault2">
              {{__('lang.disable')}}
            </label>
          </div>
          @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
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

  <!-- /.modal-edit customertyp -->
  <div wire:ignore.self class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.edit')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <input type="hidden" wire:model="hiddenId">

          <form>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.custypename')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.parent_id')}}</label>
                  <input wire:model="parent_id" type="number" class="form-control @error('parent_id') is-invalid @enderror">
                  @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="form-check">
              <label >{{__('lang.status')}}: </label>
            </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" value="1" wire:model="status">
            <label class="form-check-label" for="flexRadioDefault1">
              {{__('lang.enable')}}
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" value="2" wire:model="status">
            <label class="form-check-label" for="flexRadioDefault2">
              {{__('lang.disable')}}
            </label>
          </div>
          @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
          </div>


        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="update" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-delete Catalog-->
  <div class="modal fade" id="modal-delete">
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
          <h3>{{'('. $name.')'.__('lang.do_you_want_to_delete')}}</h3>
        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="destroy({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>


<!-- /.modal-add customer -->
  <div wire:ignore.self class="modal fade" id="modal-add-customer">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.add')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <form>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.code')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.customername')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3" >
              <div class="form-group">
                  <label>{{__('lang.custype')}}</label>
                  <select wire:model="cus_type_id" class="form-control @error('cus_type_id') is-invalid @enderror">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($customertypes as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('cus_type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.phone')}}</label>
                  <input wire:model="phone" type="text" class="form-control  @error('phone') is-invalid @enderror">
                  @error('phone') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.email')}}</label>
                  <input wire:model="email" type="email" class="form-control ">
              </div>
            </div>
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.bod')}}</label>
                  <input wire:model="bod" type="date" class="form-control ">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12" >
              <hr>
              <label><u>{{__('lang.address')}}</u> :</label>
            </div>       
          </div>
         
          <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>{{__('lang.provincename')}}</label>
                    <select wire:model="pro_id" class="form-control" >
                      <option value="" selected>{{__('lang.select')}}</option>
                        @foreach($provinces as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('pro_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
    
              <div class="col-md-6">
                  <div class="form-group" >
                    <label>{{__('lang.districtname')}}</label>
                    <select wire:model="dis_id" class="form-control" id ="dis">
                       <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($districts as $item)
                       <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                    </select>
                    @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
              </div>
 
            <div class="col-md-3">
                <div class="form-group" >
                  <label>{{__('lang.villagename')}}</label>
                  <select wire:model="vil_id" class="form-control" id ="vil">
                     <option value="" selected>{{__('lang.select')}}</option>
                    @foreach($villages as $item)
                     <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                  @error('vil_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
         </div>
         <div class="row">
          <div class="col-md-12" >
            <hr>
          </div>       
        </div>
          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.branch')}}</label>
                  <select wire:model.defer="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                      @foreach($branch as $item)
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{  $item->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{  $item->company_name_en }}</option>
                        @endif
                      @endforeach
                  </select>
                  @error('branch_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            
            <div class="col-md-9">
              <div class="form-group">
                <label>{{__('lang.note')}}</label>
                  <input wire:model="note" type="text" class="form-control">
              </div>
            </div>
          </div>

        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="storeCustomer" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-edit Customer -->
  <div wire:ignore.self class="modal fade" id="modal-edit-customer">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.edit')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <form>

          <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.code')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.customername')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                  <label>{{__('lang.custype')}}</label>
                  <select wire:model.defer="parent_id" class="form-control" @error('parent_id') is-invalid @enderror">
                    <option value="0" selected>{{__('lang.select')}}</option>
                      @foreach($customertypes as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.phone')}}</label>
                  <input wire:model="phone" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-6" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.email')}}</label>
                  <input wire:model="email" type="email" class="form-control">
              </div>
            </div>
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.bod')}}</label>
                  <input wire:model="bod" type="date" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12" wire:ignore>
                <hr>
                <label>{{__('lang.address')}}</label>            
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>{{__('lang.provincename')}}</label>
                    <select wire:model="pro_id" class="form-control">
                      <option value="" selected>{{__('lang.select')}}</option>
                        @foreach($provinces as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('pro_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>    
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__('lang.districtname')}}</label>
                    <select wire:model="dis_id" class="form-control">
                      <option value="" selected>{{__('lang.select')}}</option>
                        @foreach($districts as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                  <label>{{__('lang.villagename')}}</label>
                  <select wire:model="vil_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($villages as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('vil_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>   
          </div>
      <div class="row">
        <div class="col-md-12" wire:ignore>
            <hr>         
        </div>
      </div>
     


          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                  <label>{{__('lang.branch')}}</label>
                  <select wire:model.defer="branch_id" class="form-control" @error('branch_id') is-invalid @enderror">
                      @foreach($branch as $item)
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                        @endif
                      @endforeach
                  </select>
                  @error('branch_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label>{{__('lang.note')}}</label>
                  <input wire:model="note" type="text" class="form-control">
              </div>
            </div>
          </div>
        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="updateCustomer" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-delete Customer-->
  <div class="modal fade" id="modal-delete-customer">
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
          <button wire:click="destroyCustomer({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>
 

</div>

@push('scripts')
  <script>
    //Add CustomerType
    window.addEventListener('show-modal-add', event => {
      $('#modal-add').modal('show');
      $("#modal-add").modal({ backdrop : "static", keyboard: false});
    })
    window.addEventListener('hide-modal-add', event =>{
      $('#modal-add').modal('hide');
    })
    //Edit CustomerType
    window.addEventListener('show-modal-edit', event => {
      $('#modal-edit').modal('show');
    })
    window.addEventListener('hide-modal-edit', event =>{
      $('#modal-edit').modal('hide');
    })
    //Delete CustomerType
    window.addEventListener('show-modal-delete', event => {
      $('#modal-delete').modal('show');
    })
    window.addEventListener('hide-modal-delete', event =>{
      $('#modal-delete').modal('hide');
    })

    //Add Customer
    window.addEventListener('show-modal-add-customer', event => {
      $('#modal-add-customer').modal('show');
    })
    window.addEventListener('hide-modal-add-customer', event => {
      $('#modal-add-customer').modal('hide');
    })
    //Edit Customer
    window.addEventListener('show-modal-edit-customer', event => {
      $('#modal-edit-customer').modal('show');
    })
    window.addEventListener('hide-modal-edit-customer', event => {
      $('#modal-edit-customer').modal('hide');
    })
    //Delete Customer
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
