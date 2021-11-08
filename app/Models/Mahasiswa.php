<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table="mahasiswa"; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswas
    public $timestamps= false;

    protected  $primaryKey = 'Nim'; // Memanggil isi DB Dengan primarykey
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Nim',
        'Nama',
        'foto',
        'kelas_id',
        'Jurusan',
        'No_Handphone',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function matakuliah()
    {
        return $this->belongsToMany(Matakuliah::class)->withPivot('nilai');
    }
}
