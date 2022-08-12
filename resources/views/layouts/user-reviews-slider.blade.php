<div class="reviews-slider" style="height:1000px;width100px;background-color:red;z-index=100000000000000;"></div>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/homepage/slick/slick.min.js') }}"></script>
{{-- <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script> --}}
<script type="text/javascript">
    var jQuery_1_11_0 = jQuery.noConflict();
</script>
<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            init();
        });

        function init() {
            $('.reviews-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 33,
                draggable: false,
                pauseOnFocus: false,
                pauseOnHover: false,
                pauseOnDotsHover: false,
            });

            $.getJSON("{{ asset('assets/homepage/json/reviews.json') }}", function(data) {
                var items = [];
                $.each(data, function(key, val) {
                    /* $('.reviews-slider').slick('slickAdd', "<div style='text-align:center;'>" + val['name'] +
                        "[" + val['occupation'] + "] Said '" + val['comments'] + "</div>"); */
                    $('.reviews-slider').slick('slickAdd', cardReview(val['prof'], val['name'], val[
                        'occupation'], val['comments']));
                });
            });
        }

        function cardReview(prof, name, occupation, comments) {
            return "<div class='card' style='width: 18rem;'><img src='" + prof +
                "' class='card-img-top' style='border-radius: 50%;'><div class='card-body'><h5 class='card-title'>" +
                name +
                "</h5><h6 class='card-subtitle mb-2 text-muted'>" +
                occupation + "</h6><p class='card-text'>" + comments + "</p></div></div>";
        }
    })(jQuery_1_11_0)
</script>