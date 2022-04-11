<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

class Rest {
    
    /**
     * Para el envio en las cabeceras
     * @var string
     */
    public $contenide_type = "application/json";
    
    /**
     * Contenido de las variables que llegaron en el encabezado de request
     * @var array
     */
    public $get_input = array();
    
    /**
     * Envio de datos
     * @var array
     */
    public $_data_response = array();
    
    /**
     * Metodo request
     * @var string
     */
    private $_method_request= "";
    
    /**
     * Tipo request
     * @var string
     */
    private $_type_request= "";
    
    /**
     * Error de envio
     * @var integer
     */
    private $_code = 200;

   
    public function __construct(){

        $this->_type_request= $_SERVER['CONTENT_TYPE'];
        $this->inputs();

    }

    public function get_request(){
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getSatus()
    {
       $status = array(
            200 => 'OK',
            201 => 'Created',  
            204 => 'No Content',  
            404 => 'Not Found',  
            406 => 'Not Acceptable'
        );

       return $status[$this->_code] ?? $status[500]; 
    }

    private function inputs()
    {   
        $this->_method_request = $this->get_request();

        switch ($this->_method_request) {
            case 'POST': 
                $this->get_input = $this->getInputs($_POST);
                break;

            case 'GET':
            case 'DELETE':

                $this->get_input = $this->getInputs($_GET);
                break;

            case 'PUT':
                $this->get_input = $this->getInputs();
                break;

            default:
                echo "malos";
                break;
        }
    }
    
    /**
     * [getInputs Obtiene los datos requests y los guarda en una get_input, si es que se requiere utilizar]
     * @param  [type] $data [Recibe los datos requests de GET Y POST]
     * @return [type]       [Escribe get_input para su posterior utilizacion]
     */
    public function getInputs($data)
    {
        // Contiene datos
        $inputs = array();
        
        if (is_array($data)) {
            if ($this->_type_request== "application/json") {

                $json = file_get_contents('php://input');
                $inputs = json_decode($json, true);
                # code...
            } else {

                foreach ($data as $key => $value) {
                    $inputs[$key] = $value;
                }
            }
        } 


        $this->_request = array('statusrecibe' => "Success", "methodrecibe" => $this->_method_request, "tiporequest"=>$this->_type_request, "data" => $inputs);

        return $inputs;
    }

    public function set_header($value='')
    {
        header("HTTP/1.1 ".$this->_code." ".$this->getSatus());
        header("Content-Type:".$this->contenide_type);
        header('Access-Control-Allow-Origin: *'); 
    }
    
    
}

$r = new Rest();
echo($r->getSatus());

