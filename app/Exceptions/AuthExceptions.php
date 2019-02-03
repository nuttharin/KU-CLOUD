<?php

namespace App\Exceptions;

use Exception;

class AuthExceptions extends Exception
{
    public function render($request, Exception $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $json = [
                'message_error' => $e->getMessage(),
            ];
            return response()->json($json, 400);
        }
    }
}
