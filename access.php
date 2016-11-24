<?php
include_once('bootstrap.php');
include_once('partials/header.php');


if(!isset($_GET['id'])) die('no ID given');

$id = $_GET['id'];
$table = $registry->getTable($id);
$mgr = $registry->getTableManager($id);

if(isset($_POST)) {
		
	if(isset($_POST['access'])) {
		$access = $registry->getNewAccess($id);
		$accessor = !empty($_POST['accessor']) ? $_POST['accessor'] : '';
		$accessLevel = !empty($_POST['accessLevel']) ? $_POST['accessLevel'] : '';
		
		$access->observe('accessor', $accessor);
		$access->observe('accessLevel', $accessLevel);
		if($registry->saveAccess($access)) {
			echo '<p class="alert">Access rule added!</p>';
		}
		else {
			echo '<p class="alert">Error adding access rule.</p>';
		}
	}
	
	if(isset($_POST['delete_access'])) {
		if($access = $registry->getAccess($_POST['delete_access'])) {
			if($registry->deleteAccess($access)) {
			echo '<p class="alert">Access rule deleted!</p>';
			}
			else {
				echo '<p class="alert">Error deleting access rule.</p>';
			}
		}
	}
		
}

//re-construct the TableManager in case of POSTs
$mgr = $registry->getTableManager($id);
?>

<h2><?php echo $table->getLabel(); ?></h2>

<div class="highlight">
	<h3>Add an access rule:</h3>
	<form action="" method="POST">
		<table>
			<tr>
				<td>accessor</td>
				<td><input type="text" name="accessor" placeholder="accessor" /></td>
			</tr>
			<tr>
				<td>access level</td>
				<td><input type="text" name="accessLevel" placeholder="access level " /></td>

			</tr>
		</table>
		<input type="submit" name="access" value="submit" />
	</form>
	<div class="aside">
		<p class="aside">You can register access rules to restrict access to aspects of the system within your app.</p>
		<p>Your app supplies the logic; the Registry class contains methods to allow you to restrict listings based on access:</p>
		<ul>
			<li>$registry->accessTables($accessor, $accessLevel[, $conditions]);</li>
			<li>$registry->accessFields($accessor, $accessLevel[, $conditions]);</li>
		</ul>
	</div>
</div>

<?php
$rules = $mgr->getAccess();
if(count($rules) == 0) {
	echo '<p>No access rules exist yet.</p>';
}
foreach($rules as $rule):
?>
<div class="listing">
	<strong>Accessor</strong>: <?php echo $rule->getAccessor(); ?> <strong>Level</strong>: <?php echo $rule->getAccessLevel(); ?>
	<form action="" method="POST" class="inline"><input type="hidden" name="delete_access" value="<?php echo $rule->getId(); ?>" /><input type="submit" value="Delete" /></form>
</div>
<?php endforeach; ?>

<?php include('partials/footer.php'); ?>
