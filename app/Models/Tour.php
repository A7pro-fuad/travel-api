<?php

namespace App\Models;

use GuzzleHttp\Psr7\Stream;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'tours';

    protected $fillable = [
        'travel_id',
        'name',
        'starting_date',
        'ending_date',
        'price',
    ];

   
    public function price(): Attribute
    {
        return Attribute::make(

            get: fn ($value) => $value / 100,

            set: fn ($value) => $value * 100

        );
    }
}
