<div>
 <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                    <a href="{{route('admin.create_payroll')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{__('lang.add')}}</a>
                  </div>
                  <div class="col-md-2" wire:ignore>
                    @if(Auth()->user()->rolename->name == 'admin')
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
                  <div class="col-md-4">
                    <input type="text" wire:model="search" class="form-control" placeholder="{{__('lang.code')}}">
                  </div>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                      <thead>
                        <tr style="text-align: center">
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.month')}}-{{__('lang.year')}}</th>
                          <th>{{__('lang.total_salary')}}</th>
                          <th>{{__('lang.total_bonus')}}</th>
                          <th>{{__('lang.branchname')}}</th>
                          <th>{{__('lang.status')}}</th>
                          <th>{{__('lang.creator')}}</th>
                          @if(Auth()->user()->rolename->name == 'admin')
                          <th>{{__('lang.action')}}</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $stt = 1;    
                        @endphp
                        @foreach ($payroll as $item)
                        <tr>
                          <td align="center">{{$stt++}}</td>
                          <td style="text-align: center"><a  href="javascript:void(0)" wire:click="payrollDetail({{$item->id}})">{{$item->month}}/{{$item->year}}</a></td>
                          <td style="text-align: right"><b><a  href="javascript:void(0)" wire:click="payrollDetail({{$item->id}})">{{number_format($item->total_salary)}}</a></b></td>
                          <td style="text-align: right"><b><a  href="javascript:void(0)" wire:click="payrollDetail({{$item->id}})">{{number_format($item->total_bonus)}}</a></b></td>
                          <td style="text-align: center">
                            @if ( Config::get('app.locale') == 'lo')
                                {{$item->branchname->company_name_la}}
                            @elseif ( Config::get('app.locale') == 'en' )
                                {{$item->branchname->company_name_en}}
                            @endif
                          </td>
                          <td>@if($item->del == 0)<i class="text-warning"><b>{{__('lang.not_approve')}}<b></i>@else <i class="text-success"><b>{{__('lang.approved')}}</b></i>@endif</td>
                          <td style="text-align: center">{{$item->approvedname->name}}</td>
                          @if(Auth()->user()->rolename->name == 'admin')
                          <td width="2%" style="text-align: center">
                              <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  @if($item->del == 0)
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="approved({{$item->id}})"><i class="fas fa-star text-success"> {{__('lang.approve')}}</i></a>
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="editPayroll({{$item->id}})"><i class="fas fa-pencil-alt text-warning"> {{__('lang.edit')}}</i></a>@endif
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="payrollDetail({{$item->id}})"><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="printA4Payroll({{$item->id}})"><i class="fas fa-print text-primary"> {{__('lang.printa4')}}</i></a>
                                  @if($item->del == 0)
                                  <a class="dropdown-item" href="javascript:void(0)" wire:click="showDelete({{$item->id}})"><i class="fas fa-trash text-danger"> {{__('lang.delete')}}</i></a>@endif
                                </div>
                              </div>
                          </td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                  </table>

               
                </div>
              </div>
            </div>
        </div>
      </div>

      <!--Modal Delete Product From List -->
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
                      <input type="hidden" wire:model="hidenId">
                      <div class="row">
                          <h5><p style="color: red">{{__('lang.do_you_want_to_delete_your_data_will_delete_all')}}</p></h5>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button wire:click="deletePayroll" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
                      <button type="button" class="btn btn-info" data-dismiss="modal">{{__('lang.cancel')}}</button>
                  </div>
          </div>
        </div>
      </div>

    </div>
</section>

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

    <script>
      $(document).ready(function() {
          $('#selectMonth').select2();
          $('#selectMonth').on('change', function (e) {
              var data = $('#selectMonth').select2("val");
              @this.set('month', data);
          });
      });
    </script>
@endpush

