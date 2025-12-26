<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = [
        'title','priority','status',
        'due_date','assigned_to','project_id'
    ];

    protected $appends = ['is_overdue'];

    public function getIsOverdueAttribute()
    {
        return Carbon::parse($this->due_date)->isPast()
            && $this->status !== 'DONE';
    }
}
