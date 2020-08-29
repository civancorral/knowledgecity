<?php
// Objeto 'Student'
class Student{
 
    // Conectamos con la Base de Datos y Cargamos la Tabla.
    private $conn;
    private $table_name = "students";
 
    //Las Propiedades del Objeto
    public $id;
    public $firstname;
    public $lastname;
    public $email;
 
    //Constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
	// Metodo create(): Crear Nuevo Registro de Usuario
	public function create(){
		
		
		//Insertar Registro
		$query = "INSERT INTO " . $this->table_name . " SET firstname = :firstname, lastname = :lastname, email = :email";

		// Preparamos la Consulta
		$stmt = $this->conn->prepare($query);

		// Limpiamos de Caracteres Especiales
		$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		

		// Preparamos Valores
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':email', $this->email);
		
		// Ejecutar la consulta, también verifique si la consulta fue exitosa
		if($stmt->execute()){
			return true;
		}

		return false;
	}
 	//Función para sacar el ultimo registro.
	public function last_record(){
		// Consulta para verificar Usuario
		$query = "SELECT MAX(id) FROM " . $this->table_name;
		
		// Preparamos la Consulta
		$stmt = $this->conn->prepare( $query );

		// Ejecutamos la consulta
		$stmt->execute();
		// Tomamos el numero de registros
		$num = $stmt->rowCount();
		
		// Si el Usuario Existe, asignar valor en los datos de sesión.
		if($num>0){

			// Asignamos los registros
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// Asignamos valores
			$this->id = $row['MAX(id)'];
			
			// Retornamos "true" porque el Usuario existe en la base de datos
			return $this->id;
		}

		// Retornamos "false" porque el Usuario no existe en la Base de Datos.
		return false;
		
	}
	//Metodo usernameExists verificamos si el Usuario existe en nuestra Base de Datos.
	public function usernameExists(){

		// Consulta para verificar Usuario
		$query = "SELECT id, firstname, lastname, email, password FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
		
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
			$this->firstname = $row['firstname'];
			$this->lastname = $row['lastname'];
			$this->email = $row['email'];
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
	
	public function userslist(){
		
		$stmt =  $this->conn->prepare("SELECT * FROM $this->table_name ORDER BY id DESC");
		$stmt -> execute();
		return $stmt -> fetchAll();

		//$row = $stmt -> fetchAll();
		//echo count($stmt -> fetchAll());
		//return $row;
		$stmt -> close();
		
		$stmt = null;

	}	
	public function userslistLimit($limit){
		
		$stmt =  $this->conn->prepare("SELECT * FROM $this->table_name $limit");
		//var_dump("SELECT * FROM $this->table_name $limit");
		$stmt -> execute();
		
		return $stmt -> fetchAll();

		//$row = $stmt -> fetchAll();
		//echo count($stmt -> fetchAll());
		//return $row;
		$stmt -> close();
		
		$stmt = null;

	}
	
	function paginate($reload, $page, $tpages, $adjacents) {
	$prevlabel = "&lsaquo; Anterior";
	$nextlabel = "Siguiente &rsaquo;";
	$out = '<ul class="pagination justify-content-center">';
	
	// previous label

	if($page==1) {
		$out.= "<li class='page-item disabled'><span><a class='page-link' tabindex='-1'>$prevlabel</a></span></li>";
	} else if($page==2) {
		$out.= "<li class='page-item'><span><a href='javascript:void(0);' class='page-link' id='load' page='1'>$prevlabel</a></span></li>";
	}else {
		$prevpage=$page-1;
		$out.= "<li class='page-item'><span><a href='javascript:void(0);'  class='page-link'  id='load' page='$prevpage'>$prevlabel</a></span></li>";

	}
	
	// first label
	if($page>($adjacents+1)) {
		$out.= "<li class='page-item'><a href='javascript:void(0);'  class='page-link' id='load' page='1'>1</a></li>";
	}
	// interval
	if($page>($adjacents+2)) {
		$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
	}

	// pages

	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<li class='page-item active'><a class='page-link'>$i</a></li>";
		}else if($i==1) {
			$out.= "<li class='page-item'><a href='javascript:void(0);' class='page-link' id='load' page='$i'>$i</a></li>";
		}else {
			$out.= "<li class='page-item'><a href='javascript:void(0);' class='page-link' id='load' page='$i'>$i</a></li>";
		}
	}

	// interval

	if($page<($tpages-$adjacents-1)) {
		$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
	}

	// last

	if($page<($tpages-$adjacents)) {
		$out.= "<li class='page-item'><a href='javascript:void(0);' class='page-link' id='load' page='$tpages'>$tpages</a></li>";
	}

	// next

	if($page<$tpages) {
		$nextpage=$page+1;
		$out.= "<li class='page-item'><span><a href='javascript:void(0);' class='page-link' id='load' page='$nextpage'>$nextlabel</a></span></li>";
	}else {
		$out.= "<li class='page-item disabled'><span><a class='page-link'>$nextlabel</a></span></li>";
	}
	
	$out.= "</ul>";
	return $out;
}

}