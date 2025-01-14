<?php

namespace App\Traits\Models;

trait HasActivity
{
    public static function add($ip, $user_id, $col)
    {
        $model = static::create([
            $col => $user_id,
            'ip_address' => $ip,
            'mac_address' => getMacAddress(),
            'login_time' => now(),
        ]);

        return $model;
    }
}
