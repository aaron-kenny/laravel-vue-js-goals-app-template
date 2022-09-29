<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoalCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goal_categories';

    protected $fillable = ['id', 'user_id', 'name', 'description', 'order'];
    
    /**
     * Get user this belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get goals for this category.
     */
    public function goals()
    {
        return $this->hasMany('App\Goal');
    }
}
