<?php

namespace App\Transformers;

use App\Models\Member;
use App\Models\TeamMember;
use Illuminate\Support\Debug\Dumper;
use League\Fractal\TransformerAbstract;

class TeamMemberSearchTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    public function transform(Member $member)
    {
        return [
            'id' => $member->id,
            'text' => $member->name,
            'name' => $member->name,
            'logoPath' => null
        ];
    }
}