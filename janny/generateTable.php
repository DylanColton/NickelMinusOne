<?php
require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");
$conn = mysqli_connect(SERVER, USER, PSWD, DATABASE);

$table		= $_POST['table'];

$query		= mysqli_query($conn, "SELECT * FROM $table")->fetch_all();
$columns	= mysqli_query($conn, "SHOW COLUMNS FROM $table")->fetch_all();

echo "<table class=dbms-table>";
	echo "<thead>";
		echo "<tr>";
			foreach ($columns as $column)
				echo "<th>{$column[0]}</th>";
		echo "</tr>";
	echo "</thead>";

	echo "<tbody>";
		foreach ($query as $record) {
			echo "<tr>";
			foreach ($record as $item)
				echo "<td>$item</td>";
			echo "</tr>";
		}
	echo "</tbody>";
echo "</table>";
?>
