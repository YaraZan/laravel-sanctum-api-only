<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot function to generate UUIDs based on the database driver.
     */
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            if ($model->getConnection()->getDriverName() === 'pgsql') {
                $model->uuid = (string) Str::uuid();
            } else {
                $model->uuid = hex2bin(str_replace('-', '', (string) Str::uuid()));
            }
        });
    }

    /**
     * Accessor to convert binary UUID to string when retrieving (MySQL only).
     */
    public function getUuidAttribute($value)
    {
        if ($this->getConnection()->getDriverName() === 'pgsql') {
            return $value;
        }

        $hex = bin2hex($value);
        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12)
        );
    }

    /**
     * Find a model by its UUID.
     */
    public static function findByUuid(string $uuid)
    {
        if ((new static())->getConnection()->getDriverName() === 'pgsql') {
            return static::where('uuid', '=', $uuid)->firstOrFail();
        }

        $binaryUuid = hex2bin(str_replace('-', '', $uuid));
        return static::where('uuid', '=', $binaryUuid)->firstOrFail();
    }

    /**
     * Get IDs for an array of UUIDs, converting them to binary format.
     */
    public static function getByUuids(array $uuids)
    {
        if ((new static())->getConnection()->getDriverName() === 'pgsql') {
            return static::whereIn('uuid', $uuids);
        }

        $binaryUuids = array_map(fn($uuid) => hex2bin(str_replace('-', '', $uuid)), $uuids);

        return static::whereIn('uuid', $binaryUuids);
    }
}
