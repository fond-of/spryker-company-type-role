<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade;

interface CompanyTypeRoleToPropelFacadeInterface
{
    /**
     * @return string
     */
    public function getCurrentDatabaseEngine(): string;
}
