<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM employees WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
//TEST for READ
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    

//================================================================================MIGHT BE ABLE TO SPLIT THIS
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
}
//===========================================================================================================
//TEST for READ
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
    
    <!--Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="font-bold text-lg text-center mt-6">Delete employee data</div>
    <!--TEST for READ-->
    <div class="w-full md:w-3/5 lg:w-2/5 border-solid border-2 text-left mx-auto my-10">
        <div class="text-left flex flex-col gap-3 pl-20">
            <label class="font-bold">Name</label>
                <p><?php echo $row["name"]; ?></p>
            <label class="font-bold">Address</label>
                <p><?php echo $row["address"]; ?></p>
            <label class="font-bold">Salary</label>
                <p>$<?php echo number_format($row["salary"]); ?></p>
        </div>
    <!-- </div> -->
    <!--TEST for READ-->
    <!-- <div class="w-2/5 border-solid border-2 text-left mx-auto my-6">  TEST-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="text-left flex flex-col gap-3 pl-20">
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <p class="mt-10 text-red-500">Are you sure you want to delete this employee record?</p>
                
            <div class="flex mt-2 gap-3">
                <!-- <input type="hidden" name="id" value="<?php echo $id; ?>"/> -->
                <button type="submit" class="border-solid border-2 border-neutral-900 w-20 mr-2 bg-gray-300 hover:bg-neutral-100" value="yes">Delete</button>
                <a href="index.php"><button id="goBack" class="border-solid border-2 border-neutral-900 w-20 mr-2 bg-gray-300 hover:bg-neutral-100">Cancel</button></a>
            </div>
        </form>
    </div> <!--<<<<-->
    <script>document.getElementById('goBack').addEventListener('click', function() {history.back();})</script>
</body>
</html>