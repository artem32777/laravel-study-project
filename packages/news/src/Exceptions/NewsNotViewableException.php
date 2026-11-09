<?php

namespace LaraN\News\Exceptions;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsNotViewableException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('Новость не найдена.');
    }

    public function render(Request $request): Response
    {

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
            ], 404);
        }

        return response()->view('news::unavailable', status: 404);
    }
}
