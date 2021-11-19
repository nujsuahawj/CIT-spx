<div>
    <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('lang.pay_dividend')}}</b>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.pay_dividend')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!--Catalogs -->
        
        <!-- Employee -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-5">

                </div>
                <div class="col-md-4"> 

                </div>
                <div class="col-md-3">
                  <input wire:model="search" type="date" class="form-control">
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr style="text-align: center">
                    <th>{{__('lang.no')}}</th>
                    <th>{{__('lang.date')}}</th>
                    <th>{{__('lang.qty')}}{{__('lang.list')}}</th>
                    <th>{{__('lang.money')}}</th>
                    <th>{{__('lang.dividend')}}</th>
                    <th>{{__('lang.vat')}}</th>
                    <th>{{__('lang.amount')}}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @php $stt = 1; @endphp
                    @foreach($pay as $item)
                        <tr>
                            <td>{{$stt++}}</td>
                            <td style="text-align: center">{{date('d/m/Y', strtotime($item->created_at))}}</td>
                            <td style="text-align: center">{{$item->count}}</td>
                            <td style="text-align: right">{{number_format($item->amount)}}</td>
                            <td style="text-align: center">{{$item->devidend}}</td>
                            <td style="text-align: center">{{$item->vat}}</td>
                            <td style="text-align: right">{{number_format($item->money)}}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>

                <div class="d-flex justify-content-between">
                {{$pay->links()}}
                </div>

              </div>
            </div>
          </div>
        </div>
      </div> <!-- End row -->

    <div class="row">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @if(!empty(auth()->user()->branchname->dividend_id))
                  <a wire:click="devidend" href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fa fa-credit-card"></i> {{__('lang.pay_devide_branch')}}</a>
                  @endif
                  @if(!empty($hiddenId))
                  <a wire:click="showreport({{$hiddenId}})" href="javascript:void(0)" class="btn btn-warning btn-sm"><i class="fa fa-file-pdf"></i> {{__('lang.report')}}{{__('lang.pay_devide_branch')}}</a>
                  @endif
                </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                    <thead>
                    <tr style="text-align: center">
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.code')}}</th>
                          <th>{{__('lang.goods_type')}}</th>
                          <th>{{__('lang.product_type')}}</th>
                          <th>{{__('lang.weigh')}}</th>
                          <th>{{__('lang.amount')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $stt = 1; @endphp
                        @foreach($mat as $item)
                            <tr>
                                <td>{{$stt++}}</td>
                                <td>{{$item->code}}</td>
                                <td>{{$item->goodname->name}}</td>
                                <td>{{$item->productname->name}}</td>
                                <td>{{$item->weigh}}</td>
                                <td>{{number_format($item->amount)}}</td>
                            </tr>    
                        @endforeach
                        <tr>
                            <td colspan="4" style="text-align: right"><h4><b>{{__('lang.amount')}} :</b></h4></td>
                            <td colspan="5" style="text-align: right"><h4><b>{{number_format($sum_mat)}} {{__('lang.lak')}}</b></h4></td>
                        </tr>
                    </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                    {{$mat->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> <!-- End row -->
    </div>
  </section>

 
</div>

@push('scripts')
  <script>

  </script>

<script>

</script>
@endpush
