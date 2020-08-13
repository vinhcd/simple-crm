<?php

namespace App\Helper;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class InjectionHelper
{
    const KEY = 'injection';

    /**
     * @param string $module
     * @return void
     */
    public static function bind($module)
    {
        $injections = Config::get(self::KEY);

        if (isset($injections[$module])) {
            foreach ($injections[$module] as $interface => $implementation) {
                App::bind($interface, $implementation);
            }
        }
    }
}
