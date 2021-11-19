<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.traffic')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.traffic')}}</li>
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
                      <label><a href="{{route('admin.create_traffic')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> {{__('lang.create')}}</a></label>
                    </div>
                    <div class="col-md-3">
                      
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">   
                        <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info">{{__('lang.list_traffic')}}</button>
                              </div>
                            <input wire:model="traff_code" wire:keydown.enter="resetTraff" type="text" class="form-control">
                        </div>
                    </div>
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
                          <th>{{__('lang.code')}}</th>
                          <th>{{__('lang.vihicle')}}</th>
                          <th>{{__('lang.start_date')}}</th>
                          <th>{{__('lang.end_date')}}</th>
                          <th>{{__('lang.creator_data')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        @foreach($traffic as $item)
                          <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$item->trf_code}}</td>
                            <td>{{$item->vihiclename->name}} {{$item->vihiclename->plate_number}}</td>
                            <td>{{date('d/m/Y h:i:s', strtotime($item->start_date))}}</td>
                            <td>@if(!empty($item->stop_date)){{date('d/m/Y h:i:s', strtotime($item->stop_date))}}@endif</td>
                            <td>{{$item->username->name}}</td>
                            <td>@if($item->status == 'E') <div class="btn btn-info btn-xs">  {{__('lang.empty')}} </div> @elseif($item->status == 'S') <div class="btn btn-warning btn-xs">  {{__('lang.sending')}} </div> @else <div class="btn btn-success btn-xs">  {{__('lang.send_finish')}} @endif</td>
                            <td>
                              
                              <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="DetailTraffic({{$item->id}})"><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                  @if($item->status != 'S' && $item->status != 'F')
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="editTraffic({{$item->id}})"><i class="fas fa-pencil-alt text-warning"> {{__('lang.edit')}}</i></a>
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="showDelete({{$item->id}})"><i class="fas fa-trash text-danger"> {{__('lang.delete')}}</i></a>
                                  @endif
                                  </div>
                                </div>

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
      </section>

      <!--Modal Delete Traffic From List -->
      <div class="modal fade" id="modalDelete">
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
                          <h5><p style="color: blue">{{__('lang.do_you_want_to_delete')}}</p></h5>
                          <h4><i class="text-danger"><b>{{$trfcode}}</b></i></h4>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button wire:click="deleteTraffic" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
                      <button type="button" class="btn btn-info" data-dismiss="modal">{{__('lang.cancel')}}</button>
                  </div>
          </div>
        </div>
      </div>
  
  </div>
  
  @push('scripts')
    <script>
      window.addEventListener('show-modal-delete', event=>{
        $('#modalDelete').modal('show');
      })
      window.addEventListener('close-modal-delete', event=>{
        $('#modalDelete').modal('hide');
      })
    </script>
  @endpush
  
  