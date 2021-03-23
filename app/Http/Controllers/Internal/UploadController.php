<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Internal\Record\UploadRecordRequest;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function uploadRecord(UploadRecordRequest $request)
    {
        $file = $request->file('file');
        $path = 'tmp/' . Str::random(6);
        $filename = Str::random(11) . '.' . $file->getClientOriginalExtension();
        $temporaryFile = TemporaryFile::store($file, $path, $filename);

        return response()
            ->json([
                'path' => $temporaryFile->path
            ]);
    }
}
