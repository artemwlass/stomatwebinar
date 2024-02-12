<div>
    <section class="photo-gallery">

        <div class="container photo-gallery__container">

            <div class="photo-gallery__title">


                <div class="photo-gallery__buttons">

                    <div class="photo-gallery-button-prev">
                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="31.5" cy="31.5" r="31.5" transform="matrix(-1 0 0 1 63 0)" fill="#47C0F4"/>
                            <path d="M39.4766 31H24.5236M24.5236 31L30.754 24.7696M24.5236 31L30.754 37.2304"
                                  stroke="#F7F8F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="photo-gallery-button-next">
                        <svg width="63" height="63" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="31.5" cy="31.5" r="31.5" fill="#47C0F4"/>
                            <path d="M23.5234 31H38.4764M38.4764 31L32.246 24.7696M38.4764 31L32.246 37.2304"
                                  stroke="#F7F8F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                </div>
            </div>


            <div class="swiper-container photo-gallery__swiper">
                <div class="swiper-wrapper">
                    @foreach($webinar['images'] as $image)
                        <div class="swiper-slide photo-gallery__photo col-md-4">
                            <a href="{{asset('storage/' . $image)}}" data-fancybox="gallery" data-caption="Image 1">
                                <img class="img-fluid" src="{{asset('storage/' . $image)}}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </section>
</div>
