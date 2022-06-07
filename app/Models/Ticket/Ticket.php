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
 *
 * @property int $id
 * @property int $userId
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $subject
 * @property string $content
 * @property string $status
 *
 * @method forUser(User $user)
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

    public function edit(string $subject, string $content): void
    {
        $this->update([
            'subject' => $subject,
            'content' => $content
        ]);
    }

    public function approve(int $userId): void
    {
        if ($this->isApproved()) {
            throw new \DomainException('Тикет уже принят');
        }

        $this->setStatus(Status::APPROVED, $userId);
    }

    public function close(int $userId): void
    {
        if ($this->isClosed()) {
            throw new \DomainException('Тикет уже закрыт');
        }

        $this->setStatus(Status::CLOSED, $userId);
    }

    public function reopen(int $userId): void
    {
        if (!$this->isClosed()) {
            throw new \DomainException('Тикет не закрыт');
        }

        $this->setStatus(Status::APPROVED, $userId);
    }

    public function addMessage(int $userId, $message): void
    {
        if (!$this->allowsMessages()) {
            throw new \DomainException('Тикет закрыт для сообщений');
        }
        $this->messages()->create([
            'user_id' => $userId,
            'message' => $message
        ]);
//        Обновление даты updated_at
        $this->update();
    }

    public function allowsMessages(): bool
    {
        return !$this->isClosed();
    }

    public function canBeRemoved(): bool
    {
        return $this->isOpen();
    }

    public function isOpen(): bool
    {
        return $this->status === Status::OPEN;
    }

    public function isApproved(): bool
    {
        return $this->status === Status::APPROVED;
    }

    public function isClosed(): bool
    {
        return $this->status === Status::CLOSED;
    }

    private function setStatus($status, ?int $user_id): void
    {
        $this->statuses()->create([
            'status' => $status,
            'user_id' => $user_id
        ]);

        $this->update(['status' => $status]);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function statuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Status::class, 'ticket_id', 'id');
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'ticket_id', 'id');
    }

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
