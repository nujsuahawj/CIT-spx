<div>
    <div class="container-fluid bg-primary p-5 hero-header mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-1 text-white animated zoomIn">{{__('blog.contact')}}</h1>
                <a href="/" class="h4 text-white">{{__('blog.home')}}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <!--<h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">{{__('blog.contact')}}</h5>
                <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                    <h6 class="display-5 mb-0">{{__('blog.contact')}}</h6>
                </div>-->
            </div>
            <div class="row g-5">
                <div class="col-lg-7 wow slideInUp" data-wow-delay="0.3s">
                    <div class="bg-light rounded p-2">
    
                            <div class="row g-3">
                                <div class="col-12">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="{{__('lang.firstname')}} {{__('lang.and')}} {{__('lang.lastname')}}">
                                    @error('name') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <input type="email" class="form-control" wire:model="email" placeholder="{{__('lang.email')}}">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model="phone" placeholder="{{__('lang.phone')}}">
                                    @error('phone') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control @error('message') is-invalid @enderror" wire:model="message" cols="30" rows="10" placeholder="{{__('blog.message_detail')}}"></textarea>
                                    @error('message') <span style="color: red" class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <button wire:click="sendMessage" class="btn btn-primary w-100 py-3">{{__('blog.submit')}}</button>
                                </div>
                            </div>

                    </div>
                </div>
                <div class="col-lg-5 wow slideInUp" data-wow-delay="0.6s">
                    <div class="bg-light rounded p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo-alt fs-1 text-primary me-3"></i>
                            <div class="text-start">
                                <h5 class="mb-1">{{__('blog.contact')}}</h5>
                                <span>
                                    @if (Config::get('app.locale') == 'lo')
                                        {{$address->company_name_la}}
                                    @elseif (Config::get('app.locale') == 'en')
                                        {{$address->company_name_en}}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-envelope-open fs-1 text-primary me-3"></i>
                            <div class="text-start">
                                <h5 class="mb-1">{{__('lang.email')}}</h5>
                                <span>{{$address->director}}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-phone-vibrate fs-1 text-primary me-3"></i>
                            <div class="text-start">
                                <h5 class="mb-1">{{__('lang.phone')}}</h5>
                                <span>{{$address->phone}}</span>
                            </div>
                        </div>
                        <div>
                            <iframe class="position-relative w-100"
                                src="{{$address->google_map}}"
                                frameborder="0" style="height: 230px; border:0;" allowfullscreen="" aria-hidden="false"
                                tabindex="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-3 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mx-auto mb-3" style="max-width: 600px;">
                <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">{{__('blog.our_network')}}</h5>
                <h1 class="display-5 mb-0">{{__('lang.branch')}}</h1>
            </div>
            <div class="row g-5">

                @foreach ($branchs as $item)
                    <div class="col-lg-4 col-md-3 wow zoomIn" data-wow-delay="0.3s">
                        <div class="service-item bg-light border-bottom border-5 border-primary rounded">
                            <div class="position-relative p-5">
                                <div class="text-center">
                                    <img src="{{asset($item->logo)}}" height="50%" width="50%">
                                </div>
                                <h5 class="text-primary mb-0">{{__('lang.branch')}}</h5>
                                <h3 class="mb-3">
                                    @if (Config::get('app.locale') == 'lo')
                                        {{$item->company_name_la}}
                                    @elseif (Config::get('app.locale') == 'en')
                                        {{$item->company_name_en}}
                                    @endif
                                </h3>
                                <p class="mb-2"><i class="bi bi-telephone text-primary me-2"></i>
                                    {{$item->phone}}
                                </p>
                                <p class="mb-0"><i class="bi bi-geo-alt text-primary me-2"></i>
                                    {{$item->address_la}}
                                </p>
                                <br>
                                <!--<a href="">{{__('lang.detail')}}<i class="bi bi-arrow-right ms-2"></i></a>-->
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>