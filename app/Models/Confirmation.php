<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

/**
 * Class Location.
 *
 * @property string $phone
 * @property string $code
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Confirmation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'code',
    ];

    /**
     * Отправка подтверждения.
     *
     * @return bool
     */
    public function send()
    {
        $response = Http::get('https://sms.ru/sms/send?api_id=15545928-0300-E911-443E-785E3543FD2D&to=' . $this->phone . '&msg=' . $this->code . '&json=1&test=1');

        return $response->json('status') === 'OK';
    }
}
