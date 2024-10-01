<?php

namespace App\Models;

use App\Repositories\UserRepository\UserDTO;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'user_id'
    ];
    public function user(): ?UserDTO
    {
        if (!$this->user_id)
            return null;
        return UserRepository::getInstance()->findById($this->user_id);
    }
}
