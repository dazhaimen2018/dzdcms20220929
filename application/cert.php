<?php

function grant(){
    $grant['domain'] = 'mscms.net';
    $grant['level']  = 1;
    $grant['date']   = 0;
    $grant['sites']  = 0;
    $grant['sign']   = '';
    return $grant;
}

function agent(){
    $agent['domain'] = '';
    $agent['level']  = 0;
    $agent['date']   = 0;
    $agent['sites']  = 0;
    $agent['sign']   = '';
    return $agent;
}
