<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top"><img src="{{ url('storage/img/navbar-logo.svg') }}" alt="..." /></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class=" navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item">
                    <select class="selectpicker" data-live-search="true" style="width:10px;" data-width="auto" data-size="3">
                        <option class="py-2" data-tokens="Canada CAD"
                            data-subtext
                            title="1">SOMETHING</option>
                        {{-- <option class="py-2" data-tokens="Canada CAD"
                            data-subtext="<img class='flag' src='{{ url('storage/assets/flag/CAN_flag.png') }}'><strong class='text-dark ms-3'>CAD</strong><span class='text-dark ms-2'>Canada</span>"
                            title="Canada"></option>
                        <option class="py-2" data-tokens="Canada CAD"
                            data-subtext="<img class='flag' src='{{ url('storage/assets/flag/CAN_flag.png') }}'><strong class='text-dark ms-3'>CAD</strong><span class='text-dark ms-2'>Canada</span>"
                            title="Canada"></option> --}}
                    </select>
                </li>
            </ul>
        </div>
    </div>
</nav>
