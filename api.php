<?php
require_once("rest.php");
/**
 * 			
 */
class Api extends Rest
{

	private $host = "127.0.0.1";
	private $username = "root";
	private $password = "";
	private $database = "productos";
	
    /**
     * Simulación de como se recogeran los datos
     * @var array
     */
    private $_db_cliente = array('color' => 'sss', 'precio'=> 2560, "nombre"=>"Jordan1");

    /**
     * Respuest de datos como productos, producto y el estado devuelto.
     * @var array
     */
    private $responsedata = array('one' => "fd", "fds"=>"DSF");

    /**
     * Conexión a la base de datos
     * @var [type]
     */
    private $connection;
    
    /**
     * Table base de datos
     * @var string
     */
    private $table = "producto";

    function __construct()
    {   
    	parent::__construct();
    	$this->dbConnect();	
    }

    private function dbConnect()
    {

    	$this->connection = null;

    	try {

    		$this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);

    	} catch (PDOException $e) {

    		echo "Error: " . $e->getMessage();
    	}
    }

    public function resquest()		
    {
    	$this->_data_response = array('status' => "", "method" => "", "tiporequest"=>'',"responsedata"=> $this->responsedata, "dataRecibida" => $this->_request);

    	echo json_encode($this->_data_response);
	    //print_r($this->get_input);
    }

    public function login(){}

    public function session(){}
    
    public function products(){

    	$result = $this->connection->prepare('SELECT * FROM '.$this->table.'');

    	$result->execute();


    	$num_rowse = $result->rowCount();

    	if ($num_rowse>0) {

    		while($row = $result->fetch(PDO::FETCH_ASSOC)){
    			$this->responsedata[] = $row; 
    		}
    	}

    	$this->resquest();
    }
    
    public function product(){

    	$result = $this->connection->prepare('SELECT * FROM '.$this->table.' WHERE id = 1');

    	$result->execute();

    	$num_rowse = $result->rowCount();

    	if ($num_rowse>0) {

    		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    			$this->responsedata[] = $row;
    		}
    	}

    	$this->resquest();
    }

    public function productInsert()
    {   

    	$arrayCampos = array();
    	$arrayValues = array();
    	$lugares = array();

    	foreach ($this->_db_cliente as $key => $value) {
    		$arrayCampos[] = $key;
    		$lugares[] = "?";
    		$arrayValues[] = $value;
    	}

    	$result = $this->connection->prepare('INSERT INTO '.$this->table.'('.implode(',', $arrayCampos).') VALUES ('.implode(',', $lugares).')');

    	$result->execute($arrayValues);

    	$this->responsedata = array('functiom' => "productInsert", "dateUpdate"=>"DSF");
    	$this->resquest();
    }

    public function productUpdate(){

    	$arrayCampos = array();
    	$arrayValues = array();

    	foreach ($this->_db_cliente as $key => $value) {

    		$arrayCampos[] = "$key=?";
    		$arrayValues[] = $value;

    	}
    	
    	try {

    		$result = $this->connection->prepare('UPDATE '.$this->table.'  SET '.implode(',', $arrayCampos).' where id=1');

    		$result->execute($arrayValues);

    		$this->responsedata = array('functiom' => "productUpdate", "dateUpdate"=>"DSF");

    		$this->resquest();

    	} catch (PDOException $e) {

    		echo "Error: " . $e->getMessage();

    	}
    	
    	
    }

    public function productDelete(){

    	$this->responsedata = array('functiom' => "productDelete", "dateUpdate"=>"DSF");
    	$this->resquest();
    }

    public function productImagen()
    {   
    	
    }

    public function initialApi(){

    	$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
    	$funcd = strtolower(trim(str_replace("/","",$_REQUEST['d'])));
    	
    	echo $func."</br>";

    	echo $funcd;
    }/**/
    
}

$new = new Api();
$new->initialApi();
$new->productUpdate();

?>