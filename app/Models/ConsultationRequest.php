<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'approved',
    ];

    /**
     * リクエストを送ったユーザー（発信者）
     */
    public function fromUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'from_user_id');
    }

    /**
     * リクエストを受けたユーザー（受信者）
     */
    public function toUser()
    {
        return $this->belongsTo(U\App\Models\User::class, 'to_user_id');
    }
}

