<div class="slider-comments-wrap">
    <div id="card-slider" class="slider-comments">
        <div class="slider-comments-item">
            <div class="animation-card_image">
                <img src="https://uznayvse.ru/images/stories2016/uzn_1460039478.jpg" alt="">
            </div>
            <div class="animation-card_content">
                <h4 class="animation-card_content_title title-2">Charlize Theron 1</h4>
                <p class="animation-card_content_description p-2">With no contractual commitments comes the freedom of
                    having top notch content created whenever.</p>
                <p class="animation-card_content_city">New York, NY</p>
            </div>
        </div>
        <div class="slider-comments-item">
            <div class="animation-card_image">
                <img src="https://uznayvse.ru/images/stories2016/uzn_1460039478.jpg" alt="">
            </div>
            <div class="animation-card_content">
                <h4 class="animation-card_content_title title-2">Charlize Theron 1</h4>
                <p class="animation-card_content_description p-2">With no contractual commitments comes the freedom of
                    having top notch content created whenever.</p>
                <p class="animation-card_content_city">New York, NY</p>
            </div>
        </div>
        <div class="slider-comments-item">
            <div class="animation-card_image">
                <img src="https://uznayvse.ru/images/stories2016/uzn_1460039478.jpg" alt="haahhahaah">
            </div>
            <div class="animation-card_content">
                <h4 class="animation-card_content_title title-2">ZXZXZXZ</h4>
                <p class="animation-card_content_description p-2">With no contractual commitments comes the freedom of
                    having top notch content created whenever.</p>
                <p class="animation-card_content_city">New York, NY</p>
            </div>
        </div>
        <div class='slider-comments-item'>
            <div class='animation-card_image'>
                <img src='https://uznayvse.ru/images/stories2016/uzn_1460039478.jpg'>
            </div>
            <div class='animation-card_content'>
                <h4 class='animation-card_content_title title-2'>Charlize Theron 1</h4>
                <p class="animation-card_content_description p-2">With no contractual commitments comes the freedom of
                    having top notch content created whenever.</p>
                <p class="animation-card_content_city">New York, NY</p>
            </div>
        </div>
        <div class='slider-comments-item'>
            <div class='animation-card_image'>
                <img src='https://uznayvse.ru/images/stories2016/uzn_1460039478.jpg'>
            </div>
            <div class='animation-card_content'>
                <h4 class='animation-card_content_title title-2'>Charlize Theron 1</h4>
                <p class='animation-card_content_description p-2'>HERHEHERHEEH</p>
                <p class='animation-card_content_city'>NEW YORK MY CITY</p>
            </div>
        </div>
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

    .slider-comments-wrap {
        height: 100%;
        width: 100%;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }

    .slider-comments {
        position: absolute;
        width: 100%;
        left: 50px;
        top: 50px;
    }


    .slider-comments-item {
        width: 530px;
        padding: 20px 0 25px 30px;
        border-radius: 10px;
        background-color: #ffffff;
        display: flex;
        justify-content: flex-start;
        position: absolute;
        opacity: 0;
        z-index: 0;
        box-shadow: 0 4px 9px #f1f1f4;
        position: absolute;
        left: 0;
        top: 0;
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
        max-width: 374px;
        margin-left: 26px;
        font-family: "Open Sans", sans-serif;
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
    }

    .animation-card_content_city {
        font-size: 11px;
        margin: 10px 0 0 0;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        color: #696d74;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gsap/1.19.1/TweenMax.min.js"></script>
<script>
    var cards = $('#card-slider .slider-comments-item').toArray();

    startAnim(cards);

    function startAnim(array) {
        if (array.length >= 4) {
            TweenMax.fromTo(array[0], 0.5, {
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
                onComplete: sortArray(array)
            });

            TweenMax.fromTo(array[1], 0.5, {
                x: 79,
                y: 125,
                opacity: 1,
                zIndex: 1
            }, {
                x: 0,
                y: 0,
                opacity: 0.75,
                zIndex: 0,
                boxShadow: '-5px 8px 8px 0 rgba(82,89,129,0.05)',
                ease: Cubic.easeInOut
            });

            TweenMax.to(array[2], 0.5, {
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
                boxShadow: '-5px 8px 8px 0 rgba(82,89,129,0.05)',
                zIndex: 1,
                opacity: 1,
                ease: Cubic.easeInOut
            });

            TweenMax.fromTo(array[3], 0.5, {
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
        } else {
            $('#card-slider').append('<p>Sorry, carousel should contain more than 3 slides</p>')
        }
    }

    function sortArray(array) {
        clearTimeout(delay);
        var delay = setTimeout(function() {
            var firstElem = array.shift();
            array.push(firstElem);
            return startAnim(array);
        }, 10000)
    }
</script>
