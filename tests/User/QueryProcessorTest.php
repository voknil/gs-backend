<?php

namespace App\Tests\User;

use App\Entity\User;
use App\Exception\UserNotFound;
use App\Persistence\Repository\UserRepository;
use App\Request\User\Request;
use App\Response\User\UserForSelect;
use App\User\QueryProcessor;
use DG\BypassFinals;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class QueryProcessorTest extends TestCase
{

    public function testSearch()
    {
        BypassFinals::enable();

        $user = $this->createUser('1ed7a121-ad2c-6e28-9d78-7517eeb5c166', 'testname', 'testlastname', 'test@example.com');

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('getByEmail')
            ->with('test@example.com')
            ->willReturn($user);

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->once())
            ->method('getEmail')
            ->willReturn('test@example.com');

        $processor = new QueryProcessor($userRepository);

        $expected = new UserForSelect($user);

        $this->assertEquals($expected, $processor->search($request));

    }

    public function testSearchUserNotFound()
    {
        BypassFinals::enable();

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('getByEmail')
            ->with('nonexistent@example.com')
            ->willReturn(null);

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->expects($this->once())
            ->method('getEmail')
            ->willReturn('nonexistent@example.com');

        $processor = new QueryProcessor($userRepository);

        $this->expectException(UserNotFound::class);

        $processor->search($request);

    }


    private function createUser(string $id, string $firstName, string $lastName, string $email): User
    {
        return new User(
            Uuid::fromString($id),
            $firstName,
            $lastName,
            $email
        );
    }



}
