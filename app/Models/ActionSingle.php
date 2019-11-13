<?php

namespace App\Models;

class ActionSingle extends BaseAction
{
    protected $table = 'calendar_action_single';
    protected $guarded = [];

    /**
     * Get the announcement that owns the action.
     */
    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    /**
     * Get the user that owns the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer that owns the action.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}