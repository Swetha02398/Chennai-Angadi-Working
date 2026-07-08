<footer class="main">
    <!-- <section class="newsletter mb-15 wow animate_animated animate_fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="position-relative newsletter-inner">
                        <div class="newsletter-content">
                            @if(isset($bottomSlider) && $bottomSlider)
                                @if($bottomSlider->title_text)
                                    {!! $bottomSlider->title_text !!}
                                @else
                                    <h2 class="mb-20">
                                        Stay home & get your daily <br />
                                        needs from our shop
                                    </h2>
                                    <p class="mb-45">Start You'r Daily Shopping with <span class="text-brand">Nest Mart</span></p>
                                @endif
                            @else
                                <h2 class="mb-20">
                                    Stay home & get your daily <br />
                                    needs from our shop
                                </h2>
                                <p class="mb-45">Start You'r Daily Shopping with <span class="text-brand">Nest Mart</span>
                                </p>
                            @endif
                            <form class="form-subcriber d-flex">
                                <input type="email" placeholder="Your emaill address" />
                                <button class="btn" type="submit">Subscribe</button>
                            </form>
                        </div>
                        @if(isset($bottomSlider) && $bottomSlider)
                            @php 
                                $botImg = str_replace(['\\', 'uploads/'], ['/', ''], $bottomSlider->image); 
                                $botImg = ltrim($botImg, '/');
                                $adminUrl = rtrim(config('app.admin_asset_url'), '/');
                            @endphp
                            <img src="{{ $adminUrl }}/{{ $botImg }}" alt="newsletter" />
                        @else
                            <img src="{{ asset('assets/imgs/banner/banner-9.png') }}" alt="newsletter" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <section class="featured pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0">
                    <div class="banner-left-icon d-flex align-items-center wow animate_animated animate_fadeInUp"
                        data-wow-delay="0">
                        <div class="banner-icon">
                            <img src="{{ asset('assets/imgs/theme/icons/icon-1.svg') }} " alt="" />
                        </div>
                        <div class="banner-text">
                            <h3 class="icon-box-title">Best prices & offers</h3>
                            <p>Orders $50 or more</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="banner-left-icon d-flex align-items-center wow animate_animated animate_fadeInUp"
                        data-wow-delay=".1s">
                        <div class="banner-icon">
                            <img src="{{ asset('assets/imgs/theme/icons/icon-2.svg') }} " alt="" />
                        </div>
                        <div class="banner-text">
                            <h3 class="icon-box-title">Free delivery</h3>
                            <p>24/7 amazing services</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="banner-left-icon d-flex align-items-center wow animate_animated animate_fadeInUp"
                        data-wow-delay=".2s">
                        <div class="banner-icon">
                            <img src="{{ asset('assets/imgs/theme/icons/icon-3.svg') }} " alt="" />
                        </div>
                        <div class="banner-text">
                            <h3 class="icon-box-title">Great daily deal</h3>
                            <p>When you sign up</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="banner-left-icon d-flex align-items-center wow animate_animated animate_fadeInUp"
                        data-wow-delay=".3s">
                        <div class="banner-icon">
                            <img src="{{ asset('assets/imgs/theme/icons/icon-4.svg') }} " alt="" />
                        </div>
                        <div class="banner-text">
                            <h3 class="icon-box-title">Wide assortment</h3>
                            <p>Mega Discounts</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                    <div class="banner-left-icon d-flex align-items-center wow animate_animated animate_fadeInUp"
                        data-wow-delay=".4s">
                        <div class="banner-icon">
                            <img src="{{ asset('assets/imgs/theme/icons/icon-5.svg') }} " alt="" />
                        </div>
                        <div class="banner-text">
                            <h3 class="icon-box-title">Easy returns</h3>
                            <p>Within 30 days</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-xl-none">
                    <div class="banner-left-icon d-flex align-items-center wow animate_animated animate_fadeInUp"
                        data-wow-delay=".5s">
                        <div class="banner-icon">
                            <img src="{{ asset('assets/imgs/theme/icons/icon-6.svg') }} " alt="" />
                        </div>
                        <div class="banner-text">
                            <h3 class="icon-box-title">Safe delivery</h3>
                            <p>Within 30 days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="footer-mid pt-2 light_grey_bg">
        <div class="container py-2">
            <div class="row">
                <div class="col">
                    <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0 wow animate_animated animate_fadeInUp"
                        data-wow-delay="0">
                        <div class="logo mb-2">
                            <a href="{{ url('/') }}"><img
                                    src="{{ asset('assets/imgs/images/ChennaiAngadiLogo.png') }}"
                                    alt=" Chennai Angadi logo" />
                            </a>

                        </div>
                        <ul class="contact-infor">
                            <!-- <li><img src="{{ asset('assets/imgs/theme/icons/icon-location.svg') }} "
                                    alt="" /><strong>Address: </strong> <span>New # 15/Old # 8,Muthu Street,
                                    Mylapore,Chennai - 600004</span></li> -->
                            <li><img src="{{ asset('assets/imgs/theme/icons/icon-contact.svg') }} "
                                    alt="" /><strong>Call Us:</strong><span><a
                                        href="tel:9094676665">9094676665</a></span></li>
                            <li><img src="{{ asset('assets/imgs/theme/icons/icon-email-2.svg') }} "
                                    alt="" /><strong>Email:</strong><span><a
                                        href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a></span></li>
                            <li><img src="{{ asset('assets/imgs/theme/icons/icon-clock.svg') }} "
                                    alt="" /><strong>Hours:</strong><span>10:00 - 18:00, Mon - Sat</span></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-link-widget col wow animate_animated animate_fadeInUp" data-wow-delay=".1s">
                    <h4 class=" widget-title">Company</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{ route('pages.about') }}">About Us</a></li>
                        <!-- <li><a href="{{ route('pages.shipping-details') }}">Shipping Details</a></li> -->
                        <li><a href="{{ route('pages.privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.terms-condition') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('pages.shipping-details') }}">Shipping Details</a></li>
                        <li><a href="{{ route('pages.return-refund') }}">Return & Refund Policy</a></li>
                        <!-- <li><a href="#">Careers</a></li> -->
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate_animated animate_fadeInUp" data-wow-delay=".2s">
                    <h4 class="widget-title">Account</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="javascript:void(0);" onclick="openLoginModal()">Sign In</a></li>
                        <!-- <li><a href="javascript:void(0);" onclick="openRegisterModal()">Create Account</a></li> -->
                        <li><a href="{{route('cart.page')}}">View Cart</a></li>
                        <li><a href="{{ route('customer.wishlist') }}">My Wishlist</a></li>
                        <li><a href="{{ route('order.track') }}">Track Order</a></li>
                        <!-- <li><a href="{{ route('customer.myAccount') }}">Order List</a></li> -->
                    </ul>
                </div>
                <div class="footer-link-widget col wow animate_animated animate_fadeInUp" data-wow-delay=".2s">
                    <h4 class="widget-title">Popular Categories</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{ route('category.products', 7) }}">Jams</a></li>
                        <li><a href="{{ route('category.products', 1) }}">Chocolate candies</a></li>
                        <li><a href="{{ route('category.products', 2) }}">Jelly and gummy</a></li>
                        <li><a href="{{ route('category.products', 3) }}">Lollipop and pops</a></li>
                        <li><a href="{{ route('category.products', 4) }}">Mittai</a></li>
                    </ul>
                </div>
                <div class="footer-link-widget widget-install-app col wow animate_animated animate_fadeInUp"
                    data-wow-delay=".5s">
                    <div class="row mb-3">
                          <img class="col-6"
                                src="{{ asset('assets/imgs/images/google-play-1.svg') }}" alt="" />  
                          <img class="col-6"
                                src="{{ asset('assets/imgs/images/ios.png') }}" alt="" />  
                    </div>
                    <div class="row mb-3">
                          <img class="col-8"
                                src="{{ asset('assets/imgs/images/ISO.svg') }}" alt="" />  
                          
                    </div>
                    <!-- <h4 class="widget-title">Install App</h4>
                    <p class="">From App Store or Google Play</p>
                    <div class="download-app">
                        <a href="#" class="hover-up mb-sm-2 mb-lg-0"><img class="active"
                                src="{{ asset('assets/imgs/theme/app-store.jpg') }}" alt="" /></a>
                        <a href="#" class="hover-up mb-sm-2"><img src="{{ asset('assets/imgs/theme/google-play.jpg') }}"
                                alt="" /></a>
                    </div> -->
                    <p class="mb-2">Secured Payment Gateways</p>
                    <img class="" src="{{ asset('assets/imgs/theme/payment-method.png') }}" alt="" />
                </div>
            </div>
    </section>
    <div class="container py-2 footer-top-border wow animate_animated animate_fadeInUp dark_green_bg" data-wow-delay="0">
        <div class="row align-items-center">
            
            <div class="col-xl-4 col-lg-6 col-md-6">
                <p class="font-sm mb-0">&copy; {{ now()->year }}, <strong class="text-brand"></strong> Chennai
                        Angadi&nbsp;
                    All rights reserved</p>
            </div>
            <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                <!-- <div class="hotline d-lg-inline-flex mr-30">
                    <img src="{{ asset('assets/imgs/theme/icons/phone-call.svg') }} " alt="hotline" />
                    <p>9094676665<span></span></p>
                </div> -->
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 text-end d-none d-md-block">
                <div class="mobile-social-icon">
                    <h6>Follow Us</h6>
                    <a href="https://www.facebook.com/chennaiangaadi" target="_blank"><img
                            src="{{ asset('assets/imgs/theme/icons/icon-facebook-white.svg') }} " alt="" /></a>
                    <a href="https://twitter.com/ChennaiAngadi" target="_blank"><img
                            src="{{ asset('assets/imgs/theme/icons/icon-twitter-white.svg') }} " alt="" /></a>
                    <a href="https://www.instagram.com/chennaiangadii/" target="_blank"><img
                            src="{{ asset('assets/imgs/theme/icons/icon-instagram-white.svg') }} " alt="" /></a>
                    <a href="https://www.linkedin.com/company/35949244/admin/dashboard/" target="_blank"><img
                            src="{{ asset('assets/imgs/theme/icons/icon-linkedin-white.svg') }} " alt="" /></a>
                    <!-- <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-pinterest-white.svg') }} "
                            alt="" /></a> -->
                    <a href="https://www.youtube.com/@chennaiangadi" target="_blank"><img
                            src="{{ asset('assets/imgs/theme/icons/icon-youtube-white.svg') }} " alt="" /></a>
                    <a href="https://wa.me/9094676665?text=Reply%20Refer%20chennaiangadi.com" target="_blank"><img
                            src="{{ asset('assets/imgs/theme/icons/icon-whatsapp-white.svg') }} " alt="WhatsApp" style="width: 22px; max-width: 22px; vertical-align: middle; margin-left:2px; transform: scale(1.1);" /></a>
                </div>

            </div>
        </div>
    </div>
</footer>