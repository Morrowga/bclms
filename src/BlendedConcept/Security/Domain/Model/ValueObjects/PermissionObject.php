<?php

namespace Src\BlendedConcept\Security\Domain\Model\ValueObjects;

use Src\BlendedConcept\Security\Domain\Model\Entities\Permission;
use Src\Common\Domain\Exceptions\EntityNotFoundException;
use Src\Common\Domain\ValueObjectArray;

final class PermissionObject extends ValueObjectArray
{
    public readonly array $permissions;

    public function __construct(array $permissions)
    {
        parent::__construct($permissions);

        foreach ($permissions as $permission) {
            if (!$permission instanceof Permission) {
                throw new \InvalidArgumentException('Invalid address');
            }
        }
        $this->permissions = array_values($permissions);
    }

    public function add(Permission $permission): void
    {
        $this->append($permission);
    }

    public function update(Permission $newAddress): void
    {
        $addressIds = array_column($this->permissions, 'id');
        if (!in_array($newAddress->id, $addressIds)) {
            throw new EntityNotFoundException('Address not found');
        }
        $this->offsetSet(array_search($newAddress->id, $addressIds), $newAddress);
    }

    public function remove(int $permission_id): void
    {
        $permissionIds = array_column($this->permissions, 'id');
        if (!in_array($permission_id, $permissionIds)) {
            throw new EntityNotFoundException('Address not found');
        }
        $this->offsetUnset(array_search($permission_id, $permissionIds));
    }


    public function __toString(): string
    {
        return implode(',', $this->permissions);
    }

    public function toArray(): array
    {
        return $this->permissions;
    }

    public function jsonSerialize(): array
    {
        return $this->permissions;
    }
}
