<div>
  <!--Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{__('lang.create_traffic')}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.create_traffic')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <!--end Header -->
  <section class="content">
     <div class="container-fluid">
         <div class="row">
           <div class="col-md-12">
              <div class="card">

                 <!--sold button-->
                 <div class="card-header">
                   <div class="row">
                      <div class="col-md-6">
                       <button wire:click="savebill()" type="button" class="btn btn-primary"> <i class="fas fa-save"></i> {{__('lang.save')}}</button>              
                       <a href="{{route('admin.traffic')}}"  type="button" class="btn btn-danger" ><i class="fas fa-arrow-alt-circle-left"></i> {{__('lang.back')}}</a>
                      </div>
                   </div>
                 </div>
                 <!--end sold button-->

<!--body -->
<div class="card-body">
    <div class="row">
        <!-- ຂໍ້ມູນບິນຄິວຂົນສົ່ງ -->
        <div class="col-sm-3 callout callout-info">
            <div class="form-group clearfix">
                <h5><b>{{__('lang.bill_traffic_info')}}:</b></h5> 
                 <input type="hidden" wire:model="hiddenIdTraffic">
                <div class="form-group">   
                    <div class="input-group">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-info">{{__('lang.bill_code')}}</button>
                          </div>
                        <input wire:model="code" type="text" class="form-control  @error('code') is-invalid @enderror"  readonly>
                    </div>
                @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="form-group clearfix">
                <div class="form-group">   
                    <div class="input-group">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-info">{{__('lang.vihicle_traffic')}}</button>
                          </div>
                        <select wire:model.defer="vihicle_id" class="form-control @error('vihicle_id') is-invalid @enderror">
                            <option value="">{{__('lang.select')}}</option>
                            @foreach($vihicle as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} {{$item->plate_number}}</option>
                            @endforeach
                        </select>
                    </div>
                @error('vihicle_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group clearfix">
                <div class="form-group">   
                    <div class="input-group">
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-info">{{__('lang.start_date')}}</button>
                          </div>
                        <input wire:model="startDate" type="date" class="form-control  @error('startDate') is-invalid @enderror">
                    </div>
                @error('startDate') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- ລາຍຈ່າຍຂົນສົ່ງ-->
        <div class="col-sm-5 callout callout-info">
            <div class="form-group clearfix">
                <h5><b>{{__('lang.expend')}}:</b></h5> 

    <div class="row">
        <div class="col-md-12">
            <button wire:click="showaddExpendTraf()" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('lang.add')}}</button>
        </div>
    </div>
        <br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>{{__('lang.no')}}</th>
                        <th>{{__('lang.expend')}}</th>
                        <th>{{__('lang.money')}}</th>
                        <th>{{__('lang.action')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php $stt = 1; @endphp
                      @foreach ($expend as $item)
                      <tr>
                        <td>{{$stt++}}</td>
                        <td>{{$item->expend_name}}</td>
                        <td>{{number_format($item->amount)}}</td>
                        <td>
                            <button wire:click="showEditExpend({{$item->id}})" type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i></button> 
                            <button wire:click="showDestroyExpend({{$item->id}})" type="button" class="btn btn-danger btn-sm"><i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                </table>
            </div>
        </div>
    </div>

            </div>
        </div>

    <!-- ພະນັກງານຂົນສົ່ງ-->
    <div class="col-sm-4 callout callout-info">
        <div class="form-group clearfix">
            <h5><b>{{__('lang.employee_traffic')}}:</b></h5> 

    <div class="row">
        <div class="col-md-8">
            <select wire:model="emp_id" class="form-control @error('emp_id') is-invalid @enderror">
                <option value="">{{__('lang.select')}}</option>
                @foreach($employee as $item)
                <option value="{{ $item->id }}">{{ $item->firstname }} {{$item->lastname}}</option>
                @endforeach
            </select>
            @error('emp_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
        </div>
            <div class="col-md-4">
                <button wire:click="addEmpDoing()" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('lang.add')}}</button> 
            </div>
    </div>
        <br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>{{__('lang.no')}}</th>
                        <th>{{__('lang.first_and_lastname')}}</th>
                        <th>{{__('lang.action')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php $stt = 1; @endphp
                      @foreach ($empdoing as $item)
                      <tr>
                        <td>{{$stt++}}</td>
                        <td>{{$item->employeename->firstname}} {{$item->employeename->lastname}}</td>
                        <td>
                            <button wire:click="showdestroyEmp({{$item->id}})" type="button" class="btn btn-danger btn-sm"><i class="fa fa-minus" aria-hidden="true"></i>  
                            </button>
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>

</div>
                </div>
                <!-- End Card-body -->
              </div>
            </div> 
          </div>
        </div>
    </section>

    <!-- /.modal-delete -->
    <div class="modal fade" id="modal-delete-employee">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.delete')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" wire:model="hiddenIdStaff">
            <h3>{{__('lang.do_you_want_to_delete') }}</h3>
            <h4><i class="text-danger"><b>{{$emp_name}}</b></i></h4>
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="destroyStaff({{$hiddenIdStaff}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>

    <!-- /.modal-expend_traffic -->
    <div wire:ignore.self class="modal fade" id="modal-expend">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.expend_traffic')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label>{{__('lang.expend')}}</label>
                  <input wire:model="expendname" type="text" class="form-control @error('expendname') is-invalid @enderror">
                  @error('expendname') <span style="color: red" class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{__('lang.money')}}</label>
                  <input wire:model="expendamount" type="text" class="form-control money @error('expendamount') is-invalid @enderror">
                  @error('expendamount') <span style="color: red" class="error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="storeExpend()" type="button" class="btn btn-primary">{{__('lang.save')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>

    <!-- /.modal-expend_traffic -->
    <div wire:ignore.self class="modal fade" id="modal-edit-expend">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.expend_traffic')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" wire:model="hiddenIdExpend" value="{{$hiddenIdExpend}}">
            <div class="form-group">
                <label>{{__('lang.expend')}}</label>
                  <input wire:model="expendname" type="text" class="form-control @error('expendname') is-invalid @enderror">
                  @error('expendname') <span style="color: red" class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>{{__('lang.money')}}</label>
                  <input wire:model="expendamount" type="text" class="form-control money @error('expendamount') is-invalid @enderror">
                  @error('expendamount') <span style="color: red" class="error">{{ $message }}</span> @enderror
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="editExpend({{$hiddenIdExpend}})" type="button" class="btn btn-primary">{{__('lang.save')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>

    <!-- /.modal-delete -->
    <div class="modal fade" id="modal-delete-expend">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.delete')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" wire:model="hiddenIdExpend">
            <h3>{{__('lang.do_you_want_to_delete') }}</h3>
            <h4><i class="text-danger"><b>{{$expendname}}</b></i></h4>
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="destroyExpend({{$hiddenIdExpend}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>


</div>
@push('scripts')
  <script>
    $('.money').simpleMoneyFormat();
    window.addEventListener('show-modal-delete-employee', event => {
        $('#modal-delete-employee').modal('show');
    })
    window.addEventListener('hide-modal-delete-employee', event => {
        $('#modal-delete-employee').modal('hide');
    })

    window.addEventListener('show-modal-add-expend', event => {
        $('#modal-expend').modal('show');
    })
    window.addEventListener('hide-modal-add-expend', event => {
        $('#modal-expend').modal('hide');
    })
    window.addEventListener('show-modal-edit-expend', event => {
        $('#modal-edit-expend').modal('show');
    })
    window.addEventListener('hide-modal-edit-expend', event => {
        $('#modal-edit-expend').modal('hide');
    })
    window.addEventListener('show-modal-delete-expend', event => {
        $('#modal-delete-expend').modal('show');
    })
    window.addEventListener('hide-modal-delete-expend', event => {
        $('#modal-delete-expend').modal('hide');
    })
  </script>
@endpush