<div class="slider-comments-wrap">
    <h3 class="slider-comment-section-title">{!! __('content.section-review.title') !!}</h3>
    <div id="card-slider" class="slider-comments">
        {{-- <div class='slider-comments-item'>
            <div class='animation-card_image'>
                <img src='https://uznayvse.ru/images/stories2016/uzn_1460039478.jpg'>
            </div>
            <div class='animation-card_content'>
                <h4 class='animation-card_content_title title-2'>Charlize Theron 1</h4>
                <p class='animation-card_content_description p-2'>HERHEHERHEEH</p>
                <p class='animation-card_content_city'>NEW YORK MY CITY</p>
            </div>
        </div> --}}
    </div>
</div>
<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700');

    /* html {
        width: 100%;
        height: 100%;
    }


    .body {
        background-image: linear-gradient(180deg, #ffb253 0%, #f56259 100%);
        width: 100%;
        height: 100%;
    } */

    .slider-comment-section-title {
        font-size: 2.4rem;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .slider-comments-wrap {
        /* position: inherit; */
        height: 100%;
        width: 70%;
        margin: 0px auto;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }

    .slider-comments {
        position: relative;
        width: 100%;
        height: 100%;
        left: 50px;
        top: 50px;
    }


    .slider-comments-item {
        /* width: 530px; */
        height: 150px;
        margin: 0px 50px;
        padding: 20px 50px 25px 30px;
        border-radius: 10px;
        background-color: #ffffff;
        display: flex;
        justify-content: flex-start;
        position: absolute;
        opacity: 0;
        z-index: 0;
        box-shadow: 0 4px 9px rgb(168, 168, 168);
        position: absolute;
        left: 0;
        top: 0;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .animation-card_image {
        max-width: 60px;
        max-height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        box-shadow: 0 4px 9px rgba(241, 241, 244, 0.72);
        background-color: #ffffff;
    }

    .animation-card_image>img {
        width: 53px;
        height: 53px;
        border-radius: 50%;
        object-fit: cover;
        -webkit-user-drag: none;
        -khtml-user-drag: none;
        -moz-user-drag: none;
        -o-user-drag: none;
        user-drag: none;
    }

    /* img {
        width: 53px;
        height: 53px;
        border-radius: 50%;
        object-fit: cover;
    } */

    .animation-card_content {
        width: 100%;
        /* max-width: 374px; */
        overflow: auto;
        margin-left: 26px;
        font-family: "Open Sans", sans-serif;
        overflow-y: scroll;
        scroll-behavior: smooth;
        transition-duration: 5ms;
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .animation-card_content::-webkit-scrollbar {
        display: none;
    }

    .animation-card_content_title {
        color: #4a4545;
        font-size: 16px;
        font-weight: 400;
        letter-spacing: -.18px;
        line-height: 24px;
        margin: 0;
    }

    .animation-card_content_description {
        color: #696d74;
        font-size: 15px;
        font-weight: 300;
        letter-spacing: normal;
        line-height: 24px;
        margin: 10px 0 0 0;
        overflow: auto;
    }

    .animation-card_content_city {
        font-size: 11px;
        margin: 10px 0 0 0;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        color: #696d74;
    }

    @media screen and (max-width: 991px) {
        .slider-comments-item {
            /* position: inherit; */
        }
    }

    @media screen and (max-width: 767px) {
        .slider-comments-item {
            /* position: inherit; */
        }
    }

    @media screen and (max-width: 524px) {
        .slider-comments-wrap {
            position: inherit;
            /* width: 300px;
            margin: 0px auto; */
        }

        .slider-comments {
            left: 0px;
            width: auto;
        }

        .slider-comments-item {
            /* width: 100%; */
            height: 175px;
            left: -25px;
        }

        .animation-card_image>img {
            margin-left: 125px;
        }

        .animation-card_content {
            margin-left: -60px;
            margin-top: 75px;
        }
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gsap/1.19.1/TweenMax.min.js"></script>
<script>
    function startAnim($array) {
        if ($array.length >= 4) {
            TweenMax.fromTo($array[0], 0.5, {
                x: 0,
                y: 0,
                opacity: 0.75
            }, {
                x: 0,
                y: -120,
                opacity: 0,
                zIndex: 0,
                delay: 0.03,
                ease: Cubic.easeInOut,
                onComplete: sortArray($array)
            });


            TweenMax.fromTo($array[1], 0.5, {
                x: 79,
                y: 125,
                opacity: 1,
                zIndex: 1
            }, {
                x: 0,
                y: 0,
                opacity: 0.75,
                zIndex: 0,
                ease: Cubic.easeInOut
            });

            TweenMax.to($array[2], 0.5, {
                bezier: [{
                    x: 0,
                    y: 250
                }, {
                    x: 65,
                    y: 200
                }, {
                    x: 79,
                    y: 125
                }],
                boxShadow: '-5px 8px 8px 0 rgb(168, 168, 168)',
                zIndex: 1,
                opacity: 1,
                ease: Cubic.easeInOut
            });

            TweenMax.fromTo($array[3], 0.5, {
                x: 0,
                y: 400,
                opacity: 0,
                zIndex: 0
            }, {
                x: 0,
                y: 250,
                opacity: 0.75,
                zIndex: 0,
                ease: Cubic.easeInOut
            }, );

            $array[2].querySelector(':scope > .animation-card_content').setAttribute('id', 'animation-scroll');
            scrollWithAnimation(4500);
        } else {
            $('#card-slider').append('<p>Sorry, carousel should contain more than 3 slides</p>')
        }
    }

    function scrollWithAnimation(duration) {
        $('#animation-scroll').animate({
            scrollTop: $('#animation-scroll').get(0).scrollHeight,
        }, {
            duration: duration,
            done: function() {
                $('#animation-scroll').animate({
                    scrollTop: '0px',
                }, duration);
                $('#animation-scroll').removeAttr('id');
            },
        });
    }

    function sortArray(array) {
        clearTimeout(delay);
        var delay = setTimeout(function() {
            var firstElem = array.shift();
            array.push(firstElem);
            return startAnim(array);
        }, 10000)
    }

    $.getJSON("{{ asset('assets/homepage/json/reviews.json') }}", function(data) {
        var items = [];
        $.each(data, function(key, val) {
            var locale = $('html').attr('lang');
            if (locale.includes('zh')) locale = 'zh';
            var content = "<div class='slider-comments-item'>" +
                "<div class='animation-card_image'>" +
                "<img src='" + val['prof'] + "'>" +
                "</div>" +
                "<div class='animation-card_content'>" +
                "<h4 class='animation-card_content_title title-2'>" + val['name'][locale] + "</h4>" +
                "<p class='animation-card_content_description p-2'>" + val['occupation'][locale] +
                "</p>" +
                "<p class='animation-card_content_city'>" + val['comments'][locale] + "</p>" +
                "</div>" +
                "</div>";
            $('#card-slider').append(content);
            /* $('.reviews-slider').slick('slickAdd', cardReview(val['prof'], val['name'], val[
                'occupation'], val['comments'])); */
        });
        startAnim($('#card-slider .slider-comments-item').toArray());
    });
</script>
