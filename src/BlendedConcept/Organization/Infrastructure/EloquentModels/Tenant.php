<?php

namespace Src\BlendedConcept\Organization\Infrastructure\EloquentModels;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = ['id', 'organisation_id'];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'organisation_id',
        ];
    }
}
