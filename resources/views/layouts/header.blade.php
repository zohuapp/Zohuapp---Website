<meta name="csrf-token" content="{{ csrf_token() }}" />
<header class="section-header">
    <section class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-2">
                    <a href="{{ url('/') }}" class="brand-wrap mb-0">
                        <img alt="#" class="" style="width: 120px;" src="{{ asset('img/logo_web.png') }}"
                            id="logo_web">
                    </a>
                </div>

                <div class="col-3 d-flex align-items-center m-none head-search">
                    <div class="dropdown ml-4 d-flex align-items-center justify-content-around">
                        <a class="text-dark dropdown-toggle d-flex align-items-center p-0" href="javascript:void(0)"
                            id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <div class="head-loc" onclick="getCurrentLocation('reload')">
                                <i class="feather-map-pin mr-2 bg-light rounded-pill p-2 icofont-size"></i>
                            </div>
                            <div>
                                <input id="user_locationnew" type="text" size="50" class="pac-target-input">
                            </div>
                        </a>
                        {{-- search icon --}}
                        <a href="{{ url('search') }}" class="widget-header text-dark">
                            <div class="icon d-flex align-items-center">
                                <i class="feather-search h5 mb-0"></i>
                                {{-- <span>{{ trans('lang.search') }}</span> --}}
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-7 header-right">
                    <div class="d-flex align-items-center justify-content-around">
                        {{--  --}}
                        <a href="{{ url('offers') }}" class="widget-header mr-4 text-dark offer-link">
                            <div class="icon d-flex align-items-center">
                                <img alt="#" class="img-fluid mr-2" src="{{ asset('img/discount.png') }}">
                                <span>{{ trans('lang.offers') }}</span>
                            </div>
                        </a>
                        @auth
                        @else
                            <a href="{{ url('login') }}" class="widget-header text-dark m-none">
                                <div class="icon d-flex align-items-center">
                                    <i class="feather-user h6 mr-2 mb-0"></i> <span>{{ trans('lang.signin') }}</span>
                                </div>
                            </a>
                        @endauth

                        <div style="visibility: hidden;" class="language-list icon d-flex align-items-center text-dark"
                            id="language_dropdown_box">
                            <div class="language-select">
                                <i class="feather-globe h5"></i>
                            </div>
                            <div class="language-options">
                                <select class="form-control changeLang text-dark" id="language_dropdown">
                                </select>
                            </div>
                        </div>

                        <div class="cart">
                            <a href="{{ url('/checkout') }}" class="widget-header text-dark">
                                <div class="icon d-flex align-items-center">
                                    <i class="feather-shopping-cart h5 mr-2 mb-0"></i>
                                    {{-- <span>{{ trans('lang.cart') }}</span> --}}
                                </div>
                            </a>
                        </div>

                        @auth
                            <div class="dropdown m-none">
                                <a href="" class="dropdown-toggle text-dark py-3 d-block"
                                    id="dropdownNotificationMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="feather-bell h5"></i>
                                    <span class="notification_count d-none"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right notification_data"
                                    aria-labelledby="dropdownNotificationMenuButton"></div>
                            </div>

                            {{-- user profile icon --}}
                            <div class="dropdown m-none">
                                <a href="#"
                                    class="dropdown-toggle text-dark d-block border border-secondary rounded-pill p-1 d-flex align-items-center"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">

                                </a>
                                {{-- dropdown menu --}}
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
                                        <a class="dropdown-item"
                                            href="{{ route('terms') }}">{{ trans('lang.terms_use') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('privacy') }}">{{ trans('lang.privacy_policy') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('refund') }}">{{ trans('lang.refund_policy') }}</a>
                                    @endauth


                                </div>
                            </div>

                        @endauth


                        <div class="toggle-burger-animation p-2">
                            <a class="toggle" href="#">
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr class="m-0 p-0">
</header>

{{-- mobile resolution menu --}}
<div class="d-none">
    <div class="bg-primary p-4 d-flex align-items-center">
        <div class="col-4 logo-mobile">
            <a href="{{ route('home') }}" class="mobile-logo brand-wrap">
                <img alt="#" class="img-fluid" src="{{ asset('img/logo_web.png') }}">
            </a>
        </div>

        <div class="col-6 mobile-set-location text-right head-search">
            <!-- Button trigger modal -->
            <button type="button" class="btn text-white" data-toggle="modal" data-target="#modelId">
                <i class="fa fa-search fa-2x" aria-hidden="true"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                aria-hidden="true">
                <div class="modal-dialog model-dialog-search-input-location" role="document">
                    <div class="modal-content">
                        {{-- <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div> --}}
                        <div class="modal-body">
                            <div class="dropdown">
                                <a class="text-dark dropdown-toggle d-flex align-items-center p-0"
                                    href="javascript:void(0)" id="navbarDropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    <div class="head-loc" onclick="getCurrentLocation('reload')">
                                        <i class="feather-map-pin mr-2 bg-light rounded-pill p-2 icofont-size"></i>
                                    </div>
                                    <div>
                                        <input id="user_locationnew_mobile" type="text" size="50"
                                            class="pac-target-input">
                                    </div>
                                </a>
                            </div>
                        </div>
                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>

        <div class="col-2 burger-menu-mobile">
            <a class="toggle" href="javascript:void(0)">
                <span></span>
            </a>
        </div>
    </div>
</div>

{{-- <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-database.js"></script> --}}

@php
    $id = null;
    if (Auth::user()) {
        $id = Auth::user()->getVendorId();
    }
@endphp
<script type="text/javascript">
    var cuser_id = '{{ $id }}';
</script>
