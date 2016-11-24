<?php
include_once('bootstrap.php');
include_once('partials/header.php');


if(!isset($_GET['id'])) die('no ID given');

$id = $_GET['id'];
$table = $registry->getTable($id);
$mgr = $registry->getTableManager($id);

if(isset($_POST)) {
		
	if(isset($_POST['create_field'])) {
		
		$field = $registry->getNewField($id);
		$field->observe('fieldtype', 'string');
		$field->observe('label', $_POST['create_field']);
		$field->observe('name', $_POST['create_field']);
		if($registry->saveField($field)) {
			echo '<p class="alert">Field added!</p>';
		}
		else {
			echo '<p class="alert">Error adding field.</p>';
		}
	}
	
	if(isset($_POST['delete_field'])) {
		if($field = $registry->getField($_POST['delete_field'])) {
			if($registry->deleteField($field)) {
			echo '<p class="alert">Field deleted!</p>';
			}
			else {
				echo '<p class="alert">Error deleting field.</p>';
			}
		}
	}
	
}

//re-construct the TableManager in case of POSTs
$mgr = $registry->getTableManager($id);

?>
<h2><?php echo $table->getLabel(); ?></h2>
<div class="highlight">

	<h3>Add a field:</h3>
	<form action="" method="POST">
			Field name: <input type="text" name="create_field" placeholder="field name" />
			<input type="submit" value="Submit" />
	</form>
</div>
<?php
$fields = $mgr->getFields();
if(count($fields) == 0) {
	echo '<p>No fields exist yet.</p>';
}
foreach($fields as $field):
?>
<div class="listing">
	<?php echo $field->getLabel(); ?>
	<form action="" method="POST" class="inline"><input type="hidden" name="delete_field" value="<?php echo $field->getId(); ?>" /><input type="submit" value="Delete" /></form>
</div>
<?php endforeach; ?>

<?php include('partials/footer.php'); ?>
