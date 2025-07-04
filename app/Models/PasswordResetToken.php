<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    public $timestamps = false;

    protected $primaryKey = 'email';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Créer un nouveau token de réinitialisation
     */
    public static function createToken(string $email): string
    {
        $token = \Str::random(60);

        self::updateOrCreate(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        return $token;
    }

    /**
     * Vérifier si le token est valide
     */
    public static function isValidToken(string $email, string $token): bool
    {
        $record = self::where('email', $email)->first();

        if (!$record) {
            return false;
        }

        // Vérifier si le token n'a pas expiré (24 heures)
        if (now()->diffInHours($record->created_at) > 24) {
            $record->delete();
            return false;
        }

        return Hash::check($token, $record->token);
    }

    /**
     * Supprimer le token après utilisation
     */
    public static function deleteToken(string $email): void
    {
        self::where('email', $email)->delete();
    }
}
