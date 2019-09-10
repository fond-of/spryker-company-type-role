<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade;

use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class CompanyTypeRoleToCompanyRoleFacadeBridge implements CompanyTypeRoleToCompanyRoleFacadeInterface
{
    /**
     * @var \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @param \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(CompanyRoleFacadeInterface $companyRoleFacade)
    {
        $this->companyRoleFacade = $companyRoleFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    public function create(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer
    {
        return $this->companyRoleFacade->create($companyRoleTransfer);
    }
}
