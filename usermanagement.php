<?php
include 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
                <div class="orders">
                    <div class="card">

                        <div class="card-header">
                            <h3>User List</h3>

                            <a href="userAdd.php"><button><span class="las la-plus-square"> Add user</span></button></a>
                        </div>

                        <div class="card-body">
                            <div class="div table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>User Id</td>
                                            <td>Username</td>
                                            <td>Email</td>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        $sql = "Select * from `users`";
                                        $result = mysqli_query($conn,$sql);

                                        while($row=mysqli_fetch_assoc($result)){
                                            $user_id=$row['user_id'];
                                            $user_name=$row['user_name'];
                                            $email=$row['email'];
                                            echo '<tr>

                                                <td>
                                                    <label>'.$user_id.'</label>
                                                </td>
                                                <td>
                                                    <label>'.$user_name.'</label>
                                                </td>
                                                <td>'.$email.'</td>
                                                <td>
                                                    <button type="button" class="save">
                                                        <a href="userDelete.php?deleteid='.$user_id.'">
                                                        Delete</a></button>
                                                </td>
                                            </tr>';

                                        }

                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </main>
</body>
</html>
