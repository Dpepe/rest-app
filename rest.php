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

    public $_request = array();
    
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

    public function get_request_method(){
        
        return $_SERVER['REQUEST_METHOD'];
    }

    private function inputs()
    {   
        $this->_method_request = $this->get_request_method();

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
        $variable = array();
           
        if ($this->_type_request== "application/json") {

            $json = file_get_contents('php://input');

            $variable = json_decode($json, true);
            # code...
        } else {

            if (is_array($data)) {

                foreach ($data as $key => $value) {
                    $variable[$key] = $value;
                }

            } 
        }

        $this->_request = array('statusrecibe' => "Success", "methodrecibe" => $this->_method_request, "tiporequest"=>$this->_type_request, "data" => $variable);

        return $variable;
    }


    

    
}


//

//$arrayName = array('name' =>  "David", 'last' => "Perez" );

//$new->getInputs($arrayName);

