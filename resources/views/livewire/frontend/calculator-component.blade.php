<div>
    <div class="container-fluid bg-primary p-5 hero-header mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-1 text-white animated zoomIn">{{__('blog.price_calculator')}}</h1>
                <a href="/" class="h4 text-white">{{__('blog.home')}}</a>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <h6 class="display-5 mb-0">{{__('blog.please_input_data_bellow')}}</h6>
            </div>

            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__('blog.weight')}} Kg</label>
                        <input wire:model="weight" type="number" class="form-control @error('weight') is-invalid @enderror">
                        @error('weight') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__('blog.length')}} Cm</label>
                        <input wire:model="length" type="number" class="form-control @error('length') is-invalid @enderror">
                        @error('length') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__('blog.width')}} Cm</label>
                        <input wire:model="width" type="number" class="form-control @error('width') is-invalid @enderror">
                        @error('width') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__('blog.height')}} Cm</label>
                        <input wire:model="height" type="number" class="form-control @error('height') is-invalid @enderror">
                        @error('height') <span style="color: red" class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            
            <!--
            <br>
            <div class="row">
                <div class="col-md-12">
                    <button wire:click="calculator" class="btn btn-primary">{{__('blog.calculator')}}</button>
                </div>
            </div>-->

            <br>

            <div class="row text-center">
                <h3>{{__('blog.price_approx')}}: 

                    @if (!empty($weight) && !empty($length) && !empty($width) && !empty($height))
                        @if (($weight * $price_kg->price_local) < ((($length * $width * $height)/$price_other->condition1)*$price_other->condition2))
                            <label class="text-info">{{number_format($weight * $price_kg->price_local)}} {{__('lang.lak')}}</label>
                        @else
                            <label class="text-info">{{number_format((($length * $width * $height)/$price_other->condition1)*$price_other->condition2)}} {{__('lang.lak')}}</label>
                        @endif
                    @endif
                   
                </h3>
            </div>

            <br>
            
            <div class="row text-center">
                <h3><label class="text-primary">{{__('blog.the_above_price')}}</label></h3>
            </div>

        </div>
    </div>
</div>