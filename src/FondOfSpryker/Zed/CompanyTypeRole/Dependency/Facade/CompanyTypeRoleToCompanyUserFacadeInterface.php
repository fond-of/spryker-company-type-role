<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyTypeRoleToCompanyUserFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserById(CompanyUserTransfer $companyUserTransfer): ?CompanyUserTransfer;
}
