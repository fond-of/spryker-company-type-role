<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Communication\Plugin\PermissionExtension;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface getFacade()
 */
class AssignCustomerServiceRolePermissionPlugin extends AbstractPlugin implements PermissionPluginInterface
{
    /**
     * @var string
     */
    public const KEY = 'AssignCustomerServiceRolePermission';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
