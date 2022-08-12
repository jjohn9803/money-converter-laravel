<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/receipt/style.css') }}">
</head>

<div class="container bg-light d-md-flex align-items-center">
    <div class="card box2 shadow-sm p-md-5 p-md-5 p-4">
        <div class="p-md-4 p-4" style="text-align:right;">

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
        <form action="">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex flex-column ps-md-5 px-md-0 px-4 mb-4">
                        <span>Base Amount</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="1000">
                            <span class="fas fa-money-bill"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column px-md-3 px-md-0 px-4 mb-4">
                        <span>Exchange Rate</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="2.33">
                            <span class="fas fa-percentage"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column pe-md-5 px-md-0 px-4 mb-4">
                        <span>Result Amount</span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" value="2330">
                            <span class="fas fa-hand-holding-usd"></span>
                        </div>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-center mb-5">
                        <div class="inputWithIcon timer-container">
                            <span class="timer-title">Countdown Timer</span>
                            <span class="timer-minutes-number" id='timer-minutes-number'>00</span>
                            <span class="timer-minutes-text">minutes</span>
                            <span class="timer-symbol">:</span>
                            <span class="timer-seconds-number" id='timer-seconds-number'>00</span>
                            <span class="timer-seconds-text">seconds</span>
                            {{-- <span class="fas fa-clock"></span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> <span>Transfer to this account</span>
                        <div class="inputWithIcon"> <input class="form-control to_acc" id='to_acc' type="text"
                                value="5136 1845 5468 3894" disabled> <span class="fas fa-user-check"></span></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column px-4 mb-4"> <span>Reference No</span>
                        <div class="inputWithIcon"> <input class="form-control to_acc" id='to_acc' type="text"
                                value="1234567890" disabled> <span class="fas fa-receipt"></span></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="fw-bolder mb-4">
                        <span class="far text guide-text">
                            <span class="ps-2">1. Kindly check the information if it is <span
                                    class="highlight-text text-danger">correct</span>. If you find any unreasonable or
                                misinformation in the receipt, press <span
                                    class="highlight-text text-primary">Cancel</span> to cancel the process, and contact
                                us at 07-12345679.</span>
                            <br><br>
                            <span class="ps-2">2. You should attach the <span
                                    class="highlight-text text-danger">Reference No</span> during the transaction.
                            </span>
                            <br><br>
                            <span class="ps-2">3. Press <span class="highlight-text text-danger">Confirm</span>
                                transaction if you completed the transaction.</span>
                            <br><br>
                            <span class="far text">
                                <span class="ps-2" style="font-size:12px;"><span
                                        class="highlight-text text-danger">Note:</span> We will not be held responsible
                                    for any invalid transaction or liable for
                                    any loss.</span>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-6 px-md-2 px-1 mt-3">
                    <div class="btn btn-danger w-100">Cancel</div>
                </div>
                <div class="col-6 px-md-2 px-1 mt-3">
                    <div class="btn btn-primary w-100" id='btnConfirm'>Confirm</div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script>
    var start = moment();
    var end = moment("20220625T115200");
    var countdown = setInterval(function() {
        refreshTimer();
    }, 100);

    function refreshTimer() {
        var duration = moment.duration(end.diff(start));
        var minutes = duration.minutes();
        var seconds = duration.seconds();
        start.add(100,'milliseconds');
        if (start.isAfter(end)){
            receiptExpired();
            return;
        }
        if (minutes < 3) {
            $('.timer-minutes-number').css('color', 'red');
            $('.timer-seconds-number').css('color', 'red');
        }
        $('.timer-minutes-number').html((((minutes < 10) && (minutes > -1)) ? '0' + minutes : minutes));
        $('.timer-seconds-number').html((((seconds < 10) && (seconds > -1)) ? '0' + seconds : seconds));
    }

    function receiptExpired(){
        clearInterval(countdown);
        //alert('expired!');
    }
</script>
