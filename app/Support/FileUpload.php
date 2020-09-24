<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Filesystem
{
    /**
     * @param string $path
     * @return bool
     */
    public function deleteFromPublicUpload($path)
    {
        /* @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
        $fileSystem = Storage::disk('public');
        $realPath = $fileSystem->path($path);
        if ($this->exists($realPath)) {
            return $this->delete($realPath);
        }
        return true;
    }
}
