<?php

namespace App\Models\Ticket;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 * @package App\Models\Ticket
 * @mixin Builder
 * @property int $id
 * @property int $userId
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $subject
 * @property string $content
 *
 * @method forUser()
 */

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket_tickets';
    protected $guarded = ['id'];

    public static function new(int $userId, string $subject, string $content): self
    {
        $ticket = self::create([
            'user_id' => $userId,
            'subject' => $subject,
            'content' => $content,
            'status' => Status::OPEN
        ]);

        $ticket->setStatus(Status::OPEN, $userId);
        return $ticket;
    }

    private function setStatus($status, ?int $user_id): void
    {
        $this->statuses()->create([
            'status' => $status,
            'user_id' => $user_id
        ]);

        $this->update(['status' => $status]);
    }

    public function statuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Status::class, 'ticket_id', 'id');
    }

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
