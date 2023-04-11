<?php

/**
 * 
 * 
 * @package     Motos&Servitecas_Web
 */
class MYS_CRUD_DB
{
    /**
     * 
     */
    private $db;

    /**
     * 
     */
    public function __construct()
    {
        
        global $wpdb;
        $this->db = $wpdb;
        
    }

    /**
     * 
     */
    public function add_cliente($nombre, $telefono, $correo, $id_product){
        
        $columns =  [
            'nombre_cliente' => $nombre,
            'telefono_cliente' => $telefono,
            'correo_cliente' => $correo,
            'sku_product' => $id_product,
        ];

        $result = $this->db->insert(SERVICIOS_MYS_CLIENTES_TABLE, $columns);

        $responde = [
            'result' => $result,
        ];

        $this->db->flush();

        return json_encode($responde);
    }

    /**
     * 
     */
    public function get_clientes()
    {

        $sql = "SELECT * FROM " . SERVICIOS_MYS_CLIENTES_TABLE . ";";

        return $this->db->get_results($sql);

    }

    /**
     * 
     */
    public function delete_cliente($id)
    {
        
        $result = $this->db->delete(SERVICIOS_MYS_CLIENTES_TABLE, array('id'=>$id));

        $response = [
            'result' => $result
        ];
        
        $this->db->flush();

        return json_encode($response);

    }
}