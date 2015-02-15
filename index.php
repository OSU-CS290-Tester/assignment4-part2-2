<?php
require('database.php');
//catches php post
if (array_key_exists('deleteAll', $_POST)) deleteAll($mysqli);
if (array_key_exists('deleteVideo', $_POST)) deleteVideo($_POST['deleteVideo'], $mysqli);
if (array_key_exists('returnVideo', $_POST)) checkOutVideo($_POST['returnVideo'], $mysqli);
if (array_key_exists('rentVideo', $_POST)) checkInVideo($_POST['rentVideo'], $mysqli);
if (array_key_exists('addVideo', $_POST)) {
    addVideo($_POST['name'], $_POST['category'], $_POST['length'], $mysqli);
}
$videos = getVideos($mysqli);
$categories = getCategories($mysqli);
if (array_key_exists('filterVideo', $_POST)) {
    foreach ($videos as $key => $video)
    {
        if ($video['category'] == $_POST['filter'])
            $newVideos = $videos[$key];
    }
    $videos = $newVideos;
    unset($newVideos);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CS290 - Video</title>
</head>
<body>
<div>
    <form action="index.php" method="POST">
        Name<input type="text" name="name" required>
        Category<input type="text" name="category">
        Length<input type="number" name="length" min=1>
        <input type="hidden" name="addVideo" value="true">
        <input type="submit" value="Add Video">
    </form>
<?php
    if (!empty($videos))
    {
        ?>

    <form action="index.php" method="POST">
        <input type="hidden" name="deleteAll" value="true">
        <input type="submit" value="Delete All Videos">
    </form>
    <?php
    }
?>
<?php
    if ($categories)
    {
        ?>
    <hr>
    <form action="index.php" method="POST">
        Category Filter:
        <select name="category">
        <?php
            foreach ($categories as $key => $value)
            {
                echo '<option value='. $value['category'] .'>'. $value['category'] .'</option>';
            }
        ?>
        </select>
        <input type="hidden" name="filterVideo" value="true">
        <input type="submit" value="Filter Videos">
    </form>
    <hr>
    <?php
    }
?>
</div>
<?php
if (!empty($videos))
{
    echo '<div><table>';
    echo '<tr><th>Name</th><th>Category</th><th>Length</th></tr>';
    foreach ($videos as $key => $video)
    {
        echo '<tr><td>' .
        $video['name'] .
        '</td><td>' .
        $video['category'] .
        '</td><td>';
        if ($video['length'] > 0) echo $video['length'];
        else echo '&nbsp;';
        echo '</td><td>';
        
        if ($video['rented'] == 1)
            echo '<form action="index.php" method="POST">
            <input type="hidden" name="returnVideo" value="' . $video['id'] . '">
            <input type="submit" value="Return Video">
            </form>';
			echo '<form action="index.php" method="POST">
            <input type="hidden" name="deleteVideo" value="' . $video['id'] . '">
            <input type="submit" value="Delete">
            </form>';
        else
            echo '<form action="index.php" method="POST">
            <input type="hidden" name="rentVideo" value="' . $video['id'] . '">
            <input type="submit" value="Rent Video">
            </form>';
			echo '<form action="index.php" method="POST">
            <input type="hidden" name="deleteVideo" value="' . $video['id'] . '">
            <input type="submit" value="Delete">
            </form>';
        
        echo '</td></tr>';
    }
    echo '</table></div>';
}
else
{
    echo '<b>There are no videos in the database.<b>';
}
?>
</body>
</html>