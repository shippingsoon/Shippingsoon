<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function die_r($var, $die = TRUE)
{
    if ($die)
        die("<pre>".print_r($var, TRUE)."</pre>");
    else
        echo "<pre>".print_r($var, TRUE)."</pre>";

}