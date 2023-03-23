<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class plantilla_doc extends Model
{
    use HasFactory;

    protected $table = 'plantilla_doc';

    public static function requestInsertPlantillaDo($data) {

        try {

            $response = self::insertPlantillaDo($data);
            if (isset($response["code"]) && $response["code"] == 200) {
                return $response;
            } else {
                return $response;
            }
        } catch(Exception $e) {
            return array(
                "code"  => 500,
                "success"   => false,
                "message"   => $e->getMessage()
            );
        }
    }

    public static function insertPlantillaDo($data ) {

        $arrayResponse = array();

        try {
            $Id = \DB::table('plantilla_doc')->insertGetId($data);

            $arrayResponse = array(
                "code"      => 200,
                "message"   => "Se ha agregado el registro",
                "id"        => $formularioId
            );
        } catch (Exception $e) {
            $arrayResponse = array(
                "code"      => 500,
                "message"   => "Ocurrio un error al intentar agregar el registro. Error" . $e->getMessage()
            );
        }

        return $arrayResponse;
    }

    public function respuesta() {
        return $this->hasMany(Respuesta::class);
    }
}
