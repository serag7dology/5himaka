<section class="home-section-wrap">
    <div class="container">
        <div class="row">
            <div class="home-section-inner">
                <div class="home-slider-wrap">
                    <div
                        class="home-slider"
                        data-speed="{{ $slider->speed ?? '1000' }}"
                        data-autoplay="{{ $slider->autoplay ?? 'false' }}"
                        data-autoplay-speed="{{ $slider->autoplay_speed ?? '5000' }}"
                        data-fade="{{ $slider->fade ?? 'false' }}"
                        data-dots="{{ $slider->dots ?? 'true' }}"
                        data-arrows="{{ $slider->arrows ?? 'true' }}"
                    >
                        @foreach ($sliderBanners2 as $slide)
                            <div class="slide">
                                <img src="{{ $slide->image }}" data-animation-in="zoomInImage" class="slider-image animated">
                                <div class="slide-content align-left">
                                    <div class="captions">
                                        <span
                                            class="caption caption-1 fadeInUp animated"
                                            data-animation-in="fadeInUp"
                                            data-delay-in="null"
                                        >
                                            {!! $slide->details !!}
                                        </span>
                                        <a
                                            href="banner-products/{!! $slide->banner_id !!}"
                                            class="btn btn-primary btn-slider"
                                            data-animation-in="fadeInUp"
                                            data-delay-in="0.7"
                                            target="_blank"
                                        >
                                        {{ trans('storefront::layout.shop_now') }}
                                     
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    
                    </div>
                </div>

               
            </div>
        </div>
    </div>
</section>
