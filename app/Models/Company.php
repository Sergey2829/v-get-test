<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
      'title', 'phone', 'description'
    ];

    public function scopeByUser($query)
    {
        return $this->where('user_id', Auth::id());
    }
}
