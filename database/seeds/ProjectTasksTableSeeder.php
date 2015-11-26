<?php

use Illuminate\Database\Seeder;

class ProjectTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\CodeProject\Entities\Project::truncate();
        factory(\CodeProject\Entities\ProjectTasks::class,50)->create();
    }
}
