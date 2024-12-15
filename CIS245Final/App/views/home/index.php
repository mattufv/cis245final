<h2>Welcome to my Final for CIS 245</h2>
<?php
        
        $name = "Matthew Mill";
        $student_id = "300049210";
        $email = "matthew.mill@student.ufv.ca";
        $img_loc = "img/img.jpg";
        echo "
        <img src='$img_loc' style='float:right; width: 15%' alt='My scary face'>
        <strong>Name:</strong> $name<br>
        <strong>Student #:</strong> ".$student_id."<br>
        <strong>Email:</strong> $email<br>
        <br>
        <h4>Preferred name</h4>
        Matt or Matthew
        <h4>Reason for registering</h4>
        May persue a second degree in CS/CIS. Recovering from a brain injury
        and as I have some old previous experience, was hoping these classes
        would be a great lead in to more schooling
        <h4>Previous computer course</h4>
        Most recently CIS145. 20+ years ago various at UBC and UCFV
        <h4>Course expectations? How will it help?</h4>
        Honestly no expectations. It wil help with tinkering around in everyday
        life and will help if I do go for a second degree
        <h4>Major</h4>
        Currently in Qualifying Studies
        <h4>Location</h4>
        I am currently living in Abbotsford
        ";
        ?>