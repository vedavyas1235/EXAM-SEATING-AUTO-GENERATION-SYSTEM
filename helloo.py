def main():
    departments_roll_numbers = {}
    total_students = 0

    # Input number of departments and details
    num_departments = int(input("Enter the number of departments: "))
    for i in range(1, num_departments + 1):
        dept_name = input(f"Enter department {i} name: ")
        start_roll = int(input(f"Enter starting roll number for {dept_name}: "))
        end_roll = int(input(f"Enter ending roll number for {dept_name}: "))
        departments_roll_numbers[dept_name] = (start_roll, end_roll)
        total_students += end_roll - start_roll + 1

    # Input number of rooms and maximum students per room
    num_rooms = int(input("Enter the number of rooms: "))
    max_students_per_room = int(input("Enter the maximum number of students allowed in each room: "))

    # Seating arrangement
    print("\nSeating Arrangement:")
    student_count = 1
    remaining_students_count = total_students
    for room in range(1, num_rooms + 1):
        print(f"\nRoom {room}:")
        room_students = []
        remaining_capacity = max_students_per_room
        for dept, (start, end) in departments_roll_numbers.items():
            dept_students = [(roll, dept) for roll in range(start, end + 1)]
            room_students.extend(dept_students)
        room_students.sort(key=lambda x: x[0])
        for roll, dept in room_students:
            if student_count > total_students or remaining_capacity == 0:
                break
            print(f"Student {student_count} ({dept})")
            student_count += 1
            remaining_students_count -= 1
            remaining_capacity -= 1

    # Print remaining rooms if any
    if student_count <= total_students:
        print("\nRemaining Rooms:")
        for room in range(room + 1, num_rooms + 1):
            print(f"Room {room}")

    # Print remaining students if any
    if remaining_students_count > 0:
        print("\nRemaining Students:")
        for dept, (start, end) in departments_roll_numbers.items():
            remaining_students_dept = min(remaining_students_count, end - start + 1)
            for roll in range(end + 1, end + remaining_students_dept + 1):
                if roll > total_students:
                    break
                print(f"Student {roll} ({dept})")
                remaining_students_count -= 1
                if remaining_students_count == 0:
                    break
            if remaining_students_count == 0:
                break


if __name__ == "_main_":
    main()