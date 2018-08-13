<?php
/**
 * Database abstraction class, make very easy to work with databases.
 * @author Anil kumar Perecherla.
 * @name PDO Class
 * Database specific class - mySQL
 */
require_once 'logging.class.php';
require_once 'constant.php';
class DataBasePDO{
	/* ----------- CONNECTION PARAMETERS -------------*/
	private static $hostname = DATABASE_SERVER;
	private static $username = DATABASE_USER;
	private static $password = DATABASE_PASSWORD;
	private static $dbname   = DB_DATABASE;
	private static $instance = FALSE;
	private $db;  
	public $fetch_mode       = PDO::FETCH_ASSOC;

	/* ------------ CACHED PARAMETERS ----------------*/
	private $last_query		= NULL;
	private $last_statement	= NULL;
	private $last_result	= NULL;
	private $row_count		= NULL;
	private $affected_row	= NULL; 

	/**
	 * Constructor.
	 * @return object DB
	 * @access public
	 */

	public function __construct($connect = true, $dataBase = null, $server = null,$userName = null, $passWord = null){
		if ($dataBase !== null) $this->dbname       = $dataBase;
		if ($server   !== null) $this->hostname     = $server;
		if ($userName !== null) $this->username     = $userName;
		if ($passWord !== null) $this->password     = $passWord;
		ini_set('track_errors',1);
		if (!self::$instance){
			$this->connectToDB();
		}
		if (!$this->db) {
			$this->db = self::$instance;
		}
		return self::$instance;		
	} 
	/**
	 * Connect to the database and set the error mode to Exception. 
	 * @return void
	 * @access public
	 */
	public function connectToDB(){
		$dns='mysql:host='.self::$hostname.';dbname='.self::$dbname;
		self::$instance = new PDO($dns, self::$username, self::$password);
		self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db = self::$instance;
	} 

	/**
	 *Insert or Update data based on where condition
	 * @param string $table
	 * @param array $valueAr
	 * @param array/string $where
	 * @access public
	 * @If $where condition is NULL it executes insertData
	 * @If $where condition is NOTNULL it executes updateData
	 **/

	public function insertOrUpdate($table = NULL, $valueAr = NULL){
		//array_walk($valueAr,'DataBasePDO::prepareDbValues');
		foreach ($valueAr as $key => $val){
			$valstr[]= '`'.$key.'` = "'.$val.'"';
		}
		$sqlQuery = "INSERT INTO `".$table."` (`".implode('`, `', array_keys($valueAr))."`) VALUES (\"".implode('", "', $valueAr)."\")  ON DUPLICATE KEY UPDATE ".implode(', ', $valstr)."";
		//print("$sqlQuery\n");die();
		return $this->executeQuery($sqlQuery);	
	}
	
	
	/**
	 * Insert a value into a table.
	 * @param string $table
	 * @param array $valueAr
	 * @return void
	 * @access public
	 * @todo Validate if $table or $valueAr is null.
	 */	

	public function insertData($table=NULL,$valueAr=NULL){
		array_walk($valueAr,'DataBasePDO::prepareDbValues');
		$sqlQuery = "INSERT INTO `".$table."` 
			(`".implode('`, `', array_keys($valueAr))."`) 
			VALUES (".implode(', ', $valueAr).")";
		return $this->executeQuery($sqlQuery);							 
	}

	/**
	 * Select values form the table.
	 * @param string $table
	 * @param array $valueAr
	 * @return void
	 * @access public
	 * @todo Validate if $table or $valueAr is null.
	 */		
	public function selectData($table,$whereAr=1,$columns=NULL,$limit=NULL){

		if(!is_null($columns)){
			$sqlQuery=$this->buildSQLColumns($columns);
		}
		else{
			$sqlQuery="*";
		}			
		$sqlQuery = "SELECT ".$sqlQuery." FROM `".$table."`";
		if (is_array($whereAr)){
			$sqlQuery .=$this->buildSQLWhereClause($whereAr);
		}
		else{
			$sqlQuery .=" WHERE $whereAr";
		}
		if (! is_null($limit)) {
			$sqlQuery .= " LIMIT " . $limit;
		}
		//print_r($sqlQuery);
		return $this->getAllResults($sqlQuery);							 
	}

	/**
	 * [STATIC] Builds a comma delimited list of columns for use with SQL
	 *
	 * @param array $valuesArray An array containing the column names.
	 * @param boolean $addQuotes (Optional) TRUE to add quotes
	 * @param boolean $showAlias (Optional) TRUE to show column alias
	 * @return string Returns the SQL column list
	 *  Venkat
	 */
	static private function buildSQLColumns($columns, $addQuotes = true, $showAlias = true) {
		if ($addQuotes) {
			$quote = "`";
		} else {
			$quote = "'";
		}
		switch (gettype($columns)) {
			case "array":
				$sql = "";
				foreach ($columns as $key => $value) {
					// Build the columns
					if (strlen($sql) == 0) {
						$sql = $quote . $value . $quote;
					} else {
						$sql .= ", " . $quote . $value . $quote;
					}
					if ($showAlias && is_string($key) && (! empty($key))) {
						$sql .= ' AS "' . $key . '"';
					}
				}
				return $sql;
				break;
			case "string":
				return $quote . $columns . $quote;
				break;
			default:
				return false;
				break;
		}
	}

