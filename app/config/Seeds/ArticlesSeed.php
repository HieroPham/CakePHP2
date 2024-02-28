<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Articles seed.
 */
class ArticlesSeed extends AbstractSeed
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
        $data = [  [
            'title'    => 'admin article 1',
            'body' => 'This is Admin article 1',
            'user_id'     => 1,
            'created_at' => '2024-02-27 05:05:05',
            'updated_at' => '2024-02-27 05:05:05',
        ],
        [
            'title'    => 'admin article 2',
            'body' => 'This is Admin article 2',
            'user_id'     => 1,
            'created_at' => '2024-02-27 05:05:05',
            'updated_at' => '2024-02-27 05:05:05',
        ],
        [
            'title'    => 'user article 1',
            'body' => 'This is User article 1',
            'user_id'     => 2,
            'created_at' => '2024-02-27 05:05:05',
            'updated_at' => '2024-02-27 05:05:05',
        ],
        [
            'title'    => 'user article 2',
            'body' => 'This is User article 2',
            'user_id'     => 2,
            'created_at' => '2024-02-27 05:05:05',
            'updated_at' => '2024-02-27 05:05:05',
        ]];

        $table = $this->table('articles');
        $table->insert($data)->save();
    }
}
