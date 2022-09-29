<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use App\Traits\HasGravatar;

class User extends Authenticatable
{
    use Notifiable, Billable, HasGravatar;

    /**
     * Use the accounts database for this model
     */
    protected $connection = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'product_three_trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Determine if the Stripe model is on a "generic" trial at the model level.
     *
     * @return bool
     */
    public function onGenericTrial()
    {
        return $this->product_three_trial_ends_at && $this->product_three_trial_ends_at->isFuture();
    }
    
    /**
     * Determine if the Stripe model's trial has been set'.
     *
     * @return bool
     */
    public function trialSet()
    {
        return $this->product_three_trial_ends_at;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'product_three_trial_ends_at',
    ];

    /**
     * The human readable days left of trial.
     *
     * @return string
     */
    public function trialTimeLeft()
    {
        $daysLeft = $this->product_three_trial_ends_at->diffInDays();
        
        if ($daysLeft == 0) return 'ends today';
        elseif ($daysLeft == 1) return 'ends in ' . $daysLeft . ' day';
        else return 'ends in ' . $daysLeft . ' days';
    }

    /**
     * Get the goal categories for the user.
     */
    public function goal_categories()
    {
        return $this->hasMany('App\GoalCategory');
    }
    
    /**
     * Get the goals for the user.
     */
    public function goals()
    {
        return $this->hasMany('App\Goal');
    }
    
    /**
     * Get the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
