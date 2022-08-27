<?php

include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Project</title>

    <!--Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="h-screen bg-gradient-to-br from-gray-100 to-blue-gray-300">

<section>
    <div class="font-bold text-2xl text-center mt-12">PHP CRUD Project</div>
        <div class="text-lg text-center mt-4">Members Information</div>
        <?php
        // Include config file
        require_once "config.php";

        // Attempt select query execution
        $sql = "SELECT * FROM employees";
        if($result = $pdo->query($sql)){
            if($result->rowCount() > 0){
                echo '<table class="w-full md:w-4/5 lg:w-3/5 border-solid border-2 text-xs md:text-base text-left mx-auto my-6 shadow-md shadow-neutral-400 py-6">';
                    echo "<thead>";
                        echo '<tr class="bg-gray-200 border-b-2 border-neutral-600">';
                            // echo "<th>#</th>";
                            echo "<th>Name</th>";
                            echo "<th>Address</th>";
                            echo "<th>Salary</th>";
                            echo "<th class=\"text-center md:text-left\">Action</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($row = $result->fetch()){
                        echo "<tr class=\"bg-stone-200 even:bg-gray-100\">";
                            // echo "<td>" . $row['id'] . "</td>";
                            echo "<td class=\"py-2\">" . $row['name'] . "</td>";
                            echo "<td class=\"py-2\">" . $row['address'] . "</td>";
                            echo "<td class=\"py-2\">$" . number_format($row['salary']) . "</td>";
                            echo "<td class=\"py-2 text-right md:text-left\">";  //NOTICE use of anchors href="read.php?id='. $row['id'] .'"
                                echo '<a href="read.php?id='. $row['id'] .'" class="mr-4 md:mr-6" title="View Record" data-toggle="tooltip"><span id="view-green" class="text-lg fa fa-eye text-green-900 hover:text-green-500"></span></a>';
                                echo '<a href="update.php?id='. $row['id'] .'" class="mr-4 md:mr-6" title="Update Record" data-toggle="tooltip"><span id="update-blue" class="text-lg fa fa-pencil text-blue-900 hover:text-blue-500"></span></a>';
                                echo '<a href="delete.php?id='. $row['id'] .'" class="mr-2 md:mr-0" title="Delete Record" data-toggle="tooltip"><span id="delete-red" class="text-lg fa fa-trash text-red-900 hover:text-red-600"></span></a>';
                            echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";                            
                echo "</table>";
                // Free result set
                unset($result);
            } else{
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close connection
        unset($pdo);
        ?>
</section>

    <div class="text-center">
        <a href="create.php">
            <button class="border-solid border-2 border-neutral-900 w-20 mr-2 bg-gray-300 hover:bg-neutral-100 m-4">
            Add
            </button>
        </a>
    </div>
    <p id="signature" class="text-xs md:text-sm text-right my-4 mr-2 md:mr-16 lg:mr-64">&copy;<script>document.write(new Date().getFullYear());</script> samouchka</p>
</body>
</html>