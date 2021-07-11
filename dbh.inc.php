<?php

class Dbh {

	private $servername;
	private $username;
	private $password;
//	protected $dbname = 'newphhsystem';
	protected $dbname = 'phhsystem';
	private $charset;

	public function connect() {
		$this->servername = "localhost";
//                $this->servername = "192.168.83.18";
//                $this->servername = "10.10.1.2";
		$this->username = "root";
		$this->password = "5105458";
//		$this->dbname = "phhsystem";
//		$this->dbname = "newphhsystem";
		$this->charset = "utf8";

		try {
			$dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
			$pdo = new PDO($dsn, $this->username, $this->password);
			// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch (PDOException $e) {
			echo "Connection failed: ".$e->getMessage();
		}
	}

}

class DbhConnect {

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;
    protected static $db;

    public function __construct() {

        $this->servername = "localhost";
//        $this->servername = "192.168.83.18";
//                $this->servername = "10.10.1.2";
        $this->username = "root";
        $this->password = "5105458";
		$this->dbname = "phhsystem";
//		$this->dbname = "newphhsystem";
        $this->charset = "utf8";
        try {
            // assign PDO object to db variable
            self::$db = new PDO('mysql:host='.$this->servername.';dbname='.$this->dbname, $this->username, $this->password);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //Output error - would normally log this to error file rather than output to user.
            echo "Connection Error: " . $e->getMessage();
        }
    }

    public static function getConnection() {
        if (!self::$db) {
            new DbhConnect();
        }
        //return connection.
        return self::$db;
    }

}
