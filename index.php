<?php
try {
	$pdo = new PDO("mysql:dbname=projeto_filtrotabela;host=localhost", "mateus", "");
} catch(PDOException $e) {
	echo "Erro: ".$e->getMessage();
	exit;
}
if(isset($_POST['sexo']) && $_POST['sexo'] != "") {
	$sexo = $_POST['sexo'];
	$sql = $pdo->prepare("SELECT * FROM usuarios WHERE sexo = :sexo");
	$sql->bindValue(":sexo", $sexo);
	$sql->execute();
} else {
	$sexo = "";
	$sql = $pdo->query("SELECT * FROM usuarios");
	$sql->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container">
<form method="POST">
	<div class="form-group" style="display:flex;">
		<select class="form-control" name="sexo">
			<option></option>
			<option value="0" <?php echo ($sexo == '0')?"selected='selected'":""; ?>>Masculino</option>
			<option value="1" <?php echo ($sexo == '1')?"selected='selected'":""; ?>>Feminino</option>
		</select>
		<button type="submit" class="btn btn-primary mb-2">Filtrar</button>
	</div>
</form>
<table class="table table-bordered text-center">
	<thead>
		<tr>
			<th>Nome</th>
			<th>Sexo</th>
			<th>Idade</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sexos = array(
		'0' => 'Masculino',
		'1' => 'Feminino'
	);

	if(isset($_POST['sexo']) && $_POST['sexo'] != "") {
		$sexo = $_POST['sexo'];
		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE sexo = :sexo");
		$sql->bindValue(":sexo", $sexo);
		$sql->execute();
	} else {
		$sql = $pdo->query("SELECT * FROM usuarios");
		$sql->execute();
	}

	if($sql->rowCount() > 0) {
		foreach($sql->fetchAll() as $usuario):
		?>
		<tr>
			<td><?php echo $usuario['nome']; ?></td>
			<td><?php echo $sexos[$usuario['sexo']]; ?></td>
			<td><?php echo $usuario['idade']; ?></td>
		</tr>
		<?php
		endforeach;
	}
	?>
	</tbody>
</table>
</div>










<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>