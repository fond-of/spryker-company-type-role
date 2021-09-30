<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer;

use FondOfSpryker\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;

class PermissionSynchronizer implements PermissionSynchronizerInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface
     */
    protected $companyTypeNameFilter;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface
     */
    protected $permissionIntersection;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $config;

    /**
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface $companyTypeNameFilter
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface $permissionIntersection
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
     * @param \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig $config
     */
    public function __construct(
        CompanyTypeNameFilterInterface $companyTypeNameFilter,
        PermissionIntersectionInterface $permissionIntersection,
        CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeRoleToPermissionFacadeInterface $permissionFacade,
        CompanyTypeRoleConfig $config
    ) {
        $this->companyTypeNameFilter = $companyTypeNameFilter;
        $this->permissionIntersection = $permissionIntersection;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->permissionFacade = $permissionFacade;
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function sync(): void
    {
        $permissionCollectionTransfer = $this->permissionFacade->findAll();

        if ($permissionCollectionTransfer->getPermissions()->count() === 0) {
            return;
        }

        $companyRoleCollectionTransfer = $this->companyRoleFacade->getCompanyRoleCollection(
            new CompanyRoleCriteriaFilterTransfer()
        );

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            $companyRoleName = $companyRoleTransfer->getName();
            $companyTypeName = $this->companyTypeNameFilter->filterFromCompanyRole($companyRoleTransfer);

            if ($companyTypeName === null || $companyRoleName === null) {
                continue;
            }

            $permissionKeys = $this->config->getPermissionKeys($companyTypeName, $companyRoleName);

            if (count($permissionKeys) === 0) {
                continue;
            }

            $intersectedPermissionCollectionTransfer = $this->permissionIntersection->intersect(
                $permissionCollectionTransfer,
                $permissionKeys
            );

            $companyRoleTransfer->setPermissionCollection($intersectedPermissionCollectionTransfer);

            $this->companyRoleFacade->update($companyRoleTransfer);
        }
    }
}
