<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyTypeRoleToPermissionFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeBridge
     */
    protected $companyTypeRoleToPermissionFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleToPermissionFacadeBridge = new CompanyTypeRoleToPermissionFacadeBridge(
            $this->permissionFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->permissionFacadeMock->expects($this->atLeastOnce())
            ->method('findMergedRegisteredNonInfrastructuralPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $permissionCollectionTransfer = $this->companyTypeRoleToPermissionFacadeBridge
            ->findMergedRegisteredNonInfrastructuralPermissions();

        $this->assertEquals($this->permissionCollectionTransferMock, $permissionCollectionTransfer);
    }
}
