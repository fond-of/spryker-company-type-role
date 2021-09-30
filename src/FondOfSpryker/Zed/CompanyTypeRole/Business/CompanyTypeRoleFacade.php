<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleBusinessFactory getFactory()
 */
class CompanyTypeRoleFacade extends AbstractFacade implements CompanyTypeRoleFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignPredefinedCompanyRolesToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        return $this->getFactory()->createCompanyRoleAssigner()
            ->assignPredefinedCompanyRolesToNewCompany($companyResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer $transfer
     *
     * @return bool
     */
    public function validateCompanyTypeRoleForExport(EventEntityTransfer $transfer): bool
    {
        return $this->getFactory()
            ->createCompanyTypeRoleExportValidator()
            ->validate($transfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return string[]
     */
    public function getPermissionKeysByCompanyTypeAndCompanyRole(
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): array {
        return $this->getFactory()
            ->createPermissionReader()
            ->getCompanyTypeRolePermissionKeys($companyTypeTransfer, $companyRoleTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function syncPermissions(): void
    {
        $this->getFactory()->createPermissionSynchronizer()->sync();
    }
}
