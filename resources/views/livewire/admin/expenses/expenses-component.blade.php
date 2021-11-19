<div>
  <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('lang.other_income_expenses')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                    <li class="breadcrumb-item active">{{__('lang.other_income_expenses')}}</li>
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
                                  <select wire:model="search_by_stype" class="form-control">
                                    <option value="">{{__('lang.select')}}</option>
                                      <option value="1">{{__('lang.income')}}</option>
                                      <option value="2">{{__('lang.expand')}}</option>
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
                                            <th>{{__('lang.code')}}</th>
                                            <th>{{__('lang.type')}}</th>
                                            <th>{{__('lang.des')}}</th>
                                            <th>{{__('lang.amount')}}</th>
                                            <th>{{__('lang.username')}}</th>
                                            <th>{{__('lang.branch')}}</th>
                                            <th>{{__('lang.created_at')}}</th>
                                            <th>{{__('lang.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @php
                                      $stt = 1;    
                                      @endphp
                                      @foreach ($expenses as $item)
                                      <tr>
                                        <td>{{$stt++}}</td>
                                        <td>{{$item->code}}</td>
                                        <td>@if($item->type_id==1) {{__('lang.income')}} @else {{__('lang.expand')}} @endif</td>
                                        <td>{{$item->des}}</td>
                                        <td>{{number_format($item->amount)}}</td>
                                        <td>{{$item->username->name}}</td>
                                        <td >@if(Config::get('app.locale') == 'lo') 
                                          {{$item->branchname->company_name_la}} 
                                            @elseif (Config::get('app.locale') == 'en') 
                                          {{$item->branchname->company_name_en}}
                                            @endif</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>
                                          @if(Auth()->user()->rolename->name == 'admin')
                                            <button wire:click="edit({{$item->id}})" type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            <button wire:click="showDestroy({{$item->id}})" type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                          @endif
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
  </section>

  <!-- /.modal-add -->
  <div wire:ignore.self class="modal fade" id="modal-add">
        <div class="modal-dialog">
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
                    <label>{{__('lang.code')}}</label>
                      <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                      @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
              </div>
            </div>

              <div class="row"> 
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.type')}}</label>
                    <select wire:model="type_id" class="form-control">
                      <option value="" selected >{{__('lang.select')}}</option>
                        <option value="1">{{__('lang.income')}}</option>
                        <option value="2">{{__('lang.expand')}}</option>                   
                    </select>
                     @error('type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row">
               <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.created_at')}}</label>
                  <input wire:model="created_at" type="date" class="form-control @error('created_at') is-invalid @enderror">
                  @error('created_at') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.amount')}}</label>
                      <input wire:model="amount" type="text" class="form-control money @error('amount') is-invalid @enderror">
                      @error('amount') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.des')}}</label>
                      <input wire:model="des" type="text" class="form-control  @error('des') is-invalid @enderror">
                      @error('des') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>
            </form> 
          </div>
                  
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
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.code')}}</label>
                      <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                      @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
              </div>
            </div>

              <div class="row"> 
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.type')}}</label>
                    <select wire:model="type_id" class="form-control">
                      <option value="" selected >{{__('lang.select')}}</option>
                        <option value="1">{{__('lang.income')}}</option>
                        <option value="2">{{__('lang.expand')}}</option>                   
                    </select>
                     @error('type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row">
               <div class="col-md-12">
                <div class="form-group">
                  <label>{{__('lang.created_at')}}</label>
                  <input wire:model="created_at" type="date" class="form-control @error('created_at') is-invalid @enderror">
                  @error('created_at') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
              </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.amount')}}</label>
                      <input wire:model="amount" type="text" class="form-control money @error('amount') is-invalid @enderror">
                      @error('amount') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__('lang.des')}}</label>
                      <input wire:model="des" type="text" class="form-control  @error('des') is-invalid @enderror">
                      @error('des') <span style="color: red" class="error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>
            </form> 
        </div>
             

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
      $('.money').simpleMoneyFormat();
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
