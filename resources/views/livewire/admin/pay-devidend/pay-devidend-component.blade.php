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
                <thead style="font-weight:normal;">
                                <tr>
                                  <th>CODE</th>
                                  <th>{{__('lang.code')}}{{__('lang.bill_receive')}}</th>
                                  <th >{{__('lang.date')}}</th>
                                  <th>{{__('lang.acno')}}</th>
                                  <th >{{__('lang.acname')}}</th>
                                  <th >{{__('lang.amount')}}</th>
                                  <th >{{__('lang.descs')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($myarray as $item) 
                                <tr>
                                  <td>{{$item->txcode}}</td>
                                  <td>{{$item->vcode}}</td>
                                  <td>{{date('d/m/Y',strtotime($item->valuedt))}}</td>
                                  <td>{{$item->acno}}</td>
                                  <td >{{$item->acname}}</td>
                                  <td >{{$item->action}} {{number_format($item->amount,2,",",".")}}</td>
                                  <td >{{$item->descs}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                  <td colspan="4" style="text-align: right;"><b>{{__('lang.sum')}} :</b></td>
                                  <td colspan="2" style="text-align: right;"><b>{{number_format($sum_myarray)}} {{__('lang.lak')}}</b></td>
                                </tr>
                              </tbody>
                </table>

                <div class="d-flex justify-content-between">
                {{$myarray->links()}}
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