	/**
	 * [STATIC] Builds a SQL WHERE clause from an array.
	 * If a key is specified, the key is used at the field name and the value
	 * as a comparison. If a key is not used, the value is used as the clause.
	 *
	 * @param array $whereArray An associative array containing the column
	 *                           names as keys and values as data. The values
	 *                           must be SQL ready (i.e. quotes around
	 *                           strings, formatted dates, ect)
	 * @return string Returns a string containing the SQL WHERE clause
	 */
	static public function buildSQLWhereClause($whereAr) {
		$where = "";
		foreach ($whereAr as $key => $value) {
			if (strlen($where) == 0) {
				if (is_string($key)) {
					$where = " WHERE `" . $key . "` = " . $value;
				} else {
					$where = " WHERE " . $value;
				}
			} else {
				if (is_string($key)) {
					$where .= " AND `" . $key . "` = " . $value;
				} else {
					$where .= " AND " . $value;
				}
			}
		}
		return $where;
	}

	/**
	 * Update a value(s) in a table
	 * Ex: 
	 * $table = 'tableName';
	 * $data = array('text'=> 'value', 'date'=> '2009-12-01');
	 * $where = array('id=1','AND name="hai"'); OR $where = 'id = 1';
	 * @param string $table
	 * @param array $valueAr
	 * @param array/string $where
	 * @return void
	 * @access public
	 * @todo Validate the $table, $data, $where variables.
	 */
	public function updateData($table = NULL, $valueAr = NULL, $whereAr= NULL){
		array_walk($valueAr,'DataBasePDO::prepareDbValues');

		foreach ($valueAr as $key => $val){
			$valstr[]= '`'.$key.'` = '.$val;
		}

		$sqlQuery = "UPDATE `".$table."` SET ".implode(', ', $valstr);
		$sqlQuery .=$this->buildSQLWhereClause($whereAr);
		return $this->executeQuery($sqlQuery);
	}

	/**
	 * Delete a record from a table.
	 * Ex.
	 * $table = 'tableName';
	 * $where = array('id = 12','AND name = "John"'); OR $where = 'id = 	12';
	 * @param string $table
	 * @param array/string $where
	 * @return void
	 * @access public
	 * @todo Validate the $table, $where variables.
	 */

	public function deleteData($table = NULL, $where = NULL){
		$sqlQuery = "DELETE FROM `".$table."` WHERE ";
		if (is_array($where)){
			$sqlQuery.= implode(" ",$where);
		}
		else{
			$sqlQuery.= $where;
		}
		$this->executeQuery($sqlQuery);
	}

	/**
	 * Helper function, walk the array, and modify the values.
	 * @param pointer $item
	 * @return void
	 * @access public 
	 */

	public static function prepareDbValues(&$item){
		$item = "'".self::escape($item)."'";
	}

	/**
	 * Execute a query (INSERT, UPDATE, DELETE).
	 * @param string $sqlQuery
	 * @return int
	 * @access public
	 * @todo Validate $sqlQuery
	 */
	public function executeQuery($sqlQuery = NULL){
		$this->last_query = $sqlQuery;
		$this->affected_row = $this->db->exec($sqlQuery);
		if ( $this->catch_error() ) return false;
		return $this->affected_row;
	}	
	/** 
	 * Get one row from the DB.
	 * @param string $sqlQuery
	 * @return result set
	 * @access public
	 * @todo Validate $sqlQuery.
	 */
	public function getOneRow($sqlQuery = NULL){
		$this->internalQuery($sqlQuery);
		$result = $this->last_statement->fetch();
		$this->last_result = $result;
		return $result;		
	}

	/**
	 * Return the the query as a result set.
	 * @param string $sqlQuery
	 * @return result set
	 * @access public
	 * @todo Validate $sqlQuery.
	 */

	public function getAllResults($sqlQuery = NULL){
		$this->internalQuery($sqlQuery);

		$result = $this->last_statement->fetchAll();
		//print_r($result);
		$this->last_result = $result;
		return $result;
	}

	/**
	 * Execute a query.
	 * This function can be used from DB class methods.
	 * @param string $sqlQuery
	 * @return bool
	 * @access public
	 * @todo Validate $sqlQuery
	 */

	public function internalQuery($sqlQuery = NULL){
		$this->last_query = $sqlQuery;
		$stmt = $this->db->query($sqlQuery);
		if ( $this->catch_error() ) return false;
		$stmt->setFetchMode($this->fetch_mode);
		$this->last_statement = $stmt;
		return TRUE;
	}

	/**
	 *  Format a mySQL string correctly for safe mySQL insert
	 *  (no mater if magic quotes are on or not)
	 * @param string $str
	 * @return string
	 * @access public
	 */

	public function escape($str){
		return stripslashes($str);
	}
	/**
	 * Set the PDO fetch mode.
	 * @param string $fetch_mode
	 * @return void
	 * @access public
	 */
	public function setFetchMode($fetch_mode){
		$this->fetch_mode = $fetch_mode;
	}

	/**
	 * Return the last insert id.
	 * @return integer
	 * @access public
	 */
	public function getLastInsertId(){
		return $this->db->lastInsertId();
	}
	/**
	 * Return the last executed query.
	 * @return string
	 * @access public
	 */
	public function getLastQuery(){
		return $this->last_query;
	}
	/**
	 * Returns the number of rows affected by the last SQL statement.
	 * @return int
	 * @access public
	 */
	public function rowCount(){
		if (!is_null($this->last_statement)){
			return $this->last_statement->rowCount();
		}
		else{
			return 0;
		}
	}
	function catch_error(){
		$err_array = $this->db->errorInfo();

		if ( isset($err_array[1]) && $err_array[1] != 25){
			try {
				throw new Exception();
			}
			catch (Exception  $e){
				print $this->getLastQuery();
				die();
			}
		}
	}
}
?>
