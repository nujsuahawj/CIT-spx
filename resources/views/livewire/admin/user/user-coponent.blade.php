<div>
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('lang.user')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('lang.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('lang.user')}}</li>
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

                          <input type="hidden" wire:model="hiddenId" value="{{$hidenId}}">

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>{{__('lang.user')}}</label>
                                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('lang.username')}}">
                                @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>{{__('lang.email')}}</label>
                                <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('lang.email')}}">
                                @error('email') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>{{__('lang.phone')}}</label>
                                <input wire:model="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="{{__('lang.phone')}}">
                                @error('phone') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="password">{{__('lang.password')}}</label>
                                <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('lang.password')}}">
                                @error('password') <span style="color: red" class="error">{{ $message }}</span> @enderror
                              </div>
                            </div>
                          </div>
    
                          <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="password_confirmation">{{__('lang.confirmpassword')}}</label>
                                  <input wire:model="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{__('lang.confirmpassword')}}">
                                  @error('password_confirmation') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__('lang.rolename')}}</label>
                                  <select wire:model="role_id" class="form-control">
                                    <option value="" selected>{{__('lang.select')}}</option>
                                      @foreach($roles as $item)
                                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                                      @endforeach
                                  </select>
                                  @error('role_id') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                              </div>
                          </div>
                        
                    </div>
                    <div class="card-footer">
                      <div class="d-flex justify-content-between md-2">
                        <button type="button" wire:click="resetField" class="btn btn-primary">{{__('lang.reset')}}</button>
                        <div>
                          <button type="button" wire:click="store" class="btn btn-success">{{__('lang.save')}}</button>
                        </div>
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
                    <div class="col-md-6">
                      <label>{{__('lang.user')}}</label>
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
                        <tr>
                          <th>{{__('lang.no')}}</th>
                          <th>{{__('lang.username')}}</th>
                          <th>{{__('lang.email')}}</th>
                          <th>{{__('lang.phone')}}</th>
                          <th>{{__('lang.rolename')}}</th>
                          <th>{{__('lang.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                          $stt = 1;    
                        @endphp
    
                        @foreach ($users as $item)
                        <tr>
                          <td>{{$stt++}}</td>
                          <td>{{$item->name}}</td>
                          <td>{{$item->email}}</td>
                          <td>{{$item->phone}}</td>
                          <td>{{$item->rolename->name}}</td>
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
                      {{$users->links()}}
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>
</div>

