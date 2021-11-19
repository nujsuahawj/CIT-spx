<div>
    <div class="container-fluid bg-primary p-5 hero-header mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-1 text-white animated zoomIn">{{__('blog.terms_and_conditions')}}</h1>
                <a href="/" class="h4 text-white">{{__('blog.home')}}</a>
            </div>
        </div>
    </div>
    <div class="container py-2 wow fadeInUp" data-wow-delay="0.1s">
        <div class="row g-5">
            <div class="col-lg-12">
                <!-- Blog Detail Start -->
                <div class="row">
                    <div class="text-center">
                        <img src="{{asset($pages->image)}}" height="150" width="150"><br>
                        
                    </div>
                </div>
                <div class="mb-5">
                    <h5 class="mb-4 text-center">
                        @if (Config::get('app.locale') == 'lo')
                            {{$pages->short_des_la}}
                        @elseif (Config::get('app.locale') == 'en')
                            {{$pages->short_des_en}}
                        @endif
                    </h5>
                    <p>
                        @if (Config::get('app.locale') == 'lo')
                            {!! $pages->des_la !!}
                        @elseif (Config::get('app.locale') == 'en')
                            {!! $pages->des_en !!}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
