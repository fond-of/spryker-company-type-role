<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CompanyTypeRoleToCompanyUserFacadeBridge implements CompanyTypeRoleToCompanyUserFacadeInterface
{
    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @param \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface $companyUserFacade
     */
    public function __construct(CompanyUserFacadeInterface $companyUserFacade)
    {
        $this->companyUserFacade = $companyUserFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer|null
     */
    public function findCompanyUserById(CompanyUserTransfer $companyUserTransfer): ?CompanyUserTransfer
    {
        return $this->companyUserFacade->findCompanyUserById($companyUserTransfer->getIdCompanyUser());
    }
}
