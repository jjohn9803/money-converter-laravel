<div class="tm-top-bar" id="tm-top-bar">
    <!-- Top Navbar -->
    <div class="container">
        <div class="row">

            <nav class="navbar navbar-expand-lg narbar-light row" style="padding-left: 30px;">
                <a class="navbar-brand mr-auto" href="#">
                    <img src="{{ asset('assets/homepage/img/logo.png') }}" alt="Site logo">
                    Level
                </a>
                <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse"
                    data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="mainNav" class="collapse navbar-collapse tm-bg-tp">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#top">{{ __('content.appbar.home') }}<span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#section-features">{{ __('content.appbar.feature') }}</a>
                        </li>
                        <li class="nav-item" id='appbar-reviews'>
                            <a class="nav-link" href="#section-comment">{{ __('content.appbar.reviews') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tm-section-5">{{ __('content.appbar.guidelines') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer-section">{{ __('content.appbar.contact') }}</a>
                        </li>
                        @auth
                            <div class="dropdown cus-nav-user-b">
                                <div class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;">
                                    <span class="nav-user">{{ auth()->user()->name }}</span>
                                </div>
                                <div class="dropdown-menu cus-nav-user-li" aria-labelledby="dropdownMenu2">
                                    @if (!$verified)
                                        <li class="cus-li2" data-parent="#accordion">
                                            <form method="POST" id='verification_send_id'
                                                action="{{ route('verification.resend') }}">
                                                @csrf
                                                <a id='verify_email'>{{ __('content.appbar.verify-email') }}</a>
                                            </form>
                                        </li>
                                    @endif
                                    <li class="cus-li2"><a
                                            id='transaction_history'>{{ __('content.appbar.transaction-history') }}</a>
                                    </li>
                                    <li class="cus-li2"><a id='logout'>{{ __('content.appbar.logout') }}</a></li>
                                </div>
                            </div>
                        @else
                            <nav class="cus-nav nav-item" id='loginbefore'>
                                <ul class="cus-ul">
                                    <li class="cus-li">
                                        <a class="cus-a" data-toggle="modal" data-target="#loginModal">
                                            <span class="nav-user">{{ __('content.appbar.login') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endauth
                        <div class="dropdown cus-nav-lang-b">
                            <div class="dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;">
                                <span class="nav-user"><i class="fa fa-globe" style="font-size: 24px;"></i></span>
                                <span class="nav-user2">{{ __('content.appbar.language.title') }}</span>
                            </div>
                            <div class="dropdown-menu cus-nav-lang-li" aria-labelledby="dropdownMenu3">
                                <li class="cus-li2" id='localeEn'>
                                    <a><span class='fi fi-us mx-2'></span>{{ __('content.appbar.language.en') }}</a>
                                </li>
                                <li class="cus-li2" id='localeZh-CN'>
                                    <a><span class='fi fi-cn mx-2'></span>{{ __('content.appbar.language.zh-CN') }}</a>
                                </li>
                            </div>
                        </div>
                    </ul>
                </div>
                @auth
                    <div class="nav-item" id="notification_li">
                        <a id="notificationLink"><i class="fa fa-bell" style="font-size: 24px;"></i></a>
                        @include('layouts.homepage.notification-container')
                    </div>
                @endauth
            </nav>
        </div>
    </div>
</div>
