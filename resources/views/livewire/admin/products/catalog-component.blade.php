<div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <b>{{__('lang.products')}}</b>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
            <li class="breadcrumb-item active">{{__('lang.products')}}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!--Catalogs -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                  <a wire:click="create" href="javascript:void(0)"><i class="fa fa-plus"></i></a>
                </div>
                <div class="card-body">
  
                  <!-- Sidebar Menu -->
                <nav>
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                    @foreach ($catalogs as $item)
                      <li class="nav-item menu-open">
                        <div class="d-flex justify-content-between">
                          <a href="javascript:void(0)" wire:click="searchByCatalog({{$item->id}})" class="nav-link">{{$item->name}}</a>
                          <div>
                            <a href="javascript:void(0)" wire:click="edit({{$item->id}})"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" wire:click="showDestroyCatalog({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                          </div>
                        </div>
                        @if ($item->subcatalog)
                          <ul class="nav nav-treeview">
                            @foreach ($item->subcatalog as $child)
                              <li class="nav-item">
                                <div class="d-flex justify-content-between">
                                  <a href="javascript:void(0)" wire:click="searchByCatalog({{$child->id}})" class="nav-link">- {{$child->name}}</a>
                                  <div>
                                    <a href="javascript:void(0)" wire:click="edit({{$child->id}})"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" wire:click="showDestroyCatalog({{$child->id}})"><i class="fa fa-trash text-danger"></i></a>
                                  </div>
                                </div>
                                @if ($child->subcatalog)
                                  <ul class="nav nav-treeview">
                                    @foreach ($child->subcatalog as $subchild)
                                      <li class="nav-item">
                                        <div class="d-flex justify-content-between">
                                          <a href="javascript:void(0)" wire:click="searchByCatalog({{$subchild->id}})" class="nav-link">-- {{$subchild->name}}</a>
                                          <div>
                                            <a href="javascript:void(0)" wire:click="edit({{$subchild->id}})><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" wire:click="showDestroyCatalog({{$subchild->id}})"><i class="fa fa-trash"></i></a>
                                          </div>
                                        </div>
                                      </li>
                                    @endforeach
                                  </ul>
                                @endif
                              </li>
                            @endforeach
                          </ul>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                </nav>
  
                </div>
            </div>
        </div>
        
        <!--Products -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-2">
                      <a wire:click="showAddProduct" href="javascript:void(0)"><i class="fa fa-plus"></i></a>{{$search_by_cat}}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <input wire:model="search" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr style="text-align: center">
                    <th>{{__('lang.image')}}</th>
                    <th>{{__('lang.code')}}</th>
                    <th>{{__('lang.productname')}}</th>
                    <th>{{__('lang.buy_price')}}</th>
                    <th>{{__('lang.sale_price')}}</th>
                    <th>{{__('lang.online_price')}}</th>
                    <th>{{__('lang.catalogname')}}</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @php
                    $stt = 1;    
                  @endphp

                  @foreach ($products as $item)
                  <tr>
                    <td>
                      <img src="{{asset('storage/'.$item->image)}}" height="50">
                    </td>
                    <td>{{$item->code}}</td>
                    <td>{{$item->name}}</td>
                    <td style="text-align: right">{{number_format($item->buy_price)}}</td>
                    <td style="text-align: right">{{number_format($item->sale_price)}}</td>
                    <td style="text-align: right">{{number_format($item->online_price)}}</td>
                    <td style="text-align: center">
                      @if (!empty($item->catalog_id))
                      {{$item->product_catalog->name}}
                      @endif
                    </td>
                    <td style="text-align: center">
                        <a href="javascript:void(0)" wire:click="showEditProduct({{$item->id}})"><i class="fa fa-edit mr-2"></i></a>
                        <a href="javascript:void(0)" wire:click="showDestroyProduct({{$item->id}})"><i class="fa fa-trash text-danger"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  
                  </tbody>
                </table>

                <div class="d-flex justify-content-between">
                  {{$products->links()}}
                  {{__('lang.total_products')}}: {{$count_all_products}} {{__('lang.items')}}
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- /.modal-add Catalog -->
  <div wire:ignore.self class="modal fade" id="modal-add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.add')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form>
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{__('lang.parent_catalog')}}</label>
                    <select wire:model="parent_id" class="form-control" @error('parent_id') is-invalid @enderror">
                      <option value="0" selected>{{__('lang.select')}}</option>
                        @foreach($catalogs as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.catalogname')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="store" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-edit Catalog -->
  <div wire:ignore.self class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.edit')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <input type="hidden" wire:model="hiddenId">

          <form>
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{__('lang.parent_catalog')}}</label>
                    <select wire:model="parent_id" class="form-control" @error('parent_id') is-invalid @enderror">
                      <option value="0" selected>{{__('lang.select')}}</option>
                        @foreach($catalogs as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{__('lang.catalogname')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="update" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-delete Catalog-->
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

  <!-- /.modal-add Product -->
  <div wire:ignore.self class="modal fade" id="modal-add-product">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.add')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <form>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.barcode')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.productname')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                  <label>{{__('lang.parent_catalog')}}</label>
                  <select wire:model.defer="parent_id" class="form-control" @error('parent_id') is-invalid @enderror">
                    <option value="" selected>{{__('lang.select')}}</option>
                      @foreach($allcatalogs as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.buy_price')}}</label>
                  <input wire:model="buy_price" type="text" class="form-control money">
              </div>
            </div>
            <!--
            <div class="col-md-2" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.dearler_price')}}</label>
                  <input wire:model="dearler_price" type="text" class="form-control money">
              </div>
            </div>-->
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.sale_price')}}</label>
                  <input wire:model="sale_price" type="text" class="form-control money">
              </div>
            </div>
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.online_price')}}</label>
                  <input wire:model="online_price" type="text" class="form-control money">
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label>{{__('lang.vat')}}</label>
                  <input wire:model="vat" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.color')}}</label>
                  <input wire:model="color" type="text" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.size')}}</label>
                  <input wire:model="size" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.unit')}}</label>
                  <input wire:model="unit" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.min_qty')}}</label>
                  <input wire:model="min_qty" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.note')}}</label>
                  <input wire:model="note" type="text" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.select_image')}}</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input wire:model="image" type="file" class="custom-file-input" accept="image/png, image/gif, image/jpeg">
                    <label class="custom-file-label">{{__('lang.select')}}</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" height="100" width="100">
                @endif
              </div>
            </div>
          </div>

        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="storeProduct" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-edit Product -->
  <div wire:ignore.self class="modal fade" id="modal-edit-product">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{__('lang.edit')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <form>

          <input type="hidden" wire:model="hiddenId" value="{{$hiddenId}}">

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>{{__('lang.barcode')}}</label>
                  <input wire:model="code" type="text" class="form-control @error('code') is-invalid @enderror">
                  @error('code') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.productname')}}</label>
                  <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" autofocus>
                  @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                  <label>{{__('lang.parent_catalog')}}</label>
                  <select wire:model.defer="parent_id" class="form-control" @error('parent_id') is-invalid @enderror">
                    <option value="0" selected>{{__('lang.select')}}</option>
                      @foreach($allcatalogs as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                  </select>
                  @error('parent_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.buy_price')}}</label>
                  <input wire:model="buy_price" type="text" class="form-control money">
              </div>
            </div>
            <!--
            <div class="col-md-2" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.dearler_price')}}</label>
                  <input wire:model="dearler_price" type="text" class="form-control money">
              </div>
            </div>-->
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.sale_price')}}</label>
                  <input wire:model="sale_price" type="text" class="form-control money">
              </div>
            </div>
            <div class="col-md-3" wire:ignore>
              <div class="form-group">
                <label>{{__('lang.online_price')}}</label>
                  <input wire:model="online_price" type="text" class="form-control money">
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label>{{__('lang.vat')}}</label>
                  <input wire:model="vat" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.color')}}</label>
                  <input wire:model="color" type="text" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.size')}}</label>
                  <input wire:model="size" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.unit')}}</label>
                  <input wire:model="unit" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>{{__('lang.min_qty')}}</label>
                  <input wire:model="min_qty" type="text" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.note')}}</label>
                  <input wire:model="note" type="text" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('lang.select_image')}}</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input wire:model="image" type="file" class="custom-file-input" accept="image/png, image/gif, image/jpeg">
                    <label class="custom-file-label">{{__('lang.select')}}</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" height="100" width="100">
                @endif
              </div>
            </div>
          </div>

        </form>

        </div>
        <div class="modal-footer justify-content-between">
          <button wire:click="updateProduct" type="button" class="btn btn-success">{{__('lang.save')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.modal-delete Product-->
  <div class="modal fade" id="modal-delete-product">
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
          <button wire:click="destroyProduct({{$hiddenId}})" type="button" class="btn btn-danger">{{__('lang.delete')}}</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('lang.close')}}</button>
        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
  <script>
    //Add Catalog
    window.addEventListener('show-modal-add', event => {
      $('#modal-add').modal('show');
      $("#modal-add").modal({ backdrop : "static", keyboard: false});
    })
    window.addEventListener('hide-modal-add', event =>{
      $('#modal-add').modal('hide');
    })
    //Edit Catalog
    window.addEventListener('show-modal-edit', event => {
      $('#modal-edit').modal('show');
    })
    window.addEventListener('hide-modal-edit', event =>{
      $('#modal-edit').modal('hide');
    })
    //Delete Catalog
    window.addEventListener('show-modal-delete', event => {
      $('#modal-delete').modal('show');
    })
    window.addEventListener('hide-modal-delete', event =>{
      $('#modal-delete').modal('hide');
    })

    //Add Product
    window.addEventListener('show-modal-add-product', event => {
      $('#modal-add-product').modal('show');
    })
    window.addEventListener('hide-modal-add-product', event => {
      $('#modal-add-product').modal('hide');
    })
    //Edit Product
    window.addEventListener('show-modal-edit-product', event => {
      $('#modal-edit-product').modal('show');
    })
    window.addEventListener('hide-modal-edit-product', event => {
      $('#modal-edit-product').modal('hide');
    })
    //Delete Product
    window.addEventListener('show-modal-delete-product', event => {
      $('#modal-delete-product').modal('show');
    })
    window.addEventListener('hide-modal-delete-product', event => {
      $('#modal-delete-product').modal('hide');
    })
  </script>

  <script type="text/javascript">
    $('.money').simpleMoneyFormat();
  </script>
@endpush
