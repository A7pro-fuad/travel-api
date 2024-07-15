<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;

class Deliveryman extends Model
{
    use HasFactory, HasUuids;

    // function countPresentSheep($sheep) {
    //     return count(array_filter($sheep, function($s) { return $s === true; }));
    // }


    public $table = 'deliverymen';
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    public function latitude(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }
    public function longitude(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }
}
