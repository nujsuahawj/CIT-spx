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
                       <button wire:click="savebill()" type="button" class="btn btn-primary"{{$btnStatus1}} >{{__('lang.save')}}</button>              
                       <button wire:click="cancel()" type="button" class="btn btn-warning" {{$btnStatus1}} >{{__('lang.cancel')}}</button>
                       <button wire:click="clear()" type="button" class="btn btn-default" {{$btnStatus2}}>{{__('lang.clear')}}</button>
                       <a href="{{route('voucher.printreceive',$code)}}" rel="noopener" target="_blank" class="btn btn-default" style="{{$dislink}}"><i class="fas fa-print"></i> {{__('lang.printreceive')}}</a>
                       <a href="{{route('voucher.printmatterail',$code)}}" rel="noopener" target="_blank" class="btn btn-default" style="{{$dislink}}"><i class="fas fa-print"></i> {{__('lang.printmatterail')}}</a>
                      </div>
                      <div class="col-md-3">
                         @if(!empty($ew->id))
                            <label class="text-primary">{{__('lang.account')}}: {{$ew->acno}} = {{number_format($ew->balance,2,",",".")}}LAK</label>
                         @endif
                      </div>
                      <div class="col-md-3" align="right">
                        <button wire:click="showCusAddSend()" type="button" class="btn btn-success" ><i class="fa fa-plus"></i> {{__('lang.add')}}{{__('lang.sender')}}</button>
                        <button wire:click="showCusAddReceive()" type="button" class="btn btn-primary" ><i class="fa fa-plus"></i> {{__('lang.add')}}{{__('lang.receiver')}}</button>
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
                       <div class="form-group" wire:ignore>
                          <label>{{__('lang.distance')}}</label>
                          <select wire:model="dist_id" class="form-control" {{$isDisabled1}}>
                            <option value="" selected>{{__('lang.select')}}</option>
                              @foreach($distances as $item)
                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                          </select>
                          @error('dist_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group" wire:ignore>
                            <label>{{__('lang.branch')}}{{__('lang.by_receiver')}}</label>
                            <select wire:model.defer="branch_id" class="form-control @error('branch_id') is-invalid @enderror" id="selectBranch" >
                                  <option value="">{{__('lang.select')}}</option>
                                @foreach($branch as $item)
                                  @if (Config::get('app.locale') == 'lo')
                                    <option value="{{ $item->id }}">{{ $item->code."-".$item->pvname."-".$item->dtname."-".$item->vlname." ( ".$item->company_name_la." ) " }}</option>
                                  @elseif (Config::get('app.locale') == 'en')
                                    <option value="{{ $item->id }}">{{ $item->code."-".$item->pvname."-".$item->dtname."-".$item->vlname." - ".$item->company_name_en }}</option>
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
                            <div class="row">
                                <div class="form-group clearfix col-md-7" >
                                  <label><b>{{__('lang.service')}}:</b></label><br> 
                                    <div class="icheck-success d-inline col-sm-3">
                                      <input wire:model="r2" type="radio" id="radio1" name="r2" value="NML" {{$isDisabled1}}>
                                      <label for="radio1">{{__('lang.normal')}}</label>
                                    </div>
                                    <div class="icheck-success d-inline col-sm-3" >
                                      <input wire:model="r2" type="radio" id="radio2" name="r2" value="COD" {{$isDisabled1}} @if(empty($ew->id)) disabled @endif>
                                      <label for="radio2">{{__('lang.cod')}}</label>
                                    </div>        
                                </div> 
                                <div class="form-group clearfix col-md-5" >         
                                    <label>{{__('lang.insurance')}}</label><br>
                                    <div class="icheck-primary d-inline">
                                      <input type="checkbox"  wire:model="insur"  id="checkboxPrimary1" {{$isDisabled1}}>
                                      <label for="checkboxPrimary1">ເພີ່ມ 3% <br>ຂອງມູນຄ່າເຄື່ອງ</label>
                                    </div> 
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
                          <div class="form-group" wire:ignore>
                              <label>{{__('lang.provincename')}}</label>
                              <select wire:model="pro_id" class="form-control" id="selectProvince">
                                <option value="" selected>{{__('lang.select')}}</option>
                                  @foreach($provinces as $item)
                                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                              </select>
                              @error('pro_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>    
                      </div>
                      <div class="col-md-4">
                          <div class="form-group" wire:ignore>
                              <label>{{__('lang.districtname')}}</label>
                              <select wire:model="dis_id" class="form-control" id="selectDistrict">
                                <option value="" selected>{{__('lang.select')}}</option>
                                  @foreach($districtss as $item)
                                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                              </select>
                              @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group" wire:ignore>
                            <label>{{__('lang.villagename')}}</label>
                            <select wire:model="vil_id" class="form-control" id="selectVillage">
                              <option value="" selected>{{__('lang.select')}}</option>
                                @foreach($villagess as $item)
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

                    <div class="row">
                      <div class="col-md-12" wire:ignore>
                          <hr>
                          <label>{{__('lang.list')}}: </label>         
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                          <div class="form-group">
                              <label>{{__('lang.goods_type')}}</label>
                               <select wire:model="goods_type_id" class="form-control">
                                  <option value="" selected>{{__('lang.select')}}</option>
                                  @foreach($goodstype as $item)
                                   <option value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                               </select>
                              @error('goods_type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                      </div>

                      <div class="col-md-2">
                          <div class="form-group">
                              <label>{{__('lang.product_type')}}</label>
                              <select wire:model="product_type_id" class="form-control">
                                    <option value="">{{__('lang.select')}}</option>
                                  @foreach($ProductType as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                              </select>
                              @error('product_type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                      </div>

                      <div class="col-md-1">     
                          <div class="form-group">
                              <label>{{__('lang.large')}}(cm)</label>
                              <input  wire:model="large"   type="number" class="form-control"  aria-label="{{__('lang.large')}}" >
                              @error('large') <span style="color: red" class="error">{{ $message }}</span> @enderror
                         </div>   
                      </div>

                      <div class="col-md-1">   
                          <div class="form-group">
                              <label>{{__('lang.height')}}(cm)</label>
                              <input wire:model="height"   type="number" class="form-control"  aria-label="{{__('lang.height')}}" >
                               @error('height') <span style="color: red" class="error">{{ $message }}</span> @enderror
                         </div>
                      </div>
                        
                      <div class="col-md-1"> 
                          <div class="form-group">
                            <label>{{__('lang.longs')}}(cm)</label>
                            <input wire:model="longs"   type="number" class="form-control"  aria-label="{{__('lang.longs')}}" >
                            @error('longs') <span style="color: red" class="error">{{ $message }}</span> @enderror
                         </div>
                      </div>

                      <div class="col-md-1"> 
                        <div class="form-group">
                            <label>{{__('lang.weigh')}}(kg)</label>
                            <input wire:model="weigh"  type="number" class="form-control"  aria-label="{{__('lang.weigh')}}" >
                            @error('weigh') <span style="color: red" class="error">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      <div class="col-md-1"> 
                        <div class="form-group">
                              <label>{{__('lang.packing')}}</label>
                              <select wire:model="pack" class="form-control" >
                                <option value="0|0">{{__('lang.select')}}</option>
                                @foreach ($packet as $item)
                                <option value="{{$item->id}}|{{$item->price}}">{{$item->name}}</option> 
                                @endforeach     
                              </select>
                        </div>
                      </div>

                      <div class="col-md-1"> 
                        <div class="form-group">
                              <label>{{__('lang.paid_type')}}</label>
                              <select wire:model="piadtype" class="form-control" {{$isDisabled1}}>
                                <option value="SD">{{__('lang.by_sender')}}</option>
                                <option value="RV">{{__('lang.by_receiver')}}</option>  
                              </select>
                        </div>
                      </div>

                     

                      <div class="col-md-1"> 
                          <div class="form-group">
                              <label>{{__('lang.cod_service_amount')}}</label>
                              <input wire:model="amount"  type="number" class="form-control"  aria-label="{{__('lang.amount')}}" {{$hide_cod}} >
                              @error('amount') <span style="color: red" class="error">{{ $message }}</span> @enderror
                          </div>
                      </div>

                      <div class="col-md-1"> 
                          <div class="form-group">
                               <div class="row">
                                <label>_____</label>
                               </div>
                               <div class="row">
                               <button wire:click="addOrder" type="button" class="btn-sm btn-info" {{$btnStatus1}}>{{__('lang.save')}}</button>  
                               </div>
                          </div>
                      </div>
                  </div>

                                      <!------------list order -----> 
                                      <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                               <thead>
                                                <tr>
                                                  <th>{{__('lang.no')}}</th>
                                                  <th>{{__('lang.code')}}</th>
                                                  <th>{{__('lang.goods_type')}}</th>
                                                  <th>{{__('lang.product_type')}}</th>
                                                  <th>{{__('lang.large')}}(cm)</th>
                                                  <th>{{__('lang.height')}}(cm)</th>
                                                  <th>{{__('lang.longs')}}(cm)</th>
                                                  <th>{{__('lang.weigh')}}(kg)</th>
                                                  <th>{{__('lang.calculator_type')}}</th>
                                                  <th>{{__('lang.amount')}}</th>
                                                  <th>{{__('lang.packing')}}</th>
                                                  <th>{{__('lang.paid_type')}}</th>
                                                  <th>{{__('lang.cod_service_amount')}}</th>
                                                  <th>{{__('lang.insurance')}}</th>
                                                  <th>{{__('lang.action')}}</th>
                                                 </tr>
                                               </thead>
                                               <tbody>
                                               @php
                                                  $stt = 1; 
                                               @endphp
                         
                                               @foreach ($matterails as $item)
                                                <tr>
                                                  <td>{{$stt++}}</td>
                                                  <td>{{$item->code}}</td>
                                                  <td>{{$item->gname}}</td>
                                                  <td>{{$item->pname}}</td>
                                                  <td>{{$item->large}}</td>
                                                  <td>{{$item->height}}</td>
                                                  <td>{{$item->longs}}</td>
                                                  <td>{{$item->weigh}}</td>
                                                  <td>{{$item->calname}}</td>
                                                  <td class="text-right">{{number_format($item->amount,2,",",".") ." ". $item->currency_code}}</td>
                                                  <td class="text-right">{{number_format($item->pack_amount,2,",",".")." ".$item->currency_code}}</td>
                                                  <td>@if($item->paid_type=='SD') {{__('lang.by_sender')}}@else {{__('lang.by_receiver')}}@endif</td>
                                                  <td class="text-right">{{number_format($item->cod_amount,2,",",".")." ".$item->currency_code}}</td>
                                                  <td class="text-right">{{number_format($item->insur_amount,2,",",".")." ".$item->currency_code}}</td>
                                                  <td>
                                                     <button wire:click="showDestroy({{$item->id}})" type="button" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.Take Out')}}" {{$btnStatus1}}>
                                                       <i class="fa fa-minus" aria-hidden="true"></i>                          
                                                     </button>
                                                  </td>
                                                </tr>
                                               @endforeach   
                                               </tbody>
                                            </table>
                                             <div>
                                             {{$matterails->links()}}
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

  <!-- /.modal-delete -->
  <div class="modal fade" id="modal-delete">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">{{__('lang.delete')}}</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
               <input type="hidden" wire:model="hId" name="hId">
               <h6>{{ "( ".$thCode." )" . __('lang.do_you_want_to_delete') }}</h6>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="destroy({{$hId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
            </div>
         </div>
      </div>
  </div>

   <!-- /.modal-delete -->
   <div class="modal fade" id="modal-cancle">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
             <h4 class="modal-title">{{__('lang.cancle')}}</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <h6>{{ "( ".$code." )" . __('lang.do_you_want_to_cancle') }}</h6>
          </div>
          <div class="modal-footer justify-content-between">
              <button wire:click="destroy({{$hId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
       </div>
    </div>
</div>

<!-- /.customer-info -->
<div wire:ignore.self class="modal fade" id="modal-cus-info">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
               <h4 class="modal-title"><i class="fas fa-user-alt"></i>{{' ' . __('lang.customer') .' ( '}} @if($cusch==1){{__('lang.sender_info') .' )'}}@else{{__('lang.recieve_info') .' )'}}@endif</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <input wire:model="search_cus" type="text" class="form-control" placeholder="{{__('lang.search')}}">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">       
                  <table class="table table-bordered table-striped">
                    <thead>
                       <tr>
                         <th>{{__('lang.no')}}</th>
                         <th>{{__('lang.code')}}</th>
                         <th>{{__('lang.name')}}</th>
                         <th>{{__('lang.phone')}}</th>
                         <th>{{__('lang.choose')}}</th>
                       </tr>
                   </thead>
                   <tbody>
                    @php
                    $stt = 1;    
                    @endphp
                    @foreach ($customers as $item)
                       <tr>
                         <td>{{$stt++}}</td>
                         <td>{{$item->code}}</td>
                         <td>{{$item->name}}</td>
                         <td>{{$item->phone}}</td>
                         <td>
                             <button wire:click="get_cus({{$item->id}},{{$cusch}})" type="button" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('lang.choose')}} ">
                             <i class="fas fa-forward"></i></button>
                         </td>
                       </tr>
                    @endforeach                    
                    </tbody>
                  </table>
                  <div>
                  {{$customers->links()}}
                  </div>
               </div>
              </div>
            </div>
         </div>
       </div>
        <div class="modal-footer justify-content-left">
             <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> {{__('lang.close')}}</button>
        </div>
   </div>
</div>
</div>

<!-- /.modal-add customer -->
<div wire:ignore.self class="modal fade" id="modal-add-customer-send">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.add')}}{{__('lang.sender')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <form>
        <input wire:model="code_cus_send" type="hidden" class="form-control">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.customername')}}{{__('lang.sender')}}</label>
                  <input wire:model="namesend" type="text" class="form-control @error('namesend') is-invalid @enderror" autofocus>
                  @error('namesend') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6" >
              <div class="form-group">
                  <label>{{__('lang.custype')}}</label>
                  <select wire:model="cus_type_id_send" class="form-control @error('cus_type_id_send') is-invalid @enderror">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($customertypes as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('cus_type_id_send') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.phone')}}</label>
                  <input wire:model="phonesend" type="text" class="form-control  @error('phonesend') is-invalid @enderror">
                  @error('phonesend') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.bod')}}</label>
                  <input wire:model="bodsend" type="date" class="form-control ">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.note')}}</label>
                  <input wire:model="notesend" type="text" class="form-control">
              </div>
            </div>
          </div>

        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="storeCustomerSend" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

<div wire:ignore.self class="modal fade" id="modal-add-customer">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.add')}}{{__('lang.receiver')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <form>
        <input wire:model="code_cus" type="hidden" class="form-control">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.customername')}}{{__('lang.receiver')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6" >
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
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.phone')}}</label>
                  <input wire:model="phone" type="text" class="form-control  @error('phone') is-invalid @enderror">
                  @error('phone') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.bod')}}</label>
                  <input wire:model="bod" type="date" class="form-control ">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.note')}}</label>
                  <input wire:model="note" type="text" class="form-control">
              </div>
            </div>
          </div>
        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="storeCustomerReceive" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>



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
  window.addEventListener('show-modal-add-customer-send', event => {
      $('#modal-add-customer-send').modal('show');
  })
  window.addEventListener('hide-modal-add-customer-send', event => {
      $('#modal-add-customer-send').modal('hide');
  })
  window.addEventListener('show-modal-add-customer', event => {
      $('#modal-add-customer').modal('show');
  })
  window.addEventListener('hide-modal-add-customer', event => {
      $('#modal-add-customer').modal('hide');
  })
</script>

<script>
    $(document).ready(function() {
      $('#selectBranch').select2();
      $('#selectBranch').on('change', function (e) {
          var data = $('#selectBranch').select2("val");
          @this.set('branch_id', data);
      });

      $('#selectProvince').select2();
      $('#selectProvince').on('change', function (e) {
          var data = $('#selectProvince').select2("val");
          @this.set('pro_id', data);
      });
   
      $('#selectDistrict').select2();
      $('#selectDistrict').on('change', function (e) {
          var data = $('#selectDistrict').select2("val");
          @this.set('dis_id', data);
      });

      $('#selectVillage').select2();
      $('#selectVillage').on('change', function (e) {
          var data = $('#selectVillage').select2("val");
          @this.set('vil_id', data);
      });

      $('#pro').select2();
      $('#pro').on('change', function (e) {
          var data = $('#pro').select2("val");
          @this.set('pros_id', data);
      });
   
      $('#dis').select2();
      $('#dis').on('change', function (e) {
          var data = $('#dis').select2("val");
          @this.set('diss_id', data);
      });

      $('#vil').select2();
      $('#vil').on('change', function (e) {
          var data = $('#vil').select2("val");
          @this.set('vils_id', data);
      });
    });



</script>
@endpush