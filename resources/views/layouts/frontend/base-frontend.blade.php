<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{__('blog.title_website')}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{__('blog.title_website')}}" name="keywords">
    <meta content="{{__('blog.title_website')}}" name="description">

    <!-- Favicon -->
    <link href="{{asset('images/logo.png')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{asset('frontend/lib/flaticon/font/flaticon.css')}}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/lib/animate/animate.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('admin/plugins/toastr/toastr.min.css')}}">

    <style>
        @font-face{
          font-family: BoonHome;
          src: url('{{asset('fonts/BoonHome.ttf')}}');
        }
    </style>

    @livewireStyles

</head>

<body style="font-family: 'BoonHome'">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-2 py-lg-0 px-1 px-lg-0">
        <a href="/" class="navbar-brand ms-lg-1">
            <img src="{{asset('images/logo.png')}}" height="80">
        </a>
        <a href="/" class="navbar-brand ms-lg-0">
            <h3 class="display-4 m-0 text-warning">SLS<span class="text-secondary">Express</span></h3>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <!--<a href="/" class="nav-item nav-link">{{__('blog.home')}}</a>-->
                <a href="{{route('about')}}" class="nav-item nav-link">{{__('blog.about')}}</a>
                <a href="{{route('calculator')}}" class="nav-item nav-link">{{__('blog.price_calculator')}}</a>
                <a href="{{route('term_condition')}}" class="nav-item nav-link">{{__('blog.terms_and_conditions')}}</a>
                <a href="{{route('contact')}}" class="nav-item nav-link">{{__('blog.contact')}}</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{__('lang.language')}}</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{url('localization/lo')}}" class="dropdown-item">{{__('lang.lao')}}</a>
                        <a href="{{url('localization/en')}}" class="dropdown-item">{{__('lang.eng')}}</a>
                    </div>
                </div>
                <a href="" class="nav-item nav-link nav-contact bg-warning text-white px-3 ms-lg-3">
                    <div class="text-center">
                        <label class="text-dark text-sm">{{__('blog.hotline')}}</label>
                        <i class="bi bi-telephone-outbound me-2"></i>{{$address->phone}}
                    </div>
                </a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    {{ $slot }}

    <!-- Footer Start -->
    <div class="container-fluid bg-warning text-light mt-5 py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-dark mb-4">{{__('blog.menu')}}</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="/"><i class="bi bi-arrow-right text-primary me-2"></i>{{__('blog.home')}}</a>
                        <a class="text-dark mb-2" href="{{route('about')}}"><i class="bi bi-arrow-right text-primary me-2"></i>{{__('blog.about')}}</a>
                        <a class="text-dark mb-2" href="{{route('calculator')}}"><i class="bi bi-arrow-right text-primary me-2"></i>{{__('blog.price_calculator')}}</a>
                        <a class="text-dark mb-2" href="{{route('term_condition')}}"><i class="bi bi-arrow-right text-primary me-2"></i>{{__('blog.terms_and_conditions')}}</a>
                        <a class="text-dark mb-2" href="{{route('contact')}}"><i class="bi bi-arrow-right text-primary me-2"></i>{{__('blog.contact')}}</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-black mb-4">{{__('lang.address')}}</h3>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>
                        @if (Config::get('app.locale') == 'lo')
                            {{$address->company_name_la}}
                        @elseif (Config::get('app.locale') == 'en')
                            {{$address->company_name_en}}
                        @endif
                    </p>
                    <p class="mb-2"><i class="bi bi-telephone text-primary me-2"></i>
                        {{$address->phone}}
                    </p>
                    <p class="mb-0"><i class="bi bi-envelope-open text-primary me-2"></i>
                        {{$address->director}}
                    </p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <h3 class="text-black mb-4">{{__('blog.download_app')}}</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row g-3 text-center">
                                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                                    <a href="" target="_blank"><img src="{{asset('images/appgle-app-store.png')}}" height="50"></a>
                                </div>
                                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.6s">
                                    <a href="" target="_blank"><img src="{{asset('images/google-play-store.png')}}" height="50"></a>
                                </div>
                                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.9s">
                                    <a href="" target="_blank"><img src="{{asset('images/huawei-app-gallery.png')}}" height="50"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!--
                <div class="col-12">
                    <form class="mx-auto" style="max-width: 600px;">
                        <div class="input-group">
                            <input type="text" class="form-control border-white p-3" placeholder="Your Email">
                            <button class="btn btn-primary px-4">Sign Up</button>
                        </div>
                    </form>
                </div>
            -->
            </div>
        </div>
    </div>
    <div class="container-fluid bg-danger text-light py-4">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white border-bottom" href="https://slsexpresslaos.com/" target="_blank">{{__('blog.title_website')}}</a>. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="{{$address->whatsapp}}" target="_blank"><i class="fab fa-whatsapp fw-normal"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="{{$address->facebook_fanpage}}" target="_blank"><i class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="{{$address->youtube}}" target="_blank"><i class="fab fa-youtube fw-normal"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-secondary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('frontend/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('frontend/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('frontend/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('frontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('frontend/js/main.js')}}"></script>
    <!-- Toastr -->
    <script src="{{asset('admin/plugins/toastr/toastr.min.js')}}"></script>

    @livewireScripts

    <script>
        window.livewire.on('alert', param => {
              toastr[param['type']](param['message'],param['type']);
        });
      
    </script>
</body>

</html>