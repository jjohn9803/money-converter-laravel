<div class="modal fade" style="z-index:10001" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form autocomplete="off" method="post" id='myform' enctype="multipart/form-data"> --}}
                {{-- <form action="/receipt" autocomplete="off" target="print_popup" method="post" id='myform'> --}}
                <form action="/receipt-form" autocomplete="off" target="print_popup" method="post" id='myform'>
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="modal-body">
                        <div class="contaienr">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 mycontent-left">
                                    {{-- <h3>Your information</h3> --}}
                                    {{-- <input type="text" class="inputStoreData" id="hidden_fx_id" value="-1">
                                <input type="text" class="inputStoreData" id="hidden_fx_rate" value="3.4">
                                <input type="text" class="inputStoreData" id="hidden_from_amount" value="0">
                                <input type="text" class="inputStoreData" id="hidden_base_currency" value="">
                                <input type="text" class="inputStoreData" id="hidden_to_amount" value="0">
                                <input type="text" class="inputStoreData" id="hidden_result_currency" value="">
                                <input type="text" class="inputStoreData" id="hidden_from_bank" value=""> --}}
                                    <div class="my-3">
                                        <label for="inputSendAmountModal">{!! __('content.modal.exchange.send-amt') !!}</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control is-valid inputgroupwithselect1"
                                                id="inputSendAmountModal" placeholder="{!! __('content.modal.exchange.send-amt') !!}"
                                                value="1000" required style="width:50px !important;"
                                                name='from_amount'>
                                            <span class="modal-currency" id="modal-currency">
                                                <span class='img-flag fi fi-my'></span>
                                                MYR
                                            </span>
                                            {{-- <select class="modalSelect2" id="modalSelectBaseCurrency" name="state">
                                            <option value="AL">Alabama</option>
                                            <option value="WY">Wyoming</option>
                                        </select> --}}
                                        </div>
                                        <span class="text-danger" id='error-from_amount'></span>
                                        <span class="text-info" id='info_fx_rate'></span>

                                    </div>
                                    <input id='form_input_from_country' name="from_country" style="display: none;"
                                        value="1">
                                    <input id='form_input_to_country' name="to_country" style="display: none;"
                                        value="1">
                                    <input id='form_input_from_currency' name="from_curr" style="display: none;"
                                        value="1">
                                    <input id='form_input_to_currency' name="to_curr" style="display: none;"
                                        value="1">
                                    <div class="my-3">
                                        <label for="inputResultAmountModal">{!! __('content.modal.exchange.result-amt') !!}</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control inputgroupwithselect1"
                                                id="inputResultAmountModal" placeholder="{!! __('content.modal.exchange.result-amt') !!}"
                                                value="1000" readonly>
                                            <span class="modal-currency" id="modal-currency2">
                                                <span class='img-flag fi fi-my'
                                                    style='font-size:32px;margin-left:20px;margin-right:10px;margin-bottom:2px;'></span>
                                                MYR
                                            </span>
                                            {{-- <select class="modalSelect2" id="modalSelectResultCurrency" name="state">
                                            <option value="AL">Alabama</option>
                                            <option value="WY">Wyoming</option>
                                        </select> --}}
                                        </div>
                                    </div>
                                    <div style="border-bottom: 1px solid white;"></div>
                                    <div class="my-3">
                                        <label for="inputUserBankModal">{!! __('content.modal.exchange.your-bank') !!}</label>
                                        <select class="form-control is-valid custom-select" id="inputUserBankModal"
                                            name='your_bank' required>
                                            <option value="" selected>{!! __('content.modal.exchange.bank-from') !!}</option>
                                            {{-- <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option> --}}
                                        </select>
                                        {{-- <select class="form-control is-valid custom-select modalSelect2" name="your_bank" id="inputUserBankModal" required>
                                        </select> --}}
                                        <span class="text-danger" id='error-user_bank'></span>
                                        {{-- <a href="javascript:void(0)">Not finding your banks? Suggest us more!</a> --}}
                                    </div>
                                    <div class="my-3">
                                        <label for="inputUserBankAccModal">{!! __('content.modal.exchange.your-bank-acc') !!}</label>
                                        <input type="text" class="form-control is-valid" id="inputUserBankAccModal"
                                            placeholder="{!! __('content.modal.exchange.bank-acc') !!}" name='your_bank_acc' required>
                                        <span class="text-danger" id='error-user_bank_acc'></span>
                                    </div>
                                    <div style="border-bottom: 1px solid white;"></div>
                                    <div class="my-3">
                                        <label for="inputUserBankModal">{!! __('content.modal.exchange.your-rbank') !!}</label>
                                        <select class="form-control is-valid custom-select"
                                            id="inputUserReceiveBankModal" name='your_receive_bank' required>
                                            <option value="" selected>{!! __('content.modal.exchange.bank-from') !!}</option>
                                            {{-- <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option> --}}
                                        </select>
                                        <span class="text-danger" id='error-user_receive_bank'></span>
                                    </div>
                                    <div class="my-3">
                                        <label for="inputUserReceiveBankAccModal">{!! __('content.modal.exchange.your-rbank-acc') !!}</label>
                                        <input type="text" class="form-control is-valid"
                                            id="inputUserReceiveBankAccModal" placeholder="{!! __('content.modal.exchange.bank-acc') !!}"
                                            name='your_receive_bank_acc' required>
                                        <span class="text-danger" id='error-user_receive_bank_acc'></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="container-radio-input">{!! __('content.modal.exchange.agree') !!}
                                <input type="checkbox" id="agree" name="agree" value="true">
                                <span class="checkmark"></span>
                                <span class="text-danger" id='error-agree'></span>
                            </label>
                        </div>
                        {{-- <div style="position: absolute;right:50px;bottom:-5px;">
                            <span class="text-danger" id='error-agree'></span>
                            <input type="checkbox" id="agree" name="agree" value="true">
                            <label for="agree" class="text-info">{!! __('content.modal.exchange.agree') !!}</label><br>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{!! __('content.modal.exchange.close') !!}</button>
                        <button type="submit" id='btnConfirm'
                            class="btn btn-primary">{!! __('content.modal.exchange.btn') !!}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#error-from_amount').on("animationend", function() {
        $(this).removeClass('notificationText');
        $('#inputSendAmountModal').removeClass('is-invalid');
    });

    $('#error-agree').on("animationend", function() {
        $(this).removeClass('notificationText');
        $('#inputSendAmountModal').removeClass('is-invalid');
    });

    $('#error-user_bank').on("animationend", function() {
        $(this).removeClass('notificationText');
        $('#inputUserBankModal').removeClass('is-invalid');
    });

    $('#error-user_bank_acc').on("animationend", function() {
        $(this).removeClass('notificationText');
        $('#inputUserBankAccModal').removeClass('is-invalid');
    });

    $('#error-user_receive_bank').on("animationend", function() {
        $(this).removeClass('notificationText');
        $('#inputUserReceiveBankModal').removeClass('is-invalid');
    });

    $('#error-user_receive_bank_acc').on("animationend", function() {
        $(this).removeClass('notificationText');
        $('#inputUserReceiveBankAccModal').removeClass('is-invalid');
    });

    $(document).on("change", "#modalSelectBaseCurrency", function() {
        var e = $("#modalSelectBaseCurrency option:checked").val();
        fx_rate = 5;
        updateResultAmount();
    });

    $(document).on("change", "#modalSelectResultCurrency", function() {
        var e = $("#modalSelectResultCurrency option:checked").val();
    });

    $(document).on("input", "#inputSendAmountModal", function(e) {
        updateResultAmount();
    });

    $(document).on("click", "#btnConfirm", function(e) {
        //popupwindow("/receipt", '_blank', 520, 570);
        /* window.open("/receipt", '_blank',
            'location=yes,height=570,width=520,scrollbars=yes,status=yes', 'true'); */
        //window.open(window.location.href+'receipt');
        //return false;
    });

    /* function closeHomePageModal() {
        $("#exampleModal").modal("hide");
    } */

    $(function() { // let all dom elements are loaded
        $("#exampleModal").on('hide.bs.modal', function() {
            //exampleModalReset();
        });
    });

    function exampleModalReset() {
        $('#inputUserBankModal').val('');
        $('#inputUserBankAccModal').val('');
        $('#inputUserBankModal').val('');
        $('#inputUserReceiveBankAccModal').val('');
        $('#inputUserReceiveBankModal').val('');
        $('#agree').prop('checked', false);
    }

    $("#myform").submit(function(e) {

        //prevent Default functionality
        //e.preventDefault();
        //popupwindow("/receipt", '_blank', 520, 570);
        //get the action-url of the form
        //var actionurl = e.currentTarget.action;

        //do your own request an handle the results
        /* $.ajax({
            url: actionurl,
            type: 'post',
            dataType: 'application/json',
            data: $("#myform").serialize(),
            success: function(data) {
                popupwindow("/receipt", '_blank', 520, 570);
            }
        }); */

    });

    function popupwindow(url, title, w, h) {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        var windowReference = window.open();
        var newUrl = url;
        myService.getUrl().then(function(newUrl) {
            windowReference.location = newUrl;
        });
        return window.open(url, title,
            'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' +
            w + ', height=' + h + ', top=' + top + ', left=' + left);
    }

    function updateResultAmount() {
        if ($.trim($('#inputSendAmountModal').val()).length) {
            //var base_currency = $(".modalSelect2 option:checked").val();
            //var send_amt = parseFloat($('#inputSendAmountModal').val());
            $('#inputResultAmountModal').val(parseInt(parseFloat($("#inputSendAmountModal").val() / base_fx) *
                result_fx));
        } else {
            $('#inputResultAmountModal').val('0');
        }
    };

    //console.log({!! json_encode($banks[0]->name) !!});

    //readCurrency();

    /* function getMessage() {
        var base_id = 1;
        var result_id = 2;
        $.ajax({
            type: 'GET',
            url: "/fx",
            data: {
                base_id: base_id,
                result_id: result_id,
            },
            success: function(result) {
                console.log(result);
            },
            error: function(data) {
                console.log(data);
            }
        });
    } */

    /* function readCurrency() {
        $.ajax({
            type: 'GET',
            url: "/getCurr",
            success: function(result) {
                console.log(result);
            },
            error: function(data) {
                console.log(data);
            }
        });
    } */
</script>
