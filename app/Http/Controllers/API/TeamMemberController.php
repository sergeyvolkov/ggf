<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Team\AssignTeamMember;
use App\Models\Member;
use App\Models\TeamMember;
use App\Transformers\TeamMemberSearchTransformer;
use App\Transformers\TeamMemberTransformer;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class TeamMemberController extends Controller
{
    public function catalogue()
    {
        $collection = TeamMember::with('Member')->where(['tournamentTeamId' => Input::get('teamId')]);

        return $this->response->collection($collection->get(), new TeamMemberTransformer(), 'teamMembers');
    }

    public function assign(AssignTeamMember $request)
    {
        $input = $request->get('teamMember');

        $attributes = [
            'memberId' => array_get($input, 'memberId'),
            'tournamentTeamId' => array_get($input, 'teamId'),
        ];

        TeamMember::create($attributes);

        return $this->response->collection(TeamMember::where($attributes)->get(), new TeamMemberTransformer(), 'teamMembers');
    }

    public function remove($teamMemberId)
    {
        return TeamMember::where(['id' => $teamMemberId])->delete();
    }

    public function search()
    {
        Event::listen('illuminate.query', function($query) {
            (new Dumper())->dump($query);
        });

        $tournamentId = Input::get('tournamentId');

        $collection = Member::with(['teamMembers', 'tournamentTeams'])->get();

        dd($collection->last());
//
//        $collection = $collection->filter(function($member) use ($tournamentId) {
//            $team = $member->tournamentTeams->first(function($key, $tournamentTeam) use ($tournamentId) {
//                return $tournamentTeam->tournamentId == $tournamentId;
//            });
//
//            return is_null($team);
//        });

        return $this->response->collection(
            $collection,
            new TeamMemberSearchTransformer(),
            'members'
        );
    }
}
