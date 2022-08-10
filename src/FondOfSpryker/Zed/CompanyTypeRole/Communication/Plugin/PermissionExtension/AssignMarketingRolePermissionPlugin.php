<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Communication\Plugin\PermissionExtension;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface getFacade()
 */
class AssignMarketingRolePermissionPlugin extends AbstractPlugin implements PermissionPluginInterface
{
    /**
     * @var string
     */
    public const KEY = 'AssignMarketingRolePermission';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
