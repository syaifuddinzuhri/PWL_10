<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    
    protected $table = 'mahasiswa';

    protected $primaryKey = 'nim';

    public $increments = false;

    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'tanggal_lahir',
        'kelas_id',
        'jurusan',
        'no_handphone',
    ];

    /**
     * Get the user that owns the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * The roles that belong to the Mahasiswa_MataKuliah
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matakuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'mahasiswa_matakuliah', 'mahasiswa_nim', 'matakuliah_id')->withPivot('nilai');
    }
}