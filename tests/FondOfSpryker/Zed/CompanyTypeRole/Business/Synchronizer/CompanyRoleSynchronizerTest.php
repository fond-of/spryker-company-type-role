<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;

class CompanyRoleSynchronizerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    protected $companyCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $configMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizer
     */
    protected $synchronizer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyCollectionTransferMock = $this->getMockBuilder(CompanyCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->synchronizer = new CompanyRoleSynchronizer(
            $this->companyFacadeMock,
            $this->companyRoleFacadeMock,
            $this->companyTypeFacadeMock,
            $this->configMock
        );
    }

    /**
     * @return void
     */
    public function testSyncWithNoCompanies(): void
    {
        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn($this->companyCollectionTransferMock);

        $this->companyCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn(new \ArrayObject());

        $this->synchronizer->sync();
    }
}
