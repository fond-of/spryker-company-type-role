<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Reader;

use FondOfSpryker\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGeneratorInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;

class AssignableCompanyRoleReader implements AssignableCompanyRoleReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGeneratorInterface
     */
    protected $assignPermissionKeyGenerator;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyUserReaderInterface
     */
    protected $companyUserReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGeneratorInterface $assignPermissionKeyGenerator
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        AssignPermissionKeyGeneratorInterface $assignPermissionKeyGenerator,
        CompanyUserReaderInterface $companyUserReader,
        CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
    ) {
        $this->assignPermissionKeyGenerator = $assignPermissionKeyGenerator;
        $this->companyUserReader = $companyUserReader;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer $assignableCompanyRoleCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function getByAssignableCompanyRoleCriteriaFilter(
        AssignableCompanyRoleCriteriaFilterTransfer $assignableCompanyRoleCriteriaFilterTransfer
    ): CompanyRoleCollectionTransfer {
        $assignableCompanyRoleCollectionTransfer = new CompanyRoleCollectionTransfer();
        $companyUserCollectionTransfer = $this->companyUserReader->getByAssignableCompanyRoleCriteriaFilter(
            $assignableCompanyRoleCriteriaFilterTransfer,
        );

        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUser) {
            $idCompany = $companyUser->getFkCompany();
            $idCompanyUser = $companyUser->getIdCompanyUser();

            if ($idCompany === null || $idCompanyUser === null) {
                continue;
            }

            $companyRoleCollectionTransfer = $this->companyRoleFacade->getCompanyRoleCollection(
                (new CompanyRoleCriteriaFilterTransfer())->setIdCompany($idCompany),
            );

            foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
                if (!$this->isAssignable($companyRoleTransfer, $idCompanyUser)) {
                    continue;
                }

                $assignableCompanyRoleCollectionTransfer->addRole($companyRoleTransfer);
            }
        }

        return $assignableCompanyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     * @param int $idCompanyUser
     *
     * @return bool
     */
    protected function isAssignable(CompanyRoleTransfer $companyRoleTransfer, int $idCompanyUser): bool
    {
        $permissionKey = $this->assignPermissionKeyGenerator->generateByCompanyRole($companyRoleTransfer);

        return $permissionKey !== null && $this->permissionFacade->can($permissionKey, $idCompanyUser);
    }
}
