<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Users extends Model
{
    protected $table = 'usuario';
    use HasFactory;
    use SoftDeletes;

    public static function getAllAdminsPlayer() {
        return DB::table('usuarios as u')
            ->select('u.IdTipoUsu')
            ->whereRaw("(u.IdTipoUsu = '1'")
            ->get();
    }
}
