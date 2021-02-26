<?php

namespace App\Service;

class UserService
{
    public static function validate($repository, array $data): int
    {
        if(0 != $usernameLastError = self::isString('username',$data,21031)) return $usernameLastError;
        if(0 != $usernameLastError = self::isUnique($repository,'username',$data,21011)) return $usernameLastError;
        if(0 != $emailLastError = self::isUnique($repository,'email',$data,21012)) return $emailLastError;
        if(0 != $passwordLastError = PasswordService::validate($data['password'])) return $passwordLastError;
        if(0 != $emailLastError = self::isEmail('email',$data,21022)) return $emailLastError;
        if(0 != $firstnameLastError = self::isString('firstname',$data,21034)) return $firstnameLastError;
        if(0 != $lastnameLastError = self::isString('lastname',$data,21035)) return $lastnameLastError;

        return 0;
    }

    private static function isUnique($repository, $needle, $array, $errorCode = 2101): int
    {
        return ($repository->findOneBy([$needle => $array[$needle]])) ? $errorCode : 0;
    }

    private static function isEmail($needle, $array, $errorCode = 2102): int
    {
        return (!filter_var($array[$needle], FILTER_VALIDATE_EMAIL)) ? $errorCode : 0;
    }

    private static function isString($needle, $array, $errorCode = 2103): int
    {
        return (!is_string($array[$needle])) ? $errorCode : 0;
    }

}
