<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business;

use FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator\CompanyTypeRoleExportValidator;
use FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator\CompanyTypeRoleExportValidatorInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGenerator;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGeneratorInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersection;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapper;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssigner;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\PermissionReader;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\PermissionReaderInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReader;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReaderInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReader;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyUserReader;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\PermissionReader as NewPermissionReader;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\PermissionReaderInterface as NewPermissionReaderInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizer;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizerInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizer;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizerInterface;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface getRepository()
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
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Model\PermissionReaderInterface
     */
    public function createPermissionReader(): PermissionReaderInterface
    {
        return new PermissionReader($this->getConfig());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator\CompanyTypeRoleExportValidatorInterface
     */
    public function createCompanyTypeRoleExportValidator(): CompanyTypeRoleExportValidatorInterface
    {
        return new CompanyTypeRoleExportValidator(
            $this->getCompanyUserFacade(),
            $this->getCompanyTypeFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizerInterface
     */
    public function createPermissionSynchronizer(): PermissionSynchronizerInterface
    {
        return new PermissionSynchronizer(
            $this->createCompanyRoleReader(),
            $this->getCompanyRoleFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface
     */
    protected function createCompanyRoleReader(): CompanyRoleReaderInterface
    {
        return new CompanyRoleReader(
            $this->createNewPermissionReader(),
            $this->createPermissionKeyMapper(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\PermissionReaderInterface
     */
    protected function createNewPermissionReader(): NewPermissionReaderInterface
    {
        return new NewPermissionReader(
            $this->createPermissionIntersection(),
            $this->getConfig(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface
     */
    protected function createPermissionKeyMapper(): PermissionKeyMapperInterface
    {
        return new PermissionKeyMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizerInterface
     */
    public function createCompanyRoleSynchronizer(): CompanyRoleSynchronizerInterface
    {
        return new CompanyRoleSynchronizer(
            $this->getCompanyFacade(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReaderInterface
     */
    public function createAssignableCompanyRoleReader(): AssignableCompanyRoleReaderInterface
    {
        return new AssignableCompanyRoleReader(
            $this->createAssignPermissionKeyGenerator(),
            $this->createCompanyUserReader(),
            $this->getCompanyRoleFacade(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGeneratorInterface
     */
    protected function createAssignPermissionKeyGenerator(): AssignPermissionKeyGeneratorInterface
    {
        return new AssignPermissionKeyGenerator();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyUserReaderInterface
     */
    protected function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getCompanyUserFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface
     */
    protected function createPermissionIntersection(): PermissionIntersectionInterface
    {
        return new PermissionIntersection();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyTypeRoleToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyTypeRoleToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyTypeRoleToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyTypeRoleToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyTypeRoleToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_PERMISSION);
    }
}
