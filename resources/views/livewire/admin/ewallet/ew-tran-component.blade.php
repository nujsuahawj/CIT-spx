<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.Transaction')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.Transaction')}}</li>
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
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.ref')}}</th>
                          <th>TXCODE</th>
                          <th>{{__('lang.ref-code')}}1</th>
                          <th>{{__('lang.currency')}}</th>
                          <th>{{__('lang.amount')}}</th>
                          <th>{{__('lang.branch')}}</th>
                          <th>{{__('lang.created_at')}}</th>
                          <th>{{__('lang.description')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($ewtran as $item)
                        <tr>
                          <td>{{$stt++}}</td>
                          <td>
                            @if($item->status == 'N')
                              <div ><i class="fa fa-check" style="color:green" aria-hidden="true"></i></div>
                            @elseif($item->status == 'R')
                              <div><i class="fa fa-times" style="color:red" aria-hidden="true"></i></div>
                            @elseif($item->status == 'P')
                              <div><i class="fa fa-commenting-o" style="color: orange" aria-hidden="true"></i> </div>
                            @endif
                          </td>
                          <td>{{$item->txid}}</td>
                          <td>{{$item->txcode}}</td>
                          <td>{{$item->code1}}</td>
                          <td>{{$item->currency_code}}</td>
                          <td>{{number_format($item->amount1,2,",",".")}}</td>
                          <td>{{$item->name_la}}</td>
                          <td>{{$item->ucname}}</td>
                          <td>{{$item->descs}}</td>
                          <td>{{$item->created_at}}</td>
                          <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="detail('{{$item->txid}}')"><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                    @if(Auth()->user()->rolename->name == 'admin' && $item->status == 'N' && $item->txcode=='ECIN')
                                      <a class="dropdown-item" href="javascript:void(0)" wire:click="showdestoy('{{$item->txid}}')"><i class="fas fa-trash text-danger"> {{__('lang.revert')}}</i></a>
                                    @endif
                                    </div>
                                  </div>
                          </td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
  
                    <div>
                      {{$ewtran->links()}}
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>
  
 
   

        <!-- /.modal-delete account-->
        <div class="modal fade" id="modal-delete">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{__('lang.revert').__('lang.transaction')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
                <h3>{{__('lang.do_you_want_to_delete')}}{{$ac}}</h3>
              </div>
              <div class="modal-footer justify-content-between">
                <button wire:click="destroy('{{$ac}}')" type="button" class="btn btn-danger">{{__('lang.revert')}}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
              </div>
            </div>
          </div>
        </div>


        <!-- /.modal-detail-->
        <div class="modal fade" id="modal-detail">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{__('lang.trandeatail')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
       
              <div class="modal-body">
                <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">
                    <div class="row">       
                          <div class="col-md-4 text-center">
                            <h4>{{__('lang.ref')}} :</h4>
                          </div>
                          <div class="col-md-8 text-left">
                            <h4 class="text-primary">{{$tcod}} - {{$tid}}</h4>
                          </div>
                              
                    </div>             
                      <hr>

                    <div class="row">
                          <div class="col-md-2 text-right">
                            <label>{{__('lang.amount')}}(1):</label>
                          </div>
                          <div class="col-md-4 text-left">
                              <label>{{number_format($tam1,2,",",".")}} </label>
                          </div>         
                          <div class="col-md-2 text-right">
                              <label>{{__('lang.ref')}}(1):</label>
                          </div>
                          <div class="col-md-4 text-left">
                              <label>{{$tcode1}} </label>
                          </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-2 text-right">
                          <label>{{__('lang.amount')}}(2):</label>
                        </div>
                        <div class="col-md-4 text-left">
                            <label>{{number_format($tam2,2,",",".")}} </label>
                        </div>         
                        <div class="col-md-2 text-right">
                            <label>{{__('lang.ref')}}(2):</label>
                        </div>
                        <div class="col-md-4 text-left">
                            <label>{{$tcode2}}</label>
                        </div> 
                    </div>
                    <div class="row">
                      <div class="col-md-2 text-right">
                        <label>{{__('lang.amount')}}(3):</label>
                      </div>
                      <div class="col-md-4 text-left">
                          <label>{{number_format($tam3,2,",",".")}} </label>
                      </div>         
                      <div class="col-md-2 text-right">
                          <label>{{__('lang.ref')}}(3):</label>
                      </div>
                      <div class="col-md-4 text-left">
                          <label>{{$tcode3}}</label>
                      </div> 
                  </div>

                  <div class="row">
                    <div class="col-md-2 text-right">
                      <label>{{__('lang.date_create')}}:</label>
                    </div>
                    <div class="col-md-4 text-left">
                        <label>{{$tcrdt}}</label>
                    </div>         
                    <div class="col-md-2 text-right">
                        <label>{{__('lang.user_create')}}:</label>
                    </div>
                    <div class="col-md-4 text-left">
                        <label>{{$usc}}</label>
                    </div> 
                </div>
                <div class="row">
                  <div class="col-md-2 text-right">
                    <label>{{__('lang.date_revert')}}:</label>
                  </div>
                  <div class="col-md-4 text-left">
                      <label class="text-danger">{{$dtr}}</label>
                  </div>         
                  <div class="col-md-2 text-right">
                      <label >{{__('lang.user_revert')}}:</label>
                  </div>
                  <div class="col-md-4 text-left">
                      <label class="text-danger">{{$usr}}</label>
                  </div> 
               </div>
               <div class="row">
                      <div class="col-md-2 text-right">
                        <label>{{__('lang.branch_create')}}:</label>
                      </div>
                      <div class="col-md-4 text-left">
                          <label>{{$brc}}</label>
                      </div>         
                      <div class="col-md-2 text-right">
                          <label>{{__('lang.satus')}}:</label>
                      </div>
                      <div class="col-md-4 text-left">
                          <label class="@if($sta=='N') text-success @else text-danger @endif">{{$sta}}</label>
                      </div> 
                </div>
                <div class="row">
                  <div class="col-md-2 text-right">
                    <label>{{__('lang.description')}}:</label>
                  </div>
                  <div class="col-md-10 text-left">
                    <label class="text-primary">{{$descs}}</label>
                  </div>
                </div>

                  <div class="row">
                      <div class="card col-md-12">
                          <div class="card-header">
                            <h5 class="card-title">Statement:</h5>
                          </div>
                          <div class="card-body p-0">
                            <table class="table table-sm">
                              <thead style="font-weight:normal;">
                                <tr>
                                  <th>CODE</th>
                                  <th>{{__('lang.acno')}}</th>
                                  <th >{{__('lang.acname')}}</th>
                                  <th >{{__('lang.amount')}}</th>
                                  <th >{{__('lang.descs')}}</th>
                                  <th >{{__('lang.status')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($myarray as $item) 
                                <tr>
                                  <td>{{$item->txcode}}</td>
                                  <td>{{$item->acno}}</td>
                                  <td >{{$item->acname}}</td>
                                  <td >{{$item->action}} {{number_format($item->amount,2,",",".")}}</td>
                                  <td >{{$item->descs}}</td>
                                  <td ><label class="@if($item->status=='R') badge bg-danger @else badge bg-success @endif">{{$item->status}}</label></td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>    
                          </div>
                      </div>
                  </div>
                


              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
              </div>
            </div>
          </div>
        </div>



  </div>
  
  @push('scripts')
  <script>
   
    //revert Tran
    window.addEventListener('show-modal-delete', event => {
      $('#modal-delete').modal('show');
    })
    window.addEventListener('hide-modal-delete', event =>{
      $('#modal-delete').modal('hide');
    })

    window.addEventListener('show-modal-detail', event => {
      $('#modal-detail').modal('show');
    })
    window.addEventListener('hide-modal-detail', event =>{
      $('#modal-detail').modal('hide');
    })

  </script>

  <script type="text/javascript">
    $('.money').simpleMoneyFormat();


    $("#dist").select2({ dropdownParent: "#modal-add-customer" });?
  


    
  </script>
@endpush
  
  
  