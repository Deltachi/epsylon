<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TasksTableSeeder::class,
            UsersTableSeeder::class,
            SubjectsTableSeeder::class,
            ExamsTableSeeder::class,
            ExamUserTableSeeder::class,
            ExamTaskTableSeeder::class,
            SubjectUserTableSeeder::class,
        ]);
    }
}
