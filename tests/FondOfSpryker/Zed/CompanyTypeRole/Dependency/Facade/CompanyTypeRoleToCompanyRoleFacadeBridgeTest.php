<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class CompanyTypeRoleToCompanyRoleFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeBridge
     */
    protected $companyTypeRoleToCompanyRoleFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleToCompanyRoleFacadeBridge = new CompanyTypeRoleToCompanyRoleFacadeBridge(
            $this->companyRoleFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleResponseTransferMock);

        $companyRoleResponseTransfer = $this->companyTypeRoleToCompanyRoleFacadeBridge
            ->create($this->companyRoleTransferMock);

        $this->assertEquals($this->companyRoleResponseTransferMock, $companyRoleResponseTransfer);
    }
}
