<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.branch')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.branch')}}</li>
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
                        <tr>
                            <th>{{__('lang.no')}}</th>
                            <th>{{__('lang.logo')}}</th>
                            <th>{{__('lang.code')}}</th>
                            <th>{{__('lang.company_name')}}</th>
                            <th>{{__('lang.address')}}</th>
                            <th>{{__('lang.phone')}}</th>
                            <th>{{__('lang.branch_type')}}</th>
                            <th>{{__('lang.dividend')}}</th>
                            <th>{{__('lang.tax')}}</th>
                            <th>{{__('lang.status')}}</th>
                            <th >{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($branch as $item)
                        <tr>
                          <td style="text-align: center">{{$stt++}}</td>
                          <td style="text-align: center"><img src="{{asset($item->logo)}}" height="50"></td>
                          <td style="text-align: center">{{$item->code}}</td>
                          <td>
                            @if ( Config::get('app.locale') == 'lo')
                                {{$item->company_name_la}}
                            @elseif ( Config::get('app.locale') == 'en' )
                                {{$item->company_name_en}}
                            @endif
                          </td>
                          <td>
                            @if ( Config::get('app.locale') == 'lo')
                                {{$item->address_la}}
                            @elseif ( Config::get('app.locale') == 'en' )
                                {{$item->address_en}}
                            @endif
                          </td>
                          <td style="text-align: center">{{$item->phone}}</td>
                          <td style="text-align: center">
                            @if (!empty($item->branch_type_id))
                                {{$item->branchtypename->name}}
                            @endif
                          </td>
                          <td style="text-align: center">
                            @if (!empty($item->dividend_id))
                                {{$item->dividendname->percent}}
                            @endif
                          </td>
                          <td style="text-align: center">
                            @if (!empty($item->tax_id))
                                {{$item->taxname->percent}}
                            @endif
                          </td>
                          <td style="text-align: center">
                            @if ($item->active == 0)
                            <div class="btn btn-danger btn-xs"> {{__('blog.inactive')}} </div>
                            @else
                             <div class="btn btn-success btn-xs"> {{__('blog.active')}} </div>
                            @endif
                          </td>
                          <td style="text-align: center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                </button>
                                <div class="dropdown-menu" role="menu">
                                        @csrf
                                        @method('DELETE')
                                            <a class="dropdown-item" href="{{ route('branch.edit', $item->id) }}" ><i class="fas fa-info-circle text-info"></i> {{__('lang.edit')}}</a>
                                            <a class="dropdown-item" onclick="confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?') || event.stopImmediatePropagation()" wire:click="delete({{$item->id}})"><i class="fas fa fa-times-circle text-danger"></i> {{__('lang.delete')}}</a>
                                 </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
  
                    <div class="float-right">
                      {{$branch->links()}}
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
  
  