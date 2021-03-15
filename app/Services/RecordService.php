<?php


namespace App\Services;


use App\Http\Repositories\RecordRepository;
use App\Http\Repositories\TagRepository;
use App\Http\Requests\Internal\Record\CreateRecordRequest;
use App\Models\Record;
use Illuminate\Support\Facades\DB;

class RecordService
{
    private RecordRepository $records;
    private TagRepository $tags;

    public function __construct(RecordRepository $records, TagRepository $tags)
    {
        $this->records = $records;
        $this->tags = $tags;
    }

    public function createRecordFromRequest(CreateRecordRequest $request): Record
    {
        DB::beginTransaction();

        try {
            $record = $this->records->createFromRequest($request);
            $tags = $this->tags->getMultipleByUuid($request->input('tags'));
            $record->tags()->attach($tags);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return $record;
    }
}
