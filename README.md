# API REST KNOWLEDGECITY

## Dependencies

* PHP7+
* MySQL
* Apache

## Installation

1. Descargar el Codigo del Repositorio siguiente : https://github.com/civancorral/knowledgecity.git.
2. Descomprima la carpeta en el directorio 'D:\xampp\htdocs\' (en mi caso utilizo xampp).
3. Crea una base de datos en mi caso se genero uno con el nombre "knowledgecity".
4. Dentro de la carpeta "api/config", abrimos el archivo database.php y modificamos los siguientes valores:
	private $host = "localhost";
	private $db_name = "base de datos";
	private $username = "usuario";
	private $password = "contraseña";
	
En mi caso estos son los datos:
	private $host = "localhost";
	private $db_name = "knowledgecity";
	private $username = "root";
	private $password = "";


5. importe el archivo sql en nueva base de datos.

