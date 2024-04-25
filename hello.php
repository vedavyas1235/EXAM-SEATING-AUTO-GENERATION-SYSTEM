<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seating Arrangement</title>
</head>
<body>
    <h1>Seating Arrangement</h1>
    <form action="" method="post">
        <label for="num_departments">Number of Departments:</label>
        <input type="text" id="num_departments" name="num_departments" required><br><br>

        <!-- Add input fields for department details -->
        <div id="department_fields"></div>
        <button type="button" onclick="addDepartmentField()">Add Department</button><br><br>

        <label for="num_rooms">Number of Rooms:</label>
        <input type="text" id="num_rooms" name="num_rooms" required><br><br>

        <label for="max_students_per_room">Maximum Students per Room:</label>
        <input type="text" id="max_students_per_room" name="max_students_per_room" required><br><br>

        <input type="submit" value="Generate Seating Arrangement">
    </form>

    <script>
        function addDepartmentField() {
            var numDepartments = document.getElementById("num_departments").value;
            var container = document.getElementById("department_fields");
            var html = "";
            for (var i = 1; i <= numDepartments; i++) {
                html += '<label for="dept_name_' + i + '">Department ' + i + ' Name:</label>';
                html += '<input type="text" id="dept_name_' + i + '" name="dept_names[]" required><br><br>';
                html += '<label for="start_roll_' + i + '">Starting Roll Number:</label>';
                html += '<input type="text" id="start_roll_' + i + '" name="start_rolls[]" required><br><br>';
                html += '<label for="end_roll_' + i + '">Ending Roll Number:</label>';
                html += '<input type="text" id="end_roll_' + i + '" name="end_rolls[]" required><br><br>';
            }
            container.innerHTML = html;
        }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve input values from the form
        $num_departments = intval($_POST["num_departments"]);
        $dept_names = $_POST["dept_names"];
        $start_rolls = $_POST["start_rolls"];
        $end_rolls = $_POST["end_rolls"];
        $num_rooms = intval($_POST["num_rooms"]);
        $max_students_per_room = intval($_POST["max_students_per_room"]);

        // Generate Python command
        $cmd = "python3 helloo.py $num_departments";
        foreach ($dept_names as $i => $dept_name) {
            $cmd .= " \"$dept_name\" " . intval($start_rolls[$i]) . " " . intval($end_rolls[$i]);
        }
        $cmd .= " $num_rooms $max_students_per_room";

        // Execute Python script with input values
        $output = shell_exec($cmd);

        // Output the result
        echo "<pre>$output</pre>";
    }
    ?>
</body>
</html>
