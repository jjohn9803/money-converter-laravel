<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <title>{!! __('content.notification-container.header') !!}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/notification/css/bootstrap.min.css') }}"> <!-- Bootstrap style -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/notification/style.css') }}">
</head>

<body>
    {{-- <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Signup</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header> --}}
    <section class="section-50">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <h5 class="breadcrumb-item"><a href="/">{!! __('content.home') !!}</a></h5>
                    <h5 class="m-b-50 breadcrumb-item active">{!! __('content.notification-container.header') !!} <i
                            class="fa fa-bell text-muted"></i></h5>
                </ol>
            </nav>
            <div class="container my-3">
                <div class="row">
                    <div class="col-sm-6 my-1 col-12 form-group">
                        <div class="input-group">
                            <button id='btn-refresh' class="btn btn-secondary"><i class="fa fa-refresh"></i></button>
                            <input class="form-control" id="filter_search" type="text"
                                placeholder="{!! __('content.notification-all.search') !!}" style="padding-right: 40px;">
                            <button class="btn bg-transparent" id="btn-search-clear"
                                style="position:absolute; right:0px;visibility:hidden;">
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
                    <div class="col-sm-2 my-1 col-12">
                        <select class="form-select" id='filter_order'>
                            <option value="1">{!! __('content.notification-all.newest') !!}</option>
                            <option value="2">{!! __('content.notification-all.oldest') !!}</option>
                        </select>
                    </div>
                    <div class="col-sm-2 my-1 col-12">
                        <select class="form-select" id='filter_read'>
                            <option value="1">{!! __('content.notification-all.all') !!}</option>
                            <option value="2">{!! __('content.notification-all.unread') !!}</option>
                            <option value="3">{!! __('content.notification-all.read') !!}</option>
                        </select>
                    </div>
                    <div class="col-sm-2 my-1 col-12">
                        <button id='btn-read-all' class="btn btn-primary" style="width: 100%;"><i
                                class="fa fa-check-square-o pe-2"></i>{!! __('content.notification-all.read-all') !!}</button>
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
                {{-- <div id='notification' class='notification-list notification-list--unread'>
                    <div class='notification-list_content'>
                        <div class='notification-list_img'>
                            <i class='fa fa-envelope'></i>
                        </div>
                        <div class='notification-list_detail'>
                            <p>$message</p>
                            <p class='text-muted'><small></small></p>
                        </div>
                    </div>
                </div> --}}
            </div>

            {{-- <div class="text-center">
                <a href="#!" class="dark-link">Load more activity</a>
            </div> --}}

        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="{{ asset('assets/notification/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</body>

</html>
@isset($notification)
    <script>
        $search_by_id = String({!! json_encode($notification) !!}).padStart(5, '0');
        $msg = "{!! __('content.notification.order', ['transaction_id' => '"+$search_by_id+"']) !!}";
        $final_msg = $msg.substring(3, $msg.length - 4);
        if ($search_by_id) {
            $("#filter_search").val($final_msg);
        }
    </script>
