<?php
// Los Archivos que necesitamos para conectar
include_once 'config/database.php';
include_once 'objects/students.php';


// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
 
// Instanciar objeto de producto
$student = new Student($db);

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		//include 'pagination.php'; //incluir el archivo de paginación
		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		//Cuenta el número total de filas de la tabla*/
		//$count_query   = mysqli_query($con,"SELECT count(*) AS numrows FROM countries ");
		$count_query   = count($student->userslist());
		if ($count_query>0){$numrows = $count_query;}
		$total_pages = ceil($numrows/$per_page);
		$reload = 'index.html';
		//consulta principal para recuperar los datos
		//$query = $student->userslist();
		$limit= "LIMIT $offset , $per_page";
		$query = $student->userslistLimit($limit);
		//$query = mysqli_query($con,"SELECT * FROM countries  order by countryName LIMIT $offset,$per_page");
		
		if ($numrows>0){
			?>
			
						<h3>User List</h3>
						<table class="table table-bordered">
							  <thead>
								<tr class="tb-header">
									<th scope="col"></th>
									<th scope="col"></th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($query as $key => $row) {
								?>
								<tr>
									<td><?php echo $row['firstname'];?></td>
									<td><?php echo $row['lastname'];?></td>
									<td><?php echo $row['email'];?></td>	
								</tr>
								<?php
							}
							?>
							</tbody>
						</table>
						
							<nav aria-label="...">
								<?php echo $student->paginate($reload, $page, $total_pages, $adjacents);?>
							</nav>
						
			<?php
			
		} else {
			?>
			<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
            </div>

			<?php
		}
	}
?>