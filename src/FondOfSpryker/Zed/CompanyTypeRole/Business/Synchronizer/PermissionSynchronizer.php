<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer;

use FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;

class PermissionSynchronizer implements PermissionSynchronizerInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface
     */
    protected $companyRoleReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface $companyRoleReader
     * @param \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(
        CompanyRoleReaderInterface $companyRoleReader,
        CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
    ) {
        $this->companyRoleReader = $companyRoleReader;
        $this->companyRoleFacade = $companyRoleFacade;
    }

    /**
     * @return void
     */
    public function sync(): void
    {
        $syncableCompanyRoles = $this->companyRoleReader->findSyncableCompanyRoles();

        foreach ($syncableCompanyRoles as $syncableCompanyRole) {
            $syncableCompanyRoleIds = $syncableCompanyRole->getIds();

            if (count($syncableCompanyRoleIds) < 1) {
                continue;
            }

            foreach (array_chunk($syncableCompanyRoleIds, 100) as $chunk) {
                $companyRoleCollectionTransfer = $this->companyRoleReader->findCompanyRolesByCompanyRoleIds($chunk);

                foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
                    $companyRoleTransfer->setPermissionCollection($syncableCompanyRole->getPermissions());

                    $this->companyRoleFacade->update($companyRoleTransfer);
                }
            }
        }
    }
}
