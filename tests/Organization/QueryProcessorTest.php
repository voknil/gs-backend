<?php

namespace App\Tests\Organization;

use App\Entity\Organization;
use App\Exception\OrganizationNotFound;
use App\Organization\QueryProcessor;
use App\Repository\OrganizationRepository;
use App\Response\Organization\OrganizationUserList;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class QueryProcessorTest extends TestCase
{

    public function uuidDataProvider()
    {
        return [
            ['1eddcf12-683d-60c2-a04f-554aa5c08e6b']
        ];
    }

    /**
     * @dataProvider uuidDataProvider
     */
    public function testGetUsers($uuid)
    {
        $uuid = Uuid::fromString($uuid);

        $users = $this->createMock(Collection::class);

        $organization = $this->createMock(Organization::class);
        $organization->expects($this->once())
            ->method('getUsers')
            ->willReturn($users);

        $organizationRepository = $this->createMock(OrganizationRepository::class);
        $organizationRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($uuid))
            ->willReturn($organization);

        $queryProcessor = new QueryProcessor($organizationRepository);

        $result = $queryProcessor->getUsers($uuid);

        $this->assertInstanceOf(OrganizationUserList::class, $result);
    }

    /**
     * @dataProvider uuidDataProvider
     */
    public function testGetUsersWithInvalidOrganization($uuid)
    {
        $uuid = Uuid::fromString($uuid);

        $organizationRepository = $this->createMock(OrganizationRepository::class);
        $organizationRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($uuid))
            ->willReturn(null);

        $queryProcessor = new QueryProcessor($organizationRepository);

        $this->expectException(OrganizationNotFound::class);

        $queryProcessor->getUsers($uuid);
    }
}
