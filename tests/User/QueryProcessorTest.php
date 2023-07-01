<?php

namespace App\Tests\User;

use App\Entity\User;
use App\Exception\UserNotFound;
use App\Persistence\Repository\UserRepository;
use App\Request\User\Request;
use App\Response\User\UserForSelect;
use App\User\QueryProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class QueryProcessorTest extends TestCase
{

    public function testSearch()
    {
        $user = $this->createMock(User::class);

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('getByEmail')
            ->with('test@example.com')
            ->willReturn($user);

        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('getEmail')
            ->willReturn('test@example.com');

        $processor = new QueryProcessor($userRepository);

        $expected = new UserForSelect($user);

        $this->assertEquals($expected, $processor->search($request));
    }

    public function testSearchUserNotFound()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('getByEmail')
            ->with('nonexistent@example.com')
            ->willReturn(null);

        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('getEmail')
            ->willReturn('nonexistent@example.com');

        $processor = new QueryProcessor($userRepository);

        $this->expectException(UserNotFound::class);

        $processor->search($request);
    }
}
