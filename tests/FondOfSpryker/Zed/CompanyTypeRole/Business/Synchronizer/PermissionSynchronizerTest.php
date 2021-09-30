<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionSynchronizerTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeNameFilterMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionIntersectionMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \Generated\Shared\Transfer\PermissionCollectionTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\PermissionTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $permissionTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $companyRoleTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\PermissionCollectionTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $intersectedPermissionCollectionTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizer
     */
    protected $permissionSynchronizer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeNameFilterMock = $this->getMockBuilder(CompanyTypeNameFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionIntersectionMock = $this->getMockBuilder(PermissionIntersectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyTypeRoleToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMocks = [
            $this->getMockBuilder(PermissionTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMocks = [
            $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(CompanyRoleTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->intersectedPermissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionSynchronizer = new PermissionSynchronizer(
            $this->companyTypeNameFilterMock,
            $this->permissionIntersectionMock,
            $this->companyRoleFacadeMock,
            $this->permissionFacadeMock,
            $this->configMock
        );
    }

    /**
     * @return void
     */
    public function testSync(): void
    {
        $companyTypeNames = ['TypeA', 'TypeB'];
        $companyRoleNames = ['RoleA', 'RoleB'];
        $permissionKeys = ['PermissionA'];

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('findAll')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getPermissions')
            ->willReturn(new ArrayObject($this->permissionTransferMocks));

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getRoles')
            ->willReturn(new ArrayObject($this->companyRoleTransferMocks));

        $this->companyRoleTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyRoleNames[0]);

        $this->companyRoleTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($companyRoleNames[1]);

        $this->companyRoleTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(null);

        $this->companyTypeNameFilterMock->expects(static::atLeastOnce())
            ->method('filterFromCompanyRole')
            ->withConsecutive(
                [$this->companyRoleTransferMocks[0]],
                [$this->companyRoleTransferMocks[1]],
                [$this->companyRoleTransferMocks[2]]
            )->willReturnOnConsecutiveCalls(
                $companyTypeNames[0],
                $companyTypeNames[1],
                null
            );

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPermissionKeys')
            ->withConsecutive(
                [$companyTypeNames[0], $companyRoleNames[0]],
                [$companyTypeNames[1], $companyRoleNames[1]]
            )->willReturnOnConsecutiveCalls([], $permissionKeys);

        $this->permissionIntersectionMock->expects(static::atLeastOnce())
            ->method('intersect')
            ->with($this->permissionCollectionTransferMock, $permissionKeys)
            ->willReturn($this->intersectedPermissionCollectionTransferMock);

        $this->companyRoleTransferMocks[0]->expects(static::never())
            ->method('setPermissionCollection');

        $this->companyRoleTransferMocks[1]->expects(static::atLeastOnce())
            ->method('setPermissionCollection')
            ->with($this->intersectedPermissionCollectionTransferMock)
            ->willReturn($this->companyRoleTransferMocks);

        $this->companyRoleTransferMocks[2]->expects(static::never())
            ->method('setPermissionCollection');

        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->companyRoleTransferMocks[1]);

        $this->permissionSynchronizer->sync();
    }
}
