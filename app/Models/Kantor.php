<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kantor extends Authenticatable
{
    use HasFactory;
    protected $table = 'kantor';
    protected $guarded = ['id'];
    protected $primaryKey = 'id_kantor';

    protected static $logName = 'kantor';
    public function hasRole($role)
    {
        if ($this->role == $role) return true;
        return false;
    }
}
