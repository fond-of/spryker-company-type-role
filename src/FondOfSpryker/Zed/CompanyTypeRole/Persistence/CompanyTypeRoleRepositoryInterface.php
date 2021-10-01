<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Persistence;

interface CompanyTypeRoleRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return int[]
     */
    public function findActiveCompanyUserIdsByIdCustomer(int $idCustomer): array;
}
