<?php

namespace FondOfSpryker\Zed\CompanyTypeRole\Business\Reader;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface;
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
     * @var \FondOfSpryker\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

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

        $this->repositoryMock = $this->getMockBuilder(CompanyTypeRoleRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assignableCompanyRoleCriteriaFilterTransferMock = $this->getMockBuilder(AssignableCompanyRoleCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader(
            $this->companyUserFacadeMock,
            $this->repositoryMock
        );
    }

    /**
     * @return void
     */
    public function testGetByAssignableCompanyRoleCriteriaFilter(): void
    {
        $idCustomer = 1;
        $companyUserIds = [1, 2];

        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findActiveCompanyUserIdsByIdCustomer')
            ->with($idCustomer)
            ->willReturn($companyUserIds);

        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(null);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyUserCollection')
            ->with(
                static::callback(
                    static function (CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer) use ($companyUserIds) {
                        return $companyUserCriteriaFilterTransfer->getCompanyUserIds() === $companyUserIds
                            && $companyUserCriteriaFilterTransfer->getIdCompany() === null
                            && $companyUserCriteriaFilterTransfer->getIsActive() === true;
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
    public function testGetByAssignableCompanyRoleCriteriaFilterWithoutActiveCompanyUserIds(): void
    {
        $idCustomer = 1;
        $companyUserIds = [];

        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findActiveCompanyUserIdsByIdCustomer')
            ->with($idCustomer)
            ->willReturn($companyUserIds);

        $this->assignableCompanyRoleCriteriaFilterTransferMock->expects(static::never())
            ->method('getIdCompany')
            ->willReturn(null);

        $this->companyUserFacadeMock->expects(static::never())
            ->method('getCompanyUserCollection');

        static::assertCount(
            0,
            $this->companyUserReader->getByAssignableCompanyRoleCriteriaFilter(
                $this->assignableCompanyRoleCriteriaFilterTransferMock
            )->getCompanyUsers()
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

        $this->repositoryMock->expects(static::never())
            ->method('findActiveCompanyUserIdsByIdCustomer');

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
