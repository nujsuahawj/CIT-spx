<div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <b>{{__('lang.cal_price')}}</b>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
              <li class="breadcrumb-item active">{{__('lang.cal_price')}}</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
  
          <!--distance -->
          <div class="col-md-3">
              <div class="card">
                  <div class="card-header">
                    <div class="col-md-12 "> 
                      <a wire:click="create(1)" class="btn btn-primary"  href="javascript:void(0)"><i class="fa fa-plus"></i>{{__('lang.add')}}</a>
                      <label> <u><h5>{{__('lang.distance_setting')}}</h5></u></label>
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- Sidebar Menu -->
                  <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                      @foreach ($distance as $item)
                        <li class="nav-item menu-open">
                          <div class="d-flex justify-content-between">
                            <a class="nav-link">{{$item->name}}</a>
                            
                            <div>
                              @if($item->status==1)<span class="badge rounded-pill bg-success">{{__('lang.enable')}}</span>@else<span class="badge rounded-pill bg-warning">{{__('lang.disable')}}</span>@endif
                              <a href="javascript:void(0)" wire:click="edit({{$item->id}},{{1}})"><i class="fa fa-edit"></i></a>
                              <a href="javascript:void(0)" wire:click="showDestroyCustomerType({{$item->id}},{{1}})"><i class="fa fa-trash text-danger"></i></a>
                            </div>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </nav>
    
                  </div>
              </div>
               <!-- calculate_type -->
              <div class="card">
                <div class="card-header">
                 <!-- <a wire:click="create(2)" class="btn btn-primary"  href="javascript:void(0)"><i class="fa fa-plus" hidden></i>{{__('lang.add')}}</a> -->
                 
                </div>
                <div class="card-body">
                  <!-- Sidebar Menu -->
                <nav>
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                    @foreach ($calculateType as $item)
                      <li class="nav-item menu-open">
                        <div class="d-flex justify-content-between">
                          <a class="nav-link">{{$item->name}}</a>
                          
                          <div>
                            @if($item->status==1)<span class="badge rounded-pill bg-success">{{__('lang.enable')}}</span>@else<span class="badge rounded-pill bg-warning">{{__('lang.disable')}}</span>@endif
                            <a href="javascript:void(0)" wire:click="edit({{$item->id}},{{2}})"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" wire:click="showDestroyCustomerType({{$item->id}},{{2}})"><i class="fa fa-trash text-danger"></i></a>
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
                        <a wire:click="showAddCalculatePrice" class="btn btn-primary" href="javascript:void(0)"><i class="fa fa-plus"></i>{{__('lang.add')}}</a>
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 text-left"> 
                    <label> <u><h4>{{__('lang.price_setting')}}</h4></u></label>
                  </div>

                  <div class="col-md-6">
                    <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')." - ".__('lang.name')." - ". __('lang.function')}}">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr style="text-align: center">
                      <th>{{__('lang.name')}}</th>
                      <th>{{__('lang.distance')}}</th>
                      <th>{{__('lang.function')}}</th>
                      <th>{{__('lang.caltypename')}}</th>
                      <th>{{__('lang.min<=')}}</th>
                      <th>{{__('lang.<max')}}</th>
                      <th>{{__('lang.currency')}}</th>
                      <th>{{__('lang.price')}}</th>
                      <th>{{__('lang.status')}}</th>
                      <th>{{__('lang.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $stt = 1;    
                    @endphp
  
                    @foreach ($calculateprice as $item)
                    <tr>
                      <td>{{$item->name}}</td>
                      <td>{{$item->distname}}</td>
                      <td>{{$item->funcname}}</td>
                      <td>{{$item->caltypename}}</td>
                      <td style="text-align: right">{{($item->min_val)}}</td>
                      <td style="text-align: right">{{number_format($item->max_val)}}</td>
                      <td style="text-align: right">{{($item->currency_code)}}</td>
                      <td style="text-align: right">{{(number_format($item->price))}}</td>
                      <td style="text-align: right"> @if($item->status==1)<span class="badge rounded-pill bg-success">{{__('lang.enable')}}</span>
                        @else<span class="badge rounded-pill bg-warning">{{__('lang.disable')}}</span>@endif</td>
                      <td style="text-align: center">
                          <a href="javascript:void(0)" wire:click="showEditCalculate({{$item->id}})"><i class="fa fa-edit mr-2"></i></a>
                          <a href="javascript:void(0)" wire:click="showDestroyCalculate({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                      </td>
                    </tr>
                    @endforeach
                    
                    </tbody>
                  </table>
  
                  <div class="d-flex justify-content-between">
                    {{$calculateprice->links()}}
                  </div>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  
    <!-- /.modal-add distance,calculatetype -->
    <div wire:ignore.self class="modal fade" id="modal-add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.add'). " - "}} @if($headname==1) {{__('lang.distance')}} @else {{__('lang.calculator_type')}} @endif</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
  
            <form>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.name')}}</label>
                    <input wire:model="name" type="text" class="form-control  @error('name') is-invalid @enderror">
                    @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.type')}}</label>
                          <select wire:model="locate" class="form-control" >
                            <option value="" selected>{{__('lang.select')}}</option>
                              @foreach($location as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                          </select>
                          @error('locate') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                  <label>{{__('lang.status')}}</label>
              </div>
            </div>

            <div class="row">
              <div class="form-group clearfix">
                <div class="icheck-success d-inline col-md-2">
                  <input   type="radio" name="radio1"  id="radioSuccess1"  value="1"  wire:model="status">
                  <label for="radioSuccess1">{{__('lang.enable')}}</label>
                </div>
                <div class="icheck-warning d-inline col-md-2">
                  <input  type="radio" name="radio1" id="radioSuccess2" value="0"  wire:model="status">
                  <label for="radioSuccess2">{{__('lang.disable')}}</label>
                </div>
                @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
  
          </form>
  
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="store({{$headname}})" type="button" class="btn btn-success">{{__('lang.save')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  
    <!-- /.modal-edit distance, calculatetype -->
    <div wire:ignore.self class="modal fade" id="modal-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{__('lang.edit'). " - "}} @if($headname==1) {{__('lang.distance')}}@else{{__('lang.calculate_type')}} @endif</h4>
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
                  <label>{{__('lang.name')}}</label>
                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                    @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.type')}}</label>
                          <select wire:model="locate" class="form-control" >
                            <option value="" selected>{{__('lang.select')}}</option>
                              @foreach($location as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                          </select>
                          @error('locate') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
  
            <div class="row">
              <div class="col-md-12">
                  <label>{{__('lang.status')}}</label>
              </div>
            </div>

            <div class="row">
              <div class="form-group clearfix">
                <div class="icheck-success d-inline col-md-2">
                  <input   type="radio" name="radio1"  id="radioSuccess1"  value="1"  wire:model="status">
                  <label for="radioSuccess1">{{__('lang.enable')}}</label>
                </div>
                <div class="icheck-warning d-inline col-md-2">
                  <input  type="radio" name="radio1" id="radioSuccess2" value="0"  wire:model="status">
                  <label for="radioSuccess2">{{__('lang.disable')}}</label>
                </div>
                @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </form>
  
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="update({{$headname}})" type="button" class="btn btn-success">{{__('lang.save')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  
    <!-- /.modal-delete distance, calculatetype-->
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
            <button wire:click="destroy({{$hiddenId}},{{$headname}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  
  
  <!-- /.modal-add calculate price -->
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
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.name')}}</label>
                    <input wire:model="calname" type="text" class="form-control @error('calname') is-invalid @enderror">
                    @error('calname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-sm-8 callout callout-info text-center"  style="padding:0px">
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
                  @error('func') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                  <label>{{__('lang.distance')}}</label>  
                    <select wire:model="dist_id" class="form-control" {{$disabled2}}>
                      <option value="" selected>{{__('lang.select')}}</option>
                        @foreach($distance as $item)
                           <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('dist_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>

   
            </div>
  
            <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>{{__('lang.type')}}</label>  
                        <select wire:model="caltype" class="form-control" {{$disabled1}}>
                          <option value="" selected>{{__('lang.select')}}</option>
                            @foreach($calculateType as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('caltype') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>{{__('lang.min<=')}}</label>
                        <input wire:model="min_val" type="number" class="form-control  @error('min_val') is-invalid @enderror" {{$disabled2}}>
                        @error('min_val') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>{{__('lang.<max')}}</label>
                        <input wire:model="max_val" type="number" class="form-control @error('max_val') is-invalid @enderror" {{$disabled3}}>
                        @error('max_val') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                  </div>
            </div>
            <div class="row">
              <div class="col-md-12" >
                <hr>
              </div>
           </div>
            <div class="row">   
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>{{__('lang.price')}} LAK:</label>
                        <input wire:model="pricelak" type="number" class="form-control @error('pricelak') is-invalid @enderror text-right" >
                        @error('pricelak') <span style="color: red" class="error ">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>{{__('lang.price')}} THB:</label>
                        <input wire:model="pricethb" type="number" class="form-control @error('pricethb') is-invalid @enderror text-right">
                        @error('pricethb') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>{{__('lang.price')}} USD:</label>
                        <input wire:model="priceusd" type="number" class="form-control @error('priceusd') is-invalid @enderror text-right">
                        @error('priceusd') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                  </div>    
            </div>
           
            <div class="row">
              <div class="col-md-12" >
                <hr>
              </div> 
           </div>

           <div class="row">
              <div class="form-group clearfix">
                <div class="icheck-success d-inline col-md-2">
                  <input   type="radio" name="radio1"  id="radioSuccess1"  value="1"  wire:model="status">
                  <label for="radioSuccess1">{{__('lang.enable')}}</label>
                </div>
                <div class="icheck-warning d-inline col-md-2">
                  <input  type="radio" name="radio1" id="radioSuccess2" value="0"  wire:model="status">
                  <label for="radioSuccess2">{{__('lang.disable')}}</label>
                </div>
                @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
          </div>

          </form>
  
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="storeCalculatePrice" type="button" class="btn btn-success">{{__('lang.save')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  
    <!-- /.modal-edit calculate -->
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
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.name')}}</label>
                      <input wire:model="calname" type="text" class="form-control @error('calname') is-invalid @enderror">
                      @error('calname') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

             <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>{{__('lang.distance')}}</label>  
                      <select wire:model="dist_id" class="form-control" >
                        <option value="" selected>{{__('lang.select')}}</option>
                          @foreach($distance as $item)
                             <option value="{{ $item->id }}">{{ $item->name }}</option>
                          @endforeach
                      </select>
                      @error('dist_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="col-sm-8 callout callout-info text-center"  style="padding:0px">
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
                    @error('func') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                 </div>
               
              </div>
    
              <div class="row">
                  <div class="col-md-4">
                      <div class="form-group">
                            <label>{{__('lang.type')}}</label>  
                              <select wire:model="caltype" class="form-control" {{$disabled1}}>
                              <option value="" selected>{{__('lang.select')}}</option>
                              @foreach($calculateType as $item)
                             <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                           </select>
                          @error('caltype') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                  </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>{{__('lang.min<=')}}</label>
                      <input wire:model="min_val" type="number" class="form-control  @error('min_val') is-invalid @enderror" {{$disabled2}}>
                      @error('min_val') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>{{__('lang.<max')}}</label>
                      <input wire:model="max_val" type="number" class="form-control @error('max_val') is-invalid @enderror" {{$disabled3}}>
                      @error('max_val') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12" >
                  <hr>
                </div>
             </div>
              <div class="row">   
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>{{__('lang.price')}} LAK:</label>
                          <input wire:model="pricelak" type="number" class="form-control @error('pricelak') is-invalid @enderror text-right" >
                          @error('pricelak') <span style="color: red" class="error ">{{ $message }}</span> @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>{{__('lang.price')}} THB:</label>
                          <input wire:model="pricethb" type="number" class="form-control @error('pricethb') is-invalid @enderror text-right">
                          @error('pricethb') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>{{__('lang.price')}} USD:</label>
                          <input wire:model="priceusd" type="number" class="form-control @error('priceusd') is-invalid @enderror text-right">
                          @error('priceusd') <span style="color: red" class="error">{{ $message }}</span> @enderror
                      </div>
                    </div>    
              </div>
             
              <div class="row">
                <div class="col-md-12" >
                  <hr>
                </div> 
             </div>
  
             <div class="row">
                <div class="form-group clearfix">
                  <div class="icheck-success d-inline col-md-2">
                    <input   type="radio" name="radio1"  id="radioSuccess1"  value="1"  wire:model="status">
                    <label for="radioSuccess1">{{__('lang.enable')}}</label>
                  </div>
                  <div class="icheck-warning d-inline col-md-2">
                    <input  type="radio" name="radio1" id="radioSuccess2" value="0"  wire:model="status">
                    <label for="radioSuccess2">{{__('lang.disable')}}</label>
                  </div>
                  @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
  
            </form>
             
          </div>
          <div class="modal-footer justify-content-between">
            <button wire:click="updateCalculate" type="button" class="btn btn-success">{{__('lang.save')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  
    <!-- /.modal-delete calculate-->
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
            <button wire:click="destroyCalculate({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
          </div>
        </div>
      </div>
    </div>
   
  
  </div>
  
  @push('scripts')
    <script>
      //Add distance,cal_type
      window.addEventListener('show-modal-add', event => {
        $('#modal-add').modal('show');
        $("#modal-add").modal({ backdrop : "static", keyboard: false});
      })
      window.addEventListener('hide-modal-add', event =>{
        $('#modal-add').modal('hide');
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
  
      //Add cal_price
      window.addEventListener('show-modal-add-customer', event => {
        $('#modal-add-customer').modal('show');
      })
      window.addEventListener('hide-modal-add-customer', event => {
        $('#modal-add-customer').modal('hide');
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
  