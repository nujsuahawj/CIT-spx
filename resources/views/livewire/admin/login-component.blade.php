<div>
    <div class="login-box">
        <div class="login-logo">
          <a href="/" target="_blank"><img src="{{asset('images/logo.png')}}" height="120"><br></a>
          <a href="{{route('login')}}"><b>{{__('lang.title')}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
          <div class="card-body login-card-body">
            <p class="login-box-msg">{{__('lang.signintostartyoursession')}}</p>
            
            <form>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <button type="button" class="btn btn-primary">020</button>
                </div>
                <input wire:model="phone" wire:keydown.enter="login" class="form-control" placeholder="{{__('lang.phone')}}" autofocus>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
              </div>
              @error('phone')
                  <p class="text-center" style="color: red">{{$message}}</p>
              @enderror

              <div class="input-group mb-4">
                <input wire:model="password" wire:keydown.enter="login" type="password"class="form-control" placeholder="{{__('lang.password')}}">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              @error('password')
                  <p class="text-center" style="color: red">{{$message}}</p>
              @enderror

              <div>
                @if (session()->has('message'))
                    <div class="alert alert-warning">
                        {{ session('message') }}
                    </div>
                @endif
              </div>

              <div class="row">
                <!--
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                      Remember Me
                    </label>
                  </div>
                </div>-->
                <!-- /.col -->
                <div class="col-12">
                  <button wire:click="login" type="button" class="btn btn-primary btn-block">{{__('lang.login')}}</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
      
            <!--
            <div class="social-auth-links text-center mb-3">
              <p>- OR -</p>
              <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
              </a>
              <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
              </a>
            </div>-->
            <!-- /.social-auth-links -->
            <!--
            <p class="mb-1">
              <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
              <a href="register.html" class="text-center">Register a new membership</a>
            </p>-->
          </div>
          <!-- /.login-card-body -->
        </div>
      </div>
</div>
