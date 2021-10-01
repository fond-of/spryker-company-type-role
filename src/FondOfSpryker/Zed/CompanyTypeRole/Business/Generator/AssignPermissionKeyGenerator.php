<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Generator;

use Generated\Shared\Transfer\CompanyRoleTransfer;

class AssignPermissionKeyGenerator implements AssignPermissionKeyGeneratorInterface
{
    public const KEY_PREFIX = 'Assign';
    public const KEY_SUFFIX = 'Permission';

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return string|null
     */
    public function generateByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): ?string
    {
        $companyRoleName = $companyRoleTransfer->getName();

        if ($companyRoleName === null) {
            return null;
        }

        return sprintf(
            '%s%s%s',
            static::KEY_PREFIX,
            str_replace('_', '', ucwords($companyRoleName, '_')),
            static::KEY_SUFFIX
        );
    }
}