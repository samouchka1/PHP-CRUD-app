<?php
require "config.php";

// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";
    } elseif(!filter_var($input_address, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $address_err = "Please enter a valid address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount."; 
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer. No commas.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (:name, :address, :salary)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":address", $param_address);
            $stmt->bindParam(":salary", $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}

?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Create Record</title>

     <!--Tailwind CSS -->
     <script src="https://cdn.tailwindcss.com"></script>

 </head>

<body>
    <div class="font-bold text-lg text-center mt-6">Add employee</div>
    <div class="w-full md:w-3/5 lg:w-2/5 border-solid border-2 text-left mx-auto my-10">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="text-left flex flex-col gap-3 pl-20">
            <label class="mx-4 font-bold">Name</label>
                <input type="text" name="name" class="w-3/4 mx-4  border-solid border-2" value="<?php echo $name; ?>">
                    <span class="text-sm ml-5 text-red-500"><?php echo $name_err; ?></span>
            <label class="mx-4 font-bold">Address</label>
                <textarea name="address" class="w-3/4 mx-4  border-solid border-2" rows="2" value="<?php echo $address; ?>"></textarea>
                    <span class="text-sm ml-5 text-red-500"><?php echo $address_err; ?></span>
            <label class="mx-4 font-bold">Salary</label>
                <input type="text" name="salary" class="w-3/4 mx-4  border-solid border-2" value="<?php echo $salary; ?>">
                    <span class="text-sm ml-5 text-red-500"><?php echo $salary_err; ?></span>
            <div class="flex mx-4 mt-2 gap-3">
                <button type="submit" class="border-solid border-2 border-neutral-900 w-20 mr-2 bg-gray-300 hover:bg-neutral-100" value="Submit">Submit</button>
                <a href="index.php"><button id="goBack" class="border-solid border-2 border-neutral-900 w-20 mr-2 bg-gray-300 hover:bg-neutral-100">Cancel</button></a>
            </div>
        </form>
    </div>
    <script>document.getElementById('goBack').addEventListener('click', function() {history.back();})</script>
</body>
</html>