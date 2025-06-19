<?php

namespace Merlion\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $guarded = [];

    public static function get($key, $default = null, $group = null)
    {
        $keys = explode(".", $key);
        $key  = $keys[0];

        if (!empty($group)) {
            $setting = self::where('group', $group)->where('key', $key)->first();
        } else {
            $setting = self::where('key', $key)->first();
        }
        $value = $setting ? $setting->value : null;
        if (count($keys) > 1) {
            $value = Arr::get(to_json($value), $keys[1]);
        }
        return $value;
    }

    public static function set($key, $value, $group = null, $payload = null): void
    {
        if (empty($group)) {
            $setting = self::where('key', $key)->first();
        } else {
            $setting = self::where('group', $group)->where('key', $key)->first();
        }

        if ($setting) {
            $setting->value = to_string($value);
            if (!empty($payload)) {
                $setting->payload = $payload;
            }
            $setting->save();
        } else {
            $type = gettype($value);
            self::create([
                'key'     => $key,
                'type'    => $type,
                'value'   => to_string($value),
                'group'   => $group,
                'payload' => $payload,
            ]);
        }
    }
}
