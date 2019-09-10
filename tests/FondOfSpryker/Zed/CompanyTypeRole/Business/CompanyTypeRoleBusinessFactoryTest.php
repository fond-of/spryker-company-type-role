<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssigner;
use FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Spryker\Zed\Kernel\Container;

class CompanyTypeRoleBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface
     */
    protected $companyRoleAssignerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $configMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\CompanyTypeRoleBusinessFactory
     */
    protected $companyTypeRoleBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleAssignerMock = $this->getMockBuilder(CompanyRoleAssignerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyTypeRoleToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleBusinessFactory = new CompanyTypeRoleBusinessFactory();

        $this->companyTypeRoleBusinessFactory->setContainer($this->containerMock);
        $this->companyTypeRoleBusinessFactory->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyRoleAssigner(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION]
            )->willReturnOnConsecutiveCalls(true, true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyTypeRoleDependencyProvider::FACADE_PERMISSION]
            )->willReturnOnConsecutiveCalls($this->companyRoleFacadeMock, $this->permissionFacadeMock);

        $companyRoleAssigner = $this->companyTypeRoleBusinessFactory->createCompanyRoleAssigner();

        $this->assertInstanceOf(CompanyRoleAssigner::class, $companyRoleAssigner);
    }
}
