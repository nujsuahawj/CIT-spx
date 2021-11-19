<div>
    <!--Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('lang.create_bill')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
              <li class="breadcrumb-item active">{{__('lang.create_bill')}}</li>
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
                         <button wire:click="save()" type="button" class="btn btn-primary"{{$btnStatus1}} >{{__('lang.save')}}</button>              
                         <button wire:click="cancel()" type="button" class="btn btn-warning" {{$btnStatus1}} >{{__('lang.cancel')}}</button>
                         <button wire:click="clear()" type="button" class="btn btn-default" {{$btnStatus2}}>{{__('lang.clear')}}</button>
                        </div>
                        <div class="col-md-6" align="right">
                          <button wire:click="showCusAdd()" type="button" class="btn btn-success" ><i class="fa fa-plus"></i> {{__('lang.add_customer')}}</button>
                        </div>
                     </div>
                   </div>
                   <!--end sold button-->
  
                  <!--body -->
                   <div class="card-body">
                      <div class="row">
                         <div class="col-md-4">
                           <label>{{__('lang.bill_detail')}} : </label>
                         </div>
                         <div class="col-md-4">
                         <label>{{__('lang.sender_info')}} : </label>
                         </div>
                         <div class="col-md-4">
                           <label>{{__('lang.recieve_info')}} : </label>
                         </div>
                      </div>
                      <div class="row">
                        <!-- ຂໍ້ມູນບິນ -->
                        <div class="col-sm-4 callout callout-info">
                         <div class="form-group">   
                          <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info">{{__('lang.bill_code')}}</button>
                              </div>
                              <input wire:model="code" type="text" class="form-control  @error('code') is-invalid @enderror"  readonly>
                            </div>
                            @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                         </div>
                         <div class="form-group">
                            <label>{{__('lang.distance')}}</label>
                            <select wire:model="dist_id" class="form-control" {{$isDisabled1}}>
                              <option value="" selected>{{__('lang.select')}}</option>
                                @foreach($distances as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('dist_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                          <div class="form-group">
                              <label>{{__('lang.branch_receive')}}</label>
                              <select wire:model.defer="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                                    <option value="">{{__('lang.select')}}</option>
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
                        <!-- ຜູ້ຝາກເຄື່ອງ-->
                         <div class="col-sm-4 callout callout-info">
                          <div class="form-group">   
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info">{{__('lang.cus_code')}}</button>
                              </div>
                              <input wire:model="cusid" type="hidden" class="form-control">
                              <input wire:model="cuscode" type="text" class="form-control  @error('cuscode') is-invalid @enderror"  readonly>
                              <div class="input-group-append">
                                <button wire:click="showCusInfo(1)" type="button" class="btn btn-info"><i class="	fas fa-search-plus"></i></button>
                              </div>
                            </div>
                            @error('cuscode') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                          <div class="form-group">   
                          <label>{{__('lang.cusname_send')}}</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info">{{__('lang.cusname_send')}}</button>
                              </div>
                              <input wire:model="cusname" type="text" class="form-control  @error('cusname') is-invalid @enderror" readonly >
                            </div>
                            @error('cusname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                          <div class="form-group">   
                          <label>{{__('lang.phone')}}</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info">{{__('lang.phone')}}</button>
                              </div>
                              <input wire:model="cusphone" type="text" class="form-control  @error('cusphone') is-invalid @enderror"  readonly>
                            </div>
                            @error('cusphone') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                         </div>
                        <!-- ຜູ້ຮັບເຄື່ອງ-->
                         <div class="col-sm-4 callout callout-info">
                          <div class="form-group">
                              <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info">{{__('lang.cusname_receive')}}</button>
                              </div>
                                <input wire:model="rcid" type="hidden" class="form-control">
                                <input  wire:model="rcname" type="text" class="form-control  @error('rcname') is-invalid @enderror" readonly>
                                <div class="input-group-append">
                                  <button wire:click="showCusInfo(2)" type="button" class="btn btn-info"><i class="	fas fa-search-plus"></i></button>
                                </div>
                              </div>
                                  @error('rcname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                              <label>{{__('lang.phone_receive')}}</label>
                              <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info">{{__('lang.phone_receive')}}</button>
                              </div>
                                <input wire:model="rcphone" type="text" class="form-control @error('rcphone') is-invalid @enderror">
                                @error('rcphone') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>
                            </div>
                            <div class="form-group clearfix">
                              <label><b>{{__('lang.service')}}:</b></label> <br>
                                <div class="icheck-success d-inline col-sm-4">
                                  <input wire:model="r2" type="radio" id="radio1" name="r2" value="NML" {{$isDisabled1}}>
                                  <label for="radio1">{{__('lang.normal')}}</label>
                                </div>
                                <div class="icheck-success d-inline col-sm-4">
                                  <input wire:model="r2" type="radio" id="radio2" name="r2" value="COD" {{$isDisabled1}}>
                                  <label for="radio2">{{__('lang.cod')}}</label>
                                </div>
                             </div>
                         </div>
                      </div>
                      
                      <hr>
  
                      <div class="row">
                         <div>
                           <label>{{__('lang.recieve_more_info')}}:</label>
                         </div>
                      </div>
  
                      <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('lang.districtname')}}</label>
                                <select wire:model="dis_id" class="form-control" isDisabled1>
                                  <option value="" selected>{{__('lang.select')}}</option>
                                    @foreach($districts as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
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
                      
                      <div class="row" style="display: none">
                        <!-- ບໍລິການເສີມ -->
                        <!-- ສະກຸນເງິນ-->
                         <div class="col-sm-6 callout callout-info">
                            <div class="form-group clearfix">
                               <h5><b>{{__('lang.currency')}}:</b></h5> 
                                 <div class="icheck-primary d-inline col-sm-4">
                                     <input wire:model="r1" type="radio" id="radioPrimary1" name="r1" value="LAK" {{$isDisabled1}}>
                                     <label for="radioPrimary1">{{__('lang.lak')}}</label>
                                 </div>
                                 <div  class="icheck-primary d-inline col-sm-4">
                                     <input wire:model="r1" type="radio" id="radioPrimary2" name="r1" value="THB" {{$isDisabled1}}>
                                     <label for="radioPrimary2">{{__('lang.thb')}}</label>
                                 </div>
                                 <div class="icheck-primary d-inline col-sm-4">
                                     <input wire:model="r1" type="radio" id="radioPrimary3" name="r1" value="USD" {{$isDisabled1}}>
                                     <label for="radioPrimary3">{{__('lang.usd')}}</label>
                                 </div>
                                 @error('r1') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>
                         </div>
                      </div>
  

     
                    </div>
  
                                       
  
                  </div>
                    <!--end body -->
  
                
                </div>
             </div>
           </div>
       </div>
    </section>
  </div>
  


  @push('scripts')
  <script>
    window.addEventListener('show-modal-delete', event => {
        $('#modal-delete').modal('show');
    })
    window.addEventListener('hide-modal-delete', event => {
        $('#modal-delete').modal('hide');
    })
  
    window.addEventListener('show-modal-cus-info', event => {
        $('#modal-cus-info').modal('show');
    })
    window.addEventListener('hide-modal-cus-info', event => {
        $('#modal-cus-info').modal('hide');
    })
  
    //Add Customer
    window.addEventListener('show-modal-add-customer', event => {
        $('#modal-add-customer').modal('show');
    })
    window.addEventListener('hide-modal-add-customer', event => {
        $('#modal-add-customer').modal('hide');
    })
  </script>
  @endpush
