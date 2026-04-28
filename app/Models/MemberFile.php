<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'original_name',
        'stored_name',
        'file_path',
        'mime_type',
        'file_size',
        'uploaded_by',
    ];

    /**
     * Файл принадлежит одному члену клуба
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Размер файла в читаемом виде (KB / MB)
     */
    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }
        return round($bytes / 1024, 1) . ' KB';
    }
}
