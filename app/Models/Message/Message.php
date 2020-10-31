<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function schema()
    {
        return $this->hasOne(Message::class, 'schema_id', 'id');
    }
}