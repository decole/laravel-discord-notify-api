<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $who
 * @property string $message
 * @property int $is_priority
 * @property string $ip
 * @property int $sent
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class DiscordNotification extends Model
{
    use HasFactory;

    protected $fillable = ['who', 'message', 'is_priority'];
}
