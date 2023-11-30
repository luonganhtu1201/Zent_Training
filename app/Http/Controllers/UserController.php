<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class UserController extends BaseApiController
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $users = $this->userService->index($request);

            return $this->responseSuccess($users);
        } catch (Exception $e) {
            $data = [];
            $message = 'Có lỗi xảy ra, vui lòng thử lại sau!';
        }

        return $this->responseError($message, $data);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->userService->store($request);

            return $this->responseSuccess();
        } catch (Exception $e) {
            $data = [];
            $message = 'Có lỗi xảy ra, vui lòng thử lại sau!';
        }

        return $this->responseError($message, $data);
    }

    public function update(UpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->userService->update($request, $id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            $data = [];
            $message = 'Có lỗi xảy ra, vui lòng thử lại sau!';
        }

        return $this->responseError($message, $data);
    }

    public function destroy(DeleteRequest $request, $id): JsonResponse
    {
        try {
            $this->userService->destroy($id);

            return $this->responseSuccess();
        } catch (Exception $e) {
            $data = [];
            $message = 'Có lỗi xảy ra, vui lòng thử lại sau!';
        }

        return $this->responseError($message, $data);
    }
}
