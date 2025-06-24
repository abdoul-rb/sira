<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'slug',
        'name',
        'email',
        'phone_number',
        'website',
        'active',
        'logo_path',
        'address',
        'city',
        'zip_code',
        'country',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Company $company) {
            $company->slug = Str::slug($company->name);
            $company->uuid = Str::uuid();
        });

        static::updating(function (Company $company) {
            $company->slug = Str::slug($company->name);
        });
    }

    /* protected function phone_number(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => decrypt($value),
            set: fn(string $value) => encrypt($value),
        );
    } */


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
}
