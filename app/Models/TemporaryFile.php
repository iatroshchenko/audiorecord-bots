<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class TemporaryFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($temporaryFile) {
            if (file_exists($temporaryFile->getFile()->getPathname())) {
                FileFacade::delete($temporaryFile->getFile()->getPathname());
            }
        });
    }

    public function getFile(): File
    {
        $path = Storage::disk('local')
            ->path($this->path);

        if (!file_exists($path)) throw new \DomainException('Temporary file does not exist: ' . $path);

        return new File($path);
    }

    public static function store(SymfonyFile $file, string $path, string $filename): self
    {
        $fullPath = self::getFullPath($path);
        $file->move($fullPath, $filename);

        return self::create([
            'path' => $path . '/' . $filename
        ]);
    }

    public static function getFullPath(string $path): string
    {
        return Storage::disk('local')->path($path);
    }

    public function getFullPathAttribute()
    {
        return self::getFullPath($this->path);
    }

    public static function getByPath(string $path): self
    {
        $file = self::wherePath($path)->first();

        if (!$file) self::cantGetFileException($path, 'File not found in Database');
        $path = $file->full_path;

        if (!file_exists($path)) self::cantGetFileException($path, 'File not found on disk');

        return $file;
    }

    public static function cantGetFileException(string $path, string $message)
    {
        throw new \DomainException('Cannot get temporary file by path ' . $path . ' : ' . $message);
    }

    public function becomeReal(string $folder): string
    {
        $disk = config('filesystems.default');
        $prefix = $disk === 'local' ? 'public/' : '';

        $file = $this->getFile();
        $contents = FileFacade::get($file->getPathname());
        $realPathname = $folder . '/' . $file->getFilename();
        Storage::put($prefix . $realPathname, $contents, 'public');

        $this->delete();
        return $realPathname;
    }
}
