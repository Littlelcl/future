<?php
/**
 * Created by PhpStorm.
 * User: zhaozemin
 * Date: 2018/11/15
 * Time: 17:13
 */

if (!function_exists('jsonReturn')){
    function jsonReturn($code_msg, $data = [], $extralMsg = '')
    {
        $code_msg = explode('|', $code_msg);
        $msg = $extralMsg ?: $code_msg[1];
        return response()->json(['code' => $code_msg[0], 'msg' => $msg, 'data' => $data]);
    }
}

if (!function_exists('array_depth')) {
    function array_depth($arr) {
        $maxDepth = 1;
        foreach ($arr as $v) {
            if (is_array($v)) {
                $depth        = array_depth($v) + 1;
                if ($depth > $maxDepth) {
                    $maxDepth = $depth;
                }
            }
        }
        return $maxDepth;
    }
}

if (!function_exists('array_get_int')) {
    function array_get_int($arr, $key, $default = 0) {
        return (int)array_get($arr, $key, (int)$default);
    }
}

if (!function_exists('tableHash')) {
    function tableHash($str)
    {
        if (is_string($str)) {
            {
                $str = strtolower($str);
                $len = strlen($str);
                $num = 0;
                for ($i = 0; $i < $len; $i++) {
                    $ord = ord($str{$i});
                    if ($ord > 127) {
                        $ord -= 256;
                        $ord2 = ord($str{$i + 1});
                        if ($ord2 > 127) {
                            $ord2 -= 256;
                        }
                        $ord += $ord2;
                        $i++;
                    }
                    $num += $ord;
                }
            }
            $res = $num % 10;
            if ($num < 0) {
                return ($res + 16) % 10;
            }
            return $res;
        }
    }
}

if (!function_exists('recursion')){
    function recursion(int $num)
    {
        if ($num == 0){
            return 2;
        }
        if ($num == 1){
            return 3;
        }
        return recursion($num-1)+$num;
    }
}

if (!function_exists('getStorageUser')){
    function getStorageUser(){
        return session('user_id', 0);
    }
}

if (!function_exists('setStorageUser')){
    function setStorageUser($userId){
        return session( ['user_id' => $userId]);
    }
}