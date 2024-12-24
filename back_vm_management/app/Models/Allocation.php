<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;


    protected $table = 'allocations';


    protected $fillable = [
    'client_cin',
    'vm_id',
    'begin_date',
    'end_date',
    'amount'];



    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function vm()
    {
        return $this->belongsTo(Vm::class, 'vm_id');
    }
}
