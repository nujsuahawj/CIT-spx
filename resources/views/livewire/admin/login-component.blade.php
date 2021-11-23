<div>
    <!--
      <div class="login-box">
        <div class="login-logo">
          <a href="/" target="_blank"><img src="{{asset('images/logo.png')}}" height="120"><br></a>
          <a href="{{route('login')}}"><b>{{__('lang.title')}}</b></a>
        </div>
        
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
                </div>

                <div class="col-12">
                  <button wire:click="login" type="button" class="btn btn-primary btn-block">{{__('lang.login')}}</button>
                </div>

              </div>
            </form>
      
            <div class="social-auth-links text-center mb-3">
              <p>- OR -</p>
              <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
              </a>
              <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
              </a>
            </div>

            <p class="mb-1">
              <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
              <a href="register.html" class="text-center">Register a new membership</a>
            </p>
          </div>

        </div>
      </div>
    -->

      <div class="limiter">
        <div class="container-login100" style="background-image: url('{{asset('images/logo.png')}}');">
          <div class="wrap-login100 p-t-50 p-b-30">
            <!-- <form class="login100-form validate-form"> -->
              <div class="login100-form-avatar">
                <img src="{{asset('images/logo.png')}}" alt="AVATAR">
              </div>
    
              <span class="login100-form-title p-t-20 p-b-45">{{__('lang.title')}}</span>
    
              <div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
                <input wire:model="phone" wire:keydown.enter="login" class="input100" type="text" placeholder="{{__('lang.phone')}}">
                <span class="focus-input100"></span>
                <span class="symbol-input100"><i class="fa fa-phone"></i></span>
              </div>
              @error('phone')
                  <p class="text-center" style="color: yellow">{{$message}}</p>
              @enderror
    
              <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
                <input wire:model="password" wire:keydown.enter="login" class="input100" type="password" placeholder="{{__('lang.password')}}">
                <span class="focus-input100"></span>
                <span class="symbol-input100"><i class="fa fa-lock"></i></span>
              </div>
              @error('password')
                  <p class="text-center" style="color: yellow">{{$message}}</p>
              @enderror

              <div>
                @if (session()->has('message'))
                    <div class="alert alert-warning">
                        {{ session('message') }}
                    </div>
                @endif
              </div>
    
              <div class="container-login100-form-btn p-t-10">
                <button wire:click="login" class="login100-form-btn">{{__('lang.login')}}</button>
              </div>
    
              <!--
              <div class="text-center w-full p-t-25 p-b-230">
                <a href="#" class="txt1">
                  Forgot Username / Password?
                </a>
              </div>

              <div class="text-center w-full">
                <a class="txt1" href="#">
                  Create new account
                  <i class="fa fa-long-arrow-right"></i>						
                </a>
              </div>
              -->
            <!-- </form> -->
          </div>
        </div>
      </div>

</div>
