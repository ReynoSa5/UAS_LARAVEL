<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class TableUser extends User
{
    use Notifiable;
    protected $guarded = [];
    protected $primaryKey = 'id_user';

    public function logs()
    {
        return $this->hasMany(TableLog::class, 'id_user', 'id_user');
    }

    public function kelola()
    {
        $users = TableUser::all();
        return view('admin.kelola-user', compact('users'));
    }
}
