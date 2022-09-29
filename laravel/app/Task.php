<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['id', 'user_id', 'goal_id', 'name', 'due_date', 'is_completed', 'order'];

    /**
     * Get user this belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get goal this belongs to.
     */
    public function goal()
    {
        return $this->belongsTo('App\Goal');
    }
}
