<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RecordRepository;
use App\Http\Requests\Internal\Record\CreateRecordRequest;
use App\Traits\Controller\SendsEmptyResponse;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    use SendsEmptyResponse;

    private RecordRepository $records;

    public function __construct(
        RecordRepository $records
    )
    {
        $this->records = $records;
    }

    public function create(CreateRecordRequest $request)
    {
        $this->records->createFromRequest($request);
        return $this->sendCreatedResponse();
    }
}
