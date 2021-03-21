<?php


namespace App\Services;


use App\Http\Repositories\RecordRepository;
use App\Http\Repositories\TagRepository;
use App\Http\Requests\Internal\Record\CreateRecordRequest;
use App\Http\Requests\Internal\Record\DeleteRecordRequest;
use App\Models\Record;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function deleteRecordFromRequest(DeleteRecordRequest $request): bool
    {
        DB::beginTransaction();

        try {
            $record = $this->records->getByUuid($request->input('record_uuid'));
            $record->delete();

            $deleted = Storage::delete($record->getPathToDelete());
            if (!$deleted)  new \Exception('File not found on disk ' . $record->getPathToDelete());

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        return true;
    }
}
