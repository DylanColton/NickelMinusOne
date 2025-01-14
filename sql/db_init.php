<?php
DEFINE("SERVER", "localhost");
DEFINE("USER", "www-data");
DEFINE("PSWD", '$fourCentG4rb4ge');
//DEFINE("DATABASE", "nickelminusone");
DEFINE("DATABASE", "nmo");
// Tables
DEFINE("THREADS", "Thread");
DEFINE("REPORTS", "Report");
DEFINE("BOARDS", "Board");
DEFINE("MEDIA", "Media");
DEFINE("POSTS", "Post");
DEFINE("REFER", "Reference");
DEFINE("JANNY", "Janny");

try {
	$conn = mysqli_connect(SERVER, USER, PSWD);

	if (!$conn)
		die("Connection failed: ".mysqli_connect_error());
} catch(Exception $e) {
	die("Connection Error - $e - MySQLi error: (".mysqli_connect_errno().") ".mysqli_connect_error());
}

try {
	$dbs = mysqli_query($conn, "SHOW DATABASES")->fetch_all();
	for ($i = 0; $i < count($dbs); $i++)
		$dbs[$i] = $dbs[$i][0];

	if (!mysqli_query($conn, "CREATE DATABASE ".DATABASE))
		die ("Error creating Database ".DATABASE);
} catch (Exception $e) {
	if (!in_array(DATABASE, $dbs))
		echo "Database ".DATABASE." doesn't exist. Exception occurred - $e";
}

if (!mysqli_query($conn, "USE ".DATABASE))
	die("Couldn't change databse to ".DATABASE);

$Tables = mysqli_query($conn, "SHOW TABLES")->fetch_all();
for ($i = 0; $i < count($Tables); $i++)
	$Tables[$i] = $Tables[$i][0];

try {
	if (in_array(BOARDS, $Tables))
		goto boards_exist;

	$sql = "
		CREATE TABLE ".BOARDS." (
			BoardName	VARCHAR(4)		NOT NULL,
			BoardDesc	VARCHAR(255)	NOT NULL,
			PRIMARY KEY (BoardName)
		)";
	if (!mysqli_query($conn, $sql))
		die("Could not create ".BOARDS." ".mysqli_error($conn));
} catch (Exception $e) {
	die("Could not create ".BOARDS." - $e");
}
boards_exist:

try {
	if (in_array(MEDIA, $Tables))
		goto media_exists;

	$sql = "
		CREATE TABLE ".MEDIA." (
			MediaID		INT				UNSIGNED	NOT NULL	AUTO_INCREMENT,
			MediaName	VARCHAR(255)				NOT NULL,
			Type		VARCHAR(4)					NOT NULL,
			Size		INT				UNSIGNED	NOT NULL,
			Dim			VARCHAR(9)					NOT NULL,
			PRIMARY KEY (MediaID)
		)";
	if (!mysqli_query($conn, $sql))
		die("Could not make table ".MEDIA." ".mysqli_error($conn));
} catch (Exception $e) {
	die("Could not make table ".MEDIA." - $e");
}
media_exists:

try {
	if (in_array(POSTS, $Tables))
		goto posts_exists;

	$sql = "
		CREATE TABLE ".POSTS." (
			PostID		INT				UNSIGNED	NOT NULL	AUTO_INCREMENT,
			Type		BOOL						NOT NULL,
			ThreadID	INT				UNSIGNED	NOT NULL,
			Title		VARCHAR(100),
			Name		VARCHAR(20),
			PostTime	TIMESTAMP					NOT NULL,
			Media		INT,
			Message		TEXT(60000)					NOT NULL,
			PRIMARY KEY (PostID,
			FOREIGN KEY (Media) REFERENCES ".MEDIA."(MediaID),
			FOREIGN KEY (ThreadID) REFERENCEE ".THREADS."(ThreadNo)
		)";

	if (!mysqli_query($conn, $sql))
		die("Could not make table ".POSTS." - ".mysqli_error($conn));
} catch (Exception $e) {
	die("Could not make table ".POSTS." - $e");
}
posts_exists:

try {
	if (in_array(REFER, $Tables))
		goto refer_exists;

	$sql = "
		CREATE TABLE ".REFER." (
			Referer		INT	UNSIGNED	NOT NULL,
			Reference	INT	UNSIGNED	NOT NULL,
			FOREIGN KEY (Referer) REFERENCES ".POSTS."(PostID),
			FOREIGN KEY (Reference) REFERENCES ".POSTS."(PostID),
		)";

	if (!mysqli_query($conn, $sql))
		die("Could not make table ".REFER." - $e");
} catch (Exception $e) {
	die("Could not make table ".REFER." - $e");
}
refer_exists:

try {
	if (in_array(THREADS, $Tables))
		goto threads_exists;

	$sql = "
		CREATE TABLE ".THREADS." (
			ThreadNo		INT			UNSIGNED	NOT NULL,
			Board			VARCHAR(4)				NOT NULL,
			LastUpdate		TIMESTAMP				NOT NULL,
			PruneOrDeleted	BOOLEAN					NOT NULL,
			PRIMARY KEY(ThreadNo),
			FOREIGN KEY(ThreadNo)	REFERENCES ".POSTS."(PostID)
			FOREIGN KEY(Board)		REFERENCES ".BOARDS."(BoardName)
		)";
	if (!mysqli_query($conn, $sql)) {
		die("Could not make table ".THREADS." ".mysqli_error($conn));
	}
} catch (Exception $e) {
	die("Could not create ".THREADS." - $e");
}
threads_exists:

try {
	if (in_array(JANNY, $Tables))
		goto janny_exists;
} catch (Exception $e) {
	die("Could not create ".JANNY." - $e");
}
janny_exists:

mysqli_close($conn);
?>
