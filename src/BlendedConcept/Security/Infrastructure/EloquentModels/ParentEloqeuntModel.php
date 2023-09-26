<?php


namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentEloqeuntModel extends Model
{
    use HasFactory;


    protected $primaryKey = 'parent_id';

    protected $fillable = [
        'user_id',
        'organization_id'
    ];
}
