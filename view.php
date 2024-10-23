<?php include('data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];
            try {
                $sql = "SELECT * FROM products WHERE product_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    echo "<table class='table table-bordered'>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category ID</th>
                                <th>Average Rating</th>
                                <th>Stock Quantity</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>" . htmlspecialchars($product['product_id']) . "</td>
                                
                                <td>" . htmlspecialchars($product['product_name']) . "</td>
                                <td>" . htmlspecialchars($product['description']) . "</td>
                                <td>" . htmlspecialchars($product['price']) . "</td>
                                <td>" . htmlspecialchars($product['category_id']) . "</td>
                                <td>" . htmlspecialchars($product['average_rating']) . "</td>
                                <td>" . htmlspecialchars($product['stock_quantity']) . "</td>
                                <td>" . htmlspecialchars($product['created_at']) . "</td>
                                
                                <td>" . htmlspecialchars(is_null($product['updated_at']) ? '' : $product['updated_at']) . "</td>
                                <td>
                                    <a href='update.php?id=" . htmlspecialchars($product['product_id']) . "' class='btn btn-warning btn-sm'>Update</a>
                                    <form method='POST' action='delete.php' style='display: inline-block;'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($product['product_id']) . "' />
                                        <input type='submit' class='btn btn-danger btn-sm' value='Delete' />
                                    </form>
                                </td>
                            </tr>
                        </table>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>Product not found.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No product ID provided.</div>";
        }
        ?>
    </div>
</body>
</html>
