<?php

namespace App\Http\Controllers;

use App\Exceptions\ReportingException;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends BaseApiController
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->userService->login($request);

            return $this->responseSuccess($token);
        } catch (ReportingException $e){
            $message = $e->getMessage();
        } catch (Exception $e) {
            $message = 'Không thể truy cập tài khoản';
        }
        return $this->responseError(
            $message,
            [],
            ResponseAlias::HTTP_UNAUTHORIZED,
            ResponseAlias::HTTP_UNAUTHORIZED
        );
    }
}
