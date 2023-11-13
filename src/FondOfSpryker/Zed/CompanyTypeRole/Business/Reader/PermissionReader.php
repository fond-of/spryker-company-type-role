<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Reader;

use FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionSetTransfer;

class PermissionReader implements PermissionReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface
     */
    protected $permissionIntersection;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $config;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface $permissionIntersection
     * @param \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig $config
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        PermissionIntersectionInterface $permissionIntersection,
        CompanyTypeRoleConfig $config,
        CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
    ) {
        $this->permissionIntersection = $permissionIntersection;
        $this->config = $config;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function getPermissions(): PermissionCollectionTransfer
    {
        return $this->permissionFacade->findAll();
    }

    /**
     * @return array<\Generated\Shared\Transfer\PermissionSetTransfer>
     */
    public function getPermissionSets(): array
    {
        $permissionSets = [];
        $allPermissionCollectionTransfer = $this->getPermissions();
        $groupedPermissionKeys = $this->config->getGroupedPermissionKeys();

        foreach (array_keys($groupedPermissionKeys) as $companyTypeName) {
            foreach (array_keys($groupedPermissionKeys[$companyTypeName]) as $companyRoleName) {
                $permissionKeys = $groupedPermissionKeys[$companyTypeName][$companyRoleName];

                $permissionSet = (new PermissionSetTransfer())->setCompanyType($companyTypeName)
                    ->setCompanyRoleName($companyRoleName)
                    ->setEntries(
                        $this->permissionIntersection->intersect(
                            $allPermissionCollectionTransfer,
                            $permissionKeys,
                        ),
                    );

                $permissionSets[] = $permissionSet;
            }
        }

        return $permissionSets;
    }
}
