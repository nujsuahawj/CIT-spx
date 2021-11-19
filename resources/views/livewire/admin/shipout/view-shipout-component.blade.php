<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.shipout_goods')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.shipout_goods')}}</li>
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
                      <a href="{{route('admin.create_shipout')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> {{__('lang.create')}}</a>
                      <a href="{{route('admin.sub_shipout')}}" class="btn btn-info btn-sm"><i class="fas fa-list-ol"></i> {{__('lang.sub_list')}}</a>
                    </div>
                    <div class="col-md-6">
                      
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
                          <th>{{__('lang.traffic')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>{{__('lang.creator_data')}}</th>
                          <th>{{__('lang.branch')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        @foreach ($shipout as $item)
                          <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$item->code}}</td>
                            <td>{{$item->trafficname->trf_code}}</td>
                            <td>{{date('d/m/Y h:i:s', strtotime($item->create_date))}}</td>
                            <td>{{$item->username->name}}</td>
                            <td>
                              @if ( Config::get('app.locale') == 'lo')
                                  {{$item->branchname->company_name_la}}
                              @elseif ( Config::get('app.locale') == 'en' )
                                  {{$item->branchname->company_name_en}}
                              @endif
                            </td>
                            <td width="2%" style="text-align: center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="editShipout({{$item->id}})"><i class="fas fa-pencil-alt text-warning"> {{__('lang.edit')}}</i></a>
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="logisticDetail({{$item->id}})"><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="showDestroy({{$item->id}})"><i class="fas fa-trash text-danger"> {{__('lang.delete')}}</i></a>
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
                      <input type="hidden" wire:model="hiddenIdLgt">
                          <h5><p style="color: blue">{{__('lang.do_you_want_to_delete')}}</p></h5>
                          <h4><i class="text-danger"><b>{{$code}}</b></i></h4>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button wire:click="destroy({{$hiddenIdLgt}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
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
      window.addEventListener('hide-modal-delete', event=>{
        $('#modalDelete').modal('hide');
      })
    </script>
  @endpush
  
  