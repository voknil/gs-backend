<?php

namespace App\Helpers;

use App\Entity\User;
use http\Env\Response;

class UserHelper
{
    /**
     * Convert user object to array
     * @param User $user
     * @return array
     */
    public static function UserToJson(User $user): array
    {
        return[
            'id'=>$user->getId(),
            'name'=>$user->getName(),
            'surname'=>$user->getSurname(),
            'email'=>$user->getEmail(),
            'company'=>$user->getCompany(),
            'location'=>$user->getLocation(),
            'birthday'=>$user->getBirthday(),
            'avatar'=>$user->getAvatar()
        ];
    }
}