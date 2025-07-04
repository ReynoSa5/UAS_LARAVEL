<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableLog extends Model
{
    protected $guarded = [];

    protected $table = 'table_logs';
    protected $primaryKey = 'id_log';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(TableUser::class, 'id_user', 'id_user');
    }
}
