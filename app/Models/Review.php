<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review'; // テーブル名を明示（単数形なので必要）
    
    protected $fillable = [
        'user_id', 'name', 'email', 'gender', 'comp_name',
        'speciality', 'employment_status', 'years_of_service', 'age_group',
        'employment_type', 'growth_potential', 'job_satisfaction',
        'organizational_climate', 'social_contribution', 'salary', 'benefits',
        'female_advancement', 'reviews'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
