<?php
namespace Lib;

class Xss
{


    protected  static function removeAllSpace($str, $url_encoded = TRUE)
    {
        $non_displayables = array();
        if ($url_encoded)
        {
            $non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }

    protected static function htmlSpace($str = '',$var = '')
    {
        $add_str = array('%01','%02','%03','%04','%05','%06','%07','%08','%09','%0b','%0c','%0e','%0f','%20','%19','%18','%17','%16','%15','%14','%13','%12','%11','%10',' ','%1a','%1b','%1c','%1d','%1f');
        return str_replace($add_str,$var,$str);
    }

    protected static  function htmlEntity($str = '')
    {
        $add_str = array('<','>','.','/','\'',':',';','(',')','=','"','*','[',']','{','}','%3c','%3e','%2e','%2f','%27','%3a','%3b','%28','%29','%3d','%09','%22','%2a','%5b','%5d','%7b','%7d','$','%24','?','%3f');
        $html_str = array('&#60','&#62','&#46','&#47','&#39','&#58','&#59','&#40','&#41','&#61','&#34','&#42','&#91','&#93','&#123','&#125','&#60','&#62','&#46','&#47','&#39','&#58','&#59','&#40','&#41','&#61','<br/>','&#34','&#42','&#91','&#93','&#123','&#125','&#36;','&#36;','&#63;','&#63;');
        return str_replace($add_str,$html_str,$str);
    }


    public static function handle()
    {
        foreach ($_GET as $key => $val) {
            $val = self::removeAllSpace($val);
            $val = self::htmlSpace($val);
            $val = self::htmlEntity($val);
            $val = addslashes($val);
            $_GET[$key] = $val;
        }


        foreach ($_POST as $pkey => $pval) {
            $val = self::removeAllSpace($pval);
            $val = self::htmlSpace($val);
            $val = self::htmlEntity($val);
            $val = addslashes($val);
            $_GET[$pkey] = $val;
        }
    }


}