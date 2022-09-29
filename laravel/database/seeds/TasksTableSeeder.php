<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the tasks database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Task::truncate();
        
        $goals = App\Goal::all();
        
        $goals->each(function($goal) {
            $goal->tasks()->saveMany(factory(App\Task::class, 3)->make([
                'user_id' => $goal->user_id
            ]));
        });
        
        
    }
}
