<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseApiController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserActive extends BaseApiController
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->status === User::STATUS['DEACTIVATE']) {
            $message = 'Tài khoản của bạn đã bị khóa!';

            return $this->responseError(
                $message,
                [],
                ResponseAlias::HTTP_UNAUTHORIZED,
                ResponseAlias::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
