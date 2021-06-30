<?php
if(!function_exists('dump')) {
    function dump()
    {
        $args = func_get_args();
        call_user_func_array(['Kint', 'dump'], $args);
    }

    Kint::$aliases[] = 'dump';
}

if(!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        call_user_func_array(['Kint', 'dump'], $args);
        exit;
    }

    Kint::$aliases[] = 'dd';
}
