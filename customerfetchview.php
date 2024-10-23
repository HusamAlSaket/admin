<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_GET['id'])) {
            $customer_id = $_GET['id'];
            try {
                $sql = "SELECT * FROM customers WHERE customer_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $customer_id, PDO::PARAM_INT);
                $stmt->execute();
                $customer = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($customer) {
                    echo "<table class='table table-bordered'>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>" . htmlspecialchars($customer['customer_id']) . "</td>
                                <td>" . htmlspecialchars($customer['username']) . "</td>
                                <td>" . htmlspecialchars($customer['first_name']) . "</td>
                                <td>" . htmlspecialchars($customer['last_name']) . "</td>
                                <td>" . htmlspecialchars($customer['email']) . "</td>
                                <td>" . htmlspecialchars($customer['phone_number']) . "</td>
                                <td>" . htmlspecialchars($customer['address']) . "</td>
                                <td>" . htmlspecialchars($customer['password']) . "</td>
                                <td>
                                    <a href='customerupdate.php?id=" . htmlspecialchars($customer['customer_id']) . "' class='btn btn-warning btn-sm'>Update</a>
                                    <form method='POST' action='customerdelete.php' style='display: inline-block;'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($customer['customer_id']) . "' />
                                        <input type='submit' class='btn btn-danger btn-sm' value='Delete' />
                                    </form>
                                </td>
                            </tr>
                        </table>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>Customer not found.</div>";
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
