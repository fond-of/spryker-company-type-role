<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Reader;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $assignableCompanyRoleCriteriaFilterTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Business\Reader\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyTypeRoleToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assignableCompanyRoleCriteriaFilterTransferMock = $this->getMockBuilder(AssignableCompanyRoleCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader($this->companyUserFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetByAssignableCompanyRoleCriteriaFilter(): void
    {
        $idCustomer = 1;

        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(null);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyUserCollection')
            ->with(
                static::callback(
                    static function (CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer) use ($idCustomer) {
                        return $companyUserCriteriaFilterTransfer->getIdCustomer() === $idCustomer
                            && $companyUserCriteriaFilterTransfer->getIdCompany() === null;
                    }
                )
            )->willReturn($this->companyUserCollectionTransferMock);

        static::assertEquals(
            $this->companyUserCollectionTransferMock,
            $this->companyUserReader->getByAssignableCompanyRoleCriteriaFilter(
                $this->assignableCompanyRoleCriteriaFilterTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testGetByAssignableCompanyRoleCriteriaFilterWithoutIdCustomer(): void
    {
        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(null);

        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::never())
            ->method('getIdCompany');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('getCompanyUserCollection');

        static::assertCount(
            0,
            $this->companyUserReader->getByAssignableCompanyRoleCriteriaFilter(
                $this->assignableCompanyRoleCriteriaFilterTransferMock
            )->getCompanyUsers()
        );
    }
}
