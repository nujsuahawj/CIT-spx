<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.packet')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.packet')}}</li>
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
                    <div class="card-body">
                        <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
                        <div class='row'>
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('lang.code')}}</label>
                                    <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror" placeholder="{{__('lang.code')}}">
                                    @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{__('lang.name')}}</label>
                                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('lang.name')}}">
                                    @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                             </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('lang.larg')}} (Cm)</label>
                                    <input wire:model="largs" type="number" class="form-control @error('largs') is-invalid @enderror" placeholder="{{__('lang.larg')}}">
                                    @error('largs') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                             </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('lang.hiegh')}} (Cm)</label>
                                    <input wire:model="hieghs" type="number" class="form-control @error('hieghs') is-invalid @enderror" placeholder="{{__('lang.hiegh')}}">
                                    @error('hieghs') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                             </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('lang.long')}} (Cm)</label>
                                    <input wire:model="longs" type="number" class="form-control @error('longs') is-invalid @enderror" placeholder="{{__('lang.long')}}">
                                    @error('longs') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('lang.currency')}} (Cm)</label>
                                    <select wire:model="currency" class="form-control">
                                        <option value="" selected>{{__('lang.select')}}</option>
                                        <option value="LAK" selected>{{__('lang.LAK')}}</option>
                                        <option value="THB" selected>{{__('lang.THB')}}</option>
                                        <option value="USD" selected>{{__('lang.USD')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{__('lang.price')}}</label>
                                    <input wire:model="price" type="number" class="form-control @error('price') is-invalid @enderror" placeholder="{{__('lang.price')}}">
                                    @error('price') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                             </div>
                        </div>
                        <div class="row">
                            <label>{{__('lang.status')}}</label>
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
                    <div class="card-footer">
                        <div class="d-flex justify-content-between md-2">
                            <button type="button" wire:click="store" class="btn btn-success">{{__('lang.save')}}</button>
                            <button type="button" wire:click="resetField" class="btn btn-primary">{{__('lang.reset')}}</button>
                        </div>
                    </div>
                </div>
            </div><!--end Foram add new-->

             <!--List users- table table-bordered table-striped -->

             <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                          <div class="col-md-6">
                            <label>{{__('lang.packet')}}</label>
                          </div>
      
                           <div class="col-md-3">           
                              <select wire:model="goods_search" class="form-control">
                                <option value="0" selected>{{__('lang.select')}}</option>
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
                                <th>{{__('lang.name')}}</th>
                                <th>{{__('lang.larg')}}</th>
                                <th>{{__('lang.hiegh')}}</th>
                                <th>{{__('lang.long')}}</th>
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
          
                              @foreach ($packets as $item)
                              <tr>
                                <td>{{$stt++}}</td>
                                <td>{{$item->code}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->largs}}</td>
                                <td>{{$item->hieghs}}</td>
                                <td>{{$item->longs}}</td>
                                <td>{{$item->currency_code}}</td>
                                <td>{{$item->price}}</td>
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
                            {{$packets->links()}}
                          </div>
      
                        </div>
                      </div>

                </div>
             </div>
        </div>
        </div>
    </section>
</div>
