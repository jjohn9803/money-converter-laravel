<div class="modal fade" style="z-index:10001" id="loginModal" tabindex="-1" role="dialog"
    aria-labelledby="loginModalLongTitle" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLongTitle">{!! __('content.modal.login.login.title') !!}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form autocomplete="off" method="post" id='myform' enctype="multipart/form-data"> --}}
                {{-- <form action="/receipt" autocomplete="off" target="print_popup" method="post" id='myform'> --}}
                <form autocomplete="off" method="post" id='loginform'>
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="modal-body">
                        <div class="contaienr">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 mycontent-left">
                                    <div class="my-3" id='username_field'></div>
                                    <div class="my-3">
                                        <label for="inputLoginEmailModal">{!! __('content.modal.login.email') !!}</label>
                                        <input type="email" class="form-control is-valid" id="inputLoginEmailModal"
                                            placeholder="{!! __('content.modal.login.email') !!}" name='login_email' required>
                                        <span class="text-danger" id='error-login_email'></span>
                                    </div>
                                    <div class="my-3" id='password_field'>
                                        <label for="inputLoginPasswordModal">{!! __('content.modal.login.password') !!}</label>
                                        <input type="password" class="form-control is-valid"
                                            id="inputLoginPasswordModal" placeholder="{!! __('content.modal.login.password') !!}" name='login_password'
                                            required>
                                        <span class="text-danger" id='error-login_password'></span>
                                    </div>
                                    <div class="my-3" id='rpassword_field'></div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" id='btnSwitch'>{!! __('content.modal.login.login.switch') !!}</a><br>
                        <a href="javascript:void(0)" id='btnSwitchForgetPassword'>{!! __('content.modal.login.forget') !!}</a><br>
                        <span class="text-danger" id='error-login_message'></span>
                        <div style="position: absolute;right:50px;bottom:15px;" id='remember_section'></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! __('content.modal.login.close') !!}</button>
                        <button type="submit" id='btnLogin' class="btn btn-primary">{!! __('content.modal.login.login.btn') !!}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var app_timezone = "{!!env('APP_TIMEZONE')!!}";
    var timerInterval = 0;
    var momentCooldownSentEmailInit;
    var cooldownSentEmailDuration;

    function validationAnimation($msg, $error, $inputvalid) {
        if (typeof $inputvalid != 'undefined') $inputvalid.addClass('is-invalid');
        $error.addClass('notificationText');
        $error.html($msg);
        $error.on("animationend", function() {
            $error.removeClass('notificationText');
            if (typeof $inputvalid != 'undefined') $inputvalid.removeClass('is-invalid');
        });
    }

    modalMode(1);
    $('#btnSwitch').on('click', function() {
        $('#inputLoginEmailModal').val('');
        $('#inputLoginPasswordModal').val('');
        if ($('#loginModalLongTitle').html() === "{!! __('content.modal.login.login.title') !!}") {
            modalMode(2);
        } else {
            modalMode(1);
        }
    });

    $('#btnSwitchForgetPassword').on('click', function() {
        $('#inputLoginEmailModal').val('');
        modalMode(3);
    });

    /* $('#btnLogin').on('click', function(e) {
        if ($('#btnLogin').html('Login')) {
            $('#loginform').attr('action', 'login');
        } else {
            $('#loginform').attr('action', 'register');
        }
    }); */

    $(function() { // let all dom elements are loaded
        $("#loginModal").on('show.bs.modal', function() {
            modalMode(1);
            $('#inputLoginEmailModal').val('');
            /* $('#inputLoginEmailModal').val('');
            $('#inputLoginPasswordModal').val('');
            $('#inputUserBankModal').val('');
            $('#inputUserReceiveBankAccModal').val('');
            $('#agree').prop('checked', false); */
        });
    });

    function modalMode(mode) {
        if (mode == 1) {
            $('#loginModalLongTitle').html("{!! __('content.modal.login.login.title') !!}");
            $('#btnLogin').html("{!! __('content.modal.login.login.btn') !!}");
            $('#username_field').html('');
            $('#password_field').html("<label for='inputLoginPasswordModal'>{!! __('content.modal.login.password') !!}</label>" +
                "<input type='password' class='form-control is-valid' id='inputLoginPasswordModal'" +
                "placeholder='{!! __('content.modal.login.password') !!}' name='login_password' required>" +
                "<span class='text-danger' id='error-login_password'></span>"
            );
            $('#rpassword_field').html('');
            $('#remember_section').html(
                "<label class='container-radio-input'>{!! __('content.modal.login.remember') !!} <input type='checkbox' id='remember' name='remember' value='true'> <span class='checkmark'></span></label>"
            );
            $('#btnSwitch').html("{!! __('content.modal.login.login.switch') !!}");
            $('#btnSwitchForgetPassword').html("{!! __('content.modal.login.forget') !!}");
            $('#btnLogin').prop("disabled", false);
        } else if (mode == 2) {
            $('#inputLoginUsernameModal').val('');
            $('#loginModalLongTitle').html("{!! __('content.modal.login.register.title') !!}");
            $('#btnLogin').html("{!! __('content.modal.login.register.btn') !!}");
            $('#username_field').html(
                "<label for='inputLoginUsernameModal'>{!! __('content.modal.login.username') !!}</label><input type='text' class='form-control is-valid' id='inputLoginUsernameModal' placeholder='{!! __('content.modal.login.username') !!}' name='login_username' required><span class='text-danger' id='error-login_username'></span>"
            );
            $('#password_field').html("<label for='inputLoginPasswordModal'>{!! __('content.modal.login.password') !!}</label>" +
                "<input type='password' class='form-control is-valid' id='inputLoginPasswordModal'" +
                "placeholder='{!! __('content.modal.login.password') !!}' name='login_password' required>" +
                "<span class='text-danger' id='error-login_password'></span>"
            );
            $('#rpassword_field').html(
                "<label for='inputLoginRPasswordModal'>{!! __('content.modal.login.rpassword') !!}</label><input type='password' class='form-control is-valid' id='inputLoginRPasswordModal'placeholder='{!! __('content.modal.login.rpassword') !!}' name='login_rpassword' required><span class='text-danger' id='error-login_rpassword'></span>"
            )
            $('#remember_section').html('');
            $('#btnSwitch').html("{!! __('content.modal.login.register.switch') !!}");
            $('#btnSwitchForgetPassword').html("{!! __('content.modal.login.forget') !!}");
            $('#btnLogin').prop("disabled", false);
        } else if (mode == 3) {
            $('#inputLoginUsernameModal').val('');
            $('#loginModalLongTitle').html("{!! __('content.modal.login.reset.title') !!}");
            $('#btnLogin').html("{!! __('content.modal.login.reset.btn') !!}");
            $('#username_field').html('');
            $('#password_field').html('');
            $('#rpassword_field').html('');
            $('#remember_section').html('');
            $('#btnSwitch').html("{!! __('content.modal.login.reset.switch') !!}");
            $('#btnSwitchForgetPassword').html('');
            var seconds_ago = moment.tz(app_timezone).diff(momentCooldownSentEmailInit, 'seconds');
            timerInterval = cooldownSentEmailDuration - seconds_ago;
            if (timerInterval > 0) {
                $('#btnLogin').prop("disabled", true);
                $('#btnLogin').html("{!! __('content.modal.login.reset.btn2',['second'=>'"+seconds_ago+"']) !!}");
            } else {
                $('#btnLogin').prop("disabled", false);
            }
        }
    }

    $('#btnLogin').on('click', e => {
        e.preventDefault();
        $('#loginform').find('.is-invalid').each(function(el) {
            $(this).removeClass('is-invalid');
        });
        $('#loginform').find('.text-danger').each(function(el) {
            $(this).removeClass('notificationText');
            $(this).html('');
        });
        if ($('#loginModalLongTitle').html() === "{!! __('content.modal.login.login.title') !!}") {
            $.ajax({
                type: 'POST',
                url: "/validate-login",
                data: $("#loginform").serialize(),
                success: function(result) {
                    //$('#myform').addAttr('onsubmit','');
                    if (result['error']) {
                        if (result['error']['login_email']) {
                            validationAnimation(result['error']['login_email'], $(
                                '#error-login_email'), $('#inputLoginEmailModal'));
                        }
                        if (result['error']['login_password']) {
                            validationAnimation(result['error']['login_password'], $(
                                '#error-login_password'), $('#inputLoginPasswordModal'));
                        }
                        if (result['error']['message']) {
                            validationAnimation(result['error']['message'], $(
                                '#error-login_message'));
                        }
                    } else {
                        $('#loginform').attr('action',
                            "/login");
                        $('#loginform').submit();
                        /* Swal.fire({
                            title: 'Login',
                            text: "Are you sure to login?",
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, I &#39;m confirm!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#loginform').attr('action',
                                    "/login");
                                $('#loginform').submit();
                            }
                        }); */
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        } else if ($('#loginModalLongTitle').html() === "{!! __('content.modal.login.register.title') !!}") {
            $.ajax({
                type: 'POST',
                url: "/validate-register",
                data: $("#loginform").serialize(),
                success: function(result) {
                    //$('#myform').addAttr('onsubmit','');
                    //console.log(result);
                    if (result['error']) {
                        $('#error-login_message').addClass('notificationText');
                        $('#error-login_message').html(result['error']);
                        if (result['error']['login_username']) {
                            /* $('#inputLoginUsernameModal').addClass('is-invalid');
                            $('#error-login_username').addClass('notificationText');
                            $('#error-login_username').html(result['error']['login_username']); */
                            validationAnimation(result['error']['login_username'], $(
                                '#error-login_username'), $(
                                '#inputLoginUsernameModal'));
                        }
                        if (result['error']['login_email']) {
                            /* $('#inputLoginEmailModal').addClass('is-invalid');
                            $('#error-login_email').addClass('notificationText');
                            $('#error-login_email').html(result['error']['login_email']); */
                            validationAnimation(result['error']['login_email'], $(
                                '#error-login_email'), $(
                                '#inputLoginEmailModal'));
                        }
                        if (result['error']['login_password']) {
                            /* $('#inputLoginPasswordModal').addClass('is-invalid');
                            $('#error-login_password').addClass('notificationText');
                            $('#error-login_password').html(result['error']['login_password']); */
                            validationAnimation(result['error']['login_password'], $(
                                '#error-login_password'), $(
                                '#inputLoginPasswordModal'));
                        }
                        if (result['error']['login_rpassword']) {
                            /* $('#inputLoginRPasswordModal').addClass('is-invalid');
                            $('#error-login_rpassword').addClass('notificationText');
                            $('#error-login_rpassword').html(result['error']['login_rpassword']); */
                            validationAnimation(result['error']['login_rpassword'], $(
                                '#error-login_rpassword'), $(
                                '#inputLoginRPasswordModal'));
                        }
                        //removeClassAnimationEnd();
                    } else {
                        Swal.fire({
                            title: "{!! __('content.modal.login.register.title') !!}",
                            text: "{!! __('content.modal.login.register.sure') !!}",
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: "{!! __('content.modal.login.register.confirm') !!}"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                /* setInterval(function() {
                                    
                                }, 3000); */
                                $('#loginform').attr('action',
                                    "/register");
                                $('#loginform').submit();
                                //popupwindow('/email/verify', 'print_popup', '500', '820');
                                /* window.location.href = '/email/verify';
                                return false; */
                            }
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        } else if ($('#loginModalLongTitle').html() === "{!! __('content.modal.login.reset.title') !!}") {
            $('#btnLogin').prop("disabled", true);
            $validEmail = false;
            $.ajax({
                type: 'POST',
                url: "/email/exist",
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": $('#inputLoginEmailModal').val(),
                },
                success: function(result) {
                    if (result == 'success') {
                        $validEmail = true;
                    }
                },
                error: function(data) {
                    validationAnimation(data, $(
                        '#error-login_email'));
                }
            });
            if (!$validEmail) {
                validationAnimation("{!! __('content.modal.login.reset.error-invalid-email') !!}", $(
                    '#error-login_email'));
                return cooldownSentEmail(5);
            }
            $.ajax({
                type: 'POST',
                url: "/password/email",
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": $('#inputLoginEmailModal').val(),
                },
                complete: function(data) {
                    cooldownSentEmail(30);
                },
                success: function(result) {
                    Swal.fire(
                        "{!! __('content.modal.login.reset.title') !!}",
                        "{!! __('content.modal.login.reset.success-send-email') !!}",
                        'success'
                    );
                },
                error: function(data) {
                    validationAnimation(data['error'], $(
                        '#error-login_message'));
                    //$('#error-login_message').addClass('notificationText');
                    //$('#error-login_message').html(result['error']);
                }
            });
        }
    });

    function cooldownSentEmail(duration) {
        momentCooldownSentEmailInit = moment(app_timezone);
        cooldownSentEmailDuration = duration;
        timerInterval = moment(app_timezone).diff(momentCooldownSentEmailInit, 'seconds');
        var timerSentEmail = setInterval(() => {
            var seconds_ago = moment(app_timezone).diff(momentCooldownSentEmailInit, 'seconds');
            timerInterval = cooldownSentEmailDuration - seconds_ago
            //timerInterval -= 1000;
            if ($('#loginModalLongTitle').html() === "{!! __('content.modal.login.reset.title') !!}") {
                $('#btnLogin').prop("disabled", true);
                if (seconds_ago > cooldownSentEmailDuration) {
                    $('#btnLogin').html("{!! __('content.modal.login.reset.btn') !!}");
                    $('#btnLogin').prop("disabled", false);
                    clearInterval(timerSentEmail);
                } else {
                    $('#btnLogin').html("{!! __('content.modal.login.reset.btn2',['second'=>'"+timerInterval+"']) !!}");
                }
            } else {
                $('#btnLogin').prop("disabled", false);
                //clearInterval(timerSentEmail);
            }
        }, 100);
    }
</script>
