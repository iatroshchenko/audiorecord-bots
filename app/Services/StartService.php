<?php


namespace App\Services;


use App\Events\Admin\SuperadminCreated;
use App\Http\Requests\Start\StartFormSubmitRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StartService
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function startFromRequest(StartFormSubmitRequest $request)
    {
        try {
            DB::beginTransaction();

            $superadmin = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make(
                    $request->input('password')
                ),
                'role_id' => $this->roleService->getSuperadminRole()->id
            ]);

            event(new SuperadminCreated($superadmin));

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }
}
