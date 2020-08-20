<?php

namespace App\Module\User\Support;

use Illuminate\Support\Facades\Hash;

class PasswordGenerator
{
    /**
     * @return string
     */
    public static function generate()
    {
        return Hash::make(
            substr(
                str_shuffle(
                    str_repeat(
                        $x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x))
                    )
                ),
                1,10
            )
        );
    }
}
