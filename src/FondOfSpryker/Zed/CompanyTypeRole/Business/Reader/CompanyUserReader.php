<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Reader;

use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade
     */
    public function __construct(CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade)
    {
        $this->companyUserFacade = $companyUserFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer $assignableCompanyRoleCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function getByAssignableCompanyRoleCriteriaFilter(
        AssignableCompanyRoleCriteriaFilterTransfer $assignableCompanyRoleCriteriaFilterTransfer
    ): CompanyUserCollectionTransfer {
        $idCustomer = $assignableCompanyRoleCriteriaFilterTransfer->getIdCustomer();

        if ($idCustomer === null) {
            return new CompanyUserCollectionTransfer();
        }

        $companyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
            ->setIdCompany($assignableCompanyRoleCriteriaFilterTransfer->getIdCompany())
            ->setIdCustomer($idCustomer);

        return $this->companyUserFacade->getCompanyUserCollection($companyUserCriteriaFilterTransfer);
    }
}
