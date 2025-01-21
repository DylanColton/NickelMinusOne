<?php
require("{$_SERVER['DOCUMENT_ROOT']}/php/globals.php");
?>

<!DOCTYPE html>
<html lang=<?php echo $lang; ?>>
	<head>
		<?php include("$doc_root$static_loc/head.phtml"); ?>
		<script src="/js/janny_tools.js"></script>

		<style>
			/* General Table Container Styling */
			.table-container {
			}

			/* Table Styling */
			.dbms-table {
				width: 100%;
				border-collapse: collapse;
				font-family: Arial, sans-serif;
				font-size: 16px;
				color: #333;
			}

			/* Table Header Styling */
			.dbms-table thead {
				background-color: #007BFF;
				color: white;
				text-align: left;
			}

			.dbms-table th {
				padding: 10px 15px;
				text-transform: uppercase;
				font-weight: bold;
			}

			/* Table Row and Cell Styling */
			.dbms-table td {
				padding: 10px 15px;
				border-bottom: 1px solid #ddd;
				text-align: left;
			}

			/* Alternating Row Colors */
			.dbms-table tbody tr:nth-child(even) {
				background-color: #f2f2f2;
			}

			/* Hover Effect for Rows */
			.dbms-table tbody tr:hover {
				background-color: #e9f5ff;
			}

			/* Status Column Customization */
			.dbms-table td:nth-child(5) {
				font-weight: bold;
			}

			.dbms-table td:nth-child(5):contains("Active") {
				color: green;
			}

			.dbms-table td:nth-child(5):contains("Inactive") {
				color: red;
			}

			/* Responsive Design */
			@media (max-width: 600px) {
				.dbms-table {
					font-size: 14px;
				}

				.dbms-table th,
				.dbms-table td {
					padding: 8px;
				}
			}

			#query-form {
				width		: calc(100vw - 40px);
				min-height	: 300px;
				height		: auto;
				padding		: 40px;
			}

			.table-columns {
				width	: fit-content;
				height	: fit-content;
			}
		</style>
	</head>

	<body>
		<?php
			$conn = mysqli_connect(SERVER, USER, PSWD, DATABASE);

			$Tables = mysqli_query($conn, "SHOW TABLES")->fetch_all();

			echo "<div id=query-form>";
				echo "<form id=query>";
					echo "<select name=\"table\">";
						foreach ($Tables as $table)
							echo "<option value=\"{$table[0]}\"".($table[0] == "Board" ? ' selected' : "").">{$table[0]}</option>";
					echo "</select>";

					echo "<input type=submit onclick=fetchQuery(event)>";
				echo "</form>";
			echo "</div>";

			$columns	= mysqli_query($conn, "SHOW COLUMNS FROM Board;")->fetch_all();
			$threads	= mysqli_query($conn, "SELECT * FROM Board")->fetch_all();

			echo "<div class=table-container>";
				echo "<table class=dbms-table>";
					echo "<thead>";
						echo "<tr>";
							foreach ($columns as $column)
								echo "<th>{$column[0]}</th>";
						echo "</tr>";
					echo "</thead>";

					echo "<tbody>";
						foreach ($threads as $thread) {
							echo "<tr>";
							foreach($thread as $item)
								echo "<td>$item</td>";
							echo "</tr>";
						}
					echo "</tbody>";
				echo "</table>";
			echo "</div>";
		?>
	</body>
</html>