@endisset
<script>
    var sort = $('#filter_order').val(); //1=newest,2=oldest
    var read_filter = $('#filter_read').val(); // 1=All,2,Unread,3=Read
    $(document).ready(function() {
        $("#filter_search").on("keyup", function() {
            filterColumnList();
        });

        $("#filter_order").on("change", function() {
            sort = $(this).val();
            getNotification();
        });

        $("#filter_read").on("change", function() {
            read_filter = $(this).val();
            getNotification();
        });

        $('#filter_search').on('input', function() {
            var $this = $(this);
            var visible = Boolean($this.val());
            if (visible) {
                //$('#btn-search-clear').css('right', '0px');
                $('#btn-search-clear').css('z-index', '10000');
                $('#btn-search-clear').css('visibility', 'visible');
            } else {
                //$('#btn-search-clear').css('right', '0');
                $('#btn-search-clear').css('z-index', '0');
                $('#btn-search-clear').css('visibility', 'hidden');
            }
            //$('.form-control-clear').toggleClass('hidden', !visible);
            /* var $this = $(this);
            var visible = Boolean($this.val());
            $this.siblings('.form-control-clear').toggleClass('hidden', !visible); */
        });

        /* $('#filter_search').on('input', function() {
            var $this = $(this);
            var visible = Boolean($this.val());
            $('.form-control-clear').toggleClass('hidden', !visible);
        }); */

        /* $('.has-clear input[type="text"]').on('input propertychange', function() {
            var $this = $(this);
            var visible = Boolean($this.val());
            $this.siblings('.form-control-clear').toggleClass('hidden', !visible);
        }).trigger('propertychange'); */

        $('#btn-search-clear').click(function() {
            $("#filter_search").val('');
            filterColumnList();
        });

        $('#btn-read-all').click(function() {
            $.ajax({
                type: 'PUT',
                url: "/read-all-notification",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function() {
                    getNotification();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    });

    function filterColumnList() {
        var value = $("#filter_search").val().toLowerCase().trim();
        $("#notification-content .notification-list").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }
</script>
<script>
    $notification = [];
    getNotification();
    var timer_refresh = setInterval(() => {
        getNotification();
    }, 3000);

    function getNotification() {
        $.ajax({
            type: 'GET',
            url: "/get-notification",
            data: {
                order: sort,
                read_filter: read_filter,
            },
            success: function(result) {
                $notification_temp = [];
                $.each(result, function() {
                    $.each(this, function(key, value) {
                        $notification_temp.push(value);
                    });
                });
                if (!compareArrays($notification, $notification_temp)) {
                    $notification = $notification_temp;
                    //console.log('something change?');
                    refreshNotificationList();
                }

                /* $notification = [];
                $.each(result, function() {
                    $.each(this, function(key, value) {
                        $notification.push(value);
                    });
                }); */
                //refreshNotificationList();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function getNotificationMessageFromType(t_id, t_pad, type, reason = '') {
        var message = '';
        if (t_id != -1) {
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
                message += "{!! __('content.notification.error', ['order' => '"+t_order+"']) !!}";
            } else if (type == 7) {
                message += "";
            }
        }
        if (reason) {
            message += ' ' + Object.values(reason)[1][getLocale()];
        }
        return message;
    }

    function getLocale() {
        var locale = $('html').attr('lang');
        if (locale.includes('zh')) locale = 'zh';
        return locale;
    }

    $('#btn-refresh').click(function() {
        window.location.href = '/view-notification';
        return false;
    });

    function refreshNotificationList() {
        $('#notification-content').html('');
        $notification.forEach(function($data, $key) {
            var ref_no = '';
            var reason = '';
            if ($data['transasction']) {
                ref_no = $data['transasction']['ref_no'];
            }
            if ($data['reason']) {
                reason = $data['reason'];
            }
            newNotification($data['id'], $data['status'], getNotificationMessageFromType($data[
                'transasction_id'], ref_no, $data[
                'message_type'], reason), $data['updated_at']);
        });
        $('[id^="notification_"]').click(function(e) {
            $.ajax({
                type: 'PUT',
                url: "/update-notification",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: this.id.replace('notification_', ''),
                },
                success: function(data) {
                    if (data['redirect'] == true) {
                        var url = 'view-receipt/' + data['id'];
                        try {
                            var importantStuff = window.open(url,
                                'print_popup');
                            importantStuff.document.write('Loading preview...');
                            importantStuff.location.href = url;
                            console.log('accessable');
                        } catch (error) {
                            console.log('block!!');
                            var form = document.createElement("form");
                            form.id = "view-receipt-once";
                            form.method = "GET";
                            form.action = 'view-receipt/' + data['id'];
                            form.target = "print_popup";
                            document.body.appendChild(form);
                            form.submit();
                            document.getElementById("view-receipt-once").remove();
                        }
                        /* if (!importantStuff || importantStuff.closed ||
                            typeof importantStuff
                            .closed == 'undefined') {

                        } else {
                            console.log('accessable');
                            importantStuff.document.write('Loading preview...');
                            importantStuff.location.href = url;
                        } */
                        /* e.currentTarget.setAttribute('onClick', window.open(
                            'view-receipt/' + data['id'], "print_popup")); */
                        /* try {
                            openTab('view-receipt/' + data['id']);
                        } catch (error) {
                            try {
                                e.currentTarget.setAttribute('onClick', window.open(
                                    'view-receipt/' + data['id'], "_blank"));
                            } catch (error) {
                                document.location.assign('view-receipt/' + data['id']);
                            }
                        } */
                        //console.log(e);
                        //e.currentTarget.setAttribute('onClick', window.open('view-receipt/' + data['id'], "_blank"));
                        //e.currentTarget.setAttribute('onClick', '')
                        /* popupwindow('view-receipt/' + data['id'], 'print_popup',
                            '500', '820'); */
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
            getNotification();
        });
        filterColumnList();
    }

    function newNotification($id, $status, $message, $time) {
        $body = "<div id='notification_" + $id + "' class='notification-list";
        if ($status == 1) {
            $body += " notification-list--unread";
        }
        $body += "'>" +
            "<div class='notification-list_content'>" +
            "<div class='notification-list_img'>";
        if ($status == 1) {
            $body += "<i class='fa fa-envelope'></i>";
        } else {
            $body += "<i class='fa fa-envelope-open'></i>";
        }
        $body += "</div>" +
            "<div class='notification-list_detail'>" +
            "<p>" + $message + "</p>" +
            "<p class='text-muted'><small>" + $time + "</small></p>" +
            "</div></div></div>";
        /* $body += "<input type='checkbox'>"; */
        $('#notification-content').append($body);
    }

    /* if ($('#notification-content').html() == '') {
        $('.section-50 > .container').html("<div class='d-flex align-items-center justify-content-center vh-100'>" +
            "<div class='text-center'>" +
            "<h1 class='display-1 fw-bold'>404</h1>" +
            "<p class='fs-3'> <span class='text-danger'>Opps!</span> Page not found.</p>" +
            "<p class='lead'>" +
            "The page you’re looking for doesn’t exist." +
            "</p>" +
            "<a href='/' class='btn btn-primary'>Go Home</a>" +
            "</div>" +
            "</div>")
    } */

    function compareArrays(arr1, arr2) {
        // check the length
        if (arr1.length != arr2.length) {
            return false;
        } else {
            let result = false;
            // comparing each element of array 
            for (let i = 0; i < arr1.length; i++) {
                if (JSON.stringify(arr1[i]) != JSON.stringify(arr2[i])) {
                    return false;
                } else {
                    result = true;
                }
            }
            return result;
        }
    }

    function popupwindow(url, title, w, h) {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        return window.open(url, title,
            'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' +
            w + ', height=' + h + ', top=' + top + ', left=' + left);
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
</script>
