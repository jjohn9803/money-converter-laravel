<style>
    .comment-sm-center {
        margin-left: 50%;
        transform: translateX(-50%);
        width: fit-content;
        white-space: nowrap;
    }

    .comment-sm-card-title {
        color: #2e2d2f;
        text-align: center;
        padding: 5px 0;
    }

    .comment-sm-card-img {
        border-radius: 50%;
        border: 1px solid black;
        width: 50px;
        height: 50px;
    }

    .comment-sm-card-body {
        width: 240px;
        height: 320px;
        overflow: hidden;
    }

    .comment-sm-card-subtitle {
        color: #696d74;
        font-size: 15px;
        font-weight: 300;
        letter-spacing: normal;
        line-height: 24px;
        overflow: auto;
        white-space: normal;
        width: 180px;
        text-align: center;
    }

    .comment-sm-card-text {
        height: 200px;
        overflow-y: scroll;
        box-sizing: content-box;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        color: #696d74;
        padding: 0px 15px;
    }

    .comment-sm-card-text::-webkit-scrollbar {
        display: none;
    }

    .swiper {
        width: 240px;
        height: 320px;
    }

    .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 22px;
        font-weight: bold;
        color: #fff;
    }
</style>

<div class="swiper mySwiper my-5" id='section-comment-sm'>
    <div class="swiper-wrapper" id='swiper-container'></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    $.getJSON("{{ asset('assets/homepage/json/reviews.json') }}", function(data) {
        var items = [];
        $.each(data, function(key, val) {
            var locale = $('html').attr('lang');
            if (locale.includes('zh')) locale = 'zh';
            var content = "<div class='swiper-slide'>" +
                "<div class='card'>" +
                "<div class='card-body comment-sm-card-body'>" +
                "<img src='" + val['prof'] + "'" +
                "class='comment-sm-center comment-sm-card-img'>" +
                "<h5 class='card-title comment-sm-card-title comment-sm-center'>" + val['name'][
                    locale
                ] + "</h5>" +
                "<h6 class='card-subtitle mb-2 text-muted comment-sm-card-subtitle comment-sm-center'>" +
                val['occupation'][locale] + "</h6><p class='card-text comment-sm-card-text'>" + val[
                    'comments'][locale] + "</p>" +
                "</div></div></div>";
            //$('#card-slider').append(content);
            $('#swiper-container').append(content);
            /* $('.reviews-slider').slick('slickAdd', cardReview(val['prof'], val['name'], val[
                'occupation'], val['comments'])); */
        });
        var swiper = new Swiper(".mySwiper", {
            /* effect: "cards", */
            observer: true,
            observeParents: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            loop: true,
            spaceBetween: 30,
            grabCursor: true,
        });
        
        //startAnim($('#card-slider .slider-comments-item').toArray());
    });

    function getRandomColor() {
        const randomBetween = (min, max) => min + Math.floor(Math.random() * (max - min + 1));
        const r = randomBetween(0, 255);
        const g = randomBetween(0, 255);
        const b = randomBetween(0, 255);
        const rgba = `rgba(${r},${g},${b},1)`;
        return rgba;
    }

    function cardReview(prof, name, occupation, comments) {
        return "<div class='card'><img src='" + prof +
            "' class='card-img-top p-5' style='border-radius: 50%;'><div class='card-body'><h5 class='card-title'>" +
            name +
            "</h5><h6 class='card-subtitle mb-2 text-muted'>" +
            occupation + "</h6><p class='card-text'>" + comments + "</p></div></div>";
    }
</script>
