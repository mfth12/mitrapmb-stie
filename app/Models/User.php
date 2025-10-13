<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    /**
     * thn
     * @use HasFactory<\Database\Factories\UserFactory>
     */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    protected $primaryKey     = 'user_id';
    protected $guarded        = ['user_id']; //dilindungi agar tidak ada input yang masuk ke user_id
    protected static $logName = 'sistem';
    public $timestamps        = true;
    // protected $with 				= ['detail', 'level']; //menggunakan eiger loading di models

    /**
     * key name route pada model ini.
     *
     * @var string
     */
    public function getRouteKeyName()
    {
        return 'user_id';
    }

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    /**
     * untuk casting datetime
     *
     */
    protected $casts = [
        'last_logged_in' => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ //translation from siakad-db
        //'user_id',
        'siakad_id',            //id
        'username', //original
        'name',                 //name
        'asal_sekolah',//original
        'email',                //email
        'nomor_hp',             //nomor_hp
        'nomor_hp2',            //nomor_hp2
        'email_verified_at',    //email_verified_at
        'about',                //about
        'default_role',         //default_role 
        'theme',                //theme
        'avatar',               //avatar
        'status',               //status
        'status_login',         //status_login
        'isdeleted',            //isdeleted
        'last_logged_in', //original
        'last_synced_at', //original
        'password', // tambahkan ini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Additional according to siakad
     */

    public function registerMediaConversions(Media $media = null): void
    {
        if (function_exists('proc_open')) {
            $this->addMediaConversion('thumb')
                ->width(350)
                ->height(350);
        } else {
            $this->addMediaConversion('thumb')
                ->width(350)
                ->height(350)
                ->quality(70);
        }
    }

    /**
     * Additional according to siakad
     * digunakan untuk mengambil nama tabel model ini.
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    /**
     * Get the user's primary role
     */
    public function getPrimaryRoleAttribute()
    {
        return $this->roles->first()->name ?? 'mahasiswa';
    }
}
