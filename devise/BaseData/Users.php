<?php
namespace Xel\Devise\BaseData;
class Users
{
    public static string $table = 'users';
    public static array $column = [
        'id',
        'name',
        'email'
    ];
}