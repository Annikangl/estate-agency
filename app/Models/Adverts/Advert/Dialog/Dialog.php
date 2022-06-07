<?php

namespace App\Models\Adverts\Advert\Dialog;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dialog
 * @package App\Models\Adverts\Advert\Dialog
 *
 * @mixin Builder
 *
 * @property int $id
 * @property int $advert_id
 * @property int $user_id
 * @property int $client_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $user_new_messages
 * @property int $client_new_messages
 */

class Dialog extends Model
{
    use HasFactory;

    protected $table = 'advert_dialogs';
    protected $guarded = ['id'];


    public function writeMessage(int $userId, string $message): void
    {
        if ($userId !== $this->user_id && $userId !== $this->client_id) {
            throw new \DomainException('Незвестный диалог');
        }

        $this->messages()->create([
            'user_id' => $userId,
            'message' => $message
        ]);

        if ($userId === $this->user_id) {
            $this->user_new_messages++;
        }
        if ($userId === $this->client_id) {
            $this->client_new_messages++;
        }

        $this->save();
    }

    public function readByClient(): void
    {
        $this->update(['client_new_messages' => 0]);
    }

    public function readByOwner(): void
    {
        $this->update(['user_new_messages' => 0]);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'dialog_id', 'id');
    }
}
