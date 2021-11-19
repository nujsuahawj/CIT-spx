<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.cod_clearing')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.cod_clearing')}}</li>
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
                    <div class="col-md-4">
                            <div class="form-group">   
                                <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-info">{{__('lang.ref')}}-{{__('lang.branch')}}</button>
                                </div>
                                <input wire:model="search" type="text"  class="form-control  @error('search') is-invalid @enderror"  >
                                </div>
                            </div>
                <!-- /.form-group -->
                <!-- /.form-group -->
                    </div>
        
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>{{__('lang.voucher')}}</th>
                          <th>{{__('lang.currency')}}</th>
                          <th>{{__('lang.amount')}}</th>
                          <th>{{__('lang.sender')}}</th>
                          <th>{{__('lang.reciever')}}</th>
                          <th>{{__('lang.date1')}}</th>
                          <th>{{__('lang.date2')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.action')}}</th>

                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($listcod as $item)
                          <tr>
                             <td class="text-center">
                                    @if($item->status == '3')
                                        <div ><i class="fa fa-check" style="color:green" aria-hidden="true"></i></div>
                                    @elseif($item->status == '1')
                                        <div><i class="fa fa-exclamation-triangle " style="color: red" aria-hidden="true"></i></div>
                                    @elseif($item->status == '2')
                                        <div><i class="fa fa-exclamation-triangle " style="color: orange" aria-hidden="true"></i> </div>
                                    @endif      
                             </td>
                             <td>{{$item->valuedt}}</td>
                             <td>{{$item->vcode}}</td>
                             <td>{{$item->currency_code}}</td>
                             <td>{{number_format($item->cod_total,2,",",".")}}</td>
                             <td>{{$item->bsname}}</td>
                             <td>{{$item->brname}}</td>
                             <td>{{$item->clr_dt1}}</td>
                             <td>{{$item->clr_dt2}}</td>
                             <td> @if($item->status == '3') ຊຳລະສະສາງສຳເລັດ @elseif($item->status == '2') ລໍຖາໂອນເງິນປັນຜົນ @elseif($item->status == '1') ລໍຖ້າຊຳລະຮ້ານຄ້າ @endif</td>
                             <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                   @if($item->status==1)
                                        <a class="dropdown-item" href="javascript:void(0)" wire:click="transf_customer({{$item->id}})"><i class="fas fa-info-circle text-info"> {{__('lang.transcus')}}</i></a>
                                    @endif
                                    @if($item->status==2)
                                        <a class="dropdown-item" href="javascript:void(0)" wire:click="clear_income({{$item->id}})"><i class="fa fa-id-card text-success"> {{__('lang.clearin')}}</i></a>
                                    @endif
                                    </div>
                                </div>
                             </td>

                          </tr>
                          @endforeach
                        </tbody>
                    </table>
  
                    <div>
                
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>


      <!-- /.modal-trcus-->
        <div wire:ignore.self class="modal fade" id="modal-trcus">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('lang.transcus')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
                           <div class='row'>
                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">{{__('lang.account')}} HQ</h3>
                                         </div>
                                         <div class="card-body">

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acno')}}</button>
                                                </div>
                                                    <input  wire:model="hacno" type="text" class="form-control  @error('hacno') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('hacno') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acname')}}</button>
                                                </div>
                                                    <input wire:model="hacname" type="text" class="form-control  @error('hacname') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('hacname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-info">{{__('lang.balance')}}</button>
                                                </div>
                                                    <input wire:model="hbalance" type="text" class="form-control  @error('hbalance') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('hbalance') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                         </div>
                                     </div>
                                </div>
                           </div>

                           <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('lang.total')}}</label>
                                    <input wire:model="total" type="text" class="form-control text-right @error('total') is-invalid @enderror" readonly>
                                    @error('total') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('lang.amount')}}</label>
                                        <input wire:model="amount" type="text" class="form-control text-right @error('amount') is-invalid @enderror" readonly>
                                        <input wire:model="namount" type="hidden" class="form-control @error('namount') is-invalid @enderror">
                                        @error('namount') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('lang.ref')}}</label>
                                    <input wire:model="ref" type="text" class="form-control @error('ref') is-invalid @enderror">
                                    @error('ref') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('lang.detail')}}</label>
                                    <input wire:model="decs" type="text" class="form-control @error('decs') is-invalid @enderror">
                                    @error('decs') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                </div>
                            </div>
                            
                    </div>
                        <div class="modal-footer justify-content-between">
                        <button wire:click="rectr_cus({{$idt}},'',{{$namount}})" type="button" class="btn btn-success">{{__('lang.save')}}</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">{{__('lang.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
         <!-- /.end modal-trcus-->

        <!-- /.modal-clearin-->
        <div wire:ignore.self class="modal fade" id="modal-clearin">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('lang.clearin')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
                        <div class='row'>
                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('lang.account')}} HQ</h3>
                                     </div>
                                     <div class="card-body">
                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acno')}}</button>
                                                </div>
                                                    <input  wire:model="hacno" type="text" class="form-control  @error('hacno') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('hacno') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acname')}}</button>
                                                </div>
                                                    <input wire:model="hacname" type="text" class="form-control  @error('hacname') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('hacname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-info">{{__('lang.balance')}}</button>
                                                </div>
                                                    <input wire:model="hbalance" type="text" class="form-control  @error('hbalance') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('hbalance') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>
                                           
                                     </div>
                                 </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('lang.account')}} recieve Unit</h3>
                                     </div>
                                     <div class="card-body">
                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acno')}}</button>
                                                </div>
                                                    <input  wire:model="racno" type="text" class="form-control  @error('racno') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('racno') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acname')}}</button>
                                                </div>
                                                    <input wire:model="racname" type="text" class="form-control  @error('racname') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('racname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-info">{{__('lang.balance')}}</button>
                                                </div>
                                                    <input wire:model="rbalance" type="text" class="form-control  @error('rbalance') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('rbalance') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>
                                           
                                     </div>
                                 </div>
                            </div>


                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('lang.account')}} sent Unit</h3>
                                     </div>
                                     <div class="card-body">
                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acno')}}</button>
                                                </div>
                                                    <input  wire:model="sacno" type="text" class="form-control  @error('sacno') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('sacno') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acname')}}</button>
                                                </div>
                                                    <input wire:model="sacname" type="text" class="form-control  @error('sacname') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('sacname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-info">{{__('lang.balance')}}</button>
                                                </div>
                                                    <input wire:model="sbalance" type="text" class="form-control  @error('sbalance') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('sbalance') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>
                                           
                                     </div>
                                 </div>
                            </div>


                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('lang.cod_amount')}} : </h3>
                                     </div>
                                     <div class="card-body">
                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.cod_total')}}</button>
                                                </div>
                                                    <input  wire:model="total" type="text" class="form-control  @error('total') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('total') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend" >
                                                    <button type="button" class="btn btn-info">{{__('lang.acname')}}</button>
                                                </div>
                                                    <input wire:model="ms" type="text" class="form-control  @error('ms') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('ms') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">   
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-info">{{__('lang.balance')}}</button>
                                                </div>
                                                    <input wire:model="mr" type="text" class="form-control  @error('mr') is-invalid @enderror"  readonly>
                                                </div>
                                                @error('mr') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                            </div>
                                           
                                     </div>
                                 </div>
                            </div>

                       </div>
                       <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>{{__('lang.ref1')}}</label>
                                    <input wire:model="ref1" type="text" class="form-control @error('ref1') is-invalid @enderror">
                                    @error('ref1') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>{{__('lang.ref2')}}</label>
                                    <input wire:model="ref2" type="text" class="form-control @error('ref2') is-invalid @enderror">
                                    @error('ref2') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>  
                       </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label>{{__('lang.descs')}}</label>
                                    <input wire:model="descs" type="text" class="form-control @error('descs') is-invalid @enderror">
                                    @error('descs') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>  
                        </div>


                    </div>
                        <div class="modal-footer justify-content-between">
                        <button wire:click="rec_income('{{$idt}}')" type="button" class="btn btn-success">{{__('lang.save')}}</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">{{__('lang.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
         <!-- /.end modal-clearin-->
        

  </div>



  @push('scripts')
  <script>
   
    //revert Tran
    window.addEventListener('show-modal-trcus', event => {
      $('#modal-trcus').modal('show');
    })
    window.addEventListener('hide-modal-trcus', event =>{
      $('#modal-trcus').modal('hide');
    })

    window.addEventListener('show-modal-clearin', event => {
      $('#modal-clearin').modal('show');
    })
    window.addEventListener('hide-modal-clearin', event =>{
      $('#modal-clearin').modal('hide');
    })


  </script>

  <script type="text/javascript">
    $('.money').simpleMoneyFormat();
    $("#dist").select2({ dropdownParent: "#modal-add-customer" });

    
  </script>
@endpush

<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
  
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      });
  
    }
    // DropzoneJS Demo Code End
  </script>
  
  
  
  
  
