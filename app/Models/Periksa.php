<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periksa extends Model
{
    //
    use HasFactory; 
 
    protected $fillable = [ 
        'id_janji_periksa', 
        'tgl_periksa', 
        'catatan', 
        'biaya_periksa', 
    ]; 
 
    protected $casts = [ 
        'tgl_periksa' => 'datetime', 
    ]; 
 
    public function janjiPeriksa():BelongsTo 
    { 
        return $this->belongsTo(JanjiPeriksa::class, 'id_janji_periksa'); 
    } 
 
    public function detailPeriksas():HasMany 
    { 
        return $this->hasMany(DetailPeriksa::class, 'id_periksa'); 
    }
}
