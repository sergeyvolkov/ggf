<?php

namespace App\Models;

use App\Models\TeamMember;

use Illuminate\Contracts\Auth\Authenticatable;

class Member extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'facebookId'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @var bool
     */
    public $timestamps = true;



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class, 'memberId');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tournamentTeams()
    {
        return $this->hasManyThrough(
            TournamentTeam::class,
            TeamMember::class,
            'memberId',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tokens()
    {
        return $this->hasMany('MemberToken');
    }
}