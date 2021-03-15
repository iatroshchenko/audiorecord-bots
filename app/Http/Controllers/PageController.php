<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecordResource;
use App\Models\Record;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

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
        $defaultSort = '-created_at';

        $records = QueryBuilder::for(Record::class)
            ->with([
                'tags'
            ])
            ->allowedSorts([
                'name',
                'default_search_available',
                'created_at'
            ])
            ->defaultSort($defaultSort);

        $paginated = $records
            ->paginate($request->query('perPage') ?? 2);

        $data = $paginated->toArray();
        $data['data'] = RecordResource::collection($paginated);

        return Inertia::render('Records', [
            'paginated' => $data,
            'sortBy' => $request->query('sort')
        ]);
    }
}
