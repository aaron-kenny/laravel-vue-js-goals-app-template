<?php

namespace App\Http\Controllers;

use App\GoalCategory;
use App\Goal;
use App\Task;
use Illuminate\Http\Request;

class GoalsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Return the user's goals
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function getGoals(GoalCategory $goal_category, Goal $goal, Task $task)
    {
        // if (rand(1, 10) < 3) {
        //     abort(500, 'We could not retrieve the goals');
        // }

        // $goals_without_categories = $goal->where('user_id', '=', auth()->id())
        // ->whereNull('goal_category_id')
        // ->select('id', 'goal_category_id', 'name', 'due_date', 'is_completed', 'order')
        // ->orderBy('order', 'asc')
        // ->with([
        //     'tasks' => function($query) {
        //         $query->select('id', 'goal_id', 'name', 'due_date', 'is_completed', 'order')->orderBy('order', 'asc');
        //     }
        // ])
        // ->get();
        
        // $goals_with_categories = $goal_category->where('user_id', '=', auth()->id())
        // ->select('id', 'name', 'description', 'order')
        // ->orderBy('order', 'asc')
        // ->with([
        //     'goals' => function($query) {
        //         $query->select('id', 'goal_category_id', 'name', 'due_date', 'is_completed', 'order')->orderBy('order', 'asc');
        //     },
        //     'goals.tasks' => function($query) {
        //         $query->select('id', 'goal_id', 'name', 'due_date', 'is_completed', 'order')->orderBy('order', 'asc');
        //     },
        // ])
        // ->get();

        // $goals = [
        //     'goals' => $goals_without_categories,
        //     'goal_categories' => $goals_with_categories,
        // ];

        // return $goals;


        $goal_categories = $goal_category->where('user_id', '=', auth()->id())->get();
        $goals = $goal->where('user_id', '=', auth()->id())->get();
        $tasks = $task->where('user_id', '=', auth()->id())->get();

        $data = [
            'goal_categories' => $goal_categories,
            'goals' => $goals,
            'tasks' => $tasks
        ];

        return $data;
    }
}
