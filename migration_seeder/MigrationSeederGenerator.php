<?php

namespace Xel\MigrationSeeder;

use PDO;

readonly class MigrationSeederGenerator
{
    use SeederUtility;
    public function __construct(private  PDO $queryDML)
    {}

    public function breed(): void
    {
        $this->seedAuthUser();
    }

    /*****************************************************************************************
     * Register table seeder on this
     *****************************************************************************************/
    public function seedAuthUser(): void
    {
        // Data for the 'books' table
        $booksData = [
            ['name' => "xel", 'email' => 'xel@gmail.com', 'password' => password_hash('Todokana1ko!', PASSWORD_BCRYPT)],
            ['name' => "rudi", 'email' => 'rudi@gmail.com', 'password' => password_hash('Todokana1ko!', PASSWORD_BCRYPT)],
            ['name' => "yogi", 'email' => 'yogi@gmail.com', 'password' => password_hash('Todokana1ko!', PASSWORD_BCRYPT)],        ];

        // Data for the 'authors' table
        $authorsData = [
            ['name' => 'admin'],
            ['name' => 'operator'],
            ['name' => 'users']
        ];

        // Relationships between books and authors
//        $relations = [
//            ["user_id" =>1,"role_id" => 1],  // The Great Gatsby by F. Scott Fitzgerald
//            ["user_id" =>2,"role_id" => 2],  // 1984 by George Orwell
//            ["user_id" =>3,"role_id" => 3]   // To Kill a Mockingbird by Harper Lee
//        ];

        $relations = [
            [1,1],  // The Great Gatsby by F. Scott Fitzgerald
            [2,2],  // 1984 by George Orwell
            [3,3]   // To Kill a Mockingbird by Harper Lee
        ];


        // Seed the many-to-many relationship
        $this->seedManyToMany('users', 'roles', 'a_users_roles', $booksData, $authorsData, $relations);
    }

}