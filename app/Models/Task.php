<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Repositories\UserRepository\UserDTO;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'status' => TaskStatus::class
    ];

    protected $attributes = [
        'status' => TaskStatus::Created
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): ?UserDTO
    {
        if (!$this->user_id)
            return null;
        return UserRepository::getInstance()->findById($this->user_id);
    }
}
