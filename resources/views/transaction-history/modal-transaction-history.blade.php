<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{!! __('content.appbar.transaction-history') !!}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/4.0.0/css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/notification/style.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/css/bootstrap-multiselect.css"
        integrity="sha512-Lif7u83tKvHWTPxL0amT2QbJoyvma0s9ubOlHpcodxRxpZo4iIGFw/lDWbPwSjNlnas2PsTrVTTcOoaVfb4kwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section class="section-50">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <h5 class="breadcrumb-item"><a href="/">{!! __('content.home') !!}</a></h5>
                    <h5 class="m-b-50 breadcrumb-item active">{!! __('content.appbar.transaction-history') !!}<i
                            class="fa fa-bell text-muted"></i></h5>
                </ol>
            </nav>
            <div class="container my-3">
                <div class="row">
                    <div class="col-sm-8 col-12 form-group">
                        <div class="input-group">
                            <input class="form-control" list="filter_search_list" id="filter_search" type="text"
                                placeholder="{!! __('content.notification-all.search') !!}" style="padding-right: 40px;">
                            <button class="btn bg-transparent" id="btn-search-clear"
                                style="right:0px; position: absolute; visibility:hidden">
                                <i class="fa fa-times"></i>
                            </button>
                            {{-- <datalist id="filter_search_list">
                                <option value="Status: Pending">
                                <option value="Status: Confirmed">
                                <option value="Status: Cancelled">
                                <option value="Status: Rejected">
                                <option value="Status: Accepted">
                            </datalist>
                            <button class="btn bg-transparent" style="right:50px;">
                                <i class="fa fa-times"></i>
                            </button> --}}
                        </div>
                    </div>
                    <div class="col-sm-4 col-12">
                        <select class="form-select" id='filter_order'>
                            <option value="1">{!! __('content.notification-all.newest') !!}</option>
                            <option value="2">{!! __('content.notification-all.oldest') !!}</option>
                        </select>
                    </div>
                    {{-- <div class="col-3">
                        <select id="filter_status" multiple="multiple">
                            <option value="1">Pending</option>
                            <option value="2">Confirmed</option>
                            <option value="3">Cancelled</option>
                            <option value="4">Accepted</option>
                            <option value="5">Rejected</option>
                        </select>
                    </div> --}}
                    {{-- <div class="form-check form-check-inline col-4">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">1</label>
                    </div> --}}
                </div>
            </div>
            <div id="notification-content" class="notification-ui_dd-content">
                {{-- <div id="transaction_history_1" class="notification-list notification-list--unread">
                    <div class="notification-list_content">
                        <div class="notification-list_img"><i class="fa fa-receipt"></i></div>
                        <div class="notification-list_detail row">
                            <p>message</p>
                            <p class="text-muted"><small>date</small></p>
                        </div>
                    </div>
                </div> --}}
            </div>

            {{-- <div class="text-center">
                <a href="#!" class="dark-link">Load more activity</a>
            </div> --}}

        </div>
    </section>

    <div class="modal fade" style="z-index:10001" id="transaction_history_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-lg p-sm-0 py-1 px-1" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Transaction #123</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form autocomplete="off" method="post" id='myform' enctype="multipart/form-data"> --}}
                {{-- <form action="/receipt" autocomplete="off" target="print_popup" method="post" id='myform'> --}}
                <form action="/update-transaction-history" id='receipt_form' method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') --}}
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="status" value=''>
                    <div class="modal-body" style="padding: 10px 50px;">
                        <div class="contaienr">
                            <div class="row">
                                <div class="col-12" id='countdown' style="display: none;">
                                    <div class="d-flex justify-content-center mb-5">
                                        <div class="timer-container">
                                            <span class="timer-title">{!! __('content.receipt.countdown-timer') !!}</span>
                                            <span class="timer-minutes-number" id='timer-minutes-number'>00</span>
                                            <span class="timer-minutes-text">minutes</span>
                                            <span class="timer-symbol">:</span>
                                            <span class="timer-seconds-number" id='timer-seconds-number'>00</span>
                                            <span class="timer-seconds-text">seconds</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 row">
                                    <div class="my-3 col-sm-6 col-12">
                                        <label for="modal_from_acc">{!! __('content.receipt.send-bank-acc') !!}</label>
                                        <div class="input-group">
                                            <span class="font-weight-light" id="modal_from_acc"></span>
                                        </div>
                                    </div>
                                    <div class="my-3 col-sm-6 col-12">
                                        <label for="modal_your_receive_acc">{!! __('content.receipt.receive-bank-acc') !!}</label>
                                        <div class="input-group">
                                            <span class="font-weight-light" id="modal_your_receive_acc"></span>
                                        </div>
                                    </div>
                                    <div class="my-3 col-sm-6 col-12">
                                        <label for="modal_to_acc">{!! __('content.receipt.rbank-acc') !!}</label>
                                        <div class="input-group">
                                            <span class="font-weight-light" id="modal_to_acc"></span>
                                        </div>
                                    </div>
                                    <div class="my-3 col-sm-6 col-12">
                                        <label for="modal_ref_no">{!! __('content.receipt.reference-no') !!}</label>
                                        <div class="d-flex flex-row" id='receipt_ref_no'>
                                            <i class="fa fa-picture-o mx-3" style="font-size:20px;"
                                                aria-hidden="true" id='receipt_ref_no_icon'></i>
                                            <span class="font-weight-light" id="modal_ref_no"></span>
                                        </div>
                                        <p class="text-muted user-select-none"
                                            style="font-size:12px;font-style: italic;">
                                            {!! __('content.receipt.important-note') !!}
                                        </p>
                                    </div>
                                    <div class="my-3 col-sm-12 col-12" id='section-receipt-screenshot'>
                                        <label for="imgInp">{!! __('content.receipt.attach') !!}</label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" accept="image/*"
                                                name='imgUpload' id="imgInp">
                                            <span class="fa fa-image input-group-text"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="my-3 col-12" id='section-receipt-screenshot-preview'>
                                        <label for="modal_ref_no">{!! __('content.receipt.attach-u') !!}</label>
                                        <div class="input-group" id='receipt-screenshot-preview'>
                                            <span class="form-control"><b>{!! __('admin.view') !!}</b></span>
                                            <span class="fa fa-image input-group-text"></span>
                                        </div>
                                    </div> --}}
                                    <div class="my-lg-3 my-2 col-lg-4 col-12">
                                        <label for="modal_from_curr"
                                            style="white-space: nowrap;">{!! __('content.receipt.base-curr') !!}</label>
                                        <div class="input-group mb-lg-3 mb-0">
                                            <span class="form-control is-valid font-weight-light"
                                                id="modal_from_curr"></span>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="modal_from_curr2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-lg-3 my-2 col-lg-4 col-12">
                                        <label for="modal_fx_rate"
                                            style="white-space: nowrap;">{!! __('content.receipt.fx-rate') !!}</label>
                                        <div class="input-group mb-lg-3 mb-0">
                                            <span class="form-control font-weight-light" id="modal_fx_rate"></span>
                                        </div>
                                    </div>
                                    <div class="my-lg-3 my-2 col-lg-4 col-12">
                                        <label for="modal_to_curr"
                                            style="white-space: nowrap;">{!! __('content.receipt.result-curr') !!}</label>
                                        <div class="input-group mb-lg-3 mb-0">
                                            <span class="form-control is-valid font-weight-light"
                                                id="modal_to_curr"></span>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="modal_to_curr2"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-lg-3 my-1 col-sm-4 col-12">
                                        <label for="modal_status">{!! __('content.receipt.status') !!}</label>
                                        <div class="input-group">
                                            <span class="font-weight-light" id="modal_status"></span>
                                        </div>
                                    </div>
                                    <div class="my-3 col-sm-4 col-12">
                                        <label for="modal_created_at">{!! __('content.receipt.created_at') !!}</label>
                                        <div class="input-group">
                                            <span class="font-weight-light" id="modal_created_at">2022-06-29
                                                16:15:23</span>
                                        </div>
                                    </div>
                                    <div class="my-3 col-sm-4 col-12">
                                        <label for="modal_updated_at">{!! __('content.receipt.updated_at') !!}</label>
                                        <div class="input-group">
                                            <span class="font-weight-light" id="modal_updated_at">2022-06-29
                                                16:15:23</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id='btnClose' class="btn btn-secondary"
                            data-dismiss="modal">{!! __('content.modal.login.close') !!}</button>
                        {{-- <button type="button" id='btnView' class="btn btn-info">View</button> --}}
                        <button type="button" id='btnViewMyAttach' class="btn btn-info"
                            style="display: none;">{!! __('content.receipt.view-attach') !!}</button>
                        <button type="button" id='btnCancel' class="btn btn-danger"
                            style="display: none;">{!! __('content.receipt.cancel') !!}</button>
                        <button type="submit" id='btnConfirm' class="btn btn-primary"
                            style="display: none;">{!! __('content.receipt.confirm') !!}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('bootstrap/4.0.0/js/bootstrap.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/js/bootstrap-multiselect.js"
        integrity="sha512-e6Nk3mhokFywlEPtnkGmop6rHh6maUqL0T65yOkbSsJ3/y9yiwb+LzFoSTJM/a4j/gKwh/y/pHiSLxE82ARhJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
<script>
    var end;
    var status;
    var validRecipientReceipt = false;
    var validAttachReceipt = false;
    $transaction_history = [];
    //$status = -1;
    //var status = -1;
    var minutes = -1;
    var sort = $('#filter_order').val(); //1=created_at_desc, 2=created_at_asc
    //var filter = 'null'; //null,status,currency,
    //var search = '';
    $(document).ready(function() {
        $('#filter_status').multiselect({
            widthSynchronizationMode: 'always',
            buttonWidth: '100%'
        });

        $("#filter_search").on("keyup", function() {
            filterColumnList();
        });

        $("#filter_order").on("change", function() {
            sort = $(this).val();
            getTransactionHistory();
        });

        $('#filter_search').on('input', function() {
            var $this = $(this);
            var visible = Boolean($this.val());
            if (visible) {
                $('#btn-search-clear').css('z-index', '10000');
                $('#btn-search-clear').css('visibility', 'visible');
            } else {
                $('#btn-search-clear').css('z-index', '0');
                $('#btn-search-clear').css('visibility', 'hidden');
            }
            //$('.form-control-clear').toggleClass('hidden', !visible);
            /* var $this = $(this);
            var visible = Boolean($this.val());
            $this.siblings('.form-control-clear').toggleClass('hidden', !visible); */
        });

        /* $('.has-clear input[type="text"]').on('input propertychange', function() {
            var $this = $(this);
            var visible = Boolean($this.val());
            $this.siblings('.form-control-clear').toggleClass('hidden', !visible);
        }).trigger('propertychange'); */

        $('#btn-search-clear').click(function() {
            $("#filter_search").val('');
            filterColumnList();
        });

        /* $('.form-control-clear').click(function() {
            $("#filter_search").val('');
        }); */
    });

    function filterColumnList() {
        var value = $("#filter_search").val().toLowerCase().trim();
        $("#notification-content .notification-list").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }

    getTransactionHistory();
    /* newTransactionHistory(1, 1, 'message', 'date'); */
    $('#imgInp').click(function(e) {
        $.ajax({
            type: 'GET',
            url: "/validate-before-update-transaction-history",
            async: false,
            data: {
                "_token": "{{ csrf_token() }}",
                id: $('#btnConfirm').val(),
                status: 2,
            },
            success: function(result) {
                //console.log(result);
            },
            error: function(data) {
                console.log(data);
                getStatus();
                e.preventDefault();
            }
        });
    });

    $('#imgInp').on('change', function() {
        if ($('#imgInp').prop('files')) {
            if (this.files[0].size > 2097152) {
                Swal.fire("{!! __('content.swal.img-size-too-big', ['size' => '2']) !!}");
                this.value = "";
                return;
            }
        }
    });

    $('#btnCancel').on('click', function() {
        var valid = false;
        $.ajax({
            type: 'GET',
            url: "/validate-before-update-transaction-history",
            async: false,
            data: {
                "_token": "{{ csrf_token() }}",
                id: $('#btnCancel').val(),
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

        var order = $('#exampleModalLongTitle').html();
        Swal.fire({
            title: "{!! __('content.receipt.form-cancel-title') !!}",
            text: "{!! __('content.receipt.form-cancel-text', ['order' => '"+order+"']) !!}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{!! __('content.receipt.t-cancel-form-confirm') !!}",
            cancelButtonText: "{!! __('content.receipt.cancel') !!}"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "/update-transaction-history",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: this.value,
                        status: 3
                    },
                    success: function() {
                        Swal.fire({
                            title: "{!! __('content.swal.success') !!}",
                            html: "{!! __('content.notification.cancel', ['order' => '"+order+"']) !!}",
                            timer: 3333,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });
                        //$('#transaction_history_modal').removeClass('show');
                        $("#btnClose").click()
                        getTransactionHistory();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
    });

    $('#btnConfirm').on('click', function(e) {
        e.preventDefault();
        var valid = false;
        $.ajax({
            type: 'GET',
            url: "/validate-before-update-transaction-history",
            async: false,
            data: {
                "_token": "{{ csrf_token() }}",
                id: $('#btnConfirm').val(),
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
            });
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
                $('input[name=id]').val($('#btnConfirm').val());
                $('input[name=status]').val(2);
                $('#receipt_form').submit();
            } else {
                return false;
            }
        });
        console.log('redirect');
        return;
        var order = $('#exampleModalLongTitle').html();
        Swal.fire({
            title: "{!! __('content.receipt.form-confirm-title') !!}",
            text: "{!! __('content.receipt.form-confirm-text', ['order' => '"+order+"']) !!}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{!! __('content.receipt.t-confirm-form-confirm') !!}",
            cancelButtonText: "{!! __('content.receipt.cancel') !!}"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "/update-transaction-history",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: this.value,
                        status: 2
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "{!! __('content.swal.success') !!}",
                            html: "{!! __('content.notification.confirm', ['order' => '"+order+"']) !!}",
                            timer: 3333,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });
                        //$('#transaction_history_modal').removeClass('show');
                        $("#btnClose").click()
                        getTransactionHistory();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });

        //getTransactionHistory();
    });
    var timer_refresh = setInterval(() => {
        getTransactionHistory();
    }, 3000);

    var transaction_interval_run = false;
    var transaction_interval = setInterval(function() {
        if ($('#exampleModalLongTitle').is(':visible') && transaction_interval_run) {
            refreshTimer();
            getStatus();
        }
    }, 666);

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
                            //console.log(arr1_array[j][0]);
                            //console.log(arr1_array[j][0]);
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

    function getTransactionHistory() {
        $.ajax({
            type: 'GET',
            url: "/get-transaction-history",
            data: {
                type: sort
            },
            success: function(result) {
                //console.log(result);
                $transaction_history_temp = [];
                $.each(result, function() {
                    $.each(this, function(key, value) {
                        $transaction_history_temp.push(value);
                    });
                });
                if (!compareArrays($transaction_history, $transaction_history_temp)) {
                    $transaction_history = $transaction_history_temp;
                    //console.log('something change?');
                    refreshTransactionHistoryList();
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function refreshTransactionHistoryList() {
        if ($('#transaction_history_modal').hasClass('show')) {
            $("#transaction_history_modal .close").click()
        }
        $('#notification-content').html('');
        $transaction_history.forEach(function($data, $key) {
            newTransactionHistory($data['id'], $data['ref_no'], $data['status'], $data['created_at'],
                $data['from_curr_name'], $data['to_curr_name'], $data['from_amount'], $data['to_amount']);
        });
        filterColumnList();
    }

    function getStatusText(status) {
        if (status == 1) {
            return "<span class='text-info'>{!! __('content.receipt.pending') !!}</span>";
        } else if (status == 2) {
            return "<span class='text-info'>{!! __('content.receipt.confirm') !!}</span>";
        } else if (status == 3) {
            return "<span class='text-warning'>{!! __('content.receipt.cancelled') !!}</span>";
        } else if (status == 4) {
            return "<span class='text-success'>{!! __('content.receipt.accepted') !!}</span>";
        } else if (status == 5) {
            return "<span class='text-danger'>{!! __('content.receipt.rejected') !!}</span>";
        }
    }

    function newTransactionHistory($id, $ref_no, $status, $time, $from_curr, $to_curr, $from_amt, $to_amt) {
        //var t_pad = ($id.toString()).padStart(5, '0');
        var t_pad = $ref_no;
        var t_order = "{!! __('content.receipt.order', ['transaction_id' => '"+t_pad+"']) !!}";
        $body = "<div id='transaction_history_" + $id + "' class='notification-list'>" +
            "<div class='notification-list_content'  style='width: 100%''>" +
            "<div class='notification-list_img'>" +
            "<i class='fa fa-bookmark text-muted' style='32px;'></i>" +
            "</div><div class='notification-list_detail'>" +
            "<p><b>" + t_order +
            "</b> <span>" + $from_curr + " -> " + $to_curr + "</span></p>" +
            "<p class='text-muted'>{!! __('content.receipt.amount') !!}: " + $from_amt + " " + $from_curr + " -> " + $to_amt + " " +
            $to_curr +
            "</p>" +
            "<p class='text-muted'>{!! __('content.receipt.status') !!}: ";
        $body += getStatusText($status);
        $body += "</p><p class='text-muted'><small>" + $time + "</small></p></div></div></div>";
        $('#notification-content').append($body);

        $('#transaction_history_' + $id).click(function() {
            if ($('.modal').hasClass('show')) {
                return false;
            }
            $(this).attr('data-toggle', 'modal');
            $(this).attr('data-target', '#transaction_history_modal');
            $data = $transaction_history.find(element => element.id === $id);
            //console.log($data);
            $('#exampleModalLongTitle').html(t_order);
            $('#modal_from_acc').html($data['from_acc'] + " (" + $data['from_bank_name'] + ")");
            $('#modal_your_receive_acc').html($data['your_receive_acc'] + " (" + $data[
                'your_receive_bank_name'] + ")");
            $('#modal_to_acc').html($data['to_acc'] + " (" + $data['to_acc_name'] + ")");
            $('#modal_ref_no').html($data['ref_no']);
            $('#modal_from_curr').html($data['from_amount']);
            $('#modal_from_curr2').html($data['from_curr_name']);
            $('#modal_fx_rate').html($data['fx_rate']);
            $('#modal_to_curr').html($data['to_amount']);
            $('#modal_to_curr2').html($data['to_curr_name']);
            $('#modal_created_at').html($data['created_at']);
            $('#modal_updated_at').html($data['updated_at']);

            if ($data['receipt_img_path'] != null) {
                $('#btnViewMyAttach').css('display', 'block');
                validAttachReceipt = true;
                $('#btnViewMyAttach').on('click', function() {
                    if (validAttachReceipt) {
                        Swal.fire({
                            customClass: {
                                image: 'swal-img',
                            },
                            imageUrl: "{!! asset('receiptAttach') !!}/" + $data['receipt_img_path'],
                            //imageClass: 'swal-img',
                            imageAlt: "{!! __('content.receipt.view-attach') !!}",
                            confirmButtonText: "{!! __('content.modal.login.close') !!}",
                        })
                    }
                });
            } else {
                $('#btnViewMyAttach').css('display', 'none');
                validAttachReceipt = false;
            }

            if ($data['recipient_receipt_img_path'] != null) {
                $('#receipt_ref_no').css('cursor', 'pointer');
                $('#receipt_ref_no_icon').css('display', 'flex');
                validRecipientReceipt = true;
                $('#receipt_ref_no').on('click', function() {
                    if (validRecipientReceipt) {
                        Swal.fire({
                            customClass: {
                                image: 'swal-img',
                            },
                            imageUrl: "{!! asset('recipientReceiptAttach') !!}/" + $data[
                                'recipient_receipt_img_path'],
                            //imageClass: 'swal-img',
                            imageAlt: "{!! __('content.receipt.reference-no') !!}",
                            confirmButtonText: "{!! __('content.modal.login.close') !!}",
                        })
                    }
                });
            } else {
                $('#receipt_ref_no').css('cursor', 'unset');
                $('#receipt_ref_no_icon').css('display', 'none');
                validRecipientReceipt = false;
            }

            $('#imgInp').val('');
            $('#btnView').on('click', function() {
                popupwindow('/view-receipt/' + $data['id'], 'print_popup', '500', '820');
                return false;
            });
            $('#btnCancel').val($id);
            $('#btnConfirm').val($id);
            transaction_interval_run = true;
            status = $data['status'];
            start = moment();
            end = moment($data['created_at']).add(10, 'minutes');
            refreshTimer();
            getStatus();
            //console.log($data);
            //$status = $data['status'];
        });
    }

    function refreshTimer() {
        console.log('refreshTimer');
        var start = moment();
        var duration = moment.duration(end.diff(start));
        var minutes = duration.minutes();
        var seconds = duration.seconds();
        start.add(100, 'milliseconds');
        if (start.isAfter(end)) {
            timerExpired();
            updateStatus(5);
            /* if($status == 1){
                
            } */
            return;
        } else {
            $('#countdown').css('display', 'block');
            $('#section-receipt-screenshot').css('display', 'block');
        }
        if (minutes < 3) {
            $('.timer-minutes-number').css('color', 'red');
            $('.timer-seconds-number').css('color', 'red');
        }
        //statusText = 'Pending (' + (((minutes < 10) && (minutes > -1)) ? '0' + minutes : minutes) + ')';
        $('.timer-minutes-number').html((((minutes < 10) && (minutes > -1)) ? '0' + minutes : minutes));
        $('.timer-minutes-number').html((((minutes < 10) && (minutes > -1)) ? '0' + minutes : minutes));
        $('.timer-seconds-number').html((((seconds < 10) && (seconds > -1)) ? '0' + seconds : seconds));
    }

    function timerExpired() {
        $('#countdown').css('display', 'none');
        $('#section-receipt-screenshot').css('display', 'none');
        transaction_interval_run = false;
        //clearInterval(transaction_interval);
    }

    function updateStatus(willStatus) {
        if (((willStatus == 2 || willStatus == 3 || willStatus == 4 ||
                willStatus == 5) && (status == 1)) || willStatus == 1) {
            status = willStatus;
            getStatus();
        }
    }

    function getStatus() {
        if (status == 1) {
            $('#btnCancel').css('display', 'inline');
            $('#btnConfirm').css('display', 'inline');
        } else {
            timerExpired();
            $('#btnCancel').css('display', 'none');
            $('#btnConfirm').css('display', 'none');
        }
        $('#modal_status').html(getStatusText(status));
    }

    function popupwindow(url, title, w, h) {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        return window.open(url, title,
            'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' +
            w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
</script>
