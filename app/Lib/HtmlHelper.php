<?php
/**
 * Created by IntelliJ IDEA.
 * User: hoang
 * Date: 07/03/2017
 * Time: 16:43
 */

namespace App\Lib;

class HtmlHelper
{
    public static function setAttr($key, $value, $ignoreEmpty = true)
    {
        if ($ignoreEmpty == true and $value == "")
            return "";
        return $key . "=\"" . $value . "\" ";
    }
}