<div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('lang.customer')}}</b>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.customer')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!--customers -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-6">
                      <a wire:click="showAddContract" class="btn btn-primary" href="javascript:void(0)"><i class="fa fa-plus"></i> {{__('lang.add')}}</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3" wire:ignore> 
                @if(Auth::user()->branch_id == 1)
                  <select wire:model="branch_search" class="form-control" id="selectBranchSearch">
                    <option value="0" selected>{{__('lang.select')}}</option>
                      @foreach($branch as $item)
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                        @endif
                      @endforeach
                  </select>
                @endif
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
                  <tr style="text-align: center">
                    <th>{{__('lang.no')}}</th>
                    <th>{{__('lang.code')}}</th>
                    <th>{{__('lang.name')}}{{__('lang.branch')}}</th>
                    <th>{{__('lang.branch_type')}}</th>
                    <th>{{__('lang.money')}}</th>
                    <th>{{__('lang.start_date')}}</th>
                    <th>{{__('lang.end_date')}}</th>
                    <th>{{__('lang.status')}}</th>
                    <th>{{__('lang.action')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php $stt = 1; @endphp
                  @foreach($unit_contract as $item)
                    <tr>
                        <td style="text-align: center">{{$stt++}}</td>
                        <td style="text-align: center">{{$item->code}}</td>
                        <td style="text-align: center">
                            @if (Config::get('app.locale') == 'lo')
                                {{ $item->branchname->company_name_la }}
                            @elseif (Config::get('app.locale') == 'en')
                                {{ $item->branchname->company_name_en }}
                            @endif
                        </td>
                        <td style="text-align: center">{{$item->branchtypename->name}}</td>
                        <td style="text-align: right">{{number_format($item->amount)}}</td>
                        <td style="text-align: center">{{date('d/m/Y',strtotime($item->start_date))}}</td>
                        <td style="text-align: center">{{date('d/m/Y',strtotime($item->end_date))}}</td>
                        <td style="text-align: center">
                            @if($item->status == 0)
                                <div class="btn btn-warning btn-xs">{{__('lang.inactive')}}</div>
                            @else
                                <div class="btn btn-success btn-xs">{{__('lang.active')}}</div>
                            @endif
                        </td>
                        <td style="text-align: center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                  @if(!empty($item->file))
                                  <a class="dropdown-item" href="{{route('admin.download_contract', $item->id)}}"><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                  @endif
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="showEdit({{$item->id}})"><i class="fas fa-edit text-warning"> {{__('lang.edit')}}</i></a>
                                  @if(auth()->user()->rolename->name == 'admin')
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="showDestroyContract({{$item->id}})"><i class="fas fa-trash text-danger"> {{__('lang.delete')}}</i></a>
                                  @endif
                                  </div>
                                </div>
                        </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>

                <div class="d-flex justify-content-between">
                  
                  {{__('lang.total_contract')}}: {{__('lang.items')}}
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- /.modal-add contract -->
  <div wire:ignore.self class="modal fade" id="modal-add-contract">
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
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.code')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4"  wire:ignore>
              <div class="form-group">
                <label>{{__('lang.branch')}}</label>
                    <select wire:model="unit_id" class="form-control" id="selectUnit">
                        <option value="" selected>{{__('lang.select')}}{{__('lang.branch')}}</option>
                        @foreach($branch as $item)
                            @if (Config::get('app.locale') == 'lo')
                            <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                            @elseif (Config::get('app.locale') == 'en')
                            <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                            @endif
                        @endforeach
                    </select>
                  @error('unit_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" wire:ignore>
                <label>{{__('lang.branch_type')}}</label>
                    <select wire:model="unit_type_id" class="form-control" id="selectUnitType">
                        <option value="" selected>{{__('lang.select')}}{{__('lang.branch_type')}}</option>
                        @foreach($branch_type as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                  @error('unit_type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div> <!-- End Col -->
          </div> <!-- End Row -->

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.start_date')}}</label>
                    <input wire:model="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror">
                    @error('start_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.end_date')}}</label>
                    <input wire:model="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror">
                    @error('end_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.file')}}</label>
                    <input wire:model="file" type="file" class="form-control money @error('file') is-invalid @enderror">
                    @error('file') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.money')}}</label>
                    <input wire:model="money" type="text" class="form-control money @error('money') is-invalid @enderror">
                    @error('money') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
         
         <div class="row">
          <div class="col-md-12" >
            <hr>
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
          <button wire:click="saveContract" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-edit Customer -->
  <div wire:ignore.self class="modal fade" id="modal-edit-contract">
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
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.code')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4"  wire:ignore>
              <div class="form-group">
                <label>{{__('lang.branch')}}</label>
                    <select wire:model="unit_id" class="form-control">
                        <option value="" selected>{{__('lang.select')}}{{__('lang.branch')}}</option>
                        @foreach($branch as $item)
                            @if (Config::get('app.locale') == 'lo')
                            <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                            @elseif (Config::get('app.locale') == 'en')
                            <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                            @endif
                        @endforeach
                    </select>
                  @error('unit_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" wire:ignore>
                <label>{{__('lang.branch_type')}}</label>
                    <select wire:model="unit_type_id" class="form-control">
                        <option value="" selected>{{__('lang.select')}}{{__('lang.branch_type')}}</option>
                        @foreach($branch_type as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                  @error('unit_type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div> <!-- End Col -->
          </div> <!-- End Row -->

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.start_date')}}</label>
                    <input wire:model="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror">
                    @error('start_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.end_date')}}</label>
                    <input wire:model="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror">
                    @error('end_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.file')}}</label>
                    <input wire:model="file" type="file" accept="application/pdf, image/png, image/gif, image/jpeg"class="form-control money @error('file') is-invalid @enderror">
                    @error('file') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>{{__('lang.money')}}</label>
                    <input wire:model="money" type="text" class="form-control money @error('money') is-invalid @enderror">
                    @error('money') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.status')}}</label>
                    <select wire:model="status" class="form-control">
                        <option value="" selected>{{__('lang.select')}}{{__('lang.status')}}</option>
                        <option value="0">{{__('lang.inactive')}}</option>
                        <option value="1">{{__('lang.active')}}</option>
                    </select>
              </div>
            </div>
          </div>
         
         <div class="row">
          <div class="col-md-12" >
            <hr>
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
          <button wire:click="updateContract" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-delete contract-->
  <div class="modal fade" id="modal-delete-contract">
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
          <h4 style="color: red">{{$code}}</h4>
        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="destroyContract({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>
 

