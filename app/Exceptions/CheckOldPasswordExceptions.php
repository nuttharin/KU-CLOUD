<?php

namespace App\Exceptions;

use Exception;

class CheckOldPasswordExceptions extends Exception
{
    public function render($request)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            $json = [
                'old_password' => false,

            ];
            return response()->json($json, 400);
        }
    }
}
