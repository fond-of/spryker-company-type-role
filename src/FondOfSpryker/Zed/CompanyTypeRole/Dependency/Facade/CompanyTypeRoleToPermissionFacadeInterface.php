<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade;

use Generated\Shared\Transfer\PermissionCollectionTransfer;

interface CompanyTypeRoleToPermissionFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function findMergedRegisteredNonInfrastructuralPermissions(): PermissionCollectionTransfer;

    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function findAll(): PermissionCollectionTransfer;
}
