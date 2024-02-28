<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'email'    => 'superadmin@gmail.com',
                // admin@123
                'password' => '$2y$10$1fawgxXbf4T7FUCZcJ8iC.hCzLVEV/XbRtWYUmcsqYZ0bGm8otD2y',
                'created_at' => '2024-02-27 05:05:05',
                'updated_at' => '2024-02-27 05:05:05',
            ],
            [
                'email'    => 'user@gmail.com',
                // user@123
                'password' => '$2y$10$0U6Pik.jP5xKfKUbnIGtL.je0LE0yyAqfA5CefxvfhXcXKmlgmfme',
                'created_at' => '2024-02-27 05:05:02',
                'updated_at' => '2024-02-27 05:05:05',
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
