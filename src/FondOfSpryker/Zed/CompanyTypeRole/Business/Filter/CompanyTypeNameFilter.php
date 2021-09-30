<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Filter;

use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeNameFilter implements CompanyTypeNameFilterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade)
    {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return string|null
     */
    public function filterFromCompanyRole(CompanyRoleTransfer $companyRoleTransfer): ?string
    {
        $companyTransfer = $companyRoleTransfer->getCompany();

        if ($companyTransfer === null || $companyTransfer->getFkCompanyType() === null) {
            return null;
        }

        $companyTypeTransfer = $this->companyTypeFacade->getCompanyTypeById(
            (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType())
        );

        if ($companyTypeTransfer === null) {
            return null;
        }

        return $companyTypeTransfer->getName();
    }
}
