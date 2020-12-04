<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('log_error')) {

    function log_error($msg, $obj=null, $debug_backtrace=true)
    {
        if($obj != null)
        {
            $msg = $msg . ' : ' . print_r($obj, true);
        }

        if($debug_backtrace == true)
        {
            $d = debug_backtrace();
            if($d != null && is_array($d) && count($d) > 1)
            {
                $debug = $d[1];
                $msg = sprintf("[%s::%s] %s", $debug['class'], $debug['function'], $msg);
            }
        }

        log_message('error', $msg);
    }
}

if(!function_exists('log_mon')) {

    function log_mon($msg, $obj=null, $debug_backtrace=true)
    {
        if($obj != null)
        {
            $msg = $msg . ' : ' . print_r($obj, true);
        }

        if($debug_backtrace == true)
        {
            $d = debug_backtrace();
            if($d != null && is_array($d) && count($d) > 1)
            {
                $debug = $d[1];
                $msg = sprintf("[%s::%s] %s", $debug['class'], $debug['function'], $msg);
            }
        }
        
        log_message('mon', $msg);
    }
}
