<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pegawai  extends Authenticatable
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $guarded = ['id'];
    protected $primaryKey = 'id_pegawai';

    protected static $logName = 'pegawai';
    public function hasRole($role)
    {
        if ($this->role == $role) return true;
        return false;
    }

}
