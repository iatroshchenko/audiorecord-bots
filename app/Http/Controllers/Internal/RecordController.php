<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RecordRepository;
use App\Http\Requests\Internal\Record\BulkCreateRecordRequest;
use App\Http\Requests\Internal\Record\CreateRecordRequest;
use App\Http\Requests\Internal\Record\DeleteRecordRequest;
use App\Http\Resources\RecordResource;
use App\Models\Record;
use App\Services\RecordService;
use App\Traits\Controller\SendsEmptyResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RecordController extends Controller
{
    use SendsEmptyResponse;

    private RecordService $recordService;

    public function __construct(RecordService $recordService)
    {
        $this->recordService = $recordService;
    }

    public function create(CreateRecordRequest $request)
    {
        $this->recordService->createRecordFromRequest($request);
        return $this->sendCreatedResponse();
    }

    public function bulkCreate(BulkCreateRecordRequest $request)
    {
        $this->recordService->bulkCreateRecordFromRequest($request);
        return $this->sendCreatedResponse();
    }

    public function delete(DeleteRecordRequest $request)
    {
        $this->recordService->deleteRecordFromRequest($request);
        return $this->sendDeletedResponse();
    }
}
