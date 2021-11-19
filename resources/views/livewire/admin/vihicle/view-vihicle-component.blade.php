<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.vihicle')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.vihicle')}}</li>
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
                    <div class="col-md-6">
                      <a wire:click="create" href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{__('lang.add')}}</a>
                    </div>
                    <div class="col-md-3">
                      <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                    </div>
                    <div class="col-md-3">
                      <select wire:model.defer="search_by_brc" class="form-control @error('branch_id') is-invalid @enderror">
                        <option value="">{{__('lang.select')}}</option>
                      @foreach($vihicletype as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
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
                          <th>{{__('lang.name')}}</th>
                          <th>{{__('lang.type')}}</th>
                          <th>{{__('lang.plate')}}</th>
                          <th>{{__('lang.series')}}</th>
                          <th>{{__('lang.power')}}</th>
                          <th>{{__('lang.road_fee_date')}}</th>
                          <th>{{__('lang.technic_date')}}</th>
                          
                          <th>{{__('lang.note')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($vihicle as $item)
                        <tr>
                          <td>{{$stt++}}</td>
                          <td>{{$item->code}}</td>
                          <td>{{$item->name}}</td>
                          <td>{{$item->vihicletypename->name}}</td>
                          <td>{{$item->plate_number}}</td>
                          <td>{{$item->series_number}}</td>
                          <td >{{$item->power_number}}</td>
                          <td>{{$item->road_fee_date}}</td>
                          <td>{{$item->technic_date}}</td>
                          
                          <td>{{$item->note}}</td>
                          <td>{{$item->vihicletypename->status}}</td>
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
                      {{$vihicle->links()}}
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>

    <!-- /.modal-add -->
      <div wire:ignore.self class="modal fade" id="modal-add">
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
                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__('lang.code')}}</label>
                      <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                      @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{__('lang.name')}}</label>
                      <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                      @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-3" >
                  <div class="form-group">
                      <label>{{__('lang.type')}}</label>
                      <select wire:model="vihicletypename" class="form-control @error('vihicletypename') is-invalid @enderror">
                        <option value="" selected>{{__('lang.select')}}</option>
                          @foreach($vihicletype as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                          @endforeach
                      </select>
                      @error('vihicletypename') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__('lang.plate')}}</label>
                      <input wire:model="plate" type="text" class="form-control  @error('plate') is-invalid @enderror">
                      @error('plate') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6" wire:ignore>
                  <div class="form-group">
                    <label>{{__('lang.series')}}</label>
                      <input wire:model="series" type="text" class="form-control ">
                  </div>
                </div>
                <div class="col-md-3" wire:ignore>
                  <div class="form-group">
                    <label>{{__('lang.power')}}</label>
                      <input wire:model="power" type="text" class="form-control ">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{__('lang.road_fee_date')}}</label>
                      <input wire:model="road_fee_date" type="date" class="form-control  @error('road_fee_date') is-invalid @enderror">
                      @error('road_fee_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6" wire:ignore>
                  <div class="form-group">
                    <label>{{__('lang.technic_date')}}</label>
                      <input wire:model="technic_date" type="date" class="form-control ">
                  </div>
                </div>
              </div>  
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.note')}}</label>
                    <input wire:model="note" type="text" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.select_image')}}</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input wire:model="image" type="file" class="custom-file-input" accept="image/png, image/gif, image/jpeg">
                    <label class="custom-file-label">{{__('lang.select')}}</label>
                  </div>
                </div>
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" height="100" width="100">
                @endif
              </div>
            </div>
        </div>
            </form>      
            <div class="modal-footer justify-content-between">
              <button wire:click="store" type="button" class="btn btn-success">{{__('lang.save')}}</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
            </div>

          </div>
        </div>
      </div>

          <!-- /.modal-edit -->
      <div wire:ignore.self class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{__('lang.edit')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}"> 
            <form>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__('lang.code')}}</label>
                      <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                      @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{__('lang.name')}}</label>
                      <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                      @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-3" >
                  <div class="form-group">
                      <label>{{__('lang.type')}}</label>
                      <select wire:model="vihicletypename" class="form-control @error('vihicletypename') is-invalid @enderror">
                        <option value="" selected>{{__('lang.select')}}</option>
                          @foreach($vihicletype as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                          @endforeach
                      </select>
                      @error('vihicletypename') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__('lang.plate')}}</label>
                      <input wire:model="plate" type="text" class="form-control  @error('plate') is-invalid @enderror">
                      @error('plate') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6" wire:ignore>
                  <div class="form-group">
                    <label>{{__('lang.series')}}</label>
                      <input wire:model="series" type="text" class="form-control ">
                  </div>
                </div>
                <div class="col-md-3" wire:ignore>
                  <div class="form-group">
                    <label>{{__('lang.power')}}</label>
                      <input wire:model="power" type="text" class="form-control ">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{__('lang.road_fee_date')}}</label>
                      <input wire:model="road_fee_date" type="date" class="form-control  @error('road_fee_date') is-invalid @enderror">
                      @error('road_fee_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6" wire:ignore>
                  <div class="form-group">
                    <label>{{__('lang.technic_date')}}</label>
                      <input wire:model="technic_date" type="date" class="form-control ">
                  </div>
                </div>
              </div>  

              <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.note')}}</label>
                    <input wire:model="note" type="text" class="form-control">
                </div>
              </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.select_image')}}</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input wire:model="image" type="file" class="custom-file-input" accept="image/png, image/gif, image/jpeg">
                    <label class="custom-file-label">{{__('lang.select')}}</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" height="100" width="100">
                @endif
              </div>
            </div>

              </div>
            </form>      

            <div class="modal-footer justify-content-between">
              <button wire:click="update" type="button" class="btn btn-success">{{__('lang.save')}}</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
            </div>

          </div>
        </div>
      </div>

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
              <h3>{{__('lang.do_you_want_to_delete') }}</h3>
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
      window.addEventListener('show-modal-add', event => {
          $('#modal-add').modal('show');
      })
      window.addEventListener('hide-modal-add', event => {
          $('#modal-add').modal('hide');
      })
      window.addEventListener('show-modal-edit', event => {
          $('#modal-edit').modal('show');
      })
      window.addEventListener('hide-modal-edit', event => {
          $('#modal-edit').modal('hide');
      })
      window.addEventListener('show-modal-delete', event => {
          $('#modal-delete').modal('show');
      })
      window.addEventListener('hide-modal-delete', event => {
          $('#modal-delete').modal('hide');
      })
    </script>
  @endpush
  
  