<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sistem\KonfigurasiModel;

class KonfigurasiTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $tableName = KonfigurasiModel::getTableName();
    DB::statement("DELETE FROM $tableName");
    DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1011;");

    DB::table($tableName)->insert([
      'config_group'  => 'identitas',
      'config_key'    => 'NAMA_PT',
      'config_value'  => 'STIE Pembangunan Tanjungpinang',
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'identitas',
      'config_key'    => 'NAMA_PT_ALIAS',
      'config_value'  => 'STIE',
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'identitas',
      'config_key'    => 'NAMA_SISTEM',
      'config_value'  => 'Portal Mitra PMB',
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'identitas',
      'config_key'    => 'NAMA_SISTEM_ALIAS',
      'config_value'  => 'Mitra PMB',
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'identitas',
      'config_key'    => 'LOGO',
      'config_value'  => 'logo-main.png',
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'basic',
      'config_key'    => 'DEFAULT_TA',
      'config_value'  => date('Y'),
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'basic',
      'config_key'    => 'DEFAULT_SEMESTER',
      'config_value'  => 1,
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    //blog
    DB::table($tableName)->insert([
      'config_group'  => 'blog',
      'config_key'    => 'APPEARANCE',
      'config_value'  => json_encode([
        'headers'     => [
          'logo'        => 'storage/blog/headers/logo.png',
        ],
      ]),
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'blog',
      'config_key'    => 'PAGES',
      'config_value'  => json_encode([
        'contact'       => [
          'title'       => 'Hubungi Kami',
          'content'     => '<ul><li>Lorem</li></ul>',
          'files'       => '',
          'whatsapp'    => '',
          'telegram'    => '',
          'facebook'    => '',
          'instagram'   => '',
          'x'           => '',
          'youtube'     => '',
          'linkedin'    => '',
        ],
        'informasi_pendaftaran' => [
          'title'       => 'Informasi Pendaftaran',
          'content'     => '<ul><li>Lorem</li></ul>',
          'files'       => '',
        ],
      ]),
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'report',
      'config_key'    => 'HEADER_2',
      'config_value'  => null,
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'server',
      'config_key'    => 'TOKEN_TTL_EXPIRE',
      'config_value'  => '60', //minute
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'server',
      'config_key'    => 'WA_ENDPOINT',
      'config_value'  => 'https://wa.stie-pembangunan.ac.id', //url
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    DB::table($tableName)->insert([
      'config_group'  => 'server',
      'config_key'    => 'WA_SESSION',
      'config_value'  => 'notifstie87x6v8r2js', //secret session
      'created_at'    => Carbon::now(),
      'updated_at'    => Carbon::now()
    ]);

    KonfigurasiModel::toCache();
  }
}
