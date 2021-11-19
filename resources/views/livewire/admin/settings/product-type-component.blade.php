<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.product_type')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.product_type')}}</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            
            <!--Foram add new-->
            <div class="col-md-4">
              <div class="card card-default">

                <div class="card-header">
                  <label>{{__('lang.add')}}</label>
                </div>
        
                <form>

                    <div class="card-body">

                        <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>{{__('lang.product_type')}}</label>
                                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('lang.product_type')}}">
                                @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>

                              <div class="form-group" >
                                <label>{{__('lang.goods_type')}}</label>
                                <select wire:model="goods_id" class="form-control">
                                  <option value="" selected>{{__('lang.select')}}</option>
                                    @foreach($goodstype as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('goods_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>

                              <div class="form-group"  >
                                <input wire:model="parent_id" type="hidden" class="form-control"  placeholder="{{__('lang.parent_id')}}"  value="0">
                                @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>

                              <div class="col-sm-12 callout callout-info"  style="padding-bottom:1px">
                                <label><u>{{__('lang.function')}}</u></label>
                                <div class="form-group clearfix ">
                                  <div class="icheck-primary d-inline ">
                                    <input   type="radio" name="func"  id="radioSuccessf1"  value="CP"  wire:model="func">
                                    <label for="radioSuccessf1">{{__('lang.compare')}}</label>
                                  </div>
                                  <div class="icheck-primary d-inline col-md-2">
                                    <input  type="radio" name="func" id="radioSuccessf2" value="FX"  wire:model="func">
                                    <label for="radioSuccessf2">{{__('lang.fixed')}}</label>
                                  </div>
                                  <div class="icheck-primary d-inline col-md-2">
                                    <input  type="radio" name="func" id="radioSuccessf3" value="PU"  wire:model="func">
                                    <label for="radioSuccessf3">{{__('lang.perunit')}}</label>
                                  </div>                                  
                                </div>
                                @error('func') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                  
                                <div class="form-group" >
                                  <label>{{__('lang.caltype')}}</label>
                                  <select wire:model="caltype" class="form-control" {{$disabled}}>
                                    <option value="" selected>{{__('lang.select')}}</option>
                                      @foreach($calfunc as $item)
                                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                                      @endforeach
                                  </select>
                                  @error('caltype') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                               </div>

                               

                              <div class="row">
                                <div class="form-group">
                                  <label>{{__('lang.status')}} :</label>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group clearfix">
                                  <div class="icheck-info d-inline col-md-2">
                                    <input wire:model="status" type="radio" name="status"  id="radioSuccess1"  value="1"  >
                                    <label for="radioSuccess1">{{__('lang.enable')}}</label>
                                  </div>
                                  <div class="icheck-warning d-inline col-md-2">
                                    <input  wire:model="status" type="radio" name="status" id="radioSuccess2" value="0"  >
                                    <label for="radioSuccess2">{{__('lang.disable')}}</label>
                                  </div>
                                  @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                              </div>

                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between md-2">
                            <button type="button" wire:click="store" class="btn btn-success">{{__('lang.save')}}</button>
                            <button type="button" wire:click="resetField" class="btn btn-primary">{{__('lang.reset')}}</button>
                        </div>
                    </div>

                </form>
                
              </div>
            </div>

            <!--List users- table table-bordered table-striped -->

            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-6">
                      <label>{{__('lang.goodstype')}}</label>
                    </div>

                     <div class="col-md-3">           
                        <select wire:model="goods_search" class="form-control">
                          <option value="0" selected>{{__('lang.select')}}</option>
                            @foreach($goodstype as $item)                         
                                <option value="{{ $item->id }}">{{ $item->name }}</option>       
                            @endforeach
                        </select>             
                      </div>

                    <div class="col-md-3">
                      <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                    </div>
                  </div>

                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.productname')}}</th>
                          <th>{{__('lang.goods_type')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($producttype as $item)
                        <tr>
                          <td>{{$stt++}}</td>
                          <td>{{$item->name}}</td>
                          <td>{{$item->goodsmap->name}}</td>
                          <td>@if($item->status==0) <div class="btn btn-warning btn-xs">{{__('lang.disable')}}</div> @else <div class="btn btn-info btn-xs"> {{__('lang.enable')}} </div>  @endif</td>
                          <td>
                            @if(Auth()->user()->rolename->name == 'admin')
                              <button wire:click="edit({{$item->id}})" type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button>
                              <button wire:click="showDestroy({{$item->id}})" type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>

                    <div>
                      {{$producttype->links()}}
                    </div>

                  </div>
                </div>
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
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" wire:model="hiddenId">
              <h3>{{ "( ".$name." )" . __('lang.do_you_want_to_delete') }}</h3>
            </div>
            <div class="modal-footer justify-content-between">
              <button wire:click="destroy({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
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
    </script>
@endpush

