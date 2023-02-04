<?php
// Include config file
require_once  "config.php";

// Define variables and initialize with empty values
$emp_no = $birth_date = $first_name = $last_name = $gender = $hire_date = "";
$emp_no_err = $birth_date_err = $first_name_err = $last_name_err = $gender_err = $hire_date_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first_name
    $input_first_name = trim($_POST["first_name"]);
    if (empty($input_first_name)) {
        $first_name_err = "Please enter the first name.";
    } elseif (!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please enter a valid name.";
    } else {
        $first_name = $input_first_name;
    }

    // Validate last_name
    $input_last__name = trim($_POST["last_name"]);
    if (empty($input_last_name)) {
        $last_name_err = "Please enter the last name.";
    } elseif (!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $last_name_err = "Please enter a valid name.";
    } else {
        $last_name = $input_last_name;
    }

    // Validate gender
    $input_gender = trim($_POST["gender"]);
    if (empty($input_gender)) {
        $gender_err = "Please enter the gender.";
    } else {
        $gender = $input_gender;
    }

    // Hire date
    $input_hire_date = trim($_POST["hire_date"]);
    if (empty($input_hire_date)) {
        $hire_date_err = "Please enter the hire date.";
    } elseif (!ctype_digit($input_hire_date)) {
        $hire_date_err = "Please, enter a valid date value.";
    } else {
        $gender = $input_gender;
    }

    // Check input errors before inserting in database
    if(empty($emp_no_err) && empty($birth_date_err) && empty($first_name_err) & empty($last_name_err) && empty($gender_err) && empty($hire_date_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (emp_no, birth_date, first_name, last_name, gender, hire_date) VALUES
            (:emp_no, :birth_date, :first_name, :last_name, :gender, :hire_date)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":emp_no", $param_emp_no);
            $stmt->bindParam(":birth_date", $param_birth_date);
            $stmt->bindParam(":first_name", $param_first_name);
            $stmt->bindParam(":last_name", $param_last_name);
            $stmt->bindParam(":gender", $param_gender);
            $stmt->bindParam(":hire_date", $param_hire_date);

            // Set parameters
            $param_emp_no = $emp_no;
            $param_birth_date = $birth_date;
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_gender = $gender;
            $param_hire_date = $hire_date;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Ops! Something went wrong. Please try again later.";
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
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Create Record</h2>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Emp No</label>
                        <input type="text" name="emp_no" class="form-control <?php echo (!empty($emp_no_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $emp_no; ?>">
                        <span class="invalid-feedback"><?php echo $emp_no_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Birth Date</label>
                       <input type="date" id="birthday" name="birth_date">
                        <span class="invalid-feedback"><?php echo $birth_date_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                        <span class="invalid-feedback"><?php echo $first_name_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                        <span class="invalid-feedback"><?php echo $last_name_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <input type="text" name="gender" class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $gender; ?>">
                        <span class="invalid-feedback"><?php echo $gender_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Hire Date</label>
                        <input type="date" id="date" name="hire_date">
                        <span class="invalid-feedback"><?php echo $hire_date_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
