<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //declare the table associated with this particular model
    protected $table = 'tasks';

    //declare the mass assgignable fields
    protected $fillable = ['title','description','status'];
    //a relationship between the user and the task
    public function user()
    {
       return  $this->belongsTo(App\User::class,'id');
    }
}

