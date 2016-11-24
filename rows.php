<?php
include_once('bootstrap.php');
include_once('partials/header.php');


if(!isset($_GET['id'])) die('no ID given');

$id = $_GET['id'];
$table = $registry->getTable($id);
$mgr = $registry->getTableManager($id);
	

if(isset($_POST)) {
	
	if(isset($_POST['create_row'])) {
		$row = $mgr->getNewRow();
		$row->setData($_POST);
		if($mgr->save($row)) {
			echo '<p class="alert">Row added!</p>';
		}
		else {
			echo '<p class="alert">Error adding row!</p>';
		}
	}
	
	if(isset($_POST['delete_row'])) {
		if($row = $mgr->findById($_POST['delete_row'])) {
			if($mgr->delete($row)) {
				echo '<p class="alert">Row deleted!</p>';
			}
			else {
				echo '<p class="alert">Error deleting row!</p>';
			}
		}
	}
}

//re-construct the TableManager in case of POSTs
$mgr = $registry->getTableManager($id);
$fields = $mgr->getFields();

?>

<h2><?php echo $table->getLabel(); ?></h2>

<div class="highlight">
	<h3>Add a row</h3>
	<form action="" method="POST">
	<table>
<?php foreach($fields as $field): ?>
		<tr>
			<td><?php echo $field->getLabel(); ?></td>
			<td><input type="text" name="<?php echo $field->getName(); ?>" /></td>
		</tr>
<?php endforeach; ?>
	</table>
		<input type="submit" name="create_row" value="Add" />
	</form>
</div>
<?php

$rows = $mgr->select();
	
if(count($rows) == 0) {
	echo "<p>no rows exist yet.</p>";
}
/*

*/
?>

<?php foreach($rows as $row): ?>
	<div class="listing">
		<?php $data = $row->getData(); print_r($data); ?>
		<form class="inline" action="" method="POST"><input type="hidden" name="delete_row" value="<?php echo $row->getId(); ?>" /><input type="submit" value="Delete" /></form>	
	</div>
<?php endforeach; ?>

<?php include('partials/footer.php'); ?>
