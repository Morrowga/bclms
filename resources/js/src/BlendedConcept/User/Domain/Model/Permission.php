<?php

declare(strict_types=1);

namespace Src\BlendedConcept\User\Domain\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Permission extends Model
{
   protected $tables = 'permissions';

   protected $fillable = [
      'name',
      'description'
   ];

   public function scopeFilter($query, $filters)
   {
      $query->when($filters['name'] ?? false, function ($query, $name) {
         $query->where('name', 'like', '%' . $name . '%');
      });
      $query->when($filters['search'] ?? false, function ($query, $search) {
         $query->where('name', 'like', '%' . $search . '%');
      });
   }
}
