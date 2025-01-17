<meta name="csrf-token" content="{{ csrf_token() }}" />
<header class="section-header">
    <section class="header-main shadow-sm bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-2">
                    <a href="{{ url('/') }}" class="brand-wrap mb-0">
                        <img alt="#" class="img-fluid" src="{{ asset('img/logo_web.png') }}" id="logo_web">
                    </a>
                </div>

                <div class="col-3 d-flex align-items-center m-none head-search">
                    <div class="dropdown ml-4">
                        <a class="text-dark dropdown-toggle d-flex align-items-center p-0" href="javascript:void(0)"
                            id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <div class="head-loc" onclick="getCurrentLocation('reload')">
                                <i class="feather-map-pin mr-2 bg-light rounded-pill p-2 icofont-size"></i>
                            </div>
                            <div>
                                <input id="user_locationnew" type="text" size="50" class="pac-target-input">
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-7 header-right">
                    <div class="d-flex align-items-center justify-content-end pr-5">
                        <a href="{{ url('search') }}" class="widget-header mr-4 text-dark">
                            <div class="icon d-flex align-items-center">
                                <i class="feather-search h6 mr-2 mb-0"></i> <span>{{ trans('lang.search') }}</span>
                            </div>
                        </a>
                        <a href="{{ url('offers') }}" class="widget-header mr-4 text-dark offer-link">
                            <div class="icon d-flex align-items-center">
                                <img alt="#" class="img-fluid mr-2" src="{{ asset('img/discount.png') }}">
                                <span>{{ trans('lang.offers') }}</span>
                            </div>
                        </a>
                        @auth
                        @else
                            <a href="{{ url('login') }}" class="widget-header mr-4 text-dark m-none">
                                <div class="icon d-flex align-items-center">
                                    <i class="feather-user h6 mr-2 mb-0"></i> <span>{{ trans('lang.signin') }}</span>
                                </div>
                            </a>
                        @endauth
                        <div class="dropdown mr-4 m-none">
                            <a href="#" class="dropdown-toggle text-dark py-3 d-block" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                @auth

                                    <a class="dropdown-item"
                                        href="{{ url('profile') }}">{{ trans('lang.my_account') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ url('notification') }}">{{ trans('lang.notification') }}</a>

                                    <a class="dropdown-item"
                                        href="{{ route('faq') }}">{{ trans('lang.delivery_support') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ url('contact-us') }}">{{ trans('lang.contact_us') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('aboutus') }}">{{ trans('lang.about_us') }}</a>

                                    <a class="dropdown-item" href="{{ url('help') }}"></i>{{ trans('lang.help') }}</a>
                                    <a class="dropdown-item" href="{{ route('terms') }}">{{ trans('lang.terms_use') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('privacy') }}">{{ trans('lang.privacy_policy') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('refund') }}">{{ trans('lang.refund_policy') }}</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">{{ trans('lang.logout') }}</a>
                                @else
                                    <a class="dropdown-item"
                                        href="{{ route('faq') }}">{{ trans('lang.delivery_support') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ url('contact-us') }}">{{ trans('lang.contact_us') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('aboutus') }}">{{ trans('lang.about_us') }}</a>
                                    <a class="dropdown-item" href="{{ url('help') }}"></i>{{ trans('lang.help') }}</a>
                                    <a class="dropdown-item" href="{{ route('terms') }}">{{ trans('lang.terms_use') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('privacy') }}">{{ trans('lang.privacy_policy') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('refund') }}">{{ trans('lang.refund_policy') }}</a>
                                @endauth


                            </div>
                        </div>
                        <a href="{{ url('/checkout') }}" class="widget-header mr-4 text-dark">
                            <div class="icon d-flex align-items-center">
                                <i class="feather-shopping-cart h6 mr-2 mb-0"></i>
                                <span>{{ trans('lang.cart') }}</span>
                            </div>
                        </a>

                        <div style="visibility: hidden;"
                            class="language-list icon d-flex align-items-center text-dark ml-2"
                            id="language_dropdown_box">
                            <div class="language-select">
                                <i class="feather-globe"></i>
                            </div>
                            <div class="language-options">
                                <select class="form-control changeLang text-dark" id="language_dropdown">
                                </select>
                            </div>
                        </div>

                        @auth
                            <div class="dropdown mr-4 m-none">
                                <a href="" class="dropdown-toggle text-dark py-3 d-block"
                                    id="dropdownNotificationMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-bell blue"></i><span class="notification_count d-none"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right notification_data"
                                    aria-labelledby="dropdownNotificationMenuButton"></div>
                            </div>
                        @endauth

                        <a class="toggle" href="#">
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>
<div class="d-none">
    <div class="bg-primary p-3 d-flex align-items-center">
        <a class="toggle togglew toggle-2" href="#"><span></span></a>
        <a href="{{ url('/') }}" class="mobile-logo brand-wrap mb-0">
            <img alt="#" class="img-fluid" src="{{ asset('img/logo_web.png') }}">
        </a>
        <div class="mobile-set-location d-flex align-items-center head-search">
            <div class="dropdown ml-4">
                <a class="text-dark dropdown-toggle d-flex align-items-center p-0" href="javascript:void(0)"
                    id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="head-loc" onclick="getCurrentLocation('reload')">
                        <i class="feather-map-pin mr-2 bg-light rounded-pill p-2 icofont-size"></i>
                    </div>
                    <div>
                        <input id="user_locationnew_mobile" type="text" size="50" class="pac-target-input">
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-database.js"></script> --}}


<script type="text/javascript">
    <?php $id = null;
    if (Auth::user()) {
        $id = Auth::user()->getvendorId();
    } ?>

    var cuser_id = '<?php echo $id; ?>';
</script>
