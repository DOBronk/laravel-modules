<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'subject',
        'message',
        'to-user',
    ];
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Crop message for preview in list
     * @param int $length Maximum length of message
     * @return string
     */
    public function crop_message(int $length): string
    {
        $message = $this->message;

        if (strlen($message) > $length) {
            $message = substr($message, 0, $length - 3) . "...";
        }

        return $message;
    }
}
