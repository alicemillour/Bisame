<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $table = 'annotations';

    protected $fillable = ['word_id','postag_id','user_id','confidence_score'];

    public function postag()
    {
        return $this->belongsTo('App\Postag');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function word()
    {
        return $this->belongsTo('App\Word');
    }

    /**
     * Get the annotations not seen for a given user
     * 
     * @param App\Models\User $user
     * @return Collection of SentenceUplUser
     */
    public static function getNotSeen($user)
    {
        $query = Annotation::where('user_id',$user->id)->where('points_not_seen','!=',0);

        return $query->get();
    }

    /**
     * Reset the annotations not seen for a given user
     * 
     * @param App\Models\User $user
     * @return boolean
     */
    public static function resetNotSeen($user)
    {
        return Annotation::where('user_id',$user->id)->update(['points_not_seen'=>0]);

    }
}
