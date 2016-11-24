<?php

//need to fix normalizeName()
include_once('bootstrap.php');
include_once('partials/header.php');

$tables = $registry->listTables();

if(isset($_POST)) {
	if(isset($_POST['table_name'])) {
		$table = $registry->getNewTable();
		$table->observe('label', $_POST['table_name']);
		$table->observe('name', $registry->normalizeName($_POST['table_name']));
		if($registry->saveTable($table)) {
			echo '<p class="alert">table registered!</p>';
		}
		else {
			echo '<p>there was an error registering the table.</p>';
		}
	}
	elseif(isset($_POST['delete'])) {
		$table = $registry->getTable($_POST['delete']);
		if($registry->deleteTable($table)) {
			echo '<p class="alert">table deleted!</p>';
		}
	}
}


?>

<div class="highlight">

	<h3>Add a table:</h3>
	<form action="" method="POST">		
			Table name: <input type="text" name="table_name" placeholder="table name" />
			<input type="submit" value="Create" />
	</form>
</div>

<?php

$registeredTables = $registry->listTables();

if(count($registeredTables) == 0) {
	echo "no tables created yet.";
}
?>
<table>
	<thead>
		<tr>
			<td>Table</td>
			<td>Fields</td>
			<td>Access rules</td>
			<td>Rows</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
<?php
foreach($registeredTables as $reg):
	$mgr = $registry->getTableManager($reg->getId());
	$fields = $mgr->getFields();
	$access = $mgr->getAccess();
	$rows = $mgr->select();
	
?>
		<tr>
			<td>
				<?php echo $reg->getLabel(); ?>
			</td>
			<td>
				<a href="fields.php?id=<?php echo $reg->getId(); ?>"><?php echo count($fields); ?></a>
			</td>
			<td>
				<a href="access.php?id=<?php echo $reg->getId(); ?>"><?php echo count($access); ?></a>
			</td>
			<td>
				<a href="rows.php?id=<?php echo $reg->getId(); ?>"><?php echo count($rows); ?></a>
			</td>
			<td>
				<form action="" method="POST" class="inline"><input type="hidden" name="delete" value="<?php echo $reg->getId(); ?>" /><input type="submit" value="Delete" /></form>
			</td>
		</tr>
<?php endforeach; ?>

<?php include('partials/footer.php'); ?>