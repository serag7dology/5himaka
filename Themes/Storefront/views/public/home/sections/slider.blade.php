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
                                <img src="{{ $slide->image }}" data-animation-in="zoomInImage" class="slider-image animated" height="height: 50vh;" style="object-fit: cover;">
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
                        <!-- @foreach ($slider->slides as $slide)
                            <div class="slide">
                                <img src="{{ $slide->file->path }}" data-animation-in="zoomInImage" class="slider-image animated">
                               
                                <div class="slide-content {{ $slide->isAlignedLeft() ? 'align-left' : 'align-right' }}">
                                    <div class="captions">
                                        <span
                                            class="caption caption-1"
                                            data-animation-in="{{ data_get($slide->options, 'caption_1.effect', 'fadeInRight') }}"
                                            data-delay-in="{{ data_get($slide->options, 'caption_1.delay', '0') }}"
                                        >
                                            {!! $slide->caption_1 !!}
                                        </span>

                                        <span
                                            class="caption caption-2"
                                            data-animation-in="{{ data_get($slide->options, 'caption_2.effect', 'fadeInRight') }}"
                                            data-delay-in="{{ data_get($slide->options, 'caption_2.delay', '0.3') }}"
                                        >
                                            {!! $slide->caption_2 !!}
                                        </span>

                                        <a
                                            href="{{ $slide->call_to_action_url }}"
                                            class="btn btn-primary btn-slider"
                                            data-animation-in="{{ data_get($slide->options, 'call_to_action.effect', 'fadeInRight') }}"
                                            data-delay-in="{{ data_get($slide->options, 'call_to_action.delay', '0.7') }}"
                                            target="{{ $slide->open_in_new_window ? '_blank' : '_self' }}"
                                        >
                                            {!! $slide->call_to_action_text !!}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach -->
                    </div>
                </div>

                @include('public.home.sections.slider_banners')
            </div>
        </div>
    </div>
</section>
