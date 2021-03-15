<?php


namespace App\Http\Repositories;


use App\Http\Requests\Internal\Record\CreateRecordRequest;
use App\Models\Record;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\DB;

class RecordRepository
{
    public function createRecord(array $data): Record
    {
        $disk = config('filesystems.default');

        $record = Record::create([
            'name' => $data['name'],
            'is_remote' => $disk === 'local',
            'default_search_available' => $data['default_search_available'],
            'path' => $data['path']
        ]);

        return $record;
    }

    public function createFromRequest(CreateRecordRequest $request): Record
    {
        DB::beginTransaction();

        try {
            $temporaryFile = TemporaryFile::getByPath($request->input('path'));
            $path = $temporaryFile->becomeReal(Record::RECORD_FOLDER);

            $record = $this->createRecord([
                'name' => $request->input('name'),
                'default_search_available' => $request->input('default_search_available'),
                'path' => $path
            ]);

            DB::commit();

            return $record;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
