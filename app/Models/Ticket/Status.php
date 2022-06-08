<?php

namespace App\Models\Ticket;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * @package App\Models\Ticket
 * @property int $id
 * @property int $ticket_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $status
 */
class Status extends Model
{
    use HasFactory;

    public const OPEN = 'открыт';
    public const APPROVED = 'принят';
    public const CLOSED = 'закрыт';

    protected $table = 'ticket_statuses';

    protected $guarded = ['id'];

    public static function statusesList(): array
    {
        return [
            self::OPEN => 'Открыт',
            self::APPROVED => 'Принят',
            self::CLOSED => 'Закрыт'
        ];
    }

    public function isOpen(): bool
    {
        return $this->status === self::OPEN;
    }

    public function isApproved(): bool
    {
        return $this->status === self::APPROVED;
    }

    public function isClosed(): bool
    {
        return $this->status === self::CLOSED;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
