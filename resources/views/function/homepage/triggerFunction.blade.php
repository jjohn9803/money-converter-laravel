<script>
    function compareStrings(a, b) {
        // Assuming you want case-insensitive comparison
        a = a.toLowerCase();
        b = b.toLowerCase();

        return (a < b) ? -1 : (a > b) ? 1 : 0;
    }

    $('#btnConfirm').on('click', e => {
        e.preventDefault();
        $('#myform').find('is-invalid').each(function(el) {
            $(this).removeClass('is-invalid');
        });
        $('#myform').find('.text-danger').each(function(el) {
            $(this).removeClass('notificationText');
            $(this).html('');
        });

        $.ajax({
            type: 'POST',
            url: "/validate-form",
            data: $("#myform").serialize(),
            success: function(result) {
                //$('#myform').addAttr('onsubmit','');
                if (result['error']) {
                    if (result['error']['swal']) {
                        Swal.fire(
                            'Sorry',
                            result['error']['swal'],
                            'warning'
                        )
                        return false;
                    }
                    if (result['error']['from_amount']) {
                        $('#inputSendAmountModal').addClass('is-invalid');
                        $('#error-from_amount').addClass('notificationText');
                        $('#error-from_amount').html(result['error']['from_amount']);
                    }
                    if (result['error']['agree']) {
                        $('#error-agree').addClass('notificationText');
                        $('#error-agree').html(result['error']['agree']);
                    }
                    if (result['error']['your_bank']) {
                        $('#inputUserBankModal').addClass('is-invalid');
                        $('#error-user_bank').addClass('notificationText');
                        $('#error-user_bank').html(result['error']['your_bank']);
                    }
                    if (result['error']['your_bank_acc']) {
                        $('#inputUserBankAccModal').addClass('is-invalid');
                        $('#error-user_bank_acc').addClass('notificationText');
                        $('#error-user_bank_acc').html(result['error']['your_bank_acc']);
                    }
                    if (result['error']['your_receive_bank']) {
                        $('#inputUserReceiveBankModal').addClass('is-invalid');
                        $('#error-user_receive_bank').addClass('notificationText');
                        $('#error-user_receive_bank').html(result['error']['your_receive_bank']);
                    }
                    if (result['error']['your_receive_bank_acc']) {
                        $('#inputUserReceiveBankAccModal').addClass('is-invalid');
                        $('#error-user_receive_bank_acc').addClass('notificationText');
                        $('#error-user_receive_bank_acc').html(result['error'][
                            'your_receive_bank_acc'
                        ]);
                    }
                    //console.log('nooooo');
                } else {
                    Swal.fire({
                        title: "{!! __('content.modal.exchange.transaction_form') !!}",
                        text: "{!! __('content.modal.exchange.sure') !!}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "{!! __('content.modal.exchange.confirm') !!}",
                        cancelButtonText: "{!! __('content.modal.exchange.cancel') !!}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#myform').attr('onsubmit',
                                "popupwindow('about:blank','print_popup','500','820')");
                            $('#myform').submit();
                            location.reload();
                            //$("#exampleModal .close").click()
                            /* $("#exampleModal").modal("hide"); */
                        }
                    });
                }
                //console.log(result);
                //popupwindow('/receipt','print_popup','500','820');
                /*result.forEach(function(key) {
                    $('.js-example-basic-single').append("<option value='" + key['id'] + "." + key[
                        'country']['id'] + "'>" + key['country']['name'] + " (" + key[
                        'name'] + ")</option>");
                })
                $(".transition-section").css("pointer-events", "auto"); */
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $('#btnGetStarted').on('click', function(e) {
        var verified_type = {!! json_encode($verified) !!};
        $('#btnGetStarted').attr('data-target', '#exampleModal');
        //var wh_start = $home_pages.find(obj => obj.name == 'Working Hours')['value']['start'];
        //var wh_end = $home_pages.find(obj => obj.name == 'Working Hours')['value']['end'];
        var wh_start = {!! json_encode($wh_start) !!};
        var wh_end = {!! json_encode($wh_end) !!};
        var is_maintenance = {!! json_encode($is_maintenance) !!};
        if (is_maintenance) {
            Swal.fire(
                "{!! __('content.swal.warning') !!}",
                "{!! __('content.swal.under-maintenance') !!}",
                'warning'
            )
            $('#btnGetStarted').attr('data-target', '');
            return false;
        }
        //console.log({!! json_encode($wh_start) !!});
        /* if (!moment().isBetween(moment(wh_start, 'hh:mm:ss'), moment(wh_end, 'hh:mm:ss'))) {
            Swal.fire(
                "{!! __('content.swal.warning') !!}",
                "{!! __('content.swal.not-between-wh', ['start' => '"+wh_start+"', 'end' => '"+wh_end+"']) !!}",
                'warning'
            )
            $('#btnGetStarted').attr('data-target', '');
            return false;
        } */

        if (!moment().isBetween(moment(wh_start, 'hh:mm:ss'), moment(wh_end, 'hh:mm:ss')) && wh_start !=
            wh_end) {
            Swal.fire(
                "{!! __('content.swal.warning') !!}",
                "{!! __('content.swal.not-between-wh', ['start' => '"+wh_start+"', 'end' => '"+wh_end+"']) !!}",
                'warning'
            )
            $('#btnGetStarted').attr('data-target', '');
            return false;
        }
        if (verified_type == null) {
            Swal.fire(
                "{!! __('content.swal.warning') !!}",
                "{!! __('content.swal.get-started.prompt-login') !!}",
                'warning'
            )
            $('#btnGetStarted').attr('data-target', '');
            return false;
        }
        if (verified_type == false) {
            Swal.fire({
                icon: 'warning',
                title: "{!! __('content.swal.warning') !!}",
                text: "{!! __('content.swal.get-started.prompt-verified') !!}",
                footer: "<a onclick='sendVerification()' id='sendVerificationFooter'>{!! __('content.swal.get-started.prompt-verified-footer') !!}</a>"
            })
            $('#btnGetStarted').attr('data-target', '');
            return;
        }
        if ($('#sel_from_curr').val() === $('#sel_to_curr').val()) {
            Swal.fire(
                "{!! __('content.swal.warning') !!}",
                "{!! __('content.swal.get-started.prompt-same') !!}",
                'warning'
            )
            //alert('You cannot convert same currencies!');
            $('#btnGetStarted').attr('data-target', '');
            return false;
        }
        var from_curr_id = $('#sel_from_curr').val().split(".")[0];
        var from_min_amt = $currencies.find(obj => obj.id == from_curr_id)['min_amt'];
        var from_max_amt = $currencies.find(obj => obj.id == from_curr_id)['max_amt'];
        var from_curr_name = $currencies.find(obj => obj.id == from_curr_id)['name'];
        var inputBaseAmt = $('#base_amt_homePage').val();
        if ((inputBaseAmt < from_min_amt) || (inputBaseAmt > from_max_amt)) {
            Swal.fire(
                "{!! __('content.swal.sorry') !!}",
                "{!! __('content.swal.get-started.prompt-between', [
                    '1' => '"+from_min_amt+"',
                    '2' => '"+from_max_amt+"',
                    '3' => '"+from_curr_name+"',
                ]) !!}",
                'warning'
            )
            //alert('You cannot convert same currencies!');
            $('#btnGetStarted').attr('data-target', '');
            return false;
        }

        $('#inputUserBankModal').html('');
        $('#inputUserReceiveBankModal').html('');
        const country_id = parseInt(($('#sel_from_curr').val()).split(".")[1]);
        const country_id2 = parseInt(($('#sel_to_curr').val()).split(".")[1]);

        $banks.sort(function(a, b) {
            return compareStrings(a.name, b.name);
        }).forEach(function($data, $key) {
            if ($data['country_id'] != null) {
                const my_country = $data['country_id'].map(str => {
                    return Number(str);
                });

                if (my_country.indexOf(country_id) > -1) {
                    $('#inputUserBankModal').append('<option value="' + $data['id'] + '">' + $data[
                            'name'] +
                        '</option>');
                }
                if (my_country.indexOf(country_id2) > -1) {
                    $('#inputUserReceiveBankModal').append('<option value="' + $data['id'] + '">' +
                        $data[
                            'name'] +
                        '</option>');
                }
            }
        });

        if ($('#inputUserBankModal').html() == '' || $('#inputUserReceiveBankModal').html() == '') {
            var curr;
            if ($('#inputUserBankModal').html() == '') {
                curr = $('#sel_from_curr option:selected').text();
            } else if ($('#inputUserReceiveBankModal').html() == '') {
                curr = $('#sel_to_curr option:selected').text();
            }
            Swal.fire(
                "{!! __('content.swal.sorry') !!}",
                "{!! __('content.swal.get-started.prompt-lack-bank-account', [
                    'currency' => '<b>"+curr+"</b>',
                ]) !!}",
                'warning'
            );
            $('#btnGetStarted').attr('data-target', '');
            return false;
        }

        //
        var bank_accounts_support = false;
        $bank_accounts.forEach(element => {
            console.log(element['country_id']);
            console.log(country_id);
            if (element['country_id'].indexOf(country_id) > -1) {
                bank_accounts_support = true;
            }
        });

        if ($bank_accounts.length < 1 || !bank_accounts_support) {
            var curr = $('#sel_from_curr option:selected').text();
            Swal.fire(
                "{!! __('content.swal.sorry') !!}",
                "{!! __('content.swal.get-started.prompt-lack-banks', [
                    'currency' => '<b>"+curr+"</b>',
                ]) !!}",
                'warning'
            );
            $('#btnGetStarted').attr('data-target', '');
            return false;
        }
    });

    $("#exampleModal").on('show.bs.modal', function(e) {
        //reset modal
        //$("#inputUserBankModal").val('').trigger('change');
        //$("#inputUserBankAccModal").val('');
        //console.log($banks[0]['name']);
        var from_curr_id = $('#sel_from_curr').val().split(".")[0];
        var from_country_id = $('#sel_from_curr').val().split(".")[1];
        var from_alpha_2_code = $countries.find(obj => obj.id == from_country_id)['alpha_2_code'].toLowerCase();
        var from_curr_name = $currencies.find(obj => obj.id == from_curr_id)['name'];
        var from_min_amt = $currencies.find(obj => obj.id == from_curr_id)['min_amt'];
        var from_max_amt = $currencies.find(obj => obj.id == from_curr_id)['max_amt'];

        var to_curr_id = $('#sel_to_curr').val().split(".")[0];
        var to_country_id = $('#sel_to_curr').val().split(".")[1];
        var to_alpha_2_code = $countries.find(obj => obj.id == to_country_id)['alpha_2_code'].toLowerCase();
        var to_curr_name = $currencies.find(obj => obj.id == to_curr_id)['name'];

        //$countries[country_id - 1]['alpha_2_code']
        $('#displayMinAmt').html(from_min_amt);
        $('#displayMaxAmt').html(from_max_amt);
        $('#inputSendAmountModal').val($("#base_amt_homePage").val());
        $('#inputResultAmountModal').val(parseInt(parseFloat($("#base_amt_homePage").val() / base_fx) *
            result_fx));
        $('#modal-currency').html("<span class='img-flag fi fi-" + from_alpha_2_code + "'></span>" +
            from_curr_name);
        $('#modal-currency2').html("<span class='img-flag fi fi-" + to_alpha_2_code + "'></span>" +
            to_curr_name);
        $('#info_fx_rate').html($('#display_fx_rate_only').html());
        //$('#display_fx_rate_only').html()
        /* console.log(base_fx); */
        //alert("I want this to appear after the modal has opened!");
    });
    //inputUserBankModal

    $('#logout').click(function() {
        window.location.href = '/logout';
        return false;
    });

    $('#localeEn').click(function() {
        window.location.href = '/language/en';
        return false;
    });

    $('#localeZh-CN').click(function() {
        window.location.href = '/language/zh-CN';
        return false;
    });

    $('#notificationReadAll').click(function() {
        $.ajax({
            type: 'PUT',
            url: "/read-all-notification",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                retrieveNotification();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $('#notificationFooter').click(function() {
        window.location.href = '/view-notification';
        return false;
    });

    $('#transaction_history').click(function() {
        window.location.href = '/view-transaction-history';
        return false;
    });

    function sendVerification() {
        Swal.showLoading();
        setTimeout(function() {
            $.ajax({
                type: 'POST',
                url: "/email/resend",
                async: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: "{!! __('content.swal.success') !!}",
                        text: "{!! __('content.swal.send-verification') !!}",
                        /* footer: "<a id='verify_email_footer'>Verify your email</a>" */
                    })
                    //retrieveNotification();
                },
                error: function(data) {
                    Swal.close();
                    console.log(data);
                }
            });
        }, 500);
        /* window.location.href = 'email/verify'; */
        return false;
    }

    $('#verify_email').click(function() {
        sendVerification();
    });

    $('#scroll-to-footer').click(function() {
        $("html").animate({
            scrollTop: $('#footer-section').position().top
        });
        return false;
    });

    $('#backToTop').click(function() {
        $("html").animate({
            scrollTop: 0
        });
    });
</script>
