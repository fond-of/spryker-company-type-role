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
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyTypeNameFilterMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $permissionIntersectionMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $configMock;

    /**
     * @var \Generated\Shared\Transfer\PermissionCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject>|array<\Generated\Shared\Transfer\PermissionTransfer>
     */
    protected $permissionTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject>|array<\Generated\Shared\Transfer\CompanyRoleTransfer>
     */
    protected $companyRoleTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\PermissionCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
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
            $this->configMock,
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
                [$this->companyRoleTransferMocks[2]],
            )->willReturnOnConsecutiveCalls(
                $companyTypeNames[0],
                $companyTypeNames[1],
                null,
            );

        $this->configMock->expects(static::atLeastOnce())
            ->method('getPermissionKeys')
            ->withConsecutive(
                [$companyTypeNames[0], $companyRoleNames[0]],
                [$companyTypeNames[1], $companyRoleNames[1]],
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
