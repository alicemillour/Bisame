<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

use App\Like;
use DB;

class User  extends Authenticatable

{

    use Notifiable;
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'level', 'score', 'posX', 'posY', 'age_group_id', 'avatar_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function posts() 
    {
    return $this->hasMany('App\Post');
    }


    public static $rules = array(
        'name' => 'required',
        'email' => 'unique:users',
        'password' => 'required'
    );

    public function recipes()
    {
        return $this->hasMany('App\Recipe');
    }

    public function anecdotes()
    {
        return $this->hasMany('App\Anecdote');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }


    /**
    * Check if the user has a role
    *
    * @param string $role
    * @return boolean
    */
    public function hasRole($role): bool
    {
        return $this->roles->where('name', $role)->isNotEmpty();
    }

    /**
    * Check if the user has role admin
    *
    * @return boolean
    */
    public function isAdmin(): bool
    {
        return $this->is_admin==1;
        // return $this->hasRole(Role::ROLE_ADMIN);
    }

    /**
    * Return the user's roles
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
    
    public function badges()
    {
        return $this->belongsToMany('App\Badge');
    }
    
    public function notifications()
    {
        return $this->belongsToMany('App\Notification');
    }

    public function isSuscribedTo($notification_id)
    {
        return $this->notifications->where('id', $notification_id)->isNotEmpty();
    }

    public function tutorials()
    {
        return $this->belongsToMany('App\Postag', 'tutorials', 'user_id', 'postag_id');
    }

    public function hasDoneTutorial($postag_id)
    {
        return $this->tutorials->where('id', $postag_id)->isNotEmpty();
    }

    /**
     * Many to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\belongToMany
     */
    public function discussions()
    {
        return $this->belongsToMany('App\Discussion');
    }

    public function age_group()
    {
        return $this->belongsTo('App\AgeGroup');
    }

    public function avatar()
    {
        return $this->belongsTo('App\Avatar');
    }

    /**
     * Encrypt the user's password.
     *
     * @param string $passwword
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    
    public function likesEntity($entity): bool
    {
        return $this->likes()->where('likeable_id',$entity->id)->where('likeable_type',get_class($entity))->exists();
    }


    public function checkBadge($type_badge, $required_value){
        $user_id = $this->id;
        if(is_numeric($required_value)){
            if($badge = Badge::where('key','=',$type_badge)
                ->where('required_value','<=',$required_value)->whereNotExists(
                    function($query) use($user_id) {
                        $query->select(DB::raw(1))
                          ->from('badge_user')
                          ->whereRaw('badges.id = badge_user.badge_id')
                          ->where('badge_user.user_id','=',$user_id);
                    })
                ->first()){

                $this->badges()->save($badge);
                return $badge;
            }
        } else {
            if($badge = Badge::where('key','=',$type_badge)
                ->where('required_value_string','=',$required_value)->whereNotExists(
                    function($query) use($user_id) {
                        $query->select(DB::raw(1))
                          ->from('badge_user')
                          ->whereRaw('badges.id = badge_user.badge_id')
                          ->where('badge_user.user_id','=',$user_id);
                    })
                ->first()){

                $this->badges()->save($badge);
                return $badge;
            }
        }
        return null;

    }
    


    
}
