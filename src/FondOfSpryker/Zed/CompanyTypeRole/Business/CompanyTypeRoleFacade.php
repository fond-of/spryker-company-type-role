<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleBusinessFactory getFactory()
 */
class CompanyTypeRoleFacade extends AbstractFacade implements CompanyTypeRoleFacadeInterface
{
    /**
     * {@inheritdoc}
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
}
