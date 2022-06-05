<?php
namespace App\Helper;

use Exception;
use \Firebase\JWT\JWT;

class JwtHelper
{
	public static function BuatToken($data)
    {
      /* PROSES MEMBUAT TOKEN */
      /* ==================== */
      // PRIVATE KEY ATAU KUNCI RAHASIA KITA UNTUK MEMBUAT TOKEN
      // HARUS BERUPA STRING DAN BOLEH TERSERAH
      $key = env("JWT_PRIVATE_KEY");
      
      // DATA YANG INGIN DIMASUKKAN KEDALAM TOKEN
      $data_jwt = $data;
      $data_jwt['iss'] = time();
      
      // PROSES MEMBUAT TOKEN
      $token = JWT::encode($data_jwt, $key); // TOKEN AKAN DISIMPAN DIVARIABEL INI, BERUPA STRING
      return $token;
      /* =============================== */
      /* AKHIR DARI PROSES MEMBUAT TOKEN */
    }
    
    // BacaToken($token string)
    // @Param :
    // $token : token jwt dengan Bearer
    // $this->private_key : private key untuk generate token
    
    // Return  array asosiatif:
    // $result["error"] bool : true berarti ada yang error, false berarti tidak ada error
    // $result["message"] string : isi pesan error jika terdapat error pada token
    // $result["data"] array asosiatif : data yang diambil dari hasil parse token
    public static function BacaToken($token)
    {
      $result = [
        "status" => false,
        "message" => null,
        "data" => null,
      ];
      // KITA PAKAI TRY CATCH AGAR SAAT PROSES PEMBACAAN TOKEN
      // DAN TERNYATA ADA YANG SALAH DENGAN TOKEN
      // KITA CUKUP BERI RESPONSE 401 PADA CATCH UNTUK CLIENT
      
      try {
              // proses pembacaan token
              //~ // PRIVATE KEY, SAMA SEPERTI YANG KITA PAKAI SEBELUMNYA SAAT MEMBUAT TOKEN
              
              //~ // PROSES VALIDASI TOKEN
              $data = JWT::decode($token, env("JWT_PRIVATE_KEY"), array(env("JWT_ALGORITHM")));
              
              //~ /* OUTPUT */
              //~ echo $data->username;
              //~ echo $data->tgl_login;
              
              // KITA KEMBALIKAN ISI TOKEN KE USER DALAM BENTUK JSON
              $result["status"] = true;
              $result["data"] = $data; // data berisi username dan tgl_login dari token yg telah di buat di buat_token.php
          
      }
      catch(Exception $e) {
        $result["message"] = $e->getMessage();
      }
      finally {
        return $result;
      }
    }
}