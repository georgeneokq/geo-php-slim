<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    public $timestamps = false;

    /*
     * Relations
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}