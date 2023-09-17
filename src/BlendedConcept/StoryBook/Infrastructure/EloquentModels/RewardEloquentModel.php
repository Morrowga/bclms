<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'stickers';

    protected $fillable = [
        'id',
        'file_src',
        'name',
        'gold_coins',
        'silver_coins',
        'status',
        'rarity'
    ];

    /**
    * THIS USED FOR RARITY STATUS THAT WILL USE ON THE CONTROLLER
    * FOR ENUM TYPE THAT ARE CONSTANT
    * @HARRY
    **/
    protected const RARITY = [
        "common" => "COMMON",
        "rare"  => "RARE",
        "superrare" => "SUPERRARE",
        "epic" => "EPIC",
        "legenedary" => "LEGENDARY"
    ]
    // public function scopeFilter($query, $filters)
    // {
    //     $query->when($filters['name'] ?? false, function ($query, $name) {
    //         $query->where('name', 'like', '%' . $name . '%');
    //     });
    //     $query->when($filters['search'] ?? false, function ($query, $search) {
    //         $query->where('name', 'like', '%' . $search . '%');
    //     });
    // }
}
