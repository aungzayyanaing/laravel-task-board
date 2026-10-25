<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'notes', 'status'];

    public const STATUSES = ['todo', 'doing', 'done'];

    public function isDone(): bool
    {
        return $this->status === 'done';
    }
}
