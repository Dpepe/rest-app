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
    private $database = "neonbooc_customers";

    private $responsedata = array('one' => "fd", "fds"=>"DSF");

	private $connection;

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

	public function obt(){
        
        $query = "SELECT * FROM angularcode_customers";

        $result = $this->connection->prepare($query);

        $result->execute();

        $num_rowse = $result->rowCount();

        $userData = array();

        if ($num_rowse>0) {
        	while($row = $result->fetch(PDO::FETCH_ASSOC)){

        		$userData[] = $row; 

        	}
        }


	    $this->_data_response = array('status' => "", "method" => "", "tiporequest"=>'',"responsedata"=> $userData , "dataRecibida" => $this->_request);

	    echo json_encode($this->_data_response);
	    //print_r($this->get_input);
	}

    
}

$new = new Api();
$new->obt();

?>