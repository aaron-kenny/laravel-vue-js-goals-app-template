<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['id', 'user_id', 'goal_category_id', 'name', 'due_date', 'is_completed', 'order'];
    
    /**
     * Get the tasks for this goal.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
    
    /**
     * Get user this belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get category this belongs to.
     */
    public function goal_category()
    {
        return $this->belongsTo('App\GoalCategory');
    }
}
