<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;


    protected $table = 'clients';

    protected $primaryKey = 'cin';


    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'cin',
        'name',
        'forname',
        'address',
    ];


    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
    public function vms()
    {
        return $this->hasMany(VM::class, 'client_id', 'cin');
    }

    public function getAllClientsCINs()
{
    $clients = Client::select('cin')->get();

    if ($clients->isEmpty()) {
        return response()->json(['error' => 'No clients found'], 404);
    }

    return response()->json($clients);
}


}
