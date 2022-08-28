<?php


function handleResponse($result, $msg)
{
    $res = [
        'success' => true,
        'message' => $msg,
        'datas' => $result,
    ];

    return response()->json($res, 200);
}

function handleError($error, $errorMsg = [], $code = 404)
{
    $res = [
        'success' => false,
        'message' => $error
    ];

    if (!empty($errorMsg)) {
        $res['data'] = $errorMsg;
    }
    return response()->json($res, $code);
}