<div>
    <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('lang.employee')}}</b>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.employee')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!--Catalogs -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                  <a wire:click="create" href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{__('lang.add')}}</a>
                </div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr style="text-align: center">
                    <th>{{__('lang.position')}}</th>
                    <th>{{__('lang.action')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($salarytypes as $item)
                    <tr>
                      <td>{{$item->name}}</td>
                      <td>
                        <a href="javascript:void(0)" wire:click="edit({{$item->id}})"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" wire:click="showDestroySalaryType({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>  
                </div>
            </div>
        </div>
        
        <!-- Employee -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-4">
                      <a wire:click="showAddEmployee" href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{__('lang.add')}}</a>{{$search_by_stype}}
                    </div>
                  </div>
                </div>
                <div class="col-md-3"> 
                @if(Auth::user()->branch_id == 1)
                  <select wire:model="branch_search" class="form-control">
                    <option value="0" selected>{{__('lang.select')}}</option>
                      @foreach($allbranch as $item)
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                        @endif
                      @endforeach
                  </select>
                @endif
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
                  <tr style="text-align: center">
                    <th>{{__('lang.first_and_lastname')}}</th>
                    <th>{{__('lang.phone')}}</th>
                    <th>{{__('lang.address')}}</th>
                    <th>{{__('lang.position')}}</th>
                    <th>{{__('lang.branch')}}</th>
                    <th>{{__('lang.action')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php
                    $stt = 1;    
                  @endphp
                  @foreach ($employees as $item)
                  <tr>
                    <td><a href="javascript:void(0)" wire:click="EmployeeDetail({{$item->id}})">{{$item->firstname}} {{$item->lastname}}</a></td>
                    <td><a href="javascript:void(0)" wire:click="EmployeeDetail({{$item->id}})">{{$item->phone}}</a></td>
                    <td>{{$item->address}}</td>
                    <td>{{$item->salaryhname->name}}</td>
                    <td>
                      @if (Config::get('app.locale') == 'lo')
                        <option value="{{ $item->id }}">{{ $item->branchname->company_name_la }}</option>
                      @elseif (Config::get('app.locale') == 'en')
                        <option value="{{ $item->id }}">{{ $item->branchname->company_name_en }}</option>
                      @endif
                    </td>
                    <td style="text-align: center">
                       <a href="javascript:void(0)" wire:click="showEditEmployee({{$item->id}})"><i class="fa fa-edit mr-2"></i></a>
                        <a href="javascript:void(0)" wire:click="showDestroyEmployee({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>

                <div class="d-flex justify-content-between">

                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- /.modal-add SalaryType -->
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
                <label>{{__('lang.position')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
        <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.money')}}</label>
                  <input wire:model="salary" type="text" class="form-control money @error('salary') is-invalid @enderror">
                  @error('salary') <span style="color: red" class="error">{{ $message }}</span> @enderror
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

  <!-- /.modal-edit SalaryType -->
  <div wire:ignore.self class="modal fade" id="modal-edit">
    <div class="modal-dialog">
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
                <label>{{__('lang.position')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.money')}}</label>
                  <input wire:model="salary" type="text" class="form-control money @error('salary') is-invalid @enderror">
                  @error('salary') <span style="color: red" class="error">{{ $message }}</span> @enderror
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

  <!-- /.modal-delete SalaryType-->
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
          <h3>{{__('lang.do_you_want_to_delete')}}</h3>
        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="destroy({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>
<!-- /.modal-add Employee-->
  <div wire:ignore.self class="modal fade" id="modal-add-employee">
    <div class="modal-dialog modal-xl">
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
                <label>{{__('lang.barcode')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.firstname')}}</label>
                  <input wire:model="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" autofocus>
                  @error('firstname') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.lastname')}}</label>
                  <input wire:model="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" autofocus>
                  @error('lastname') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.bod')}}</label>
                  <input wire:model="bod" type="date" class="form-control">
                  @error('bod') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.phone')}}</label>
                  <input wire:model="phone" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-5" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.address')}}</label>
                  <input wire:model="address" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.card_no')}}</label>
                  <input wire:model="card_id" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.card_enddate')}}</label>
                  <input wire:model="card_enddate" type="date" class="form-control">
                  @error('card_enddate') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                  <label>{{__('lang.salary')}}</label>
                  <select wire:model="saraly_type_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($salarytypes as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('saraly_type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.branch')}}</label>
                  <select wire:model="branch_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($allbranch as $item)
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                        @endif
                      @endforeach
                  </select>
                @error('branch_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.start_date')}}</label>
                  <input wire:model="start_date" type="date" class="form-control">
                  @error('start_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.end_date')}}</label>
                  <input wire:model="end_date" type="date" class="form-control">
                  @error('end_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.provincename')}}</label>
                  <select wire:model="pro_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($provinces as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                @error('pro_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.districtname')}}</label>
                  <select wire:model="dis_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($districts as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.villagename')}}</label>
                  <select wire:model="vill_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($villages as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
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

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="storeEmployee" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

<!-- /.modal-edit Employee-->
  <div wire:ignore.self class="modal fade" id="modal-edit-employee">
    <div class="modal-dialog modal-xl">
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
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.barcode')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.firstname')}}</label>
                  <input wire:model="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" autofocus>
                  @error('firstname') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.lastname')}}</label>
                  <input wire:model="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" autofocus>
                  @error('lastname') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.bod')}}</label>
                  <input wire:model="bod" type="date" class="form-control">
                  @error('bod') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.phone')}}</label>
                  <input wire:model="phone" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-5" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.address')}}</label>
                  <input wire:model="address" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.card_no')}}</label>
                  <input wire:model="card_id" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.card_enddate')}}</label>
                  <input wire:model="card_enddate" type="date" class="form-control">
                  @error('card_enddate') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                  <label>{{__('lang.salary')}}</label>
                  <select wire:model="saraly_type_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($salarytypes as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('saraly_type_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.branch')}}</label>
                  <select wire:model="branch_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($allbranch as $item)
                        @if (Config::get('app.locale') == 'lo')
                          <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                        @elseif (Config::get('app.locale') == 'en')
                          <option value="{{ $item->id }}">{{ $item->company_name_en }}</option>
                        @endif
                      @endforeach
                  </select>
                @error('branch_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.start_date')}}</label>
                  <input wire:model="start_date" type="date" class="form-control">
                  @error('start_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.end_date')}}</label>
                  <input wire:model="end_date" type="date" class="form-control">
                  @error('end_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>{{__('lang.provincename')}}</label>
                  <select wire:model="pro_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($provinces as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                @error('pro_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-4">
              @if (count($districts) > 0)
              <div class="form-group">
                <label>{{__('lang.districtname')}}</label>
                  <select wire:model="dis_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($districts as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
              @endif
            </div>
            <div class="col-md-4">
              @if (count($villages) > 0)
              <div class="form-group">
                <label>{{__('lang.villagename')}}</label>
                  <select wire:model="vill_id" class="form-control">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($villages as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                @error('dis_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
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

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="updateEmployee" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

 <!-- /.modal-delete employee-->
  <div class="modal fade" id="modal-delete-employee">
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
          <button wire:click="destroyEmployee({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
  <script>
    //Add SalaryType
    window.addEventListener('show-modal-add', event => {
      $('#modal-add').modal('show');
      $("#modal-add").modal({ backdrop : "static", keyboard: false});
    })
    window.addEventListener('hide-modal-add', event =>{
      $('#modal-add').modal('hide');
    })
    //Edit SalaryType
    window.addEventListener('show-modal-edit', event => {
      $('#modal-edit').modal('show');
    })
    window.addEventListener('hide-modal-edit', event =>{
      $('#modal-edit').modal('hide');
    })
    //Delete SalaryType
    window.addEventListener('show-modal-delete', event => {
      $('#modal-delete').modal('show');
    })
    window.addEventListener('hide-modal-delete', event =>{
      $('#modal-delete').modal('hide');
    })
    //Add Employee
    window.addEventListener('show-modal-add-employee', event => {
      $('#modal-add-employee').modal('show');
    })
    window.addEventListener('hide-modal-add-employee', event => {
      $('#modal-add-employee').modal('hide');
    })
    //Edit Employee
    window.addEventListener('show-modal-edit-employee', event => {
      $('#modal-edit-employee').modal('show');
    })
    window.addEventListener('hide-modal-edit-employee', event => {
      $('#modal-edit-employee').modal('hide');
    })
    //Delete Employee
    window.addEventListener('show-modal-delete-employee', event => {
      $('#modal-delete-employee').modal('show');
    })
    window.addEventListener('hide-modal-delete-employee', event => {
      $('#modal-delete-employee').modal('hide');
    })
  </script>

<script>
  $('.money').simpleMoneyFormat();
  $(document).ready(function() {
      $('#selectEmployee').select2();
      $('#selectEmployee').on('change', function (e) {
          var data = $('#selectEmployee').select2("val");
          @this.set('search_employee', data);
      });
  });
</script>
@endpush
