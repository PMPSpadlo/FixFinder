<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workshop_id',
        'description',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    public function updateStatus(string $status): bool
    {
        $validStatuses = ['pending', 'accepted', 'in_progress', 'completed', 'declined'];
        if (in_array($status, $validStatuses)) {
            $this->status = $status;
            return $this->save();
        }
        return false;
    }

}
