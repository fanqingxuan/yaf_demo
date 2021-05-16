<?php
function dump(...$params)
{
    foreach ($params as $var) {
        var_dump($var);
    }
}

function dd(...$params)
{
    dump(...$params);
    die;
}
