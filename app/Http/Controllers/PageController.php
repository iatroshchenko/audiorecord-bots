<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index(Request $request)
    {
        return Inertia::render('Home');
    }

    public function login(Request $request)
    {
        $started = $this->adminService->getSuperadmin();

        return Inertia::render('Login', [
            'started' => !!$started
        ]);
    }

    public function start(Request $request)
    {
        $started = $this
            ->adminService
            ->getSuperadmin();

        if ($started) abort(404);

        return Inertia::render('Start');
    }

    public function records(Request $request)
    {
        return Inertia::render('Records');
    }
}
