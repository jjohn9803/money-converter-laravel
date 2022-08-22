<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{trans('content.exchange.base_msg',[
        'from_min_amt'=>'300',
        'from_max_amt'=>'600',
        'from_curr_name'=>'SGB',
        ])}}</title> --}}
    <title>{{ __('content.title') }}</title>
    {{-- <title>{{ __('content.title') }}</title> --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}">
    <!--

Template 2095 Level

http://www.tooplate.com/view/2095-level

-->



    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/bootstrap.min.css') }}"> <!-- Bootstrap style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/homepage/slick/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/homepage/slick/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/homepage/css/datepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/tooplate-style.css') }}"> <!-- Templatemo style -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script><!-- jQuery base library needed -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
    <audio style="display:none; height: 0" id="notification-alert-sound" preload="auto"
        src={{ asset('assets/audio/notification_2.mp3') }}></audio>
</head>

<body>
    <div class="tm-main-content" id="top">
        <div class="tm-top-bar-bg"></div>
        @include('layouts.homepage.appbar')
        @include('layouts.homepage.exchange')
        <div id='help' class="tm-section-2">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h2 class="tm-section-title">{{ __('content.section-2.title') }}</h2>
                        <p class="tm-color-white tm-section-subtitle">{{ __('content.section-2.subtitle') }}</p>
                        <div id='scroll-to-footer' class="btn-primary tm-color-white tm-btn-white-bordered">
                            {{ __('content.section-2.btn') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tm-section tm-position-relative" id='section-features'>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                class="tm-section-down-arrow">
                <polygon fill="#4ba5b1" points="0,0  100,0  50,60"></polygon>
            </svg>
            <div class="container tm-pt-5 tm-pb-1">
                <div class="row text-center">
                    <article class="col-sm-12 col-md-3 col-lg-3 col-xl-3 tm-article">
                        <i class="fa tm-fa-6x fa-thumbs-up tm-color-primary tm-margin-b-20"></i>
                        <h3 class="tm-color-primary tm-article-title-1">{!! __('content.section-feature.1.title') !!}
                        </h3>
                        <p>{!! __('content.section-feature.1.subtitle') !!}</p>
                        {{-- <a href="#" class="text-uppercase tm-color-primary tm-font-semibold">Continue
                            reading...</a> --}}
                    </article>
                    <article class="col-sm-12 col-md-3 col-lg-3 col-xl-3 tm-article">
                        <i class="fa tm-fa-6x fa-money tm-color-primary tm-margin-b-20"></i>
                        <h3 class="tm-color-primary tm-article-title-1">{!! __('content.section-feature.2.title') !!}</h3>
                        <p>{!! __('content.section-feature.2.subtitle') !!}</p>
                        {{-- <a href="#" class="text-uppercase tm-color-primary tm-font-semibold">Continue
                            reading...</a> --}}
                    </article>
                    <article class="col-sm-12 col-md-3 col-lg-3 col-xl-3 tm-article">
                        <i class="fa tm-fa-6x fa-exchange tm-color-primary tm-margin-b-20"></i>
                        <h3 class="tm-color-primary tm-article-title-1">{!! __('content.section-feature.3.title') !!}</h3>
                        <p>{!! __('content.section-feature.3.subtitle') !!}</p>
                        {{-- <a href="#" class="text-uppercase tm-color-primary tm-font-semibold">Continue
                            reading...</a> --}}
                    </article>
                    <article class="col-sm-12 col-md-3 col-lg-3 col-xl-3 tm-article">
                        <i class="fa tm-fa-6x fa-shield tm-color-primary tm-margin-b-20"></i>
                        <h3 class="tm-color-primary tm-article-title-1">{!! __('content.section-feature.4.title') !!}</h3>
                        <p>{!! __('content.section-feature.4.subtitle') !!}</p>
                        {{-- <a href="#" class="text-uppercase tm-color-primary tm-font-semibold">Continue
                            reading...</a> --}}
                    </article>
                </div>
            </div>
        </div>
        <div class="tm-section mb-5" id='section-comment'>
            <div class="container"
                style="position: absolute;
            width: 100%;
            min-height: 100%;
            display: block;">
                @include('layouts.homepage.comments')
            </div>
        </div>
        @include('layouts/homepage/comments-sm')
        {{-- <div class="container">
            <div class="reviews-slider"></div>
        </div> --}}

        {{-- <div class="tm-section tm-section-pad tm-bg-gray" id="tm-section-4">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <div class="tm-article-carousel">
                            <article class="tm-bg-white mr-2 tm-carousel-item">
                                <img src="{{ asset('assets/homepage/img/img-01.jpg') }}" alt="Image"
                                    class="img-fluid">
                                <div class="tm-article-pad">
                                    <header>
                                        <h3 class="text-uppercase tm-article-title-2">Nunc in felis aliquet metus
                                            luctus
                                            iaculis</h3>
                                    </header>
                                    <p>Aliquam ac lacus volutpat, dictum risus at, scelerisque nulla. Nullam
                                        sollicitudin at augue venenatis eleifend. Nulla ligula ligula, egestas sit amet
                                        viverra id, iaculis sit amet ligula.</p>
                                    <a href="#" class="text-uppercase btn-primary tm-btn-primary">Get More
                                        Info.</a>
                                </div>
                            </article>
                            <article class="tm-bg-white mr-2 tm-carousel-item">
                                <img src="{{ asset('assets/homepage/img/img-02.jpg') }}" alt="Image"
                                    class="img-fluid">
                                <div class="tm-article-pad">
                                    <header>
                                        <h3 class="text-uppercase tm-article-title-2">Sed cursus dictum nunc quis
                                            molestie</h3>
                                    </header>
                                    <p>Pellentesque quis dui sit amet purus scelerisque eleifend sed ut eros. Morbi
                                        viverra blandit massa in varius. Sed nec ex eu ex tincidunt iaculis. Curabitur
                                        eget turpis gravida.</p>
                                    <a href="#" class="text-uppercase btn-primary tm-btn-primary">View
                                        Detail</a>
                                </div>
                            </article>
                            <article class="tm-bg-white mr-2 tm-carousel-item">
                                <img src="{{ asset('assets/homepage/img/img-01.jpg') }}" alt="Image"
                                    class="img-fluid">
                                <div class="tm-article-pad">
                                    <header>
                                        <h3 class="text-uppercase tm-article-title-2">Eget diam pellentesque interdum
                                            ut
                                            porta</h3>
                                    </header>
                                    <p>Aenean finibus tempor nulla, et maximus nibh dapibus ac. Duis consequat sed
                                        sapien venenatis consequat. Aliquam ac lacus volutpat, dictum risus at,
                                        scelerisque nulla.</p>
                                    <a href="#" class="text-uppercase btn-primary tm-btn-primary">More Info.</a>
                                </div>
                            </article>
                            <article class="tm-bg-white mr-2 tm-carousel-item">
                                <img src="{{ asset('assets/homepage/img/img-02.jpg') }}" alt="Image"
                                    class="img-fluid">
                                <div class="tm-article-pad">
                                    <header>
                                        <h3 class="text-uppercase tm-article-title-2">Lorem ipsum dolor sit amet,
                                            consectetur</h3>
                                    </header>
                                    <p>Suspendisse molestie sed dui eget faucibus. Duis accumsan sagittis tortor in
                                        ultrices. Praesent tortor ante, fringilla ac nibh porttitor, fermentum commodo
                                        nulla.</p>
                                    <a href="#" class="text-uppercase btn-primary tm-btn-primary">Detail
                                        Info.</a>
                                </div>
                            </article>
                            <article class="tm-bg-white mr-2 tm-carousel-item">
                                <img src="{{ asset('assets/homepage/img/img-01.jpg') }}" alt="Image"
                                    class="img-fluid">
                                <div class="tm-article-pad">
                                    <header>
                                        <h3 class="text-uppercase tm-article-title-2">Orci varius natoque penatibus et
                                        </h3>
                                    </header>
                                    <p>Pellentesque quis dui sit amet purus scelerisque eleifend sed ut eros. Morbi
                                        viverra blandit massa in varius. Sed nec ex eu ex tincidunt iaculis. Curabitur
                                        eget turpis gravida.</p>
                                    <a href="#" class="text-uppercase btn-primary tm-btn-primary">Read More</a>
                                </div>
                            </article>
                            <article class="tm-bg-white tm-carousel-item">
                                <img src="{{ asset('assets/homepage/img/img-02.jpg') }}" alt="Image"
                                    class="img-fluid">
                                <div class="tm-article-pad">
                                    <header>
                                        <h3 class="text-uppercase tm-article-title-2">Nullam sollicitudin at augue
                                            venenatis eleifend</h3>
                                    </header>
                                    <p>Aenean finibus tempor nulla, et maximus nibh dapibus ac. Duis consequat sed
                                        sapien venenatis consequat. Aliquam ac lacus volutpat, dictum risus at,
                                        scelerisque nulla.</p>
                                    <a href="#" class="text-uppercase btn-primary tm-btn-primary">More
                                        Details</a>
                                </div>
                            </article>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 tm-recommended-container">
                        <div class="tm-bg-white">
                            <div class="tm-bg-primary tm-sidebar-pad">
                                <h3 class="tm-color-white tm-sidebar-title">Recommended Places</h3>
                                <p class="tm-color-white tm-margin-b-0 tm-font-light">Enamel pin cliche tilde, kitsch
                                    and VHS thundercats</p>
                            </div>
                            <div class="tm-sidebar-pad-2">
                                <a href="#" class="media tm-media tm-recommended-item">
                                    <img src="{{ asset('assets/homepage/img/tn-img-01.jpg') }}" alt="Image">
                                    <div class="media-body tm-media-body tm-bg-gray">
                                        <h4 class="text-uppercase tm-font-semibold tm-sidebar-item-title">Europe</h4>
                                    </div>
                                </a>
                                <a href="#" class="media tm-media tm-recommended-item">
                                    <img src="{{ asset('assets/homepage/img/tn-img-02.jpg') }}" alt="Image">
                                    <div class="media-body tm-media-body tm-bg-gray">
                                        <h4 class="text-uppercase tm-font-semibold tm-sidebar-item-title">Asia</h4>
                                    </div>
                                </a>
                                <a href="#" class="media tm-media tm-recommended-item">
                                    <img src="{{ asset('assets/homepage/img/tn-img-03.jpg') }}" alt="Image">
                                    <div class="media-body tm-media-body tm-bg-gray">
                                        <h4 class="text-uppercase tm-font-semibold tm-sidebar-item-title">Africa</h4>
                                    </div>
                                </a>
                                <a href="#" class="media tm-media tm-recommended-item">
                                    <img src="{{ asset('assets/homepage/img/tn-img-04.jpg') }}" alt="Image">
                                    <div class="media-body tm-media-body tm-bg-gray">
                                        <h4 class="text-uppercase tm-font-semibold tm-sidebar-item-title">South America
                                        </h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        @include('layouts.homepage.modal.homepage')
        @include('layouts.homepage.modal.login')
        <div class="tm-section tm-section-pad tm-bg-img" id="tm-section-5">
            <div class="container ie-h-align-center-fix">
                <div class="row tm-flex-align-center">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-xl-1 tm-media-title-container">
                        <h2 class="text-uppercase tm-section-title-2">{!! __('content.section-guideline.title') !!}</h2>
                        <h3 class="tm-color-primary tm-font-semibold tm-section-subtitle-2">{!! __('content.section-guideline.subtitle') !!}</h3>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12 col-xl-11 mt-0 mt-sm-3">
                        <div class="ml-auto tm-bg-white-shadow tm-pad tm-media-container">
                            {{-- <article class="media tm-margin-b-20 tm-media-1">
                                <img src="{{ asset('assets/homepage/img/img-03.jpg') }}" alt="Image">
                                <div class="media-body tm-media-body-1 tm-media-body-v-center">
                                    <h3 class="tm-font-semibold tm-color-primary tm-article-title-3">Suspendisse
                                        vel est libero sem phasellus ac laoreet</h3>
                                    <p>Integer libero purus, consectetur vitae posuere quis, maximus id diam.
                                        Vivamus eget tellus ornare, sollicitudin quam id, dictum nulla. Phasellus
                                        finibus rhoncus justo, tempus eleifend neque dictum ac. Aenean metus leo,
                                        consectetur non.
                                        <br><br>
                                        Etiam aliquam arcu at mauris consectetur scelerisque. Integer elementum
                                        justo in orci facilisis ultricies. Pellentesque at velit ante. Duis
                                        scelerisque metus vel felis porttitor gravida.
                                    </p>
                                </div>
                            </article>
                            <article class="media tm-margin-b-20 tm-media-1">
                                <img src="{{ asset('assets/homepage/img/img-04.jpg') }}" alt="Image">
                                <div class="media-body tm-media-body-1 tm-media-body-v-center">
                                    <h3 class="tm-font-semibold tm-article-title-3">Suspendisse vel est libero sem
                                        phasellus ac laoreet</h3>
                                    <p>Duis accumsan sagittis tortor in ultrices. Praesent tortor ante, fringilla ac
                                        nibh porttitor, fermentum commodo nulla.</p>
                                    <a href="#"
                                        class="text-uppercase tm-color-primary tm-font-semibold">Continue
                                        reading...</a>
                                </div>
                            </article>
                            <article class="media tm-margin-b-20 tm-media-1">
                                <img src="{{ asset('assets/homepage/img/img-05.jpg') }}" alt="Image">
                                <div class="media-body tm-media-body-1 tm-media-body-v-center">
                                    <h3 class="tm-font-semibold tm-article-title-3">Faucibus dolor ligula nisl
                                        metus auctor aliquet</h3>
                                    <p>Nunc in felis aliquet metus luctus iaculis vel et nisi. Nulla venenatis nisl
                                        orci, laoreet ultricies massa tristique id.</p>
                                    <a href="#"
                                        class="text-uppercase tm-color-primary tm-font-semibold">Continue
                                        reading...</a>
                                </div>
                            </article> --}}
                            <div class="reviews-slider2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            {{-- <a href="https://api.whatsapp.com/send?phone=601137733412&text=你好 any issue? Feel free to ask us!"
                class="float" target="_blank">
                <i class="fa fa-whatsapp my-float"></i>
            </a> --}}
            <div class="fabs">
                @if ($contacts != null)
                    @foreach ($contacts as $data)
                        @if ($data->status != 1)
                            <a onclick="window.open('{{ $data->contact_link }}')"
                                @if ($data->type == 1) class="fab fab-whatsapp">
                                    <i class='fa fa-whatsapp'
                                    @elseif($data->type == 2)class="fab fab-facebook">
                                    <i class='fa fa-facebook'
                                    @elseif($data->type == 3)class="fab fab-instagram">
                                    <i class='fa fa-instagram'
                                    @elseif($data->type == 4)class="fab fab-twitter">
                                    <i class='fa fa-twitter'
                                    @elseif($data->type == 5)class="fab fab-others">
                                    <i class='fa fa-phone' @endif></i>
                            </a>
                        @endif
                    @endforeach
                @endif
                <a id="prime" class="fab"><i class="fa fa-whatsapp"></i></a>
            </div>
            {{-- <div href="javascript:void(0)" id='backToTop' class="float float2">
                <i class="fa fa-angle-up my-float"></i>
            </div> --}}
        </div>
        {{-- {{$realtime_fxes}} --}}
        {{-- <div class="tm-section tm-section-pad tm-bg-img tm-position-relative" id="tm-section-6">
            <div class="container ie-h-align-center-fix">
                <div class="row" style="background-color: rgb(231, 231, 232,0.5);height:500px;">
                    @include('layouts.homepage.bar')
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-7">
                        <img class="footer-img" src="{{ asset('assets/homepage/img/img-06.jpg') }}" alt="Image">
                        <div id="google-map"></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 mt-3 mt-md-0">
                        <div class="tm-bg-white tm-p-4">
                            <form action="index.html" method="post" class="contact-form">
                                <div class="form-group">
                                    <input type="text" id="contact_name" name="contact_name" class="form-control"
                                        placeholder="Name" required />
                                </div>
                                <div class="form-group">
                                    <input type="email" id="contact_email" name="contact_email"
                                        class="form-control" placeholder="Email" required />
                                </div>
                                <div class="form-group">
                                    <input type="text" id="contact_subject" name="contact_subject"
                                        class="form-control" placeholder="Subject" required />
                                </div>
                                <div class="form-group">
                                    <textarea id="contact_message" name="contact_message" class="form-control" rows="9" placeholder="Message"
                                        required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary tm-btn-primary">Send Message
                                    Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <footer id='footer-section'>
            <div class="footer-area">
                <div class="container">
                    <div class="row">
                        <div class="my-md-0 my-5 col-md-4 col-sm-4 col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <div class="footer-logo">
                                        <h2>{!! __('content.section-footer.ours.title') !!}</h2>
                                    </div>
                                    {!! __('content.section-footer.ours.subtitle') !!}
                                    <p></p>
                                    <div class="footer-icons">
                                        <ul>
                                            @if ($contacts != null)
                                                @foreach ($contacts as $data)
                                                    @if ($data->status != 2)
                                                        <li>
                                                            <a onclick="window.open('{{ $data->contact_link }}')">
                                                                @if ($data->type == 1)
                                                                    <i class='fa fa-whatsapp'>
                                                                    @elseif($data->type == 2)
                                                                        <i class='fa fa-facebook'>
                                                                        @elseif($data->type == 3)
                                                                            <i class='fa fa-instagram'>
                                                                            @elseif($data->type == 4)
                                                                                <i class='fa fa-twitter'>
                                                                                @elseif($data->type == 5)
                                                                                    <i class='fa fa-phone'>
                                                                @endif
                                                                </i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                            {{-- <li>
                                                <a href="#"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-google"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                        <div class="mb-md-0 mb-5 col-md-4 col-sm-4 col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <h4>{!! __('content.section-footer.info.title') !!}</h4>
                                    <p>
                                        {!! __('content.section-footer.info.subtitle') !!}
                                    </p>
                                    <div class="footer-contacts">
                                        @php
                                            $locale = config('app.locale');
                                            if (str_contains($locale, 'zh')) {
                                                $locale='zh';
                                            }
                                        @endphp
                                        @isset($home_pages)
                                            <p><span>{!! __('content.section-footer.info.tel') !!} </span>{{ $homepage_tel }}
                                            </p>
                                            <p><span>{!! __('content.section-footer.info.email') !!} </span>{{ $homepage_email }}
                                            </p>
                                            <p><span>{!! __('content.section-footer.info.wh') !!} </span>
                                                @if ($wh_start == $wh_end)
                                                    {!! __('content.section-footer.info.wh-every') !!}
                                                @else
                                                    {!! __('content.section-footer.info.wh-msg', [
                                                        'start' => $wh_start,
                                                        'end' => $wh_end,
                                                    ]) !!}
                                                @endif

                                            </p>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head note_text">
                                    <h4>{!! __('content.section-footer.note.title') !!}</h4>
                                    <p>{!! __('content.section-footer.note.subtitle-1') !!}</p>
                                    <p>{!! __('content.section-footer.note.subtitle-2') !!}</p>
                                    <div class="note_subtext">
                                        <p>{!! __('content.section-footer.note.msg-1') !!}</p>
                                        <p>{!! __('content.section-footer.note.msg-2') !!}</p>
                                        <p>{!! __('content.section-footer.note.msg-3') !!}</p>
                                        <p>{!! __('content.section-footer.note.msg-4') !!}</p>
                                        <p>{!! __('content.section-footer.note.msg-5') !!}</p>
                                    </div>
                                    {{-- <div class="flicker-img">
                                        <a href="#"><img src="img/portfolio/1.jpg" alt=""></a>
                                        <a href="#"><img src="img/portfolio/2.jpg" alt=""></a>
                                        <a href="#"><img src="img/portfolio/3.jpg" alt=""></a>
                                        <a href="#"><img src="img/portfolio/4.jpg" alt=""></a>
                                        <a href="#"><img src="img/portfolio/5.jpg" alt=""></a>
                                        <a href="#"><img src="img/portfolio/6.jpg" alt=""></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-area-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="copyright text-center">
                                <p>
                                    &copy; Copyright <strong>eBusiness</strong>. All Rights Reserved
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        {{-- <footer class="tm-bg-dark-blue">
            <div class="container">
                <div class="row">
                    <p class="col-sm-12 text-center tm-font-light tm-color-white p-4 tm-margin-b-0">
                        Copyright &copy; <span class="tm-current-year">2018</span> Your Company

                        - Design: Tooplate</p>
                </div>
            </div>
        </footer> --}}
    </div>

    <!-- load JS files -->
    {{-- <script src="{{ asset('assets/homepage/js/jquery-1.11.3.min.js') }}"></script> <!-- jQuery (https://jquery.com/download/) --> --}}
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="{{ asset('assets/homepage/js/popper.min.js') }}"></script> <!-- https://popper.js.org/ -->
    <script src="{{ asset('assets/homepage/js/bootstrap.min.js') }}"></script> <!-- https://getbootstrap.com/ -->
    <script src="{{ asset('assets/homepage/js/datepicker.min.js') }}"></script> <!-- https://github.com/qodesmith/datepicker -->
    <script src="{{ asset('assets/homepage/js/jquery.singlePageNav.min.js') }}"></script> <!-- Single Page Nav (https://github.com/ChrisWojcik/single-page-nav) -->
    {{-- <script type="text/javascript" src="{{ asset('assets/homepage/slick/slick.min.js') }}"></script> --}}
    <script src="{{ asset('assets/homepage/slick/slick.min.js') }}"></script> <!-- http://kenwheeler.github.io/slick/ -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        new PureCounter();
        /*         // Plain javascript
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    var locale = document.getElementsByTagName("html")[0].getAttribute("lang");
                                                                                                                                                                                                                                                                                                                                                                                                                                                        // jQuery
                                                                                                                                                                                                                                                                                                                                                                                                                                                        var localeJquery = $('html').attr('lang'); */

        //var sValue = '<%=HttpContext.Current.Session["register"]%>';
        /* console.log('start');
        console.log({{ Session::get('register') }});
        console.log('end'); */
        //var a = '@Request.RequestContext.HttpContext.Session["register"]';
        //console.log('<%=Session("register") %>');
        //window.location.href = '/lol';
        //$(".transition-section").css("pointer-events", "none");
        var base_fx = 1;
        var result_fx = 1;
        var base_curr_id = null
        var result_curr_id = null
        $currencies = {!! json_encode($currencies) !!};
        $countries = {!! json_encode($countries) !!};
        $fxes = {!! json_encode($fxes) !!};
        $banks = {!! json_encode($banks) !!};
        $bank_accounts = {!! json_encode($bank_accounts) !!};
        $currencies_countries = {!! json_encode($currencies_countries) !!};
        $home_pages = {!! json_encode($home_pages) !!};
        //$fxes.find(obj => obj.base_currency_id == '1' && obj.result_currency_id == '2')
        $("#inputSendAmountModal").on('input', allowDigitsOnly);
        $("#base_amt_homePage").on('input', allowDigitsOnly);
        $("#result_amt_homePage").on('input', allowDigitsOnly);
        $("#base_amt_homePage").on('input', getFxRateOnInput);
        $("#result_amt_homePage").on('input', getFxRateOnInput);
        $("#sel_from_curr").on('change', getFxRateOnInput);
        $("#sel_to_curr").on('change', getFxRateOnInput);
        $("#fx-arrow-rotate").on('click', function() {
            var from = $('#sel_from_curr').val();
            var to = $('#sel_to_curr').val();
            $("#sel_from_curr").val(to).trigger('change');
            $("#sel_to_curr").val(from).trigger('change');
        });
        $('#section-title').on("animationend", function() {
            $(this).removeClass('w3-animate-zoom');
        });
        /* $('#title_from_country').on("animationend", function() {
            $(this).removeClass('w3-animate-zoom');
        });
        $('#title_to_country').on("animationend", function() {
            $(this).removeClass('w3-animate-zoom');
        }); */

        function compareStrings(a, b) {
            // Assuming you want case-insensitive comparison
            a = a.toLowerCase();
            b = b.toLowerCase();

            return (a < b) ? -1 : (a > b) ? 1 : 0;
        }

        $alphabet = '';
        var first_country = $currencies_countries.find(obj => obj.id == 1);
        appendSelect2($('.js-example-basic-single'), first_country['id'], first_country['country']['id'], first_country[
            'country'][
            'name'
        ], first_country['name']);
        $currencies_countries.sort(function(a, b) {
            return compareStrings(a.country.name, b.country.name);
        }).forEach(function($data, $key) {
            if ($data['id'] != 1) {
                appendSelect2($('.js-example-basic-single'), $data['id'], $data['country']['id'], $data['country'][
                    'name'
                ], $data['name']);
            }
        });

        function appendSelect2(select, id, country_id, country_name, name) {
            var alpha_onchange = false;
            var append = '';
            /* if ($alphabet != $data['country']['name'].charAt(0).toUpperCase()) {
                $alphabet = $data['country']['name'].charAt(0).toUpperCase();
                append += "<optgroup label='" + $alphabet + "'>";
                alpha_onchange = true;
            } */
            append += "<option value='" + id + "." + country_id + "' alt='" + $alphabet + "'>" + country_name + " (" +
                name + ")</option>";
            /* append += "<option value='" + $data['id'] + "." + $data[
                'country']['id'] + "' alt='" + $alphabet + "'>" + $data['country']['name'] + " (" + $data[
                'name'] + ")</option>"; */
            /* if (alpha_onchange) {
                append += "</optgroup>";
            } */
            select.append(append);
        }

        function allowDigitsOnly(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, "");
            if ((e.target.value).charAt(0) === '0') {
                e.target.value = (e.target.value).substr(1);
            }
            if (e.target.value === '') {
                e.target.value = '0';
            }
        }

        function getFxRateOnInput(e) {
            base_fx = 1;
            result_fx = 1;
            base_curr_id = parseInt($("#sel_from_curr").val().split(".")[0]);
            result_curr_id = parseInt($("#sel_to_curr").val().split(".")[0]);
            //var fx = $fxes.find(obj => obj.base_currency_id == base_curr_id && obj.result_currency_id == result_curr_id);
            var fbase_fx = $fxes.find(obj => obj.result_currency_id == base_curr_id);
            var fresult_fx = $fxes.find(obj => obj.result_currency_id == result_curr_id);
            if (fbase_fx !== undefined) {
                base_fx = fbase_fx['fx_rate'];
            }
            if (fresult_fx !== undefined) {
                result_fx = fresult_fx['fx_rate'];
            }
            if (e.target.id === 'base_amt_homePage' || e.target.id === 'sel_from_curr' || e.target.id === 'sel_to_curr') {
                var inputVal = parseFloat($("#base_amt_homePage").val());
                $("#result_amt_homePage").val(parseInt((inputVal / base_fx) * result_fx));
            } else if (e.target.id === 'result_amt_homePage') {
                var inputVal = parseFloat($("#result_amt_homePage").val());
                $("#base_amt_homePage").val(parseInt((inputVal / result_fx) * base_fx));
            }
            var from_curr_id = $('#sel_from_curr').val().split(".")[0];
            var from_curr_name = $currencies.find(obj => obj.id == from_curr_id)['name'];
            var to_curr_id = $('#sel_to_curr').val().split(".")[0];
            var to_curr_name = $currencies.find(obj => obj.id == to_curr_id)['name'];
            $('#display_base_curr').html(from_curr_name);
            $('#display_result_amt').html(toFixed(parseFloat((1 / base_fx) * result_fx), 10));
            $('#display_result_curr').html(to_curr_name);
            var from_country_id = $('#sel_from_curr').val().split(".")[1];
            var from_country_name = $countries.find(obj => obj.id == from_country_id)['name'];
            var to_country_id = $('#sel_to_curr').val().split(".")[1];
            var to_country_name = $countries.find(obj => obj.id == to_country_id)['name'];
            $('#title_from_country').html(from_country_name);
            $('#title_to_country').html(to_country_name);
            $('#data-sm-title').html("{!! __('content.index-sm.title', ['c1' => '"+from_country_name+"', 'c2' => '"+to_country_name+"']) !!}");
            $('#section-title').addClass('w3-animate-zoom');
            /* $('#title_from_country').addClass('w3-animate-zoom');
            $('#title_to_country').addClass('w3-animate-zoom'); */
            $('#form_input_from_country').attr('value', from_country_id);
            $('#form_input_to_country').attr('value', to_country_id);
            $('#form_input_from_currency').attr('value', from_curr_id);
            $('#form_input_to_currency').attr('value', to_curr_id);
            $('#form_input_from_currency').attr('value', from_curr_id);
            $('#form_input_to_currency').attr('value', to_curr_id);
            var from_min_amt = $currencies.find(obj => obj.id == from_curr_id)['min_amt'];
            var from_max_amt = $currencies.find(obj => obj.id == from_curr_id)['max_amt'];
            $('#send_min_max_homepage').html("{!! __('content.exchange.base-hint', [
                'from_min_amt' => '"+from_min_amt+"',
                'from_max_amt' => '"+from_max_amt+"',
                'from_curr_name' => '"+from_curr_name+"',
            ]) !!}");
            /* $('#send_min_max_homepage').html("{{ __('content.exchange.base-hint') }}" + " (" + from_min_amt + " ~ " +
                from_max_amt + " " + from_curr_name +
                ")"); */
        }
        /* var array_currency = []; */

        function toFixed(num, fixed) {
            var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
            return num.toString().match(re)[0];
        }

        function matchStart(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }

            if (typeof data.text === 'undefined') {
                return null;
            }

            return data.text.toUpperCase().indexOf(params.term.toUpperCase()) >= 0
        }

        function formatState(state) {
            /* console.log((state.id).split(".",1)); */
            if (!state.id) {
                return state.text;
            }
            var country_id = parseInt((state.id).split(".")[1]);
            //var baseUrl = "{{ asset('assets/img/flag') }}";
            var country = $countries.find(obj => obj.id == country_id)
            if (country != null) {
                var $state = $(
                    "<span style='margin-right:6px;white-space:nowrap;text-overflow:ellipsis;'><span class='fi fi-" +
                    country['alpha_2_code']
                    .toLowerCase() + " mx-2'></span>" +
                    state.text + '</span>'
                );
            } else {
                return state.text;
            }

            return $state;
        };

        function formatCountry(state) {
            /* console.log((state.id).split(".",1)); */
            if (!state.id) {
                return state.text;
            }
            var country_id = parseInt(($('#sel_from_curr').val()).split(".")[1]);
            var bank_id = $banks.filter(obj => obj.country_id == country_id);
            console.log(bank_id);
            return;
            //var baseUrl = "{{ asset('assets/img/flag') }}";
            var $state = $(
                "<span style='margin-right:6px;'><span class='fi fi-" + $countries[country_id - 1]['alpha_2_code']
                .toLowerCase() + " mx-2'></span>" +
                state.text + '</span>'
            );

            return $state;
        };

        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                templateResult: formatState,
                templateSelection: formatState,
                width: '100%',
                allowClear: false,
                height: 'auto',
            });

            $('.modalSelect2').select2({
                width: '100%',
                allowClear: true,
                height: 'auto',
                templateResult: formatCountry,
                templateSelection: formatCountry,
                dropdownParent: $('#exampleModal'),
            });
        });
    </script>
    @include('function/homepage/triggerFunction')
    <script>
        $(document).ready(function() {
            init();
        });

        function init() {
            $('#base_amt_homePage').val(0).trigger("input");
            $('.reviews-slider').slick({
                /* slidesToShow: 3, */
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3333,
                pauseOnFocus: false,
                pauseOnHover: false,
                pauseOnDotsHover: false,
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                        }
                    },
                    /* {
                        breakpoint: 99999,
                        settings: {
                            slidesToShow: 3,
                        }
                    } */
                ],
            });

            /* $.getJSON("{{ asset('assets/homepage/json/reviews.json') }}", function(data) {
                var items = [];
                $.each(data, function(key, val) {
                    $('.reviews-slider').slick('slickAdd', cardReview(val['prof'], val['name'][locale], val[
                        'occupation'][locale], val['comments'][locale]));
                });
            }); */

            $('.reviews-slider2').slick({
                /* slidesToShow: 3, */
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 6667,
                pauseOnFocus: false,
                pauseOnHover: false,
                pauseOnDotsHover: false,
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                        }
                    },
                    /* {
                        breakpoint: 99999,
                        settings: {
                            slidesToShow: 3,
                        }
                    } */
                ],
            });

            $('.reviews-slider2').slick('slickAdd', cardReview2(1, "{{ asset('assets/homepage/guides/1.png') }}",
                "{!! __('content.section-guideline.steps.1.title') !!}", "{!! __('content.section-guideline.steps.1.msg') !!}"));
            $('.reviews-slider2').slick('slickAdd', cardReview2(2, "{{ asset('assets/homepage/guides/2.png') }}",
                "{!! __('content.section-guideline.steps.2.title') !!}",
                "{!! __('content.section-guideline.steps.2.msg') !!}"
            ));
            $('.reviews-slider2').slick('slickAdd', cardReview2(3, "{{ asset('assets/homepage/guides/3.png') }}",
                "{!! __('content.section-guideline.steps.3.title') !!}",
                "{!! __('content.section-guideline.steps.3.msg') !!}"));
            $('.reviews-slider2').slick('slickAdd', cardReview2(4, "{{ asset('assets/homepage/guides/4.png') }}",
                "{!! __('content.section-guideline.steps.4.title') !!}",
                "{!! __('content.section-guideline.steps.4.msg') !!}"));
            $('.reviews-slider2').slick('slickAdd', cardReview2(5, "{{ asset('assets/homepage/guides/5.png') }}",
                "{!! __('content.section-guideline.steps.5.title') !!}",
                "{!! __('content.section-guideline.steps.5.msg') !!}"));
            $('.reviews-slider2').slick('slickAdd', cardReview2(6, "{{ asset('assets/homepage/guides/6.png') }}",
                "{!! __('content.section-guideline.steps.6.title') !!}",
                "{!! __('content.section-guideline.steps.6.msg') !!}"));
            $('.reviews-slider2').slick('slickAdd', cardReview2(7, "{{ asset('assets/homepage/guides/7.png') }}",
                "{!! __('content.section-guideline.steps.7.title') !!}",
                "{!! __('content.section-guideline.steps.7.msg') !!}"));
            /* $('.reviews-slider2').slick('slickAdd', cardReview2("{{ asset('assets/homepage/guides/2.png') }}", 2,
                'HELLO'));
            $('.reviews-slider2').slick('slickAdd', cardReview2("{{ asset('assets/homepage/guides/3.png') }}", 3,
                'HELLO'));
            $('.reviews-slider2').slick('slickAdd', cardReview2("{{ asset('assets/homepage/guides/4.png') }}", 4,
                'HELLO'));
            $('.reviews-slider2').slick('slickAdd', cardReview2("{{ asset('assets/homepage/guides/5.png') }}", 5,
                'HELLO'));
            $('.reviews-slider2').slick('slickAdd', cardReview2("{{ asset('assets/homepage/guides/6.png') }}", 6,
                'HELLO')); */
        }

        function cardReview(prof, name, occupation, comments) {
            return "<div class='card'><img src='" + prof +
                "' class='card-img-top p-5' style='border-radius: 50%;'><div class='card-body'><h5 class='card-title'>" +
                name +
                "</h5><h6 class='card-subtitle mb-2 text-muted'>" +
                occupation + "</h6><p class='card-text'>" + comments + "</p></div></div>";
        }

        function cardReview2(step, img, title, text) {
            return "<div class='card'><div class='guide-num'>" + step + "</div><img src='" + img +
                "' class='card-img-top p-2 guide-img'><div class='card-body guide-card-body'><h5 class='card-title text-center'>" +
                title +
                "</h5><p class='card-text'>" + text + "</p></div></div>";
        }
    </script>
    <script>
        $notification_pop = false;
        //$notification_close_on_scroll = 0;
        $(document).ready(function() {
            $('#navMenu').addClass('popUp');
            $('#navLanguage').addClass('popUp');
            $(document).scroll(function() {
                if ($(document).width() <= 991) {
                    $("#notification_count").fadeIn("slow").css("display", "inline");
                    $("#notificationContainer").hide();
                }
            });

            /* $(".popUp").hover(function() {
                $(this).toggleClass("active");
            }); */

            /* $('.popUp').click(function() {
                $('.active').not($(this)).removeClass('active');
                $(this).toggleClass('active');
                //event.stopPropagation();
            }) */

            $('#dropdownMenu2,#dropdownMenu3').click(function() {
                $("#notificationContainer").hide();
            });

            $("#notificationLink").click(function() {
                $('.collapse').collapse('hide');
                $('.dropdown-menu').removeClass('show');
                if ($notification_pop) {
                    $notification_pop = false;
                    $("#notification_count").fadeIn("slow").css("display", "inline");
                    $("#notificationContainer").hide();
                    $('#navMenu').addClass('popUp');
                    $('#navLanguage').addClass('popUp');
                } else {
                    $notification_pop = true;
                    /* $notification_close_on_scroll = document.documentElement.scrollTop; */
                    $("#notificationContainer").fadeToggle(300);
                    $("#notification_count").css("display", "none");
                    $('#navMenu').removeClass('popUp');
                    $('#navLanguage').removeClass('popUp');
                }
                return false;
            });

            //Document Click hiding the popup 
            $(document).click(function() {
                if ($notification_pop) {
                    $notification_pop = false;
                    $("#notification_count").fadeIn("slow").css("display", "inline");
                    $("#notificationContainer").hide();
                    $('#navMenu').addClass('popUp');
                    $('#navLanguage').addClass('popUp');
                }
            });

            //Popup on click
            $("#notificationContainer").click(function() {
                return false;
            });

        });

        function getLocale() {
            var locale = $('html').attr('lang');
            if (locale.includes('zh')) locale = 'zh';
            return locale;
        }
    </script>
    @auth
        <script>
            $notification_list = [];
            $notification_unread_count = 0;
            retrieveNotification();
            $active = false;
            $notification_init_alert = false;
            /* var active = false;
            var notificationAlert = 0; */
            var notification_countdown = setInterval(function() {
                retrieveNotification();
            }, 10000);

            $(document).ready(function() {
                window.addEventListener('click', () => {
                    $('body').bind('touchstart touchmove scroll mousedown DOMMouseScroll mousewheel keyup',
                        function(event) {
                            $active = true;
                        }
                    );
                }, {
                    once: true
                });
            });

            /* var timeoutTime = 60000;
            var timeoutTimer;
            $(document).ready(function() {
                window.addEventListener('click', () => {
                    $('body').bind('touchstart touchmove scroll mousedown DOMMouseScroll mousewheel keyup',
                        function(event) {
                            active = true;
                            notificationAlert = 1;
                            timeoutTimer = timeoutActive(timeoutTimer, timeoutTime);
                        }
                    );
                }, {
                    once: true
                });
            }); */

            /* function timeoutActive(timeoutTimer, timeoutTime) {
                clearTimeout(timeoutTimer);
                return setTimeout(function() {
                    active = false;
                }, timeoutTime);
            } */

            function retrieveNotification() {
                $.ajax({
                    type: 'GET',
                    url: "/get-notification",
                    success: function(result) {
                        $notification_temp = [];
                        $.each(result, function() {
                            $.each(this, function(key, value) {
                                $notification_temp.push(value);
                            });
                        });
                        refreshNotificationList($notification_list, $notification_temp);
                        return;
                        /* if (notificationAlert == 1) {
                            triggerNotificationAlert();
                            notificationAlert = 2;
                        } */
                        if (!compareArrays($notification_list, $notification_temp)) {
                            $notification_list = $notification_temp;
                            refreshNotificationList();
                            /* if (notificationAlert == 2) {
                                triggerNotificationAlert();
                            } */
                            /* var activeListerner = setInterval(function() {
                                if (active) {
                                    clearInterval(activeListerner);
                                    
                                }
                            }, 500); */
                            /* var audio = document.getElementById('notification-alert-sound');
                            setTimeout(function() {
                                audio.play();
                                $('body').addClass('shake-animation');
                                //$('#notificationLink > i').addClass('shake-animation');
                                $('#notificationLink > i').css('color', 'yellow');
                                if (active) {
                                    setTimeout(function() {
                                        audio.load(); // 1.5秒后关闭音频通知
                                        $('body').removeClass('shake-animation');
                                        //$('#notificationLink > i').removeClass('shake-animation');
                                        $('#notificationLink > i').css('color', '');
                                    }, 500);
                                }

                            }, 1500); */
                        }
                        /* if(($notification_list.length > 0) && ($("#notificationsBody").html().trim()=='')){
                            $('#notification_count').css('display','inline');
                        }else{
                            $('#notification_count').css('display','none');
                        } */
                        //refreshNotificationList();
                    },
                    error: function(data) {
                        console.log('nande');
                        console.log(data);
                    }
                });

                function triggerNotificationAlert() {
                    var audio = document.getElementById('notification-alert-sound');
                    audio.play();
                    /* $('body').addClass('shake-animation'); */
                    $('#notificationLink > i').addClass('shake-animation');
                    $('#notificationLink > i').css('color', 'yellow');
                    setTimeout(function() {
                        audio.load(); // 1.5秒后关闭音频通知
                        /* $('body').removeClass('shake-animation'); */
                        $('#notificationLink > i').removeClass('shake-animation');
                        $('#notificationLink > i').css('color', '');
                    }, 500);
                }

                function compareArrays(arr1, arr2, exclude = []) {
                    // check the length
                    if (arr1.length != arr2.length) {
                        return false;
                    } else {
                        let result = false;
                        // comparing each element of array 
                        for (let i = 0; i < arr1.length; i++) {
                            var arr1_array = Object.entries(arr1[i]);
                            var arr2_array = Object.entries(arr2[i]);
                            for (let j = 0; j < arr1_array.length; j++) {
                                if (!exclude.includes(arr1_array[j][0])) {
                                    if (JSON.stringify(arr1_array[j][1]) != JSON.stringify(arr2_array[j][1])) {
                                        console.log(arr1_array[j][0]);
                                        console.log(arr1_array[j][0]);
                                        return false;
                                    } else {
                                        result = true;
                                    }
                                }
                            }
                        }
                        return result;
                    }
                }

                function getNotificationMessageFromType(t_id, t_pad, type, reason = '') {
                    var message = '';
                    if (t_id != -1) {
                        //var t_pad = t_id;
                        //var t_pad = (t_id.toString()).padStart(5, '0');
                        var t_order = "{!! __('content.notification.order', ['transaction_id' => '"+t_pad+"']) !!}";
                        if (type == 1) {
                            message += "{!! __('content.notification.pending', ['order' => '"+t_order+"']) !!}";
                        } else if (type == 2) {
                            message += "{!! __('content.notification.confirm', ['order' => '"+t_order+"']) !!}";
                        } else if (type == 3) {
                            message += "{!! __('content.notification.cancel', ['order' => '"+t_order+"']) !!}";
                        } else if (type == 4) {
                            message += "{!! __('content.notification.accept', ['order' => '"+t_order+"']) !!}";
                        } else if (type == 5) {
                            message += "{!! __('content.notification.reject', ['order' => '"+t_order+"']) !!}";
                        } else if (type == 6) {
                            message += "{!! __('content.notification.reject-timeout', ['order' => '"+t_order+"']) !!}";
                        } else if (type == 7) {
                            message += "{!! __('content.notification.error', ['order' => '"+t_order+"']) !!}";
                        } else if (type == 8) {
                            message += "";
                        }
                    }
                    if (reason) {
                        message += ' ' + Object.values(reason)[1][getLocale()];
                    }
                    return message;
                }

                function arrayWithSpecificKey(arr, keys) {
                    var new_arr = [];
                    for (let i = 0; i < arr.length; i++) {
                        var arr_array = Object.entries(arr[i]);
                        var new_arr_array = [];
                        for (let j = 0; j < arr_array.length; j++) {
                            if (keys.includes(arr_array[j][0])) {
                                new_arr_array[arr_array[j][0]] = arr_array[j][1];
                            }
                        }
                        new_arr[i] = new_arr_array;
                    }
                    return new_arr;
                }

                function refreshNotificationList(notification_list, notification_temp) {
                    var notification_alert = !compareArrays(arrayWithSpecificKey(notification_list, ['created_at']),
                        arrayWithSpecificKey(notification_temp, ['created_at']));
                    $notification_list = notification_temp;
                    $notification_unread_count = 0;
                    $new_body = '';
                    //$('#notificationsBody').html('');
                    $notification_list.forEach(element => {
                        var ref_no = '';
                        var reason = '';
                        if (element['transasction']) {
                            ref_no = element['transasction']['ref_no'];
                        }
                        if (element['reason']) {
                            reason = element['reason'];
                        }
                        var notification_message = getNotificationMessageFromType(element[
                            'id'], ref_no, element[
                            'message_type'], reason);
                        if (element['status'] == 1) {
                            $notification_unread_count += 1;
                        }
                        if (moment().diff(moment(element['created_at']), 'years') > 0) {
                            var years_ago = moment().diff(moment(element['created_at']), 'years');
                            if (years_ago <= 1) {
                                var created_at_message = years_ago + " year ago";
                            } else {
                                var created_at_message = years_ago + " years ago";
                            }
                        } else if (moment().diff(moment(element['created_at']), 'months') > 0) {
                            var months_ago = moment().diff(moment(element['created_at']), 'months');
                            if (months_ago <= 1) {
                                var created_at_message = months_ago + " month ago";
                            } else {
                                var created_at_message = months_ago + " months ago";
                            }
                        } else if (moment().diff(moment(element['created_at']), 'weeks') > 0) {
                            var weeks_ago = moment().diff(moment(element['created_at']), 'weeks');
                            if (weeks_ago <= 1) {
                                var created_at_message = weeks_ago + " week ago";
                            } else {
                                var created_at_message = weeks_ago + " weeks ago";
                            }
                        } else if (moment().diff(moment(element['created_at']), 'days') > 0) {
                            var days_ago = moment().diff(moment(element['created_at']), 'days');
                            if (days_ago <= 1) {
                                var created_at_message = days_ago + " day ago";
                            } else {
                                var created_at_message = days_ago + " days ago";
                            }
                        } else if (moment().diff(moment(element['created_at']), 'hours') > 0) {
                            var hours_ago = moment().diff(moment(element['created_at']), 'hours');
                            if (hours_ago <= 1) {
                                var created_at_message = hours_ago + " hour ago";
                            } else {
                                var created_at_message = hours_ago + " hours ago";
                            }
                        } else {
                            var minutes_ago = moment().diff(moment(element['created_at']), 'minutes');
                            if (minutes_ago <= 1) {
                                var created_at_message = minutes_ago + " minute ago";
                            } else {
                                var created_at_message = minutes_ago + " minutes ago";
                            }
                        }
                        var body = "<a href='#'' target='print_popup' id='" + element[
                            'id'] + "' class='notificationMessageText' value = '";
                        if (element['status'] == 1) {
                            body += "0";
                        } else {
                            body += "1"
                        }
                        body += "'>";
                        var hasReceiptImg = false;
                        var hasYourReceiptImg = false;
                        if (element['transasction'] != null) {
                            if (element['transasction'][
                                    'recipient_receipt_img_path'
                                ] !=
                                null && element['message_type'] == 4) {
                                hasReceiptImg = true;
                            }
                            if (element['transasction'][
                                    'receipt_img_path'
                                ] !=
                                null && element['message_type'] == 2) {
                                hasYourReceiptImg = true;
                            }
                        }
                        if (hasReceiptImg) {
                            //console.log(element['transasction']['recipient_receipt_img_path']);
                            body +=
                                "<img src='{{ URL::asset('/recipientReceiptAttach') }}/" + element['transasction'][
                                    'recipient_receipt_img_path'
                                ] +
                                "' class='notification-icon-main' style='left:10px;border: 1px solid rgba(231, 231, 232,0.5);' width='52' height='52'>";
                        } else if (hasYourReceiptImg) {
                            //console.log(element['transasction']['recipient_receipt_img_path']);
                            body +=
                                "<img src='{{ URL::asset('/receiptAttach') }}/" + element['transasction'][
                                    'receipt_img_path'
                                ] +
                                "' class='notification-icon-main' style='left:10px;border: 1px solid rgba(231, 231, 232,0.5);' width='52' height='52'>";
                        } else {
                            body += "<i class='fa fa-bell notification-icon-main' style='color:";

                            //d5dc23 yellow
                            //f39c0c orange
                            //4ed728 green
                            //e3291c red
                            //4ba5b1 blue
                            if (element['message_type'] == 1) {
                                body += "#d5dc23";
                            } else if (element['message_type'] == 2) {
                                body += "#4ba5b1";
                            } else if (element['message_type'] == 3) {
                                body += "#f39c0c";
                            } else if (element['message_type'] == 4) {
                                body += "#4ed728";
                            } else {
                                body += "#e3291c";
                            }
                            body += ";'></i>";
                        }

                        /* if (element['transaction_status'] == 2) {
                            body += "#4ba5b1";
                        }else if (element['transaction_status'] == 3) {
                            body += "#4ba5b1";
                        }else if (element['transaction_status'] == 4) {
                            body += "#4ba5b1";
                        }else if (element['transaction_status'] == 5) {
                            body += "#4ba5b1";
                        }else{
                            body += "#4ba5b1";
                        } */
                        body += "<p>" + notification_message + "</p><span>" + created_at_message + "</span>";
                        if (element['status'] == 1) {
                            body += "<i class='fa fa-circle notification-icon-unread'></i>";
                        }
                        body += "</div>";
                        $new_body += body;
                    });
                    $('#notificationsBody').html($new_body);
                    $('.notificationMessageText').on('click', function(e) {
                        /* Swal.fire({
                            icon: 'info',
                            title: 'Notification',
                            text: message,
                            footer: e.currentTarget.value,
                        }); */
                        if (e.currentTarget.getAttribute('value') == 1) {
                            //return;
                        }
                        e.currentTarget.setAttribute('value', 1);
                        var readOnly = false;
                        if (e.target.classList.contains('notification-icon-unread')) readOnly = true;
                        $.ajax({
                            type: 'PUT',
                            url: "/update-notification",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: e.currentTarget.id,
                            },
                            success: function(data) {
                                //console.log(data);
                                if (!readOnly) {
                                    if (data['redirect'] == true) {
                                        var url = 'view-receipt/' + data['id'];
                                        var importantStuff = window.open(url,
                                            'print_popup');
                                            document.location.href(url);
                                        if (!importantStuff || importantStuff.closed ||
                                            typeof importantStuff
                                            .closed == 'undefined') {
                                            console.log('block!!');
                                            document.location.href(url);
                                        } else {
                                            /* console.log('accessable');
                                            importantStuff.document.write('Loading preview...');
                                            importantStuff.location.href = url; */
                                        }
                                        /* e.currentTarget.setAttribute('onClick', window.open(
                                                    'view-receipt/' + data['id'], "print_popup")); */
                                        /* try {
                                            openTab('view-receipt/' + data['id']);
                                        } catch (error) {
                                            try {
                                                console.log('second method!');
                                                e.currentTarget.setAttribute('onClick', window.open(
                                                    'view-receipt/' + data['id'], "_blank"));
                                            } catch (error) {
                                                console.log('final weapon!');
                                                document.location.assign('view-receipt/' + data['id']);
                                            }
                                        } */
                                        //.log('redirect');
                                        //e.currentTarget.setAttribute('onClick', window.open('view-receipt/' + data['id'], "_blank"))
                                        /* var windowReference = window.open();

                                        myService.getUrl().then(function() {
                                            windowReference.location = 'view-receipt/' + data['id'];
                                        }); */
                                        //console.log(e);
                                        //e.href = 'view-receipt/' + data['id'];
                                        //e.currentTarget.target = '_blank';
                                        //e.currentTarget.setAttribute('target', '_blank');
                                        //e.currentTarget.setAttribute('href', 'view-receipt/' + data['id']);
                                        /* popupwindow(, '_blank',
                                            '500', '820'); */
                                    } else {
                                        e.preventDefault();
                                    }
                                    //window.location.href = 'view-notification?id=' + data, 'print_popup';
                                }
                                //popupwindow('view-notification?id='+data,'print_popup','500','820');
                                //popupwindow('view-receipt/'+data,'print_popup','500','820');
                                retrieveNotification();
                            },
                            error: function(data) {
                                e.currentTarget.setAttribute('value', 0);
                                console.log(data);
                            }
                        });
                    });
                    $('#notification_count').html($notification_unread_count);
                    if (($notification_unread_count > 0 && $active) && (!$notification_init_alert || notification_alert)) {
                        if (!$notification_init_alert) $notification_init_alert = true;
                        triggerNotificationAlert();
                    }
                }
            }

            function openTab(url) {
                // Create link in memory
                var a = window.document.createElement("a");
                a.target = '_blank';
                a.href = url;

                // Dispatch fake click
                var e = window.document.createEvent("MouseEvents");
                e.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                a.dispatchEvent(e);
            };

            /* $notification.forEach(element => {
                if (element['status'] == 1) {
                    $unread_notification.push(element);
                    console.log(moment(element['updated_at']));
                }
            });
            $('#notification_count').html($unread_notification.length); */
        </script>
    @endauth
    <script>
        function setPageHeight() {
            if ($(window).scrollTop() > $('.tm-section-2').position().top) {
                $(".tm-top-bar").addClass("active");
                $(".cus-nav").addClass("active");
                $("#notification_li").addClass("active");
                $('#notificationContainer').addClass("active");
                $('.cus-nav-lang-b').addClass("active");
                $('.cus-nav-user-b').addClass("active");
                /* $('#notification_count').addClass("active"); */
                $(".nav-user").css("hidden");
                $('#notificationContainer').css('transition-duration', '0.3s');
                $('#backToTop').addClass("active");
                /* $('#backToTop').css('bottom', '40px');
                $('#backToTop').css('opacity', '1'); */
                //$(".cus-nav#navLanguage").removeClass("active");
                $('#navLanguage').css('transition', 'margin 0.33s ease-out,opacity 0.33s ease-out');
                $('#navLanguage').css('margin', '-15px');
                $('#navLanguage').css('opacity', '0');
            } else {
                //remove the background property so it comes transparent again (defined in your css)
                $(".tm-top-bar").removeClass("active");
                $(".cus-nav").removeClass("active");
                $("#notification_li").removeClass("active");
                $(".nav-user").removeClass("active");
                $('#notificationContainer').removeClass("active");
                $('.cus-nav-lang-b').removeClass("active");
                $('.cus-nav-user-b').removeClass("active");
                /* $('#notification_count').removeClass("active"); */
                $('#notificationContainer').css('transition-duration', '0.7s');
                if ($('#mainNav').hasClass('show')) $('#mainNav').removeClass('show');
                $('#backToTop').removeClass("active");
                /* $('#backToTop').css('bottom', '-100px');
                $('#backToTop').css('opacity', '0'); */
                $('#navLanguage').css('margin', '0px');
                $('#navLanguage').css('opacity', '1');
                //$('#navLanguage').css('opacity', '0');
            }
        }

        function setCarousel() {

            if ($('.tm-article-carousel').hasClass('slick-initialized')) {
                $('.tm-article-carousel').slick('destroy');
            }

            if ($(window).width() < 438) {
                // Slick carousel
                $('.tm-article-carousel').slick({
                    infinite: false,
                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                });
            } else {
                $('.tm-article-carousel').slick({
                    infinite: false,
                    dots: true,
                    slidesToShow: 2,
                    slidesToScroll: 1
                });
            }
        }

        function setPageNav() {
            if ($(window).width() > 991) {
                $('#tm-top-bar').singlePageNav({
                    currentClass: 'active',
                    offset: 79
                });
            } else {
                $('#tm-top-bar').singlePageNav({
                    currentClass: 'active',
                    offset: 65
                });
            }
        }

        function togglePlayPause() {
            vid = $('.tmVideo').get(0);

            if (vid.paused) {
                vid.play();
                $('.tm-btn-play').hide();
                $('.tm-btn-pause').show();
            } else {
                vid.pause();
                $('.tm-btn-play').show();
                $('.tm-btn-pause').hide();
            }
        }
        $(document).ready(function() {
            //$('transition-section')
            $(window).on("scroll", function() {
                setPageHeight();
            });

            setCarousel();
            setPageNav();
            setPageHeight();

            $(window).resize(function() {
                setCarousel();
                setPageNav();
            });

            // Close navbar after clicked
            $('.nav-link').click(function() {

            });

            // Control video
            $('.tm-btn-play').click(function() {
                togglePlayPause();
            });

            $('.tm-btn-pause').click(function() {
                togglePlayPause();
            });

            // Update the current year in copyright
            $('.tm-current-year').text(new Date().getFullYear());

            /* $home_pages_data1 = $home_pages.find(obj => obj.name == 'Transaction Complete')['value'][getLocale()];
            $home_pages_data2 = $home_pages.find(obj => obj.name == 'Money Saved')['value'][getLocale()];
            $home_pages_data3 = $home_pages.find(obj => obj.name == 'Hours Time Saved')['value'][getLocale()];
            var home_pages_data_timer_count = 0;
            const home_pages_data_timer_interval = 3000;
            var home_pages_data_timer = setInterval(() => {
                var percent_home_page = (home_pages_data_timer_count / home_pages_data_timer_interval) *
                    100;
                if (home_pages_data_timer_count <= home_pages_data_timer_interval) {
                    home_pages_data_timer_count += 100;
                } else {
                    clearInterval(home_pages_data_timer);
                    return;
                }
                array.forEach(element => {
                    
                });
                $('#homepage-data1').html(parseInt($home_pages_data1) * percent_home_page);
            }, 100); */
        });
    </script>
    <script>
        $('#prime').click(function() {
            if ($('.fabs').hasClass('show')) {
                $('.fabs').removeClass('show');
            } else {
                $('.fabs').addClass('show');
            };
        });
        /* //floating button moveable
        const fabElement = $('#prime');
        //fabElement.top = "200px";
        //const fabElement = document.getElementById("prime");
        let oldPositionX, oldPositionY;

        const move = (e) => {
            console.log(e.clientX+","+e.clientY);
            if (!fabElement.hasClass("fab-active")) {
                if (e.type === "touchmove") {
                    fabElement.top = e.clientY + "px";
                    fabElement.left = e.clientX + "px";
                } else {
                    fabElement.animate({ top: e.clientY + "px" }, 0);
                    fabElement.animate({ left: e.clientX + "px" }, 0);
                    //fabElement.top = ;
                    //fabElement.left = e.clientX + "px";
                }
            }
        }; */

        /* const mouseDown = (e) => {
            console.log("mouse down ");
            oldPositionY = fabElement.top;
            oldPositionX = fabElement.left;
            if (e.type === "mousedown") {
                //window.addEventListener("mousemove", move);
                $(window).on("mousemove",move);
            } else {
                //window.addEventListener("touchmove", move);
                $(window).on("touchmove",move);
            }

            fabElement.transition = "none";
        };

        $('#prime').on("mousedown",mouseDown); */

        /* const mouseUp = (e) => {
            console.log("mouse up");
            if (e.type === "mouseup") {
                window.removeEventListener("mousemove", move);
            } else {
                window.removeEventListener("touchmove", move);
            }
            snapToSide(e);
            fabElement.style.transition = "0.3s ease-in-out left";
        }; */

        /* const snapToSide = (e) => {
            const wrapperElement = document.getElementById('top');
            //const wrapperElement = document.getElementById('main-wrapper');
            const windowWidth = window.innerWidth;
            let currPositionX, currPositionY;
            if (e.type === "touchend") {
                currPositionX = e.changedTouches[0].clientX;
                currPositionY = e.changedTouches[0].clientY;
            } else {
                currPositionX = e.clientX;
                currPositionY = e.clientY;
            }
            if (currPositionY < 50) {
                fabElement.style.top = 50 + "px";
            }
            if (currPositionY > wrapperElement.clientHeight - 50) {
                fabElement.style.top = (wrapperElement.clientHeight - 50) + "px";
            }
            if (currPositionX < windowWidth / 2) {
                fabElement.style.left = 30 + "px";
                fabElement.classList.remove('right');
                fabElement.classList.add('left');
            } else {
                fabElement.style.left = windowWidth - 30 + "px";
                fabElement.classList.remove('left');
                fabElement.classList.add('right');
            }
        }; */

        /* fabElement.addEventListener("mousedown", mouseDown);

        fabElement.addEventListener("mouseup", mouseUp);

        fabElement.addEventListener("touchstart", mouseDown);

        fabElement.addEventListener("touchend", mouseUp);

        fabElement.addEventListener("click", (e) => {
            if (
                oldPositionY === fabElement.style.top &&
                oldPositionX === fabElement.style.left
            ) {
                fabElement.classList.toggle("fab-active");
            }
        }); */
    </script>
    @include('layouts/homepage/contacts')
    {{-- @include('layouts/user-reviews-slider') --}}
</body>

</html>
