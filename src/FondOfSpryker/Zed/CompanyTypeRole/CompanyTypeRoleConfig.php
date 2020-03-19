<?php

namespace FondOfSpryker\Zed\CompanyTypeRole;

use FondOfSpryker\Shared\CompanyTypeRole\CompanyTypeRoleConstants;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyTypeRoleConfig extends AbstractBundleConfig
{
    public const ROLE_NAME_SUPER_ADMINISTRATION = 'super_administration';
    public const ROLE_NAME_CUSTOMER_SERVICE = 'customer_service';
    public const ROLE_NAME_DISTRIBUTION = 'distribution';

    public const ROLE_NAME_ADMINISTRATION = 'administration';
    public const ROLE_NAME_MARKETING = 'marketing';
    public const ROLE_NAME_PURCHASE = 'purchase';

    /**
     * @param string $companyTypeName
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer[]
     */
    public function getPredefinedCompanyRolesByCompanyTypeName(string $companyTypeName): array
    {
        if (!$this->isValidCompanyTypeName($companyTypeName)) {
            return [];
        }

        $predefinedRoles = [
            $this->createCompanyRole($companyTypeName, static::ROLE_NAME_ADMINISTRATION, true),
            $this->createCompanyRole($companyTypeName, static::ROLE_NAME_DISTRIBUTION, false),
            $this->createCompanyRole($companyTypeName, static::ROLE_NAME_CUSTOMER_SERVICE, false),
        ];

        if ($companyTypeName === 'manufacturer') {
            return $predefinedRoles;
        }

        $predefinedRoles = array_merge($predefinedRoles, [
            $this->createCompanyRole($companyTypeName, static::ROLE_NAME_SUPER_ADMINISTRATION, false),
            $this->createCompanyRole($companyTypeName, static::ROLE_NAME_MARKETING, false),
        ]);

        if ($companyTypeName !== 'retailer') {
            return $predefinedRoles;
        }

        $predefinedRoles = array_merge($predefinedRoles, [
            $this->createCompanyRole($companyTypeName, static::ROLE_NAME_PURCHASE, false),
        ]);

        return $predefinedRoles;
    }

    /**
     * @param string $companyType
     *
     * @return string[]
     */
    public function getValidCompanyRolesForExport(string $companyType = ''): array
    {
        $companyRoles = $this->get(CompanyTypeRoleConstants::VALID_COMPANY_ROLES_FOR_EXPORT);

        if ($companyType === '') {
            return $companyRoles;
        }

        return $companyRoles[$companyType];
    }

    /**
     * @param string $companyTypeName
     *
     * @return bool
     */
    protected function isValidCompanyTypeName(string $companyTypeName): bool
    {
        $validCompanyTypeNames = $this->get(CompanyTypeRoleConstants::VALID_COMPANY_TYPE_NAMES);

        return in_array($companyTypeName, $validCompanyTypeNames, true);
    }

    /**
     * @param string $companyTypeName
     * @param string $companyTypeRoleName
     * @param bool|string $isDefault
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected function createCompanyRole(
        string $companyTypeName,
        string $companyTypeRoleName,
        bool $isDefault
    ): CompanyRoleTransfer {
        $permissionKeys = $this->getPermissionKeys($companyTypeName, $companyTypeRoleName);
        $permissionCollection = $this->createPermissionCollectionFromPermissionKeys($permissionKeys);

        return (new CompanyRoleTransfer())
            ->setName($companyTypeRoleName)
            ->setIsDefault($isDefault)
            ->setPermissionCollection($permissionCollection);
    }

    /**
     * @param string $companyTypeName
     * @param string $roleName
     *
     * @return string[]
     */
    protected function getPermissionKeys(string $companyTypeName, string $roleName): array
    {
        $permissionKeys = $this->get(CompanyTypeRoleConstants::PERMISSION_KEYS, []);

        if (!array_key_exists($companyTypeName, $permissionKeys)) {
            return [];
        }

        if (!array_key_exists($roleName, $permissionKeys[$companyTypeName])) {
            return [];
        }

        return $permissionKeys[$companyTypeName][$roleName];
    }

    /**
     * @param string[] $permissionKeys
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    protected function createPermissionCollectionFromPermissionKeys(array $permissionKeys): PermissionCollectionTransfer
    {
        $permissions = new PermissionCollectionTransfer();

        foreach ($permissionKeys as $permissionKey) {
            $permission = (new PermissionTransfer())
                ->setKey($permissionKey);
            $permissions->addPermission($permission);
        }

        return $permissions;
    }
}
