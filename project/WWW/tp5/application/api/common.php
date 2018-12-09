<?php
function show($status, $message='' , $data=[]) {       //返回规范的数组
    return [
        'status' => intval($status),
        'message' => $message,
        'data' => $data,
    ];
}