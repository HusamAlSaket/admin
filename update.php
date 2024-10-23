<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $ProductName = $_POST['ProductName'];
            $Description = $_POST['Description'];
            $Price = $_POST['Price'];
            $StockQuantity = $_POST['StockQuantity'];
            $CategoryId = $_POST['CategoryId'];
            // Average rating and created_at are assumed not to be updated directly

            try {
                $sql = "UPDATE products 
                        SET product_name = :product_name, 
                            description = :description, 
                            price = :price, 
                            stock_quantity = :stock_quantity, 
                            category_id = :category_id, 
                            updated_at = NOW() 
                        WHERE product_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':product_name', $ProductName, PDO::PARAM_STR);
                $stmt->bindParam(':description', $Description, PDO::PARAM_STR);
                $stmt->bindParam(':price', $Price, PDO::PARAM_STR);
                $stmt->bindParam(':stock_quantity', $StockQuantity, PDO::PARAM_INT);
                $stmt->bindParam(':category_id', $CategoryId, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Product updated successfully.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'products.php';
                                }
                            });
                          </script>";
                } else {
                    echo "<script>Swal.fire('Error updating product.', '', 'error');</script>";
                }
            } catch (PDOException $e) {
                echo "<script>Swal.fire('Error: " . $e->getMessage() . "', '', 'error');</script>";
            }
            exit();
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $sql = "SELECT * FROM products WHERE product_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($product) {
                    echo "<form action='' method='POST' class='mt-4'>
                            <div class='mb-3'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($product['product_id']) . "'>
                            </div>
                            <div class='mb-3'>
                                <label for='ProductName' class='form-label'>Product Name</label>
                                <input type='text' class='form-control' id='ProductName' name='ProductName' value='" . htmlspecialchars($product['product_name']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='Description' class='form-label'>Description</label>
                                <input type='text' class='form-control' id='Description' name='Description' value='" . htmlspecialchars($product['description']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='Price' class='form-label'>Product Price</label>
                                <input type='number' step='0.01' class='form-control' id='Price' name='Price' value='" . htmlspecialchars($product['price']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='StockQuantity' class='form-label'>Stock Quantity</label>
                                <input type='number' class='form-control' id='StockQuantity' name='StockQuantity' value='" . htmlspecialchars($product['stock_quantity']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='CategoryId' class='form-label'>Category ID</label>
                                <input type='number' class='form-control' id='CategoryId' name='CategoryId' value='" . htmlspecialchars($product['category_id']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='AverageRating' class='form-label'>Average Rating</label>
                                <input type='text' class='form-control' id='AverageRating' name='AverageRating' value='" . htmlspecialchars($product['average_rating']) . "' readonly>
                            </div>
                            <div class='mb-3'>
                                <label for='CreatedAt' class='form-label'>Created At</label>
                                <input type='text' class='form-control' id='CreatedAt' name='CreatedAt' value='" . htmlspecialchars($product['created_at']) . "' readonly>
                            </div>
                            <div class='mb-3'>
                                <label for='UpdatedAt' class='form-label'>Updated At</label>
                                <input type='text' class='form-control' id='UpdatedAt' name='UpdatedAt' value='" . htmlspecialchars($product['updated_at']) . "' readonly>
                            </div>
                            <button type='submit' name='update' class='btn btn-primary'>Update Product</button>
                        </form>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>No product found.</div>";
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
