<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;

class FileUpload extends Filesystem
{
    /**
     * @param string $path
     * @return bool
     */
    public function deleteFromPublicUpload($path)
    {
        $realPath = Config::get('filesystems.disks.public.root') . '/' . $path;
        if ($this->exists($realPath)) {
            return $this->delete($realPath);
        }
        return true;
    }
}
