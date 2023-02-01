<?php
class conexion{
	
	/*
	private $conectar;

	public function __construct(){
		$cadena_conexion = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
		try{
			$this->conectar = new PDO($cadena_conexion, DB_USER, DB_PASSWORD);
			$this->conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //echo "conexión exitosa";
		}catch(PDOException $e){
			$this->conectar = 'Error de conexión';
		    echo "ERROR: " . $e->getMessage();
		}
	}

	public function conectar(){
		return $this->conectar;
	}
	*/

	/**
     * Única instancia de la clase
     */
    private static $db = null;
    
    /**
     * Instancia de PDO
     */
    private static $pdo;

    final private function __construct()
    {
        try {
            // Crear nueva conexión PDO
            self::getDb();
        } catch (PDOException $e) {
            // Manejo de excepciones
        }


    }

    /**
     * Retorna en la única instancia de la clase
     * @return Database|null
     */
    public static function getInstance()
    {
        if (self::$db === null) {
            self::$db = new self();
        }
        return self::$db;
    }

    /**
     * Crear una nueva conexión PDO basada
     * en los datos de conexión
     * @return PDO Objeto PDO
     */
    public function getDb()
    {
        //  $c = new PDO( "sqlsrv:Server=(local) ; Database = AdventureWorks ", "", "", array(PDO::SQLSRV_ATTR_DIRECT_QUERY => true));
        //  
        //  
        if (self::$pdo == null) {
            self::$pdo = new PDO(
                'mysql:dbname=' . DB_NAME .
                ';host=' . DB_HOST .
                ';port:3306;', // Eliminar este elemento si se usa una instalación por defecto
                DB_USER,
                DB_PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );
            // Habilitar excepciones
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }

    /**
     * Evita la clonación del objeto
     */
    final protected function __clone()
    {
    }

    function _destructor()
    {
        self::$pdo = null;
    }
}

?>