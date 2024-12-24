<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;


    protected $table = 'servers';


    protected $fillable = ['ram', 'disk', 'hypervisor'];


    public function allocation()
{
    return $this->belongsTo(Allocation::class);
}

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_cin', 'cin');
    }

        public function vms()
    {
        return $this->hasMany(VM::class);
    }
}
