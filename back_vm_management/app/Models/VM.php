<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VM extends Model
{
    use HasFactory;


    /**
     *
     *
     * @var string
     */
    protected $table = 'vms';

    /**
     *
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'ram',
        'disk',
        'os',
        'server_id',
        'client_cin',
        'allocation_id',
    ];

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     *
     *
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allocations()
    {
        return $this->hasMany(Allocation::class,'vm_id','id');
    }


    public function client()
{
    return $this->belongsTo(Client::class, 'client_cin', 'cin');
}

}
