<?php
if (!function_exists('priceFormatted')) {
    function priceFormatted($amount="")
    {
         return ($amount !=null ? $amount : 0).' AED';
    }
}
if (!function_exists('defaultCode')) {
    function defaultCode()
    {
         return 971;
    }
}


if (!function_exists('ordinal')) {
    function ordinal($number)
    {
        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }
}
