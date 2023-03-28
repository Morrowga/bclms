<?php

declare(strict_types=1);

namespace Src\BlendedConcept\User\Domain\Model;

use Illuminate\Database\Eloquent\Model;

use Src\BlendedConcept\User\Domain\Model\User;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Role extends Model
{

    protected $fillable = ['name','description'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }


}
