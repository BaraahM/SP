<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User adding Page</title>
    
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <link rel="stylesheet" href="stylin.css">
</head>
<body>

<input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand"> 
            <h2><span class="lab la-accusoft"></span><span>User Management</span></h2>
        </div>

        <div class="sidebar-menu"> 
            <ul>
                <li>
                    <a href="usermanagement.php" class="active"><span class="las la-receipt"></span>
                    <span>User Management</span></a>
                </li>
                <li>
                    <a href="logout.php"><span class="las la-power-off"></span>
                    <span>Log Out</span></a>
                </li>
            </ul>
        </div> 
    </div>

    <div class="main-content">
        <header>
            <h2>

                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                User Management
            </h2>

            <div class="user-wrapper">
                <img src="img/admin.png" width="40px" height="40px" alt="user image">
                <div>
                    <h4>Admin</h4>
                </div>
            </div>
        </header>

        <main>
            
            <div class="recent-grid">
                <div class="users">
                    <div class="card">
                        <form action="userAddition.php" method="post" name="registrationForm" onsubmit="return validateRegisterationForm()">
                            <div class="card-header">
                                <h3>Add a User</h3>

                                <input type="submit" value="Register">
                            </div>

                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" class="form-control" placeholder="Enter the username of the new user" 
                                    name="username" id="username" autocomplete="off" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="text" class="form-control" placeholder="Enter the email address of the new user" 
                                    name="email" id="email" autocomplete="off" required>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Enter the password of the new user" 
                                    name="password" id="password" autocomplete="off" required>
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Enter the password of the new user" 
                                    name="confirmPassword" id="confirmPassword" autocomplete="off" required>
                                </div>
                        </form>
                        

                    </div>
                </div>
            </div>

        </main>

        <script type="text/javascript" src="script.js"></script>
</body>
</html>