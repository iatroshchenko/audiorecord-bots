<?php

namespace App\Http\Controllers;

use App\Http\Requests\Start\StartFormSubmitRequest;
use App\Services\StartService;
use Illuminate\Support\Facades\Redirect;

class StartController extends Controller
{
    private StartService $startService;

    public function __construct(
        StartService $startService
    )
    {
        $this->startService = $startService;
    }

    public function start(StartFormSubmitRequest $request)
    {
        $this
            ->startService
            ->startFromRequest($request);

        return Redirect::route('verification.notice');
    }
}
