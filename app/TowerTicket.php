<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TowerTicket extends Model
{
    public $table='tower_tickets';
    public $fillable = [
        'id', 'tower_id', 'broadcast_id', 'tower_link_id',
        'tower_link_id', 'category', 'priority', 'status',
        'title','message', 'created_by', 'closed_by', 'updated_by'
    ];


    public function user() {
        return $this->belongsTo('App\User','created_by','id');
    }


}
