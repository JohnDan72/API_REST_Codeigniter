<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class Usuario extends Model
{
    protected $table      = 'usuario';
    protected $primaryKey = 'Id_Usuario';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;    

    public function login($userName = null, $password = null){
        if($userName == null || $password == null)
            return false;

        $sql = "SELECT  usuario.*, 
                        EXPORT_SET(permisos.Juridico,'1','0','',4) AS Juridico,
                        EXPORT_SET(permisos.Dictamen_M,'1','0','',4) AS Dictamen_M,
                        EXPORT_SET(permisos.Remisiones,'1','0','',4) AS Remisiones,
                        EXPORT_SET(permisos.Inspecciones,'1','0','',4) AS Inspecciones,
                        EXPORT_SET(permisos.Inteligencia_Op,'1','0','',4) AS Inteligencia_Op,
                        EXPORT_SET(permisos.IPH_Final,'1','0','',4) AS IPH_Final,
                        EXPORT_SET(permisos.Seguimientos,'1','0','',4) AS Seguimientos,
                        EXPORT_SET(permisos.Evento_D,'1','0','',4) AS Evento_D,
                        permisos.Modo_Admin
                FROM usuario
                LEFT JOIN permisos ON permisos.Id_Permisos = usuario.Id_Permisos
                WHERE Estatus=1 AND User_Name=? AND Password = AES_ENCRYPT(?,?)";
        $query = $this->db->query($sql,[$userName, $password, Services::getEncryptationKey()]);
        return $query->getRow();
        
    }
}