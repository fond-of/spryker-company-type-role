<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Persistence;

use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPropelFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\CompanyMapper;
use FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\CompanyMapperInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\CompanyRoleMapper;
use FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\CompanyRoleMapperInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\PermissionMapper;
use FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\PermissionMapperInterface;
use Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface getRepository()
 */
class CompanyTypeRolePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\CompanyRoleMapperInterface
     */
    public function createCompanyRoleMapper(): CompanyRoleMapperInterface
    {
        return new CompanyRoleMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\CompanyMapperInterface
     */
    public function createCompanyMapper(): CompanyMapperInterface
    {
        return new CompanyMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper\PermissionMapperInterface
     */
    public function createPermissionMapper(): PermissionMapperInterface
    {
        return new PermissionMapper();
    }

    /**
     * @return \Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPropelFacadeInterface
     */
    public function getPropelFacade(): CompanyTypeRoleToPropelFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_PROPEL);
    }
}
