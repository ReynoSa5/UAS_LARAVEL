<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableTransaksi extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'id_transaksi';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'table_transaksis';

    public function user()
    {
        return $this->belongsTo(TableUser::class, 'id_user', 'id_user');
    }
}
