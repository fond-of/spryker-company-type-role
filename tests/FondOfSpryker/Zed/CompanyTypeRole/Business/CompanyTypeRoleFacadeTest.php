<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;

class CompanyTypeRoleFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacade
     */
    protected $companyTypeRoleFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleBusinessFactory
     */
    protected $companyTypeRoleBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface
     */
    protected $companyRoleAssignerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeRoleBusinessFactoryMock = $this->getMockBuilder(CompanyTypeRoleBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleAssignerMock = $this->getMockBuilder(CompanyRoleAssignerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleFacade = new CompanyTypeRoleFacade();

        $this->companyTypeRoleFacade->setFactory($this->companyTypeRoleBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testAssignPredefinedCompanyRolesToNewCompany(): void
    {
        $this->companyTypeRoleBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyRoleAssigner')
            ->willReturn($this->companyRoleAssignerMock);

        $this->companyRoleAssignerMock->expects($this->atLeastOnce())
            ->method('assignPredefinedCompanyRolesToNewCompany')
            ->with($this->companyResponseTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $companyResponseTransfer = $this->companyTypeRoleFacade
            ->assignPredefinedCompanyRolesToNewCompany($this->companyResponseTransferMock);

        $this->assertEquals($companyResponseTransfer, $this->companyResponseTransferMock);
    }
}
