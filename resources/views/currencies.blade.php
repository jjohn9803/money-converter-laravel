<link rel="stylesheet" href="{{ asset('assets/homepage/css/bootstrap.min.css') }}">

<body>
    {{-- <div class=''>
        <img src='" + img + "' class='card-img-top p-5' style=''>
        <div class='card-body'>
            <h5 class='card-title text-center'>1" +
                "</h5>
            <p class='card-text'>" + text + "</p>
        </div>
    </div> --}}
    <div class="card" style="width: 18rem;">
        <div style="    width: 40px;
        position: fixed;
        line-height: 36px;
        border-radius: 50%;
        text-align: center;
        font-size: 20px;
        color: white;
        background-color: black;
        border: 2px solid #666;">1</div>
        <img class="card-img-top" src="{{ asset('assets/homepage/guides/1.png') }}" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
</body>

{{-- <ul id="nav">
    <li id="notification_li">
        <a href="#" id="notificationLink">Notifications</a>
        <span id="notification_count">3</span>

        <div id="notificationContainer">
            <div id="notificationTitle">Notifications</div>
            <div id="notificationsBody" class="notifications"></div>
            <div id="notificationFooter"><a href="#">See All</a></div>
        </div>

    </li>
</ul>
<style>
    #nav {
        list-style: none;
        margin: 0px;
        padding: 0px;
    }

    #nav li {
        float: left;
        margin-right: 20px;
        font-family: Arial;
        font-size: 14px;
        font-weight: bold;
    }

    #nav li a {
        color: #333333;
        text-decoration: none
    }

    #nav li a:hover {
        color: #006699;
        text-decoration: none
    }


    #notification_li {
        position: relative
    }

    #notificationContainer {
        background-color: #fff;
        border: 1px solid rgba(100, 100, 100, .4);
        -webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
        overflow: visible;
        position: absolute;
        top: 30px;
        margin-left: -170px;
        width: 400px;
        z-index: -1;
        display: none; // Enable this after jquery implementation
    }

    // Popup Arrow
    #notificationContainer:before {
        content: '';
        display: block;
        position: absolute;
        width: 0;
        height: 0;
        color: transparent;
        border: 10px solid black;
        border-color: transparent transparent white;
        margin-top: -20px;
        margin-left: 188px;
    }

    #notificationTitle {
        font-weight: bold;
        padding: 8px;
        font-size: 13px;
        background-color: #ffffff;
        position: fixed;
        z-index: 1000;
        width: 384px;
        border-bottom: 1px solid #dddddd;
    }

    #notificationsBody {
        padding: 33px 0px 0px 0px !important;
        min-height: 300px;
    }

    #notificationFooter {
        background-color: #e9eaed;
        text-align: center;
        font-weight: bold;
        padding: 8px;
        font-size: 12px;
        border-top: 1px solid #dddddd;
    }



    #notification_count {
        padding: 3px 7px 3px 7px;
        background: #cc0000;
        color: #ffffff;
        font-weight: bold;
        margin-left: 77px;
        border-radius: 9px;
        -moz-border-radius: 9px;
        -webkit-border-radius: 9px;
        position: absolute;
        margin-top: -11px;
        font-size: 11px;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#notificationLink").click(function() {
            $("#notificationContainer").fadeToggle(300);
            $("#notification_count").fadeOut("slow");
            return false;
        });

        //Document Click hiding the popup 
        $(document).click(function() {
            $("#notificationContainer").hide();
        });

        //Popup on click
        $("#notificationContainer").click(function() {
            return false;
        });

    });
</script> --}}
