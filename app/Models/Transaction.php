<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'customer_id',
        'amount',
        'due_date',
        'vat',
        'is_vat_inclusive',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    // category relation
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // sub_category relation
    public function sub_category(){
        return $this->belongsTo(SubCategory::class);
    }

    // customer relation
    public function customer(){
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    // payments relation
    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
