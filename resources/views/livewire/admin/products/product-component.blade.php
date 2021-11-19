<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                          <label>{{__('lang.village')}}</label>
                        </div>
                        <div class="col-md-6">
                          <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{__('lang.products')}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>{{__('lang.no')}}</th>
                              <th>{{__('lang.villagename')}}</th>
                              <th>{{__('lang.districtname')}}</th>
                              <th>{{__('lang.provincename')}}</th>
                              <th>{{__('lang.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                              $stt = 1;    
                            @endphp
        
                            @foreach ($products as $item)
                            <tr>
                              <td>{{$stt++}}</td>
                              <td>{{$item->name}}</td>
                              <td>{{$item->disname->name}}</td>
                              <td>{{$item->proname->name}}</td>
                              <td>
                                @if(Auth()->user()->rolename->name == 'admin')
                                  
                                  <a href="javascript:void(0)" wire:click="edit({{$item->id}})" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                  <button wire:click="destroy({{$item->id}})" type="button" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')"><i class="fas fa-trash"></i></button>
    
                                </form>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
    
                        <div>
                          {{$products->links()}}
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
