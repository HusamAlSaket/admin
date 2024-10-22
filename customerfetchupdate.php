<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $fullName = $_POST['fullName'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phoneNumber'];
            $role = $_POST['role'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $password = $_POST['password'];
            try {
                $sql = "UPDATE users SET 
                        fullname = :fullname, 
                        email = :email, 
                        phonenumber = :phonenumber, 
                        role = :role, 
                        city = :city, 
                        address = :address, 
                        password = :password 
                        WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':fullname', $fullName, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':phonenumber', $phoneNumber, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                $stmt->bindParam(':city', $city, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'User updated successfully.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'customer.php';
                                }
                            });
                          </script>";
                } else {
                    echo "<script>Swal.fire('Error updating user.', '', 'error');</script>";
                }
            } catch (PDOException $e) {
                echo "<script>Swal.fire('Error: " . $e->getMessage() . "', '', 'error');</script>";
            }
            exit();
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $sql = "SELECT * FROM users WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    echo "<form action='' method='POST' class='mt-4'>
                            <div class='mb-3'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($user['id']) . "'>
                            </div>
                            <div class='mb-3'>
                                <label for='fullName' class='form-label'>Full Name</label>
                                <input type='text' class='form-control' id='fullName' name='fullName' value='" . htmlspecialchars($user['fullname']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='email' class='form-label'>Email</label>
                                <input type='email' class='form-control' id='email' name='email' value='" . htmlspecialchars($user['email']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='phoneNumber' class='form-label'>Phone Number</label>
                                <input type='text' class='form-control' id='phoneNumber' name='phoneNumber' value='" . htmlspecialchars($user['phonenumber']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='role' class='form-label'>Role</label>
                                <input type='text' class='form-control' id='role' name='role' value='" . htmlspecialchars($user['role']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='city' class='form-label'>City</label>
                                <input type='text' class='form-control' id='city' name='city' value='" . htmlspecialchars($user['city']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='address' class='form-label'>Address</label>
                                <input type='text' class='form-control' id='address' name='address' value='" . htmlspecialchars($user['address']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='password' class='form-label'>Password</label>
                                <input type='text' class='form-control' id='password' name='password' value='" . htmlspecialchars($user['password']) . "' required>
                            </div>
                            <button type='submit' name='update' class='btn btn-primary'>Update User</button>
                          </form>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>No user found.</div>";
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