</div>

@push('scripts')
  <script>
    //Add contract
    window.addEventListener('show-modal-add-contract', event => {
      $('#modal-add-contract').modal('show');
    })
    window.addEventListener('hide-modal-add-contract', event => {
      $('#modal-add-contract').modal('hide');
    })
    //Edit contract
    window.addEventListener('show-modal-edit-contract', event => {
      $('#modal-edit-contract').modal('show');
    })
    window.addEventListener('hide-modal-edit-contract', event => {
      $('#modal-edit-contract').modal('hide');
    })
    //Delete contract
    window.addEventListener('show-modal-delete-contract', event => {
      $('#modal-delete-contract').modal('show');
    })
    window.addEventListener('hide-modal-delete-contract', event => {
      $('#modal-delete-contract').modal('hide');
    })
  </script>

  <script type="text/javascript">
    $('.money').simpleMoneyFormat();

    $(document).ready(function() {
      $('#selectBranchSearch').select2();
      $('#selectBranchSearch').on('change', function (e) {
          var data = $('#selectBranchSearch').select2("val");
          @this.set('branch_search', data);
      });

      $('#selectUnit').select2();
      $('#selectUnit').on('change', function (e) {
          var data = $('#selectUnit').select2("val");
          @this.set('unit_id', data);
      });

      $('#selectUnitType').select2();
      $('#selectUnitType').on('change', function (e) {
          var data = $('#selectUnitType').select2("val");
          @this.set('unit_type_id', data);
      });
    });
     
  </script>
@endpush
