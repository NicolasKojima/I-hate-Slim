
<?php

use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    protected $fillable = ['title', 'content', 'due_date'];
}


