<?php

namespace Src\BlendedConcept\Organization\Infrastructure\EloquentModels;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;



class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = ['id','organization_id'];



public static function getCustomColumns(): array
{
    return [
        'id',
        'organization_id',
    ];
}
}