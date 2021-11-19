<div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('lang.list_call_good')}}</b>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.list_call_good')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!--customers -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-6">
                     
                    </div>
                  </div>
                </div>
                <div class="col-md-3"> 

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
                    <th>{{__('lang.no')}}</th>
                    <th>{{__('lang.created_at')}}</th>
                    <th>{{__('lang.goods_type')}}</th>
                    <th>{{__('lang.vihicletype')}}</th>
                    <th>{{__('lang.qty')}}{{__('lang.product')}}</th>
                    <th>{{__('lang.weigh')}}(kg)</th>
                    <th>{{__('lang.creator')}}</th>
                    <th>{{__('lang.status')}}</th>
                    <th>{{__('lang.action')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php $stt = 1; @endphp
                    @foreach($call_goods as $item)
                    <tr style="text-align: center;">
                        <td>{{$stt++}}</td>
                        <td>{{date('d/m/Y',strtotime($item->appoinment_time))}}</td>
                        <td>{{$item->goodTypename->name}}</td>
                        <td>{{$item->vihicletypename->name}}</td>
                        <td>{{$item->product_count}}</td>
                        <td>{{number_format($item->weight)}}</td>
                        <td>{{$item->username->name}}</td>
                        <td>
                                  @if($item->status == 0)
                                    <div class="btn btn-danger btn-xs"> {{__('lang.reject')}} </div>
                                  @elseif($item->status == 1)
                                    <div class="btn btn-warning btn-xs"> {{__('lang.wait_approve')}} </div>
                                  @elseif($item->status == 2)
                                    <div class="btn btn-info btn-xs"> {{__('lang.will_receive')}} </div>
                                  @elseif($item->status == 3)
                                    <div class="btn btn-success btn-xs"> {{__('lang.receive_approve')}} </div>
                                  @endif
                        </td>
                        <td>
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    @if($item->status == 1)
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="DetailReceive({{$item->id}})"><i class="fas fa fa-check-circle text-success"> {{__('lang.approve')}}</i></a>
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="showDestroy({{$item->id}})"><i class="fas fa fa-times-circle text-danger"> {{__('lang.cancel')}}</i></a>
                                    @endif  
                                </div>
                                </div>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                <div class="d-flex justify-content-between">
                {{$call_goods->links()}}
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
