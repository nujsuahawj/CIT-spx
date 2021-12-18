<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.user')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.user')}}</li>
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
                    <div class="col-md-9">
                      <label><a  class="btn btn-primary btn-sm" href="{{route('branch.create')}}">{{__('lang.create')}}</a></label>
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
                            <th>{{__('lang.image')}}</th>
                            <th>{{__('lang.firstname')}} {{__('lang.and')}} {{__('lang.lastname')}}</th>
                            <th>{{__('lang.phone')}}</th>
                            <th>{{__('lang.address')}}</th>
                            <th>{{__('lang.email')}}</th>
                            <th>{{__('lang.branch')}}</th>
                            <th>{{__('lang.rolename')}}</th>
                            <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($user as $item)
                        <tr>
                          <td style="text-align: center">{{$stt++}}</td>
                          <td style="text-align: center"><img src="{{asset($item->image)}}" height="50"></td>
                          <td>{{$item->name}}</td>
                          <td>{{$item->phone}}</td>
                          <td>{{$item->address}}</td>
                          <td>{{$item->email}}</td>
                          <td>
                            @if (!empty($item->branch_id))
                              {{$item->branchname->company_name_la}}
                            @endif
                          </td>
                          <td>
                            @if (!empty($item->role_id))
                              {{$item->rolename->name}}
                            @endif
                          </td>
                          <td style="text-align: center">
                            <div class="btn-group">
                              <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                              </button>
                              <div class="dropdown-menu" role="menu">
                                @if(Auth()->user()->rolename->name == 'admin')
                                    @csrf
                                    @method('DELETE')
                                    @if ($item->rolename->name != 'admin')
                                      <a class="dropdown-item" href="{{ route('user.edit', $item->id) }}" ><i class="fas fa-info-circle text-info"></i>{{__('lang.edit')}}</a>
                                      <a class="dropdown-item" onclick="confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?') || event.stopImmediatePropagation()" wire:click="delete({{$item->id}})"><i class="fas fa fa-times-circle text-danger"></i> {{__('lang.delete')}}</a>
                                    @else
                                    <a class="dropdown-item" href="{{ route('user.edit', $item->id) }}" ><i class="fas fa-info-circle text-info"></i>{{__('lang.edit')}}</a>
                                    @endif
                                @endif
                              </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
  
                    <div class="float-right">
                      {{$user->links()}}
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </section>
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
  
  