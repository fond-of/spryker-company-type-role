<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Orm\Zed\CompanyRole\Persistence\Base\SpyCompanyRole;

interface CompanyRoleMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\Base\SpyCompanyRole $spyCompanyRole
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function fromSpyCompanyRole(SpyCompanyRole $spyCompanyRole): CompanyRoleTransfer;
}
