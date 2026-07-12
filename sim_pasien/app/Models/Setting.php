<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Setting extends Model
{
    protected $table = 'settings';
 
    protected $fillable = [
        'setting_key',
        'setting_value',
    ];
 
    /**
     * Ambil nilai setting berdasarkan key.
     * Contoh: Setting::get('per_page', 10)
     */
    public static function get(string $key, $default = null)
    {
        return static::where('setting_key', $key)
            ->value('setting_value') ?? $default;
    }
}
 