<div class="tm-section tm-bg-img transition-section" id="tm-section-1">
    <div class="container">
        <span class="title-font text-wrap">
            <p id='section-title'>{{ __('content.index-h1.1') }}
                <span id='title_from_country'></span>{{ __('content.index-h1.2') }}<span id='title_to_country'></span>
            </p>
        </span>
        <span class="subtitle-font">
            <p>
                {{ __('content.index-h2.1') }}
                <br> {{ __('content.index-h2.2') }}
            </p>
        </span>
        @php
            $locale = config('app.locale');
            if (str_contains($locale, 'zh')) {
                $locale='zh';
            }
        @endphp
        <div class="data-font-container-sm">
            <p class="text-center" id='data-sm-title'></p>
            <div class="row">
                <div class="col-3 text-center">
                    <span
                        class="data-font-container-sm-span1">{{ $home_pages->where('name', 'Remittance')->first()->value[$locale] }}</span>
                    <div class="w-100"></div>
                    <span class="data-font-container-sm-span2">{{ __('content.index-sm.row.1.2') }}</span>
                </div>
                <div class="col-3 text-center">
                    <span
                        class="data-font-container-sm-span1">{{ $home_pages->where('name', 'Arrival')->first()->value[$locale] }}</span>
                    <div class="w-100"></div>
                    <span class="data-font-container-sm-span2">{{ __('content.index-sm.row.2.2') }}</span>
                </div>
                <div class="col-3 text-center">
                    <span
                        class="data-font-container-sm-span1">{{ $homepage_fee }}</span>
                    <div class="w-100"></div>
                    <span class="data-font-container-sm-span2">{{ __('content.index-sm.row.3.2') }}</span>
                </div>
                <div class="col-3 text-center">
                    <span
                        class="data-font-container-sm-span1">{{ $homepage_bank }}</span>
                    <div class="w-100"></div>
                    <span class="data-font-container-sm-span2">{{ __('content.index-sm.row.4.2') }}</span>
                </div>
            </div>
        </div>
        <div class="data-font-container">
            <div class="data-font">
                <span class="data-font-bold d-flex purecounter" data-purecounter-start="0"
                    data-purecounter-duration="1.67"
                    data-purecounter-end="{{ $homepage_tc }}"
                    data-purecounter-separator="true">

                </span>
                <span class="d-flex">{{ __('content.index-data.1') }}</span>
            </div>
            <div class="data-font">
                <span class="data-font-bold d-flex purecounter" data-purecounter-start="0"
                    data-purecounter-duration="1.67"
                    data-purecounter-end="{{ $homepage_ms }}"
                    data-purecounter-separator="true">

                </span>
                <span class="d-flex">{{ __('content.index-data.2') }}</span>
            </div>
            <div class="data-font">
                <span class="data-font-bold d-flex purecounter" data-purecounter-start="100"
                    data-purecounter-duration="1.67"
                    data-purecounter-end="{{ $homepage_hts }}"
                    data-purecounter-separator="true">

                </span>
                <span class="d-flex">{{ __('content.index-data.3') }}</span>
            </div>
        </div>
        <div class="tm-bg-tp2 ie-container-width-fix-2 mx-auto">
            <div class="container ie-h-align-center-fix">
                <div class="row">
                    <div class="col-xs-12 ml-auto mr-auto ie-container-width-fix">
                        <form action="index.html" method="get" class="tm-search-form tm-section-pad-2">
                            <div class="form-row tm-search-form-row mb-3">
                                <div class="mx-auto">
                                    @isset($data)
                                        <marquee class="tm-margin-b-0 text-center" height="25px" scrollamount="3"
                                            truespeed="truespeed" direction="up">
                                            @foreach ($data as $item)
                                                <p style="color: white; font-size:15px;">{{ $item }}</p>
                                            @endforeach
                                        </marquee>
                                    @endisset
                                </div>
                            </div>
                            <div class="form-row tm-search-form-row">
                                <div class="form-group tm-form-element tm-form-element-100 mx-auto custom-form-element">
                                    <div class="btn-group tm-form-exchange row">
                                        <div class="col-lg-7 col-md-8 col-sm-8 col-xs-12">
                                            <span class="custom-floating-span custom-floating-span2"
                                                id='send_min_max_homepage'>{{ __('content.exchange.base-hint') }}</span>
                                            <input class="custom-floating-input" type="text" id="base_amt_homePage"
                                                value="0">
                                        </div>
                                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12" style="padding:0;">
                                            <select class="js-example-basic-single col-12" name="state"
                                                style="display:none;" id="sel_from_curr">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="div_fx_rate">
                                        <span class="display_fx_rate">
                                            <span id='display_fx_rate_only'>
                                                1
                                                <span id='display_base_curr'>MYR</span>
                                                =
                                                <span id='display_result_amt'>1.0000</span>
                                                <span id='display_result_curr'>MYR</span>
                                            </span>
                                            <span
                                                style="font-size: 12px;">{{ __('content.exchange.real-time-rate') }}</span>
                                            <img class="broken_line"
                                                src="{{ asset('assets/homepage/img/broken_line.png') }}"
                                                alt="">
                                        </span>
                                    </div>
                                </div>
                                <div class="custom-form-element2">
                                    <a id='fx-arrow-rotate'><img class="fx-arrow"
                                            src="{{ asset('assets/img/widgets/exchange.png') }}"></a>
                                </div>
                                <div class="form-group tm-form-element tm-form-element-100 mx-auto custom-form-element">
                                    <div class="btn-group tm-form-exchange row">
                                        <div class="col-lg-7 col-md-8 col-sm-8 col-xs-12">
                                            <span
                                                class="custom-floating-span custom-floating-span2">{{ __('content.exchange.result-hint') }}</span>
                                            <input class="custom-floating-input" type="text"
                                                id="result_amt_homePage" value="0">
                                        </div>
                                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12" style="padding:0;">
                                            <select class="js-example-basic-single" name="state"
                                                style="display:none;" id="sel_to_curr">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tm-form-element-2 mx-auto">
                                    <button type="button" id='btnGetStarted' class="btn btn-primary tm-btn-search"
                                        data-toggle="modal">
                                        {{ __('content.exchange.get-started') }}
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="form-row tm-search-form-row">
                                <div class="form-group tm-form-element tm-form-element-2 mx-auto">
                                    <button type="button" class="btn btn-primary  tm-btn-search"
                                        data-toggle="modal" data-target="#exampleModal">
                                        Get started
                                    </button>
                                </div>
                            </div> --}}
                            <div class="form-row clearfix pl-2 pr-2 tm-fx-col-xs">
                                {{-- <p class="tm-margin-b-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p> --}}
                                <a href="#help"
                                    class="ie-10-ml-auto ml-auto mt-1 tm-font-semibold tm-color-primary">{{ __('content.exchange.need-help') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
