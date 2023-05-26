<?php

namespace App\Tests\Organization;

use App\Entity\Organization;
use App\Entity\User;
use App\Organization\CommandProcessor;
use App\Persistence\Repository\UserRepository;
use App\Repository\MediaFileRepository;
use App\Repository\OrganizationRepository;
use App\Request\User\Request;
use App\User\UserProfiler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CommandProcessorTest extends TestCase
{
    public function uuidDataProvider()
    {
        return [
            ['1eddcf12-683d-60c2-a04f-554aa5c08e6b', '2eddcf12-683d-60c2-a04f-554aa5c08e6b'],
            // Добавьте здесь другие наборы UUID, если нужно
        ];
    }

    /**
     * @dataProvider uuidDataProvider
     */
    public function testAddUserToOrganization($uuidOrganization, $uuidUser)
    {
        $uuidOrganization = Uuid::fromString($uuidOrganization);
        $uuidUser = Uuid::fromString($uuidUser);

        $userProfile = $this->createMock(UserProfiler::class);
        $mediaFileRepository = $this->createMock(MediaFileRepository::class);

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getId')
            ->willReturn($uuidUser);


        $user = $this->createMock(User::class);

        $organization = $this->createMock(Organization::class);
        $organization->expects($this->once())
            ->method('addUser')
            ->with($this->equalTo($user));

        $organizationRepository = $this->createMock(OrganizationRepository::class);
        $organizationRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($uuidOrganization))
            ->willReturn($organization);

        $organizationRepository->expects($this->once())
            ->method('save')
            ->with($this->equalTo($organization), $this->equalTo(true));

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('get')
            ->with($this->equalTo($uuidUser))
            ->willReturn($user);

        $commandProcessor = new CommandProcessor(
            $organizationRepository,
            $userProfile,
            $userRepository,
            $mediaFileRepository
        );

        $commandProcessor->addUserToOrganization($uuidOrganization, $request);
    }
}
