<?php
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'tyl-db', 'bcNSksIVefQbSoYQ', 'tyl-db');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

//gets all the videos in the table
function getVideos($mysqli) {
    return $mysqli->query("SELECT * FROM Video;");
}

//adds to the table
function addVideo($name, $category, $length, $mysqli) {
    if (empty($length)) $length = 0;
    return $mysqli->query("INSERT INTO Video (name, category, length) VALUES ('$name', '$category', $length);");
}

//deletes a video from the table
function deleteVideo($id, $mysqli) {
    return $mysqli->query("DELETE FROM Video WHERE id=$id LIMIT 1;");
}

//delete all videos
function deleteAll($mysqli) {
    return $mysqli->query("DELETE FROM Video;");
}

//rents a video
function rentVideo($id, $mysqli) {
    return $mysqli->query("UPDATE Video set rented=1 where id=$id LIMIT 1;");
}

//returns a video
function returnVideo($id, $mysqli) {
    return $mysqli->query("UPDATE Video set rented=0 where id=$id LIMIT 1;");
}

//Categories list
function getCategory($mysqli) {
    return $mysqli->query("SELECT DISTINCT category FROM Video WHERE category != '';");
}

//Filter list
function filter($mycategory, $mysqli) {
	if ($mycategory == "all") {
		return $mysqli->query("SELECT * FROM Video;");
	}
	else {
		return $mysqli->query("SELECT * FROM Video WHERE category = '$mycategory';");
	}
}
?>