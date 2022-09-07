<?php

namespace Sumra\SDK\Traits\Resolve;

use Illuminate\Support\Facades\DB;

trait IdentityResolveTrait
{
    /**
     * @param $id
     */
    public function getUserDetail($id)
    {
        // Get User detail
        $user = DB::connection('identity')
            ->table('users')
            ->select(['first_name', 'last_name', 'username'])
            ->where('id', $id)
            ->first();

        if ($user) {
            $name = trim($user->first_name . ' ' . $user->last_name);
            $name = $name ?? $user->username;
        } else {
            $name = 'Unknown user';
        }

        return $name;
    }
}
