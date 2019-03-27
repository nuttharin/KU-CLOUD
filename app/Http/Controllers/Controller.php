<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public const HTTP_OK = 200;
    // public const HTTP_CREATED = 201;
    // public const HTTP_ACCEPTED = 202;
    // public const HTTP_NO_CONTENT = 204;

    // public const HTTP_BAD_REQUEST = 400;
    // public const HTTP_UNAUTHORIZED = 401;
    // public const HTTP_PAYMENT_REQUIRED = 402;
    // public const HTTP_FORBIDDEN = 403;
    // public const HTTP_NOT_FOUND = 404;
    // public const HTTP_METHOD_NOT_ALLOWED = 405;
    // public const HTTP_UNPROCESSABLE_ENTITY = 422;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
            // 'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
