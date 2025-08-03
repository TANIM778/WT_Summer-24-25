<!DOCTYPE html>
<head>
    <meta charset = "UTF-8"/>
</head>
<body>
    <h1>Student profile & Status</h1> 
    <script>
        console.log("Student Profile");
        var student = {
            name : "Ethan",
            age : 23,
            isStudent : true,
            subject : ["Web tech", "DLC", "AI"],
            marks : [90, 95, 92],
        };
        console.log("Name: ",student.name);
        console.log("Age: ", student.age);
        console.log("Is Student: ", student.isStudent);

        console.log("\nCalculations");
        var totalMarks = 0;
        for(var i = 0; i <student.marks.length; i++)
        {
            totalMarks = totalMarks + student.marks[i];
        }

        var average = totalMarks / student.marks.length;
        console.log("Total Marks: ", totalMarks);
        console.log("Average: ", average);

        console.log("\nStatus Check");
        var isAdult = student.age >= 18;
        var passed = average >= 40;
        console.log("Is Adult?", isAdult);
        console.log("Passed? ", passed);

        function display() 
        {
            console.log("\nSummary");
            console.log("Student: ", student.name);
            console.log("Age: ", student.age); 
            console.log("Total : ", totalMarks); 
            console.log("Average: ", average); 
            console.log("Result: ", passed? "Passed" : "Failed");     
        }

        display();

        function show()
        {
            var message = 
            "Student:" + student.name + "\n" +
            "Age: "+ student.age + (isAdult ? "(Adult)" : "(Minor)") + "\n" +
            "Total: "+ totalMarks + "\n" +
            "Average: "+ average + "\n" +
            "Result: "+ (passed? "Passed" : "Failed");

            alert(message);

        }
        
        show();
        console.log("Here is the result!")
    </script>
</body>
</html>