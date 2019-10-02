<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business;

use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssigner;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 */
class CompanyTypeRoleBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface
     */
    public function createCompanyRoleAssigner(): CompanyRoleAssignerInterface
    {
        return new CompanyRoleAssigner(
            $this->getConfig(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->getPermissionFacade()
        );
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyTypeRoleToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyTypeRoleToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyTypeRoleToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_PERMISSION);
    }
}
