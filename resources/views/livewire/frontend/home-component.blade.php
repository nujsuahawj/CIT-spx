<div>
      
    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                    @foreach ($sliders as $key => $item)
                        <div class="carousel-item position-relative {{$key == 0 ? 'active' : '' }}" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="{{asset($item->image)}}" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                        @if (Config::get('app.locale')== 'lo')
                                            {{$item->title_la}}
                                        @elseif (Config::get('app.locale') == 'en')
                                            {{$item->title_en}}
                                        @endif
                                    </h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                        @if (Config::get('app.locale')== 'lo')
                                            {{$item->des_la}}
                                        @elseif (Config::get('app.locale') == 'en')
                                            {{$item->des_en}}
                                        @endif
                                    </p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="{{route('calculator')}}">{{__('blog.price_calculator')}}</a>
                                </div>
                            </div>
                        </div> <!-- slide -->
                    @endforeach
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 style="color: #249AF3;" class="fa fa-check m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">{{__('lang.service')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 style="color: #249AF3;" class="fa fa-shipping-fast m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">{{__('lang.delivery')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 style="color: #249AF3;" class="fas fa-exchange-alt m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">{{__('blog.terms_and_conditions')}}</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 style="color: #249AF3;" class="fa fa-phone-volume m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">{{__('blog.contact')}}</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

</div>