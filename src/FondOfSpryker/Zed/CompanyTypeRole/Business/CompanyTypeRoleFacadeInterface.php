<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;

interface CompanyTypeRoleFacadeInterface
{
    /**
     * Specification
     * - Create company roles by company type and config
     * - Assign created company roles to new company
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignPredefinedCompanyRolesToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer;

    /**
     * Specification
     * - Check if the Type of Data based on the Company Type Role can be exported
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer $transfer
     *
     * @return bool
     */
    public function validateCompanyTypeRoleForExport(EventEntityTransfer $transfer): bool;

    /**
     * Specification
     * - Retrieve the permission keys for a company type and company role
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return array
     */
    public function getPermissionKeysByCompanyTypeAndCompanyRole(
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): array;
}
