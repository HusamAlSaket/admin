<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];
            try {
                $sql = "SELECT * FROM users WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    echo "<table class='table table-bordered'>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>" . htmlspecialchars($user['id']) . "</td>
                                <td>" . htmlspecialchars($user['fullname']) . "</td>
                                <td>" . htmlspecialchars($user['email']) . "</td>
                                <td>" . htmlspecialchars($user['phonenumber']) . "</td>
                                <td>" . htmlspecialchars($user['role']) . "</td>
                                <td>" . htmlspecialchars($user['city']) . "</td>
                                <td>" . htmlspecialchars($user['address']) . "</td>
                                <td>" . htmlspecialchars($user['password']) . "</td>
                                <td>
                                    <a href='customerupdate.php?id=" . htmlspecialchars($user['id']) . "' class='btn btn-warning btn-sm'>Update</a>
                                    <form method='POST' action='customerdelete.php' style='display: inline-block;'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($user['id']) . "' />
                                        <input type='submit' class='btn btn-danger btn-sm' value='Delete' />
                                    </form>
                                </td>
                            </tr>
                        </table>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>User not found.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No user ID provided.</div>";
        }
        ?>
    </div>
</body>
</html>
