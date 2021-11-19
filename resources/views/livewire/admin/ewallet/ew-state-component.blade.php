<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.statement')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.statement')}}</li>
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
                    <div class="col-md-4">
                            <div class="form-group" wire:ignore>   
                                <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-info">{{__('lang.account')}}</button>
                                </div>
                                    <select wire:model.defer="acno" class="form-control acc">
                                      <option value="">{{__('lang.select')}}</option>
                                      @foreach ($bran as $item)
                                          <option value="{{$item->acno}}">{{$item->acno.'-'.$item->acname}}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- /.form-group -->
                <!-- /.form-group -->
                    </div>
                    <div class="col-md-2">
                            <div class="form-group" wire:ignore>   
                                <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-info">{{__('lang.from_date')}}</button>
                                </div>
                                    <input wire:model.defer="frdt" type="date"  class="form-control datetimepicker-input  @error('frdt') is-invalid @enderror"  data-target="#reservationdate">
                                </div>
                                @error('frdt') <span style="color: red" class="error">{{ $message }}</span> @enderror
                            </div>
                    </div>
                    <div class="col-md-2">
                            <div class="form-group" wire:ignore>   
                                <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-info">{{__('lang.to_date')}}</button>
                                </div>
                                    <input wire:model.defer="todt" type="date" class="form-control  datetimepicker-input  @error('todt') is-invalid @enderror"  data-target="#reservationdatetime" >
                                </div>
                                @error('todt') <span style="color: red" class="error">{{ $message }}</span> @enderror
                            </div>
                      </div>
                      <div class="col-md-3">
                        <button wire:click="search()" class=" btn btn-primary">{{__('lang.search')}}</button>
                      </div>
                  </div>
                </div>
               
                <div class="card-body">
                  <div class="row">
                    <div class='col-md-4'>
                        <div class="row">
                          <div class="col-md-3 text-right">
                            <label>{{__('lang.acno')}}:</label>  
                          </div>
                          <div class="col-md-6 text-left">
                            <label>{{$vacno}}</label>  
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 text-right">
                            <label>{{__('lang.acname')}}:</label>  
                          </div>
                          <div class="col-md-6 text-left">
                            <label>{{$vname}}</label>  
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 text-right">
                            <label>{{__('lang.branch')}}:</label>  
                          </div>
                          <div class="col-md-6 text-left">
                            <label>{{$vbr}}</label>  
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 text-right">
                            <label>{{__('lang.balance')}}:</label>  
                          </div>
                          <div class="col-md-6 text-left">
                            <label>{{$bal}}</label>  
                          </div>
                        </div>
                    </div>
                     
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>CODE</th>
                          <th>{{__('lang.ref')}}</th>
                          <th>{{__('lang.action')}}</th>
                          <th>{{__('lang.amount')}}</th>
                          <th>{{__('lang.ending')}}</th>
                          <th>{{__('lang.description')}}</th>
                          <th>{{__('lang.user_create')}}</th>

                        </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan="6" class="text-right"><h5><u>ຍອດຍົກມາ</u></h5></td>
                            <td class="text-right"><h5>{{number_format($opnbal,2,",",".") }}</h5></td>
                            <td ></td>
                            <td ></td>
                          </tr>
                          @php
                               $enbal = 0;   
                               $i=0; 
                          @endphp
                          @foreach ($myarray as $item)
                          <tr>
                             <td>{{$i=$i+1}}</td>
                             <td>{{$item->valuedt}}</td>
                             <td>{{$item->txcode}}</td>
                             <td>{{$item->trcode}}</td>
                             <td>{{$item->action}}</td>
                             <td class="text-right">{{number_format($item->amount,2,",",".")}}</td>
                             <td class="text-right">
                               @if($item->action=='+')
                                 {{number_format($enbal=$enbal+$item->amount,2,",",".") }}          
                               @else
                                 {{number_format($enbal=$enbal-$item->amount,2,",",".") }} 
                               @endif
                             </td>
                             <td>{{$item->descs}}</td>
                             <td>{{$item->name}}</td>
                          </tr>
                          @endforeach
                          <tr>
                            <td colspan="6" class="text-right"><h5><u>ຍອດເຫຼືອທ້າຍ</u></h5></td>
                            <td class="text-right"><h5>
                                 @if($i==0)
                                     {{number_format($opnbal,2,",",".")}}
                                 @else
                                     {{number_format($enbal,2,",",".")}}
                                 @endif
                                 </h5>
                            </td>
                            <td ></td>
                            <td ></td>
                          </tr>
                        </tbody>
                    </table>
                    <div>
                      
                    </div>
                    <div>
                
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

      $('.acc').select2();
      $('.acc').on('change', function (e) {
          var data = $('.acc').select2("val");
          @this.set('acno', data);
      });

       //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    });
    // DropzoneJS Demo Code End
  </script>

  @endpush
  
  
  
