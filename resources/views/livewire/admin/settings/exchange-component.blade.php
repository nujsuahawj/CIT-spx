<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.rate_exchange')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.rate_exchange')}}</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            
            <!--Foram add new-->
            <div class="col-md-4">
              <div class="card card-default">

                <div class="card-header">
                  <label>{{__('lang.add')}}</label>
                </div>
        
                <form>

                    <div class="card-body">

                        <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('lang.date')}}</label>
                                    <input wire:model="ex_date" type="date" class="form-control @error('ex_date') is-invalid @enderror">
                                    @error('ex_date') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('lang.thb')}}</label>
                                    <input wire:model="rate_one" type="text" class="form-control money @error('rate_one') is-invalid @enderror" placeholder="{{__('lang.thb')}}">
                                    @error('rate_one') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>{{__('lang.usd')}}</label>
                                <input wire:model="rate_two" type="text" class="form-control money @error('rate_two') is-invalid @enderror" placeholder="{{__('lang.usd')}}">
                                @error('rate_two') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between md-2">
                            <button type="button" wire:click="store" class="btn btn-success">{{__('lang.save')}}</button>
                            <button type="button" wire:click="resetField" class="btn btn-primary">{{__('lang.reset')}}</button>
                        </div>
                    </div>

                </form>
                
              </div>
            </div>

            <!--List users- table table-bordered table-striped -->

            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-8">
                      <label>{{__('lang.data')}}{{__('lang.rate_exchange')}}</label>
                    </div>
                    <div class="col-md-4">
                      <input wire:model="search_date" type="date" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr align="center">
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.date')}}</th>
                          <th>{{__('lang.thb')}}</th>
                          <th>{{__('lang.usd')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $stt = 1; @endphp
                        @foreach($exchange as $item)
                        <tr>
                            <td align="center">{{$stt++}}</td>
                            <td align="center">{{date('d/m/Y',strtotime($item->ex_date))}}</td>
                            <td align="right">{{number_format($item->rate_one)}}</td>
                            <td align="right">{{number_format($item->rate_two)}}</td>
                            <td align="center">
                                @if(Auth()->user()->rolename->name == 'admin')  
                                <button wire:click="edit({{$item->id}})" type="button" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                <button wire:click="showDestroy({{$item->id}})" type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                     </tbody>
                    </table>

                    <div>

                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- /.modal-delete -->
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

</div>
@push('scripts')
    <script>
      $('.money').simpleMoneyFormat();
      window.addEventListener('show-modal-delete', event => {
          $('#modal-delete').modal('show');
      })
      window.addEventListener('hide-modal-delete', event => {
          $('#modal-delete').modal('hide');
      })
    </script>
@endpush