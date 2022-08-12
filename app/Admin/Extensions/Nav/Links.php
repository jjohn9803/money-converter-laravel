<?php

namespace App\Admin\Extensions\Nav;

class Links
{
    public function __toString()
    {
        $audio = asset('assets/audio/notification_1.mp3');
        return <<<HTML
<audio style="display:none; height: 0" id="bg-music" preload="auto" src='$audio'></audio>

<li>
    <a href="/admin/transactions?order=confirm">
      <i class="fa fa-exchange"></i>
      <span class="label label-warning" id="inventory"></span>
    </a>
</li>

<script>
    var userInteract = false;
    $(document).ready(function() {
        window.addEventListener('click', () => {
            $('body').bind('touchstart touchmove scroll mousedown DOMMouseScroll mousewheel keyup',
                function(event) {
                    userInteract = true;
                }
            );
        }, {
            once: true
        });
    });

    $.ajax(getting);
    window.setInterval(function() {
        $.ajax(getting);
    },5000);

    var getting = {
        url:'/admin/getNotification',
        dataType:"json",
        success:function(res) {
          if(res.code == 200){
            toastr.options = {
                timeOut:120000,
                onclick: function() {
                    location = window.location.origin+'/admin/transactions?order=confirm';
                },
            }
            toastr.warning(res.msg); // 提示文字
            if(userInteract){
                var audio = document.getElementById('bg-music');  // 启用音频通知
                audio.play();
                setTimeout(function(){
                    audio.load(); // 1.5秒后关闭音频通知
                },1500);
            }
          }
          $('#inventory').html(res.re);
        },
        error: function (res) {
            console.log(res);
        }
    };
</script>
HTML;
    }
}
