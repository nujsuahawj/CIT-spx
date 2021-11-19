<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.customertype')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.customertype')}}</li>
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
                                <label>{{__('lang.customertype')}}</label>
                                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('lang.customertype')}}">
                                @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>

                              <div class="form-group">
                                <label>{{__('lang.parent_id')}}</label>
                                <input wire:model="parent_id" type="number" class="form-control" placeholder="{{__('lang.parent_id')}}">
                              </div>

                              <div class="form-group">
                                <label>{{__('lang.status')}}: </label>
                                <label class="radio"><input type="radio"  wire:model="status"  name="status" value="1" /> {{__('lang.enable')}}  </label>
                                <label class="radio"><input type="radio" wire:model="status"  name="status" value="0"  />  {{__('lang.disable')}} </label>
                                @error('status') <span style="color: red" class="error">{{ $message }}</span> @enderror
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
                      <label>{{__('lang.customertype')}}</label>
                    </div>
                    <div class="col-md-6">
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
                          <th>{{__('lang.Parent_id')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($customertype as $item)
                        <tr>
                          <td>{{$stt++}}</td>
                          <td>{{$item->name}}</td>
                          <td>{{$item->parent_id}}</td>
                          <td>@if($item->status==1)<span class="badge bg-success">{{__('lang.enable')}}</span>@else<span class="badge bg-warning">{{__('lang.disable')}}</span>@endif</td>
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
                      {{$customertype->links()}}
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

