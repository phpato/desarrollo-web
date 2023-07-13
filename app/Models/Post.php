<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use  App\Models\User;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        //relacion que trae la info del usuario incluso si fue eliminado ya que el sistema trabaja con softdeletes
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the state that owns the comment.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
