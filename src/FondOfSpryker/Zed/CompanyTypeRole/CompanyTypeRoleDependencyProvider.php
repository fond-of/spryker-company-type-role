<?php

namespace FondOfSpryker\Zed\CompanyTypeRole;

use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeBridge;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeBridge;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeBridge;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyTypeRoleDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';
    public const FACADE_COMPANY_TYPE = 'FACADE_COMPANY_TYPE';
    public const FACADE_PERMISSION = 'FACADE_PERMISSION';
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addCompanyRoleFacade($container);
        $container = $this->addCompanyTypeFacade($container);
        $container = $this->addPermissionFacade($container);
        $container = $this->addCompanyUserFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_ROLE] = function (Container $container) {
            return new CompanyTypeRoleToCompanyRoleFacadeBridge(
                $container->getLocator()->companyRole()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPermissionFacade(Container $container): Container
    {
        $container[static::FACADE_PERMISSION] = function (Container $container) {
            return new CompanyTypeRoleToPermissionFacadeBridge(
                $container->getLocator()->permission()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyTypeFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_TYPE] = function (Container $container) {
            return new CompanyTypeRoleToCompanyTypeFacadeBridge(
                $container->getLocator()->companyType()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER] = function (Container $container) {
            return new CompanyTypeRoleToCompanyUserFacadeBridge(
                $container->getLocator()->companyUser()->facade()
            );
        };

        return $container;
    }
}
