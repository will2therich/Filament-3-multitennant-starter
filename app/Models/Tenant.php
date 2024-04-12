<?php

namespace App\Models;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Legodion\Lucid\Traits\HasNewFactory;

class Tenant extends Model
{
    use SoftDeletes, HasNewFactory;

    protected $table = 'tenants';

    protected $connection = 'master_db';

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function definition(Generator $faker)
    {
        return [
            'name' => $faker->name,
        ];
    }
}
