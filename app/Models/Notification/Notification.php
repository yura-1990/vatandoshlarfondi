<?php

namespace App\Models\Notification;


use Illuminate\Support\Facades\Auth;

class Notification extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['title', 'description', 'link', 'type', 'image', 'user_id'];
    public function save(array $options = [])
    {
        if (!$this->user_id && Auth::user()) {
            $this->user_id = Auth::user()->id;
        }

        parent::save();
    }
}
