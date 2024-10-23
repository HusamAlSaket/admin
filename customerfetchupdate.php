<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_POST['update'])) {
            $customer_id = $_POST['customer_id'];
            $username = $_POST['username'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $address = $_POST['address'];
            $password = $_POST['password'];

            try {
                $sql = "UPDATE customers SET 
                        username = :username, 
                        first_name = :first_name, 
                        last_name = :last_name, 
                        email = :email, 
                        phone_number = :phone_number, 
                        address = :address, 
                        password = :password 
                        WHERE customer_id = :customer_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
                $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Customer updated successfully.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'customer.php';
                                }
                            });
                          </script>";
                } else {
                    echo "<script>Swal.fire('Error updating customer.', '', 'error');</script>";
                }
            } catch (PDOException $e) {
                echo "<script>Swal.fire('Error: " . $e->getMessage() . "', '', 'error');</script>";
            }
            exit();
        }

        if (isset($_GET['id'])) {
            $customer_id = $_GET['id'];
            try {
                $sql = "SELECT * FROM customers WHERE customer_id = :customer_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
                $stmt->execute();
                $customer = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($customer) {
                    echo "<form action='' method='POST' class='mt-4'>
                            <div class='mb-3'>
                                <input type='hidden' name='customer_id' value='" . htmlspecialchars($customer['customer_id']) . "'>
                            </div>
                            <div class='mb-3'>
                                <label for='username' class='form-label'>Username</label>
                                <input type='text' class='form-control' id='username' name='username' value='" . htmlspecialchars($customer['username']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='first_name' class='form-label'>First Name</label>
                                <input type='text' class='form-control' id='first_name' name='first_name' value='" . htmlspecialchars($customer['first_name']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='last_name' class='form-label'>Last Name</label>
                                <input type='text' class='form-control' id='last_name' name='last_name' value='" . htmlspecialchars($customer['last_name']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='email' class='form-label'>Email</label>
                                <input type='email' class='form-control' id='email' name='email' value='" . htmlspecialchars($customer['email']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='phone_number' class='form-label'>Phone Number</label>
                                <input type='text' class='form-control' id='phone_number' name='phone_number' value='" . htmlspecialchars($customer['phone_number']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='address' class='form-label'>Address</label>
                                <input type='text' class='form-control' id='address' name='address' value='" . htmlspecialchars($customer['address']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='password' class='form-label'>Password</label>
                                <input type='text' class='form-control' id='password' name='password' value='" . htmlspecialchars($customer['password']) . "' required>
                            </div>
                            <button type='submit' name='update' class='btn btn-primary'>Update Customer</button>
                          </form>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>No customer found.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No customer ID provided.</div>";
        }
        ?>
    </div>
</body>
</html>
