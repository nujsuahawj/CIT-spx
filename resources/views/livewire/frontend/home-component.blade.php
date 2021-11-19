<div>
        <!-- Carousel Start -->
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                    <div class="carousel-inner">
                        
                        @foreach ($sliders as $key => $item)
                        <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                            <img class="w-100" src="{{asset($item->image)}}" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 900px;">
                                    <h5 class="text-white text-uppercase animated bounceInDown">
                                        @if (Config::get('app.locale')== 'lo')
                                            {{$item->title_la}}
                                        @elseif (Config::get('app.locale') == 'en')
                                            {{$item->title_en}}
                                        @endif
                                    </h5>
                                    <h1 class="display-1 text-white mb-md-4 animated zoomIn">
                                        @if (Config::get('app.locale')== 'lo')
                                            {{$item->des_la}}
                                        @elseif (Config::get('app.locale') == 'en')
                                            {{$item->des_en}}
                                        @endif
                                    </h1>
                                    <a href="{{route('calculator')}}" class="btn btn-warning py-md-3 px-md-5 me-3 animated slideInLeft">{{__('blog.price_calculator')}}</a>
                                    <!--<a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Contact Us</a>-->
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>  
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Carousel End -->
    
        <!-- Tracking -->
        <div class="container-fluid py-3 wow zoomIn bg-light" data-wow-delay="0.1s">
            <div class="container">
                <div class="text-center mx-auto mb-3" style="max-width: 600px;">
                    <h1 class="display-5 mb-2">{{__('blog.tracking_goods')}}</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mt-1 mb-1">
                        <input type="text" wire:model="search" wire:keydown.enter="search" class="form-control" placeholder="{{__('blog.trachking_by_id_phone_customername')}}">
                    </div>
                    <div class="col-lg-1 text-center mt-1 mb-1">
                        <a wire:click="search" href="javascript:void(0)" class="btn btn-warning">{{__('lang.search')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-3 wow zoomIn bg-light" data-wow-delay="0.1s">
            <div class="container">
                <div class="text-center mx-auto mb-3" style="max-width: 800px;">
                    @if(!empty($data))
                    <table class="table table-striped">
                        <thead>
                        <tr style="text-align: center">
                            <th>{{__('blog.no')}}</th>
                            <th>{{__('blog.code')}}</th>
                            <th>{{__('blog.created_at')}}</th>
                            <th>{{__('blog.cus_receive')}}</th>
                            <th>{{__('blog.tel_receive')}}</th>
                            <th>{{__('blog.status')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $stt = 1; @endphp
                            @foreach($receivetransaction as $item)
                                <tr>
                                    <td>{{$stt++}}</td>
                                    <td>{{$item->code}}</td>
                                    <td>{{date('d/m/Y', strtotime($item->valuedt))}}</td>
                                    <td>{{$item->crr}}</td>
                                    <td>{{$item->crphone}}</td>
                                    <td>
                                    @if($item->status == 'P')
                                        <div class="btn btn-warning btn-xs"> {{__('lang.pending')}} </div>
                                    @elseif($item->status == 'N')
                                        <div class="btn btn-warning btn-xs"> {{__('lang.normal')}} </div>
                                    @elseif($item->status == 'S')
                                        <div class="btn btn-success btn-xs"> {{__('lang.sending')}} </div>
                                    @elseif($item->status == 'ST')
                                        <div class="btn btn-danger btn-xs"> {{__('lang.warehouse')}} </div>
                                    @elseif($item->status == 'F')
                                        <div class="btn btn-info btn-xs"> {{__('lang.send_finish')}} </div>
                                    @elseif($item->status == 'SC')
                                        <div class="btn btn-primary btn-xs"> {{__('lang.send_goods_customer_finish')}} </div>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        <!-- Download App -->
        <div class="container-fluid py-3 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="text-center mx-auto mb-3" style="max-width: 600px;">
                    <h1 class="display-5 mb-2">{{__('blog.download_app')}}</h1>
                </div>
                <div class="row g-3 text-center">
                    <div class="col-lg-12 wow slideInUp" data-wow-delay="0.3s">
                        <a href="{{$address->app_store}}" target="_blank"><img src="{{asset('images/appgle-app-store.png')}}" height="60"></a>
                        <a href="{{$address->play_store}}" target="_blank"><img src="{{asset('images/google-play-store.png')}}" height="60"></a>
                        <a href="{{$address->app_gallery}}" target="_blank"><img src="{{asset('images/huawei-app-gallery.png')}}" height="60"></a>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Services Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                    <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">{{__('blog.service')}}</h5>
                    <h1 class="display-5 mb-0">{{__('blog.my_busineses')}}</h1>
                </div>
                <div class="row g-5">

                    @foreach ($services as $item)
                        <div class="col-lg-6 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                            <div class="service-item bg-light border-bottom border-5 border-primary rounded">
                                <div class="position-relative p-5">
                                    <i class="{{$item->service_icon}} d-block display-1 text-secondary mb-3"></i>
                                    <h5 class="text-primary mb-0">{{__('blog.service')}}</h5>
                                    <h3 class="mb-3">
                                        @if (Config::get('app.locale') == 'lo')
                                            {{$item->title_la}}
                                        @elseif(Config::get('app.locale') == 'en')
                                            {{$item->title_en}}
                                        @endif
                                    </h3>
                                    <p>
                                        @if (Config::get('app.locale') == 'lo')
                                            {{$item->des_la}}
                                        @elseif(Config::get('app.locale') == 'en')
                                            {{$item->des_en}}
                                        @endif
                                    </p>
                                    <!--<a href="">Read More<i class="bi bi-arrow-right ms-2"></i></a>-->
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- Services End -->
    
        <!-- Team Start 
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                    <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">ຄະນະບໍລິຫານງານ</h5>
                    <h1 class="display-5 mb-0">ຄະນະບໍລິຫານງານ</h1>
                </div>
                <div class="row g-5">
                    <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                        <div class="position-relative rounded-top">
                            <img class="img-fluid rounded-top w-100" src="{{asset('frontend/img/team-1.jpg')}}" alt="">
                            <div class="position-absolute bottom-0 end-0 d-flex flex-column bg-white p-1" style="margin-right: -25px;">
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-linkedin-in fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="bg-warning text-center rounded-bottom p-4">
                            <h3 class="text-white">Full Name</h3>
                            <p class="text-white m-0">Designation</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow slideInUp" data-wow-delay="0.6s">
                        <div class="position-relative rounded-top">
                            <img class="img-fluid rounded-top w-100" src="{{asset('frontend/img/team-2.jpg')}}" alt="">
                            <div class="position-absolute bottom-0 end-0 d-flex flex-column bg-white p-1" style="margin-right: -25px;">
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-linkedin-in fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="bg-warning text-center rounded-bottom p-4">
                            <h3 class="text-white">Full Name</h3>
                            <p class="text-white m-0">Designation</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow slideInUp" data-wow-delay="0.9s">
                        <div class="position-relative rounded-top">
                            <img class="img-fluid rounded-top w-100" src="{{asset('frontend/img/team-3.jpg')}}" alt="">
                            <div class="position-absolute bottom-0 end-0 d-flex flex-column bg-white p-1" style="margin-right: -25px;">
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-linkedin-in fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="bg-warning text-center rounded-bottom p-4">
                            <h3 class="text-white">Full Name</h3>
                            <p class="text-white m-0">Designation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    
        <!-- Testimonial Start -->
        <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                    <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">{{__('blog.testimonial')}}</h5>
                    <h1 class="display-5 mb-0">{{__('blog.some_testimonial')}}</h1>
                </div>
                <div class="owl-carousel testimonial-carousel">
                    @foreach ($testimonials as $key => $item)
                        <div class="text-center {{$key == 0 ? 'pb-4' : '' }}">
                            <img class="img-fluid mx-auto rounded-circle" src="{{asset($item->image)}}" style="width: 100px; height: 100px;" >
                            <div class="testimonial-text bg-light rounded p-4 mt-n5">
                                <p class="mt-5">
                                    @if (Config::get('app.locale')=='lo')
                                        {{$item->des_la}}
                                    @else
                                        {{$item->des_en}}
                                    @endif
                                </p>
                                <h5> {{$item->name}}</h5>
                                <i> {{$item->position}}</i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Testimonial End -->
</div>