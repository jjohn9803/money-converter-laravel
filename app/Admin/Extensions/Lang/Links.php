<?php

namespace App\Admin\Extensions\Lang;

class Links
{

    public function __toString()
    {
        
        return <<<HTML

<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-language"></i>
    </a>
    <ul class="dropdown-menu">
        <li>
            <div>
                <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                    <li><!-- start message -->
                            <a class="text-black" href="/admin/language/en" data-id="en">
                            English
                            </a>
                    </li>
                    <li><!-- start message -->
                        <a class="text-black" href="/admin/language/zh-CN" data-id="zh-CN">
                             簡體中文
                        </a>
                    </li>
                </ul>
            <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 200px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
        </li>
    </ul>
</li>
HTML;

    }
}