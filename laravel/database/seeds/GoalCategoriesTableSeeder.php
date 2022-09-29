<?php

use Illuminate\Database\Seeder;

class GoalCategoriesTableSeeder extends Seeder
{
    /**
     * Run the goal categories database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\GoalCategory::truncate();
        
        $users = App\User::all();
        
        $users->each(function($user) {
            $user->goal_categories()->saveMany(factory(App\GoalCategory::class, 3)->make());
        });
    }
}
