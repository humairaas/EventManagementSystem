<?php
require_once 'utils/functions.php';
require_once 'classes/User.php';
require_once 'classes/Location.php';
require_once 'classes/LocationTableGateway.php';
require_once 'classes/Connection.php';

$connection = Connection::getInstance();
$gateway = new LocationTableGateway($connection);

$statement = $gateway->getLocations();

start_session();

if (!is_logged_in()) {
    header("Location: login_form.php");
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <?php require 'utils/styles.php'; ?>
        <?php require 'utils/scripts.php'; ?>
    </head>
    <body>
        <?php require 'utils/header.php'; ?>
        <div class = "content">
            <div class = "container">
                <?php 
                if (isset($message)) {
                    echo '<p>'.$message.'</p>';
                }
                ?>
                <h3>Location List</h3>
                <table class ="table table-hover">
                    <thead>
                        <tr>
                            <!--table label-->
                            <!--this will only show the detail of a location with specific ID chosen by the user-->
                            <th>No</th>
                            <th>Name</th>
                            <th>Address</th>                    
                            <th>Manager First Name</th>
                            <th>Manager Last Name</th>
                            <th>Manager Email</th>
                            <th>Manager Number</th>
                            <th>Max Capacity</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--table contents-->
                        <?php
                        $row = $statement->fetch(PDO::FETCH_ASSOC);
                        $count = 1;
                        while ($row) {
                            echo '<tr>';
                            echo '<td>' . $count . '</td>';
                            echo '<td>' . $row['Name'] . '</td>';
                            echo '<td>' . $row['Address'] . '</td>';                    
                            echo '<td>' . $row['ManagerFName'] . '</td>';
                            echo '<td>' . $row['ManagerLName'] . '</td>';
                            echo '<td>' . $row['ManagerEmail'] . '</td>';
                            echo '<td>' . $row['ManagerNumber'] . '</td>';
                            echo '<td>' . $row['MaxCapacity'] . '</td>';
                            echo '<td>'
                            . '<a href="editLocationForm.php?id='.$row['LocationID'].'"><span class="glyphicon glyphicon-pencil mr-2"></a> '
                            . '<a href="deleteLocation.php?id='.$row['LocationID'].'"><span class="glyphicon glyphicon-trash mr-2""></a> '
                            . '<a href="viewLocation.php?id='.$row['LocationID'].'">View Event</a> '
                            . '</td>';
                            echo '</tr>';  

                            $count++;
                            $row = $statement->fetch(PDO::FETCH_ASSOC);
                        }
                        ?>
                    </tbody>
                </table>
                <a class="btn btn-default" href="createLocationForm.php">Create Location</a>
            </div>
        </div>
        <?php require 'utils/footer.php'; ?>
    </body>
</html>
