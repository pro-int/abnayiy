<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class SystemConfigurationError extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        $message = $this->message;
        if ($request->wantsJson()) {
            return response()->json([
                'done' => false,
                'success' => false,
                'message' => $message,
                'errors' => [],
            ], 400);
        }
        return view('errors.400', compact('message'));
    }
}
