<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <b>{{__('lang.purchase')}}</b>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.purchase')}}</li>
              </ol>
            </div>
          </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-4">
                      <a href="{{route('admin.purchase.create')}}"><i class="fa fa-plus"></i></a>
                      @if(Auth::user()->rolename->name == 'admin')
                      <a href=""><i class="fa fa-trash ml-3"></i></a>
                      @endif
                    </div>

                    <div class="col-md-2" wire:ignore>
                      @if(Auth::user()->branch_id == '1')
                        <div class="form-group">
                          <select wire:model="search_branch" id="selectBranch" class="form-control">
                            <option value="" selected>{{__('lang.select')}}</option>
                              @foreach($all_branch as $item)
                                  <option value="{{ $item->id }}">{{ $item->company_name_la }}</option>
                              @endforeach
                          </select>
                        </div>
                      @endif
                    </div>
                    
                    <div class="col-md-2">
                      <input wire:model="search_date" type="date" class="form-control">
                    </div>

                    <div class="col-md-2" wire:ignore>
                      <div class="form-group">
                        <select wire:model="search_member" id="selectMember" class="form-control">
                          <option value="" selected>{{__('lang.select')}}</option>
                            @foreach($all_member as $item)
                                <option value="{{ $item->id }}">{{ $item->firstname }} {{ $item->lastname }} {{ $item->phone }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                        <select wire:model="search_by_approve" class="form-control">
                          <option value="" selected>{{__('lang.select')}}</option>
                          <option value="0">{{__('lang.not_approve')}}</option>
                          <option value="1">{{__('lang.approved')}}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                      <tr style="text-align: center">
                        <th>{{__('lang.code')}}</th>
                        <th>{{__('lang.date')}}</th>
                        <th>{{__('lang.member_name')}}</th>
                        <th>{{__('lang.address')}}</th>
                        <th>{{__('lang.total_amount')}}</th>
                        <th>{{__('lang.total_paid')}}</th>
                        <th>{{__('lang.total_overdue')}}</th>
                        <th>{{__('lang.payment')}}</th>
                        <th>{{__('lang.creator')}}</th>
                        <th>{{__('lang.status')}}</th>
                        <th>{{__('lang.branch')}}</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                        $stt = 1;    
                      @endphp
    
                      @foreach ($purchase as $item)
                        <tr>
                            <td><a href="">{{$item->code}}</a></td>
                            <td style="text-align: center"><a href="">{{date('d/m/Y h:m:s', strtotime($item->created_at))}}</a></td>
                            <td><a href="">{{$item->membername->firstname}} {{$item->membername->lastname}}</a></td>
                            <td><a href="">{{$item->membername->villagename->name}}, {{$item->membername->districtname->name}}, {{$item->membername->provincename->name}}</a></td>
                            <td style="text-align: right">{{number_format($item->grand_total)}}</td>
                            <td style="text-align: center; color: blue"">{{number_format($item->paid)}}</td>
                            <td style="text-align: center; color: red">{{number_format($item->debit)}}</td>
                            <td style="text-align: center">
                              @if($item->payment_id == 1)
                                {{$item->paymentname->name}}
                              @else
                                {{$item->paymentname->name}}
                              @endif
                            </td>
                            <td style="text-align: center">{{$item->username->name}}</td>
                            <td style="text-align: center">
                              @if ($item->approve_status == 0)
                                  <label class="text-danger">{{__('lang.not_approve')}}
                              @else
                                  <label class="text-success">{{__('lang.approved')}}</label>
                              @endif
                            </td>
                            <td style="text-align: center">{{$item->branch_id}}</td>
                            <td width="2%" style="text-align: center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="" target="_blank"><i class="fas fa-print text-primary"> {{__('lang.printbill')}}</i></a>
                                    <a class="dropdown-item" href=""><i class="fas fa-info-circle text-info"> {{__('lang.detail')}}</i></a>
                                    @if(Auth::user()->rolename->name == 'admin')
                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="showdestroySale({{$item->id}})"><i class="fas fa-trash text-danger"> {{__('lang.delete')}}</i></a>
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

    <!-- /.delete Sale -->
    <div class="modal fade" id="modal-delete-sale">
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
              <button wire:click="destroySale({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
            </div>
          </div>
        </div>
      </div>

</div>

@push('scripts')
    <script>
      window.addEventListener('show-modal-delete-sale', event => {
        $('#modal-delete-sale').modal('show')
      })
      window.addEventListener('hide-modal-delete-sale', event => {
        $('#modal-delete-sale').modal('hide')
      })
    </script>
    <script>
      $(document).ready(function() {
          $('#selectMember').select2();
          $('#selectMember').on('change', function (e) {
              var data = $('#selectMember').select2("val");
              @this.set('search_member', data);
          });
          $('#selectBranch').select2();
          $('#selectBranch').on('change', function (e) {
              var data = $('#selectBranch').select2("val");
              @this.set('search_branch', data);
          });
      });
    </script>
@endpush