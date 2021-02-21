<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Services\AdminService;
use Closure;
use Illuminate\Http\Request;

class ErrorIfNotStarted
{
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $superAdmin = $this->adminService->getSuperadmin();
        if (!$superAdmin) {
            abort('404');
        }

        return $next($request);
    }
}
