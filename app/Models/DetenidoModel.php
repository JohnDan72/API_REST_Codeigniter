<?php

namespace App\Models;

use CodeIgniter\Model;

class DetenidoModel extends Model
{
    protected $table      = 'detenido';
    protected $primaryKey = 'No_Remision';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    //protected $allowedFields = ['Nombre', 'Ap_Paterno', 'Ap_Materno'];
    

    public function getRemisione($no_remsion = null){
        if($no_remsion == null)
            return false;
            $sql = "SELECT * FROM detenido WHERE No_Remision = ?";
            $query = $this->db->query($sql,[$no_remsion]);
            return $query->getRow();
        
    }
}