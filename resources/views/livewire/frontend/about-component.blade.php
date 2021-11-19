<div>
    <div class="container-fluid bg-primary p-5 hero-header mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-1 text-white animated zoomIn">{{__('blog.about')}}</h1>
                <a href="/" class="h4 text-white">{{__('blog.home')}}</a>
            </div>
        </div>
    </div>
    <!-- About Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        @if (!empty($pages->image))
                            <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.3s" src="{{asset($pages->image)}}" style="object-fit: cover;">
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="mb-4">
                        <!--<h5 class="text-warning bg-gradient text-uppercase" style="letter-spacing: 5px;">ກ່ຽວກັບພວກເຮົາ</h5>-->
                        <h1 class="display-5 mb-0">
                            @if (Config::get('app.locale') == 'lo')
                                {{$pages->title_la}}
                            @elseif (Config::get('app.locale') == 'en')
                                {{$pages->title_en}}
                            @endif
                        </h1>
                    </div>
                    <!--<h4 class="text-body fst-italic mb-4">Diam dolor diam ipsum sit. Clita erat ipsum et lorem stet no lorem sit clita duo justo magna dolore</h4>-->
                    <p class="mb-4">
                        @if (Config::get('app.locale') == 'lo')
                            {{$pages->short_des_la}}
                        @elseif (Config::get('app.locale') == 'en')
                            {{$pages->short_des_en}}
                        @endif
                    </p>
                    <!--
                    <div class="row g-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                            <div class="bg-warning bg-gradient d-flex flex-column justify-content-center text-center border-bottom border-5 border-secondary rounded p-3" style="height: 200px;">
                                <i class="fa fa-star fa-4x text-white mb-4"></i>
                                <h4 class="text-white mb-0">15 Years Experience</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.9s">
                            <div class="bg-secondary d-flex flex-column justify-content-center text-center border-bottom border-5 border-warning rounded p-3" style="height: 200px;">
                                <i class="fa fa-award fa-4x text-white mb-4"></i>
                                <h4 class="text-white mb-0">Award Winning</h4>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <!-- Team Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <!--<h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">{{__('blog.board_of_director')}}</h5>-->
                <h1 class="display-5 mb-0">{{__('blog.board_of_director')}}</h1>
            </div>
            <div class="row g-5">

                @foreach ($employees as $item)
                    <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                        <div class="position-relative rounded-top">
                            <img class="img-fluid rounded-top w-100" src="{{asset('frontend/img/team-1.jpg')}}" alt="">
                            <!--
                            <div class="position-absolute bottom-0 end-0 d-flex flex-column bg-white p-1" style="margin-right: -25px;">
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-linkedin-in fw-normal"></i></a>
                                <a class="btn btn-outline-secondary btn-square m-1" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                            </div>
                            -->
                        </div>
                        <div class="bg-warning text-center rounded-bottom p-4">
                            <h3 class="text-white">Full Name</h3>
                            <p class="text-white m-0">Designation</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>    
</div>