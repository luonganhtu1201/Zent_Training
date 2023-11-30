<?php

namespace App\Services\User;

use App\Exceptions\ReportingException;
use App\Mail\SendMailCreateUser;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * @param Request $request
     * @return array
     * @throws ReportingException
     */
    public function login(Request $request): array
    {
        try {
            $user = User::query()->where([
                'email' => $request->email,
                'status' => User::STATUS['ACTIVE']
            ])->first();

            if(!$user){
                throw new ReportingException('Tài khoản đã bị khóa hoặc không tồn tại trên hệ thống!');
            }

            $credentials = request(['email', 'password']);
            $token = auth()->attempt($credentials);
            if($token){
                return [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ];
            }

            throw new ReportingException('Đăng nhập tài khoản không thành công!');
        } catch (Exception $e) {
            Log::error("ERROR - Login user", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage()
            ]);

            throw $e;
        }
    }
    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
	public function index(Request $request): mixed
	{
		try {
            $perPage = $request->integer('per_page') ?? config('contains.per_page');
            $query = User::query();

            if ($request->filled('q')) {
                $keyword = $request->string('q');
                $query = $query->where(function (Builder $q) use ($keyword) {
                    $q->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email', 'LIKE', '%' . $keyword . '%');
                });
            }

            if ($request->filled('status')) {
                $query = $query->where('status', $request->integer('status'));
            }

            if ($request->filled('order') && $request->filled('column')) {
                $query = $query->orderBy(
                    $request->string('column'),
                    $request->string('order')
                );
            } else {
                $query = $query->latest('created_at');
            }

            return $query->paginate($perPage);
	    } catch (Exception $e) {
			Log::error("ERROR - Get list users", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}

    /**
     * @param Request $request
     * @return void
     * @throws Exception
     */
	public function store(Request $request): void
    {
        DB::beginTransaction();
		try {
            $path = null;
            if ($request->hasFile('avatar')) {
                $path = Storage::disk('public')
                    ->put(
                        'uploads/images/avatars',
                        $request->file('avatar')
                    );
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => User::STATUS['ACTIVE'],
                'avatar' => $path,
            ]);
            Mail::to($request->email)->send(new SendMailCreateUser([
                'name' => $user->name
            ]));
			DB::commit();
		} catch (Exception $e) {
            DB::rollBack();
			Log::error("ERROR - create user", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}

    /**
     * @param Request $request
     * @param $id
     * @return void
     * @throws Exception
     */
	public function update(Request $request, $id): void
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $path = $user->avatar;
            if ($request->hasFile('avatar')) {
                $path = Storage::disk('public')
                    ->put(
                        'uploads/images/avatars',
                        $request->file('avatar')
                    );

                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->status = (int) $request->status;
            $user->avatar = $path;
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("ERROR - Update user", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage()
            ]);

            throw $e;
        }
	}

    /**
     * @param $id
     * @return void
     * @throws Exception
     */
	public function destroy($id): void
    {
		try {
            $user = User::find($id);
            $user->delete();
			return;
		} catch (Exception $e) {
			Log::error("ERROR - Delete user", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}
}
