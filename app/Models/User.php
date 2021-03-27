<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class User extends Model
{
    public $timestamps = false;

    private $token_expiry_timer = 10 * 60; // 10 Minutes

    /*
     * Relations
     */
    public function user_sessions() {
        return $this->hasOne(UserSession::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    /*
     * Returns a user model, retrieved by a token. The result includes the token information as well.
     */
    public static function getByToken($token) {
        $user_session = UserSession::where('token', $token)->first();
        $user = $user_session->user;
        return $user;
    }

    public function renewToken() {
        $token = $this->generateToken();
        $user_session = UserSession::where('user_id', $this->id)->first();
        if(!$user_session) {
            $user_session = new UserSession();
            $user_session->user_id = $this->id;
            $user_session->token = $token;
            $user_session->expires_at = $this->renewTokenExpiry();
        } else {
            $user_session->token = $token;
            $user_session->expires_at = $this->renewTokenExpiry();
        }
        $user_session->save();

        return $token;
    }

    private function generateToken() {
        $random_string = 'a!@# jfbg0--l;adc';
        return password_hash($this->email . $random_string . $this->id, PASSWORD_BCRYPT);
    }

    private function renewTokenExpiry() {
        $time = time();
        $time += $this->token_expiry_timer;
        $expiry = date('Y-m-d H:i:s', $time);
        printf($expiry);
        return $expiry;
    }
}
