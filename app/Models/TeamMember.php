<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model {

	protected $table = 'team_members';
	public $timestamps = false;

	public function member()
	{
		return $this->belongsTo('Member', 'memberId');
	}

	public function team()
	{
		return $this->belongsTo('Team');
	}

}