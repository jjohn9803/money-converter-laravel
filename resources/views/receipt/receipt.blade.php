<html lang="{{ config('app.locale') }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.locale') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/receipt/style.css') }}">
</head>

<div class="container bg-light d-lg-flex align-items-center">
    <div class="card box2 shadow-sm p-lg-5 p-lg-5 p-4">
        <div class="p-lg-4 p-4" style="text-align:right;">
        </div>
        {{-- <div class="p-md-5 p-4" style="text-align:right;"> 
            <span class="h5 fw-bold m-0">
                Timer:
                <span>
                    <span class="h5 fw-bold ps-1" id='minutes'>10</span>
                    <span class="h4 fw-bold ps-1">:</span>
                    <span class="h5 fw-bold ps-1" id='seconds'>10</span>
                </span>
            </span>
        </div> --}}
        {{-- <div class="px-md-5 px-4 mb-4 d-flex align-items-center">
            <div class="btn btn-success me-4"><span class="fas fa-plus"></span></div>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group"> <input type="radio"
                    class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked> <label
                    class="btn btn-outline-primary" for="btnradio1"><span class="pe-1">+</span>5949</label> <input
                    type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off"> <label
                    class="btn btn-outline-primary" for="btnradio2"><span class="lpe-1">+</span>3894</label> </div>
        </div> --}}
        {{-- <form action="" id='receipt_form'> --}}
        <form action="/update-transaction-history" id='receipt_form' method="POST" enctype="multipart/form-data">
            @csrf
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            {{-- @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
            @endif --}}
            {{-- @isset($success)
                
            @endisset
            @isset($error)
                <div class="alert alert-danger" role="alert">
                    {{$error}}
                </div>
            @endisset --}}
            <input type="hidden" name="id" value=''>
            <input type="hidden" name="status" value=''>
            <div class="row">
                <div class="col-12" id='countdown' style="display:none;">
                    <div class="d-flex justify-content-center mb-5">
                        <div class="inputWithIcon timer-container">
                            <span class="timer-title">{!! __('content.receipt.countdown-timer') !!}</span>
                            <span class="timer-minutes-number" id='timer-minutes-number'>00</span>
                            <span class="timer-minutes-text">{!! __('content.receipt.minutes') !!}</span>
                            <span class="timer-symbol">:</span>
                            <span class="timer-seconds-number" id='timer-seconds-number'>00</span>
                            <span class="timer-seconds-text">{!! __('content.receipt.seconds') !!}</span>
                            {{-- <span class="fas fa-clock"></span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="d-flex flex-column px-4 mb-4">
                        <span>{!! __('content.receipt.rbank-acc') !!}</span>
                        <div class="inputWithIcon">
                            <input class="form-control copyable" type="text"
                                value="{{ $recipient_acc }} ({{ $recipient_bank_name }})"
                                onclick="copyToClipboard('{{ $recipient_acc }}');" readonly>
                            <span class="fas fa-user-check"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="d-flex flex-column px-4 mb-4">
                        <span>{!! __('content.receipt.reference-no') !!}</span>
                        <div class="inputWithIcon">
                            <input class="form-control copyable" type="text" value="{{ $ref_no }}"
                                onclick="copyToClipboard('{{ $ref_no }}');" readonly>
                            <span class="fas fa-receipt"></span>
                        </div>
                    </div>
                </div>
                @isset($recipient_receipt_img)
                    <div class="col-12">
                        <div class="d-flex flex-column px-4 mb-4">
                            <span>{!! __('content.receipt.recipient-receipt') !!}</span>
                            <img id='recipient-receipt'
                                src="{{ asset('recipientReceiptAttach') }}/{{ $recipient_receipt_img }}">
                        </div>
                    </div>
                @endisset
                <div class="col-12" id='section-receipt-screenshot' style="display: none;">
                    <div class="d-flex flex-column px-4 mb-4"> <span>{!! __('content.receipt.attach') !!}</span>
                        <div class="inputWithIcon">
                            <input class="form-control" type="file" accept="image/*" name='imgUpload' id="imgInp">
                            <span class="fas fa-image"></span>
                        </div>
                    </div>
                    <div class="col-12"><img id='preview-attach-receipt' src="#" alt="your image"
                            style="display:none;"></div>

                </div>
                <div class="col-12" id='section-receipt-screenshot-2'>
                    <div class="fw-bolder px-4">
                        <b class="text-danger">{!! __('content.receipt.important') !!}</b>
                        <span class="far text guide-text">
                            <span>{!! __('content.receipt.important-note') !!}</span>
                        </span>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column px-lg-4 px-4 mb-4">
                        <span>{!! __('content.receipt.email') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="{{ $email }}" readonly>
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="d-flex flex-column ps-lg-4 px-4 mb-4">
                        <span>{!! __('content.receipt.send-bank-acc') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control"
                                value="{{ $from_acc }} ({{ $from_bank }})" readonly>
                            <span class="fas fa-user-circle"></span>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="d-flex flex-column ps-md-5 px-md-0 px-4 mb-4">
                        <span>Your Sending Bank</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="{{ $from_bank }}" readonly>
                            <span class="fas fa-university"></span>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-6 col-12">
                    <div class="d-flex flex-column pe-lg-4 px-4 mb-4">
                        <span>{!! __('content.receipt.receive-bank-acc') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control"
                                value="{{ $your_receive_acc }} ({{ $your_receive_bank }})" readonly>
                            <span class="fas fa-money-check-alt"></span>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="d-flex flex-column ps-md-5 px-md-0 px-4 mb-4">
                        <span>Your Receiving Bank</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="" readonly>
                            <span class="fas fa-money-check"></span>
                        </div>
                    </div>
                </div> --}}
                <div class="col-6">
                    <div class="d-flex flex-column ps-lg-4 px-4 mb-4">
                        <span>{!! __('content.receipt.base-curr') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="{{ $from_curr }}" readonly>
                            <span class="fas fa-money-bill"></span>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column pe-lg-4 px-4 mb-4">
                        <span>{!! __('content.receipt.result-curr') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="{{ $to_curr }}" readonly>
                            <span class="fas fa-money-bill"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="d-flex flex-column ps-lg-4 px-4 mb-4">
                        <span>{!! __('content.receipt.base-amt') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="{{ $from_amount }}" readonly>
                            <span class="fas fa-money-bill"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="d-flex flex-column px-lg-0 px-4 mb-4">
                        <span>{!! __('content.receipt.fx-rate') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="{{ $fx_rate }}" readonly>
                            <span class="fas fa-percentage"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="d-flex flex-column pe-lg-4 px-lg-0 px-4 mb-4">
                        <span>{!! __('content.receipt.result-amt') !!}</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="{{ $result_amount }}" readonly>
                            <span class="fas fa-hand-holding-usd"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="fw-bolder mb-4">
                        <span class="far text guide-text px-5 py-3">
                            @php
                                $locale = config('app.locale');
                                if (str_contains($locale, 'zh')) {
                                    $locale='zh';
                                }
                            @endphp
                            @isset($home_page_tel, $home_page_email)
                                <span class="ps-2">{!! __('content.receipt.note-1', [
                                    'tel' => '<b class="copyable" id="homepage-tel">' . $home_page_tel . '</b>',
                                    'email' => '<b class="copyable" id="homepage-email">' . $home_page_email . '</b>',
                                ]) !!}</span>
                            @endisset
                        </span>
                        <span class="far text guide-text px-5 py-3">
                            <span class="ps-2 col">{!! __('content.receipt.note-2') !!}</span>
                        </span>
                        <span class="far text guide-text px-5 py-3">
                            <span class="far text">
                                <span class="ps-2"
                                    style="font-size:12px;font-weight: 600;">{!! __('content.receipt.note-danger') !!}</span>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <span>{!! __('content.receipt.status') !!}: <span id='status'></span></span>
                </div>
                @isset($receipt_img_path)
                    <div class="col-lg-6 px-lg-2 px-1 mt-3">
                        <input type="button" class="btn btn-info w-100" id='btnViewMyAttach' name='btnViewMyAttach'
                            value="{!! __('content.receipt.view-attach') !!}" />
                    </div>
                @endisset
                <div class="col-lg-6 px-lg-2 px-1 mt-3">
                    {{-- <div class="btn btn-danger w-100" id='btnCancel'>Cancel</div> --}}
                    <input type="button" class="btn btn-danger w-100" id='btnCancel' name='cancel'
                        value="{!! __('content.receipt.cancel') !!}" style="display: none;" />
                </div>
                <div class="col-lg-6 px-lg-2 px-1 mt-3">
                    {{-- <div class="btn btn-primary w-100" id='btnConfirm'>Confirm</div> --}}
                    <input type="button" class="btn btn-primary w-100" id='btnConfirm' name='confirm'
                        value="{!! __('content.receipt.confirm') !!}" style="display: none;" />
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
{{-- <script>
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script> --}}
<script>
    $('#homepage-tel').attr("onclick", "copyToClipboard('" + {!! json_encode($home_page_tel) !!} + "');");
    $('#homepage-email').attr("onclick", "copyToClipboard('" + {!! json_encode($home_page_email) !!} + "');");

    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);

    var end = moment({!! json_encode($end_date) !!});
    var status = {!! json_encode($status) !!};
    var statusText = '';
    /* document.querySelector('.timer-container').scrollIntoView({
        behavior: 'smooth'
    }); */
    refreshTimer();
    getStatus();
    updateTransactionStatus();

    function updateTransactionStatus() {
        $.ajax({
            type: 'GET',
            url: "/get-transaction-history-id",
            data: {
                id: {!! json_encode($id) !!},
            },
            success: function(result) {
                //console.log(result);
                updateStatus(result['status']);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    var countdown = setInterval(function() {
        refreshTimer();
        getStatus();
    }, 100);

    var timer_refresh = setInterval(() => {
        updateTransactionStatus();
    }, 3000);

    function refreshTimer() {
        var start = moment();
        var duration = moment.duration(end.diff(start));
        var minutes = duration.minutes();
        var seconds = duration.seconds();
        start.add(100, 'milliseconds');
        if (start.isAfter(end)) {
            console.log('over!!');
            receiptExpired();
            updateStatus(5);
            return;
        } else {
            $('#countdown').css('display', 'block');
        }
        if (minutes < 3) {
            $('.timer-minutes-number').css('color', 'red');
            $('.timer-seconds-number').css('color', 'red');
        }

        $('.timer-minutes-number').html((((minutes < 10) && (minutes > -1)) ? '0' + minutes : minutes));
        $('.timer-seconds-number').html((((seconds < 10) && (seconds > -1)) ? '0' + seconds : seconds));
    }

    $('#recipient-receipt').click(function() {
        if ($('#recipient-receipt').hasClass('preview')) {
            $('#recipient-receipt').removeClass('preview');
        } else {
            $('#recipient-receipt').addClass('preview');
        }
    });

    $('#preview-attach-receipt').click(function() {
        if ($('#preview-attach-receipt').hasClass('preview')) {
            $('#preview-attach-receipt').removeClass('preview');
        } else {
            $('#preview-attach-receipt').addClass('preview');
        }
    });

    function receiptExpired() {
        $('#countdown').css('display', 'none');
        clearInterval(countdown);
    }

    function copyToClipboard(text) {
        console.log('text: ' + text);
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        Swal.fire({
            icon: 'success',
            title: "{!! __('content.receipt.clipboard') !!}",
        });
    }

    $('#btnViewMyAttach').on('click', function() {
        Swal.fire({
            customClass: {
                image: 'swal-img',
            },
            imageUrl: "{!! asset('receiptAttach') !!}/" + {!! json_encode($receipt_img_path) !!},
            //imageClass: 'swal-img',
            imageAlt: "{!! __('content.receipt.view-attach') !!}",
            confirmButtonText: "{!! __('content.modal.login.close') !!}",
        })
    });

    $('#btnConfirm').on('click', function() {
        var valid = false;
        $.ajax({
            type: 'GET',
            url: "/validate-before-update-transaction-history",
            async: false,
            data: {
                "_token": "{{ csrf_token() }}",
                id: {!! json_encode($id) !!},
                status: 2,
            },
            success: function(result) {
                valid = true;
                console.log(result);
            },
            error: function(data) {
                getStatus();
                console.log(data);
            }
        });
        if (!valid) {
            return;
        }

        if ($('input[name=imgUpload]').val() == '') {
            Swal.fire({
                icon: 'warning',
                title: "{!! __('content.receipt.img-missing-title') !!}",
                text: "{!! __('content.receipt.img-missing-text') !!}",
                didClose: () => $('html,body').animate({
                        scrollTop: 0
                    },
                    'slow'),
            });
            //document.getElementById("section-receipt-screenshot").scrollIntoView();

            //$('html,body').scrollTop = $("#section-receipt-screenshot").offset().top;
            return false;
        }

        Swal.fire({
            title: "{!! __('content.receipt.t-form-title') !!}",
            text: "{!! __('content.receipt.t-confirm-form-text') !!}",
            icon: 'warning',
            footer: "{!! __('content.receipt.t-confirm-form-footer') !!}",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{!! __('content.receipt.t-confirm-form-confirm') !!}",
            cancelButtonText: "{!! __('content.receipt.cancel') !!}"
        }).then((result) => {
            if (result.isConfirmed) {
                $('input[name=id]').val({!! json_encode($id) !!});
                $('input[name=status]').val(2);
                $('#receipt_form').submit();
            } else {
                return false;
            }
        });
    });

    $('#btnCancel').on('click', function() {
        var valid = false;
        $.ajax({
            type: 'GET',
            url: "/validate-before-update-transaction-history",
            async: false,
            data: {
                "_token": "{{ csrf_token() }}",
                id: {!! json_encode($id) !!},
                status: 3,
            },
            success: function(result) {
                valid = true;
                console.log(result);
            },
            error: function(data) {
                getStatus();
                console.log(data);
            }
        });
        if (!valid) {
            return;
        }

        Swal.fire({
            title: "{!! __('content.receipt.t-form-title') !!}",
            text: "{!! __('content.receipt.t-cancel-form-text') !!}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{!! __('content.receipt.t-cancel-form-confirm') !!}",
            cancelButtonText: "{!! __('content.receipt.cancel') !!}"
        }).then((result) => {
            if (result.isConfirmed) {
                $('input[name=id]').val({!! json_encode($id) !!});
                $('input[name=status]').val(3);
                $('#receipt_form').submit();
            } else {
                return false;
            }
        });
    });

    $('#imgInp').on('change', function() {
        if ($('#imgInp').prop('files')) {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-attach-receipt').attr('src', e.target.result);
            }
            if ($('#preview-attach-receipt').css('display') == 'none') {
                $('#preview-attach-receipt').css('display', 'block');
            }
            reader.readAsDataURL(this.files[0]);
            //preview-attach-receipt
        }
    });

    $('#imgInp').click(function(e) {
        $.ajax({
            type: 'GET',
            url: "/validate-before-update-transaction-history",
            async: false,
            data: {
                "_token": "{{ csrf_token() }}",
                id: {!! json_encode($id) !!},
                status: 3,
            },
            success: function(result) {
                //console.log(result);
            },
            error: function(data) {
                console.log(data);
                $('#section-receipt-screenshot').css('display', 'none');
                e.preventDefault();
            }
        });
    });

    function updateStatus(willStatus) {
        //console.log('???? '+willStatus);
        if (status == 1) {
            status = willStatus;
            getStatus();
        }
    }

    function getStatus() {
        //console.log('status: '+status);
        if (status == 1) {
            statusText = "{!! __('content.receipt.pending') !!}";
            $('#btnCancel').css('display', 'block');
            $('#btnConfirm').css('display', 'block');
            $('#section-receipt-screenshot').css('display', 'block');
            $('#section-receipt-screenshot-2').css('display', 'block');
        } else {
            receiptExpired();
            $('#section-receipt-screenshot').css('display', 'none');
            $('#section-receipt-screenshot-2').css('display', 'none');
            $('#btnCancel').css('display', 'none');
            $('#btnConfirm').css('display', 'none');
        }
        if (status == 2) {
            statusText = "{!! __('content.receipt.confirm') !!}";
        } else if (status == 3) {
            statusText = "{!! __('content.receipt.cancelled') !!}";
        } else if (status == 4) {
            statusText = "{!! __('content.receipt.accepted') !!}";
        } else if (status == 5) {
            statusText = "{!! __('content.receipt.rejected') !!}"
        }
        if (status == 1 || status == 2) {
            $('#status').html("<span class='text-info'>" + statusText + "</span>");
        } else if (status == 3) {
            $('#status').html("<span class='text-warning'>" + statusText + "</span>");
        } else if (status == 4) {
            $('#status').html("<span class='text-success'>" + statusText + "</span>");
        } else if (status == 5) {
            $('#status').html("<span class='text-danger'>" + statusText + "</span>");
        }
    }
</script>
