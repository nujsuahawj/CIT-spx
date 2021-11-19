<div>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('lang.separate_goods_report')}}</b>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.separate_goods_report')}}</li>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                <div class="form-group" wire:ignore>   
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-info">{{__('lang.vihicle_traffic')}}</button>
                                        </div>
                                        <select wire:model.defer="vhcl_id" class="form-control" id="selectvhcl">
                                            <option value="">{{__('lang.select')}}</option>
                                            @foreach($traff_vhcl as $item)
                                            <option value="{{ $item->id }}">{{ $item->vihiclename->name }} {{$item->vihiclename->plate_number}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> <!-- end form group -->
                                </div> <!-- end div-col -->
                                <div class="col-md-3">
                                    <div class="form-group" wire:ignore>
                                        <select wire:model="condition" class="form-control" >
                                        <option value="" selected>{{__('lang.select_condition')}}</option>
                                                <option value="0">{{__('lang.<max')}}</option>
                                                <option value="1">{{__('lang.min<=')}}</option>
                                        </select>
                                    </div>
                                </div><!-- end div-col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="number" wire:model="search" class="form-control" placeholder="{{__('lang.weigh')}}">
                                    </div>
                                </div><!-- end div-col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button class="btn btn-info" id="print"><i class="fas fa-print"></i> {{__('lang.print')}}</button>
                                    </div>
                                </div><!-- end div-col -->
                            </div><!-- end div-row -->

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="right_content">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h4>{{__('lang.hearder-title1')}}</h4>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h4>{{__('lang.hearder-title2')}}</h4>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h4>-----------*****----------</h4>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <img src="{{asset('images/logo2.png')}}" alt="" width="70%">
                                            </div>
                                            <div class="col-6 text-right" ><br>
                                                <h4>{{__('lang.print_date')}}: {{date('d/m/Y h:i:s', time())}}</h4>
                                                <h4>
                                                        @if (Config::get('app.locale') == 'lo')
                                                        {{__('lang.branch')}}: {{ auth()->user()->branchname->company_name_la }}
                                                        @elseif (Config::get('app.locale') == 'en')
                                                        {{__('lang.branch')}}: {{ auth()->user()->branchname->company_name_en }}
                                                        @endif
                                                </h4>
                                                <h4>{{__('lang.mobile')}}: {{auth()->user()->branchname->phone}}</h4>            
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <h3><b><u>{{__('lang.separate_goods_report')}}</u></b></h3>
                                            </div>
                                        </div> <!-- end row -->
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                    <th>{{__('lang.no')}}</th>
                                                    <th>{{__('lang.code')}}</th>
                                                    <th>{{__('lang.goods_type')}}</th>
                                                    <th>{{__('lang.product_type')}}</th>
                                                    <th>{{__('lang.large')}}(cm)</th>
                                                    <th>{{__('lang.height')}}(cm)</th>
                                                    <th>{{__('lang.longs')}}(cm)</th>
                                                    <th>{{__('lang.weigh')}}(kg)</th>
                                                    <th>{{__('lang.to')}}{{__('lang.branch')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php $stt = 1; @endphp
                                                @foreach ($mat as $item)
                                                <tr>
                                                  <td>{{$stt++}}</td>
                                                  <td>{{$item->rvcode}}</td>
                                                  <td>{{$item->goodname->name}}</td>
                                                  <td>{{$item->productname->name}}</td>
                                                  <td>{{$item->large}}</td>
                                                  <td>{{$item->height}}</td>
                                                  <td>{{$item->longs}}</td>
                                                  <td>{{$item->weigh}}</td>
                                                  @if (Config::get('app.locale') == 'lo')
                                                  <td>{{$item->logisdetailname->sendto->company_name_la}}</td>
                                                  @elseif (Config::get('app.locale') == 'en')
                                                  <td>{{$item->logisdetailname->sendto->company_name_en}}</td>
                                                  @endif
                                                </tr>
                                               @endforeach 
                                                </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div>    <!-- end right content -->

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

    $(document).ready(function() {
      $('#selectvhcl').select2();
      $('#selectvhcl').on('change', function (e) {
          var data = $('#selectvhcl').select2("val");
          @this.set('vhcl_id', data);
      });
    });

$('#print').click(function(){
   
        printDiv();
        function printDiv() {
        var printContents = $(".right_content").html();
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    location.reload();
 });
</script>
@endpush
