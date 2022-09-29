<?php

use Illuminate\Database\Seeder;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the goals database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Goal::truncate();
        
        $users = App\User::all();
        $goal_categories = App\GoalCategory::all();
        
        $users->each(function($user) {
            $user->goals()->saveMany(factory(App\Goal::class, 3)->make());
        });

        $goal_categories->each(function($goal_category) {
            $goal_category->goals()->saveMany(factory(App\Goal::class, 3)->make([
                'user_id' => $goal_category->user_id
            ]));
        });

    }
}
