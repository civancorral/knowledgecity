<?php
// Objeto 'user'
class Api_Student{
 
    // Conectamos con la Base de Datos y Cargamos la Tabla.
    private $conn;
    private $table_name = "api_users";
 
    //Las Propiedades del Objeto
    public $id;
    public $students_id;
    public $username;
    public $password;
    public $last_login;
    public $created;
 
    //Constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
	// Metodo create(): Crear Nuevo Registro de Usuario
	public function create($students_id){

		
		//Insertar Registro
		$query = "INSERT INTO " . $this->table_name . " SET students_id = :students_id, username = :username, password = :password";

		// Preparamos la Consulta
		$stmt = $this->conn->prepare($query);
		// Limpiamos de Caracteres Especiales
		$this->students_id=htmlspecialchars(strip_tags($students_id));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->password=htmlspecialchars(strip_tags($this->password));

		// Preparamos Valores
		$stmt->bindParam(':students_id', $students_id);
		$stmt->bindParam(':username', $this->username);

		// hash la contraseña antes de guardar en la base de datos
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);
		
		// Ejecutar la consulta, también verifique si la consulta fue exitosa
		if($stmt->execute()){
			return true;
		}

		return false;
	}
 
	//Metodo usernameExists verificamos si el Usuario existe en nuestra Base de Datos.
	public function usernameExists(){
		
		// Consulta para verificar Usuario
		$query = "SELECT id,students_id, password FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
		
		// Preparamos la Consulta
		$stmt = $this->conn->prepare( $query );

		// Limpiamos de Caracteres Especiales
		$this->username=htmlspecialchars(strip_tags($this->username));
		
		// Preparamos el Usuario
		$stmt->bindParam(1, $this->username);

		// Ejecutamos la consulta
		$stmt->execute();
		// Tomamos el numero de registros
		$num = $stmt->rowCount();

		// Si el Usuario Existe, asignar valor en los datos de sesión.
		if($num>0){

			// Asignamos los registros
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// Asignamos valores
			$this->id = $row['id'];
			$this->students_id = $row['students_id'];
			$this->password = $row['password'];

			// Retornamos "true" porque el Usuario existe en la base de datos
			return true;
		}

		// Retornamos "false" porque el Usuario no existe en la Base de Datos.
		return false;
	}
 
	// update a user record
	public function update(){

		// if password needs to be updated
		$password_set=!empty($this->password) ? ", password = :password" : "";

		// if no posted password, do not update the password
		$query = "UPDATE " . $this->table_name . "
				SET
					firstname = :firstname,
					lastname = :lastname,
					email = :email,
					username = :username
					{$password_set}
				WHERE id = :id";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->username=htmlspecialchars(strip_tags($this->username));

		// bind the values from the form
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':username', $this->username);

		// hash the password before saving to database
		if(!empty($this->password)){
			$this->password=htmlspecialchars(strip_tags($this->password));
			$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password_hash);
		}

		// unique ID of record to be edited
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}

		return false;
	}
	// update token
	public function UpdateToken($jwt, $student_id){

		
		// if no posted password, do not update the password
		$query = "UPDATE " . $this->table_name . " SET token = :jwt WHERE student_id = :student_id";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// bind the values from the form
		$stmt->bindParam(':jwt', $jwt);
		$stmt->bindParam(':student_id', $student_id);
		
		// execute the query
		if($stmt->execute()){
			return true;
		}

		return false;
	}
	
	public function userslist(){
		// if no posted password, do not update the password
		$query = "SELECT * FROM $this->table_name ORDER BY id DESC";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->username=htmlspecialchars(strip_tags($this->username));

		// bind the values from the form
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':username', $this->username);
		
		
			return $stmt -> fetchAll();

	}
}