<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        caption {
            font-size: 1.2em;
            margin: 10px;
        }
        form {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px;
        }
        input[type="submit"], input[type="reset"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    
    <?php
    // Database connection
    include "db_conn.php";
    
    // Add Student
    if(isset($_POST['btnAdd'])) {
        $Rollno = $_POST['Rollno'];
        $Sname = $_POST['Sname'];
        $Address = $_POST['Address'];
        $Email = $_POST['Email'];
        if($Rollno=="" || $Sname=="" || $Address=="" || $Email=="") {
            echo "(*) Fields cannot be empty";
        } else {
            $sql = "SELECT Rollno FROM students WHERE Rollno='$Rollno'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==0) {
                $sql = "INSERT INTO students VALUES ('$Rollno', '$Sname', '$Address', '$Email')";
                mysqli_query($conn,$sql);
                echo '<meta http-equiv="refresh" content="0; URL=StudentList.php">';
            } else {
                echo "Student already exists";
            }
        }
    }

    // Delete Student
    if(isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];
        $sql = "DELETE FROM students WHERE Rollno='$id'";
        if(mysqli_query($conn, $sql)) {
            header("Location: StudentList.php");
            exit();
        } else {
            echo "<h2>Error deleting record:</h2><p class='error-message'>" . mysqli_error($conn) . "</p>";
        }
    }
    ?>

    <!-- Student List Table -->
    <table>
        <caption>Student List</caption>
        <tr>
            <th>Rollno</th>
            <th>Student Fullname</th>
            <th>Address</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        
        $sql = "SELECT * FROM students";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        ?>
            <tr>
                <td><?php echo $row['Rollno']; ?></td>
                <td><?php echo $row['Sname']; ?></td>
                <td><?php echo $row['Address']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td><a href="edit_student.php?id=<?php echo $row['Rollno']; ?>">Edit</a></td>
                <td><a href="?delete_id=<?php echo $row['Rollno']; ?>">Delete</a></td>
            </tr>
        <?php } ?>
    </table>


    <!-- Add Student Form -->
    <form method="post">
        <table>
            <caption><b>Add Student</b></caption>
            <tr>
                <td>Rollno</td>
                <td><input type="text" name="Rollno"/> </td>
            </tr>
            <tr>
                <td>Student Name</td>
                <td><input type="text" name="Sname"/> </td>
            </tr>
            <tr>
                <td>Student Address</td>
                <td><input type="text" name="Address"/> </td>
            </tr>
            <tr>
                <td>Student Email</td>
                <td><input type="text" name="Email"/> </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Add" name="btnAdd"/>
                    <input type="reset" value="Cancel" name="btnCancel"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>