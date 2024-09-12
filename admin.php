    <?php
        session_start();
        if(isset($_SESSION['surname'])) {
            $username = $_SESSION['surname'];
            $connection1 = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
            if (!$connection1) {
                die("Connection failed: " . mysqli_connect_error());
            }
        } 
        else{
            header("Location: sign.php");
            exit();
        }
        $name = '';
        $surname='';
        $email='';
        $field='';


        $sqlquery = "SELECT `name`, `surname`, `email`,`field` FROM `admin` WHERE `surname`=?";

        if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $name = htmlspecialchars($row['name']);
                $surname= htmlspecialchars($row['surname']);
                $email = htmlspecialchars($row['email']);
                $field = htmlspecialchars($row['field']);
                
            }
            mysqli_stmt_close($stmt);
        }
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="css/admin.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <title>Admin Profile</title>
    
</head>
<body>
    <section id="sidebar">
        <div class="back">
            <a href="sign.php">
                <i class="fas fa-arrow-circle-left" style="margin: 0vh 2vh;"></i>
                <span id="back">Logout</span>
            </a>
        </div>
        <ul class="side-menu top">
            <li class="active">
                <a href="#section-personal-details">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Adminstrator details</span>
                </a>
            </li>
            <li>
                <a href="#section-subscriptions">
                    <i class='bx bxs-wrench' ></i>
                    <span class="text">Manage Mentees</span>
                </a>
            </li>
            <li>
                <a href="#section-mentors">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Manage mentors</span>
                </a>
            </li>
            
            <li>
                <a href="#section-help-support">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Overview</span>
                </a>
            </li>
            <br><br><br>
            
            <br><br><br><br>
            	
        </ul>

    </section>



    <section id="content">
        <nav>
            <i class='bx bx-menu' id="hum"></i>
            <a href="#" class="nav-link">Menu</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            
            
        </nav>

        <main>
            <div class="head-title">
                <div class="left">
                    <h2>Admin Profile</h2>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#active-menu">Personal Details</a>
                        </li>
                    </ul>
                </div>
                <a href="#" class="profile">
                <img src="">
                </a>
            </div>
            
            <div class="table-data">
                <div class="order">
                    <div class="head">
                    </div>
                    <table>
                        <tbody>
                            <div class="personal-details" id="section-personal-details">
                                
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="surname">Surname:</label>
                                        <input type="text" id="surname" name="surname" value="<?php echo $surname; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Email Adress:</label>
                                        <input type="text" id="address" name="address" value="<?php echo $email; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Career Field:</label readonly>
                                        <input type="text" id="dob" name="dob" value="<?php echo $field; ?>">
                                    </div>
                            
                            </div>

                            <div class="subscriptions" style="display:none;" id="section-subscriptions">
                                
                                    <h2 class="section--title"> Mentees</h2>
                                    <div class="mentors--right--btns">
                                    <form action="" method="post">
                                        <select name="date" id="subscriptionFilter" class="dropdown doctor--filter">
                                            <option value="filt">All accounts</option>
                                            <option value="free">Free</option>
                                            <option value="basic">Basic</option>
                                            <option value="premium">Premium</option>
                                        </select>
                                        <button type="submit">Submit</button>
                                    </form>


                                        
                                    </div>
                                    <div id="subscriptionTable" style="display:none;">
                                        <table>
                                            <th>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Surname</td>
                                                    <td>Email</td>
                                                    <td>Subscription</td>
                                                    <td>Cellphone</td>
                                                    <td>Country</td>
                                                    <td>Action</td>
                                                </tr>
                                            </th>
                                            <td>
                                                <?php
                                                    if (isset($_POST['date']) && $_POST['date'] == "filt") {
                                                                    
                                                        $sqlquery = "SELECT `first-name`, `last-name`, `email`, `subscription`, `phone`, `country` FROM `mentor-mentee-signup`";

                                                        if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
                                                            mysqli_stmt_execute($stmt);
                                                            $result = mysqli_stmt_get_result($stmt);
                                                            
                                                            
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr>
                                                                        <td>".$row['first-name']."</td>
                                                                        <td>".$row['last-name']."</td>
                                                                        <td>".$row['email']."</td>
                                                                        <td>".$row['subscription']."</td>
                                                                        <td>".$row['phone']."</td>
                                                                        <td>".$row['country']."</td>
                                                                        <td>
                                                                            <form method=`post`>
                                                                                <button type='submit'>
                                                                                <i class='fas fa-user-times'></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                        
                                                                        
                                                                        </tr>";
                                                                    }
                                                                    
                                                                
                                                            } 
                                                            else {
                                                                echo "No records found";
                                                            }
                                                        } 
                                                        else{
                                                            echo "Error executing query: " . mysqli_error($connection1);
                                                        }
                                                    }
                                                    else if (isset($_POST['date']) && $_POST['date'] == "free") {
                                                                    
                                                        $sqlquery = "SELECT `first-name`, `last-name`, `email`, `subscription`, `phone`, `country` FROM `mentor-mentee-signup` WHERE `subscription` = 'free'";

                                                        if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
                                                            mysqli_stmt_execute($stmt);
                                                            $result = mysqli_stmt_get_result($stmt);
                                                            
                                                            
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr>
                                                                        <td>".$row['first-name']."</td>
                                                                        <td>".$row['last-name']."</td>
                                                                        <td>".$row['email']."</td>
                                                                        <td>".$row['subscription']."</td>
                                                                        <td>".$row['phone']."</td>
                                                                        <td>".$row['country']."</td>
                                                                        </tr>";
                                                                    }
                                                                    
                                                                
                                                            } 
                                                            else {
                                                                echo "No records found";
                                                            }
                                                        } 
                                                        else{
                                                            echo "Error executing query: " . mysqli_error($connection1);
                                                        }
                                                    }
                                                    else if (isset($_POST['date']) && $_POST['date'] == "basic") {
                                                                    
                                                        $sqlquery = "SELECT `first-name`, `last-name`, `email`, `subscription`, `phone`, `country` FROM `mentor-mentee-signup` WHERE `subscription`='basic'";

                                                        if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
                                                            mysqli_stmt_execute($stmt);
                                                            $result = mysqli_stmt_get_result($stmt);
                                                            
                                                            
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr>
                                                                        <td>".$row['first-name']."</td>
                                                                        <td>".$row['last-name']."</td>
                                                                        <td>".$row['email']."</td>
                                                                        <td>".$row['subscription']."</td>
                                                                        <td>".$row['phone']."</td>
                                                                        <td>".$row['country']."</td>
                                                                        </tr>";
                                                                    }
                                                                    
                                                                
                                                            } 
                                                            else {
                                                                echo "No records found";
                                                            }
                                                        } 
                                                        else{
                                                            echo "Error executing query: " . mysqli_error($connection1);
                                                        }
                                                    }
                                                    else if (isset($_POST['date']) && $_POST['date'] == "basic") {
                                                                    
                                                        $sqlquery = "SELECT `first-name`, `last-name`, `email`, `subscription`, `phone`, `country` FROM `mentor-mentee-signup` WHERE `subscription`='premium'";

                                                        if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
                                                            mysqli_stmt_execute($stmt);
                                                            $result = mysqli_stmt_get_result($stmt);
                                                            
                                                            
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo "<tr>
                                                                        <td>".$row['first-name']."</td>
                                                                        <td>".$row['last-name']."</td>
                                                                        <td>".$row['email']."</td>
                                                                        <td>".$row['subscription']."</td>
                                                                        <td>".$row['phone']."</td>
                                                                        <td>".$row['country']."</td>
                                                                        </tr>";
                                                                    }
                                                                    
                                                                
                                                            } 
                                                            else {
                                                                echo "No records found";
                                                            }
                                                        } 
                                                        else{
                                                            echo "Error executing query: " . mysqli_error($connection1);
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                
                                
                        </div>
                        <div class="manage-mentors" id="section-mentors" style="display:none;">
                        <table>
                            <th>
                                <tr>
                                    <td>Name</td>
                                    <td>Surname</td>
                                    <td>Email</td>
                                    
                                    <td>Cellphone</td>
                                    <td>Country</td>
                                </tr>
                            </th>
                            <td>
                                <?php

                                    $sqlquery = "SELECT `first-name`, `last-name`, `email` ,`phone`, `country`  FROM `mentor-mentee-mentor`";

                                    if ($stmt = mysqli_prepare($connection1, $sqlquery)) {
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>
                                                <td>".$row['first-name']."</td>
                                                <td>".$row['last-name']."</td>
                                                <td>".$row['email']."</td>
                                                <td>".$row['phone']."</td>
                                                <td>".$row['country']."</td>
                                                
                                                </tr>";
                                            }
                                        } 
                                        else{
                                            echo "No records found";
                                        }
                                    } 
                                    else{
                                        echo "Error executing query: " . mysqli_error($connection1);
                                    }
                                ?>
                            </td>
                        </table>        
                            
                        </div>

                        
                        <div class="help-support" style="display:none;" id="section-help-support" >
                            <div class="one">
                                <div class="overview">
                                    <div class="title">
                                        <h2 class="section--title" style="border-radius: 25px;">Overview</h2>
                                        
                                    </div>
                                    <div class="cards">
                                        <div class="card card-1">
                                            <div class="card--data">
                                                <div class="card--content">
                                                    <h5 class="card--title">Total  Mentors</h5>
                                                    <h1>
                                                        <?php
                                                        
                                                            $sqlquery = "SELECT COUNT(*) FROM `mentor-mentee-mentor`";
                                                            $result = mysqli_query($connection1, $sqlquery);
                                                            $row = mysqli_fetch_row($result);
                                                            echo $row[0];
                                                        ?>
                                                    </h1>
                                                </div>
                                                <i class="ri-user-2-line card--icon--lg"></i>
                                            </div>
                                            <div class="card--stats">
                                                
                                            </div>
                                        </div>
                                        <div class="card card-2">
                                            <div class="card--data">
                                                <div class="card--content">
                                                    <h5 class="card--title">Total Mentees</h5>
                                                    <h1>
                                                        <?php
                                                            
                                                            $sqlquery = "SELECT COUNT(*) FROM `mentor-mentee-signup`";
                                                            $result = mysqli_query($connection1, $sqlquery);
                                                            $row = mysqli_fetch_row($result);
                                                            echo $row[0];
                                                        ?>
                                                    </h1>
                                                </div>
                                                <i class="ri-user-line card--icon--lg"></i>
                                            </div>
                                            
                                        </div>
                                        <div class="card card-3">
                                            <div class="card--data">
                                                <div class="card--content">
                                                    <h5 class="card--title">Total Website Accounts</h5>
                                                    <h1>
                                                    <?php
                                                        $connection1 = mysqli_connect('localhost', 'root', '', 'mentor-mentee');
                                                        if (!$connection1) {
                                                            die("Connection failed: " . mysqli_connect_error());
                                                        }

                                                        $sqlquery1 = "SELECT COUNT(*) as total_mentors FROM `mentor-mentee-mentor`;";
                                                        $result1 = mysqli_query($connection1, $sqlquery1);
                                                        if ($result1) {
                                                            $row1 = mysqli_fetch_assoc($result1);
                                                            $total_mentors = $row1['total_mentors'];
                                                        } else {
                                                            echo "Error: " . mysqli_error($connection1);
                                                        }

                                                        $sqlquery2 = "SELECT COUNT(*) as total_signups FROM `mentor-mentee-signup`;";
                                                        $result2 = mysqli_query($connection1, $sqlquery2);
                                                        if ($result2) {
                                                            $row2 = mysqli_fetch_assoc($result2);
                                                            $total_signups = $row2['total_signups'];
                                                        } else {
                                                            echo "Error: " . mysqli_error($connection1);
                                                        }

                                                        $total_rows = $total_mentors + $total_signups;

                                                        echo $total_rows;

                                                        mysqli_close($connection1);
                                                        ?>

                                                    </h1>
                                                </div>
                                                <i class="ri-calendar-2-line card--icon--lg"></i>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                        </div>
                    </tbody>
                </table>
            </div>  
        </div>

    </main>
</section>
    
</body>
</html>
<script src="admin.js"></script>







