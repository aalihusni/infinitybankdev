<?php

namespace App\Http\Controllers;

use App\User;
use App\Passport;
use Auth;
use DB;

class LeaderController extends Controller
{
    public function passport_leader($end_date = "")
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $leader_at = $user->leader_at;
        if ($leader_at <> "0000-00-00 00:00:00")
        {
            $leader_date = $leader_at;
        } else {
            $leader_date = "3000-01-01 00:00:00";
        }
        if (!empty($end_date))
        {
            $end_date = $end_date." 23:59:59";
        }

        $sql = Passport::select(DB::raw('sum(passport.debit) as total_passport'))
            ->leftjoin('users', function($join) use ($user_id) {
                $join->on('passport.user_id', '=', 'users.id');
                $join->on('users.hierarchy', 'like', DB::raw("'%#".$user_id."#%'"));
            })
            ->where('description', 'like', '%purchased%')
            ->where('debit', '>', '0')
            ->where('users.id', '<>', $user_id);
        if (!empty($end_date))
        {
            $sql->where(DB::raw('passport.created_at'), '>', $leader_date);
            $sql->where(DB::raw('passport.created_at'), '<=', $end_date);
        } else {
            $sql->where(DB::raw('passport.created_at'), '>', $leader_date);
        }
        $total_passport = $sql->first()->total_passport;

        $sql = Passport::select(DB::raw('passport.*'), DB::raw('users.alias'))
            ->leftjoin('users', function($join) use ($user_id) {
                $join->on('passport.user_id', '=', 'users.id');
                $join->on('users.hierarchy', 'like', DB::raw("'%#".$user_id."#%'"));
            })
            ->where('description', 'like', '%purchased%')
            ->where('debit', '>', '0')
            ->where('users.id', '<>', $user_id)
            ->where(DB::raw('passport.created_at'), '>', $leader_date)
            ->orderby(DB::raw('passport.created_at'), 'desc');
        if (!empty($end_date))
        {
            $sql->where(DB::raw('passport.created_at'), '>', $leader_date);
            $sql->where(DB::raw('passport.created_at'), '<=', $end_date);
        } else {
            $sql->where(DB::raw('passport.created_at'), '>', $leader_date);
        }
        $passports = $sql->paginate(250);

        return view('member.leader')->with('total_passport', $total_passport)->with('passports', $passports);
    }
}