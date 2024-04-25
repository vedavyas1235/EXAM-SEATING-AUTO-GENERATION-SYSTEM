<?php
session_start();

// Function to generate seating arrangement
function generateSeatingArrangement($departments_roll_numbers, $num_rooms, $max_students_per_room)
{
    $total_students = 0;
    $seating_arrangement = [];

    // Calculate total number of students
    foreach ($departments_roll_numbers as $dept_name => $roll_range) {
        $total_students += $roll_range['end'] - $roll_range['start'] + 1;
    }

    // Generate seating arrangement
    $student_count = 1;
    $remaining_students_count = $total_students;

    for ($room = 1; $room <= $num_rooms; $room++) {
        $room_students = [];
        $remaining_capacity = $max_students_per_room;

        foreach ($departments_roll_numbers as $dept_name => $roll_range) {
            for ($roll = $roll_range['start']; $roll <= $roll_range['end']; $roll++) {
                $room_students[] = ['roll' => $roll, 'dept' => $dept_name];
            }
        }

        usort($room_students, function ($a, $b) {
            return $a['roll'] - $b['roll'];
        });

        foreach ($room_students as $student) {
            if ($student_count > $total_students || $remaining_capacity == 0) {
                break;
            }
            $seating_arrangement[] = ['room' => $room, 'roll' => $student['roll'], 'dept' => $student['dept']];
            $student_count++;
            $remaining_students_count--;
            $remaining_capacity--;
        }
    }

    return $seating_arrangement;
}

// Function to print seating arrangement
function printSeatingArrangement($seating_arrangement)
{
    if (empty($seating_arrangement)) {
        echo "No seating arrangement available.";
        return;
    }

    echo "<div class='table-responsive border'>";
    echo "<table class='table table-hover text-center'>";
    echo "<thead class='thead-light'>";
    echo "<tr><th>Room</th><th>Student Number</th><th>Department</th></tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($seating_arrangement as $entry) {
        echo "<tr>";
        echo "<td>{$entry['room']}</td>";
        echo "<td>{$entry['roll']}</td>";
        echo "<td>{$entry['dept']}</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}

// Main code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $departments_roll_numbers = $_POST['departments_roll_numbers'];
    $num_rooms = $_POST['num_rooms'];
    $max_students_per_room = $_POST['max_students_per_room'];

    // Generate seating arrangement
    $seating_arrangement = generateSeatingArrangement($departments_roll_numbers, $num_rooms, $max_students_per_room);
}
?>

<html>
<head>
    <title>Exam Seating Arrangement</title>
    <link rel="stylesheet" href="common.css">
    <?php include '../link.php'; ?>
</head>
<body>
    <div class="wrapper">
        <!-- Navigation Sidebar -->
        <!-- Assuming this part remains the same as in other pages -->
        
        <div id="content">
            <!-- Page Content Header -->
            <!-- Assuming this part remains the same as in other pages -->

            <!-- Main Content -->
            <div class="main-content">
                <!-- Input Form -->
                <h2>Enter Details</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="departments_roll_numbers">Departments Roll Numbers:</label>
                        <input type="text" class="form-control" id="departments_roll_numbers" name="departments_roll_numbers" required>
                    </div>
                    <div class="form-group">
                        <label for="num_rooms">Number of Rooms:</label>
                        <input type="number" class="form-control" id="num_rooms" name="num_rooms" required>
                    </div>
                    <div class="form-group">
                        <label for="max_students_per_room">Max Students per Room:</label>
                        <input type="number" class="form-control" id="max_students_per_room" name="max_students_per_room" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Seating Arrangement</button>
                </form>

                <!-- Display Seating Arrangement -->
                <?php
                // Display seating arrangement if available
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($seating_arrangement)) {
                    echo "<h2>Seating Arrangement</h2>";
                    printSeatingArrangement($seating_arrangement);
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
