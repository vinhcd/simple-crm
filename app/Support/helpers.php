<?php

use Illuminate\Support\Facades\URL;

if (! function_exists('upload_url')) {
    /**
     * Generate a uploaded url for the application.
     *
     * @param  string  $path
     * @return string
     */
    function upload_url($path)
    {
        return URL::to('storage/' . SUBDOMAIN . DIRECTORY_SEPARATOR . $path);
    }
}
