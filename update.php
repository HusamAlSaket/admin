<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    if (isset($_POST['update'])) {
        $id = $_POST['id']; 
        $ProductName = $_POST['ProductName'];
        $Description = $_POST['Description'];
        $Price = $_POST['Price'];
        $StockQuantity = $_POST['StockQuantity'];
        $CategoryId = $_POST['CategoryId'];

        try {
            $sql = "UPDATE product 
                    SET product_name = :product_name, 
                        description = :description, 
                        price = :price, 
                        stock_quantity = :stock_quantity, 
                        category_id = :category_id 
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
            $sql = "SELECT * FROM product WHERE product_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($product) {
                echo "Product found";
    ?>

                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                    <label>Product name:</label>
                    <input type="text" name="ProductName" value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br><br>
                    <label>Description:</label>
                    <input type="text" name="Description" value="<?php echo htmlspecialchars($product['description']); ?>" required><br><br>
                    <label>Product Price:</label>
                    <input type="number" step="0.01" name="Price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>
                    <label>Stock Quantity:</label>
                    <input type="number" name="StockQuantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required><br><br>
                    <label>Category ID:</label>
                    <input type="number" name="CategoryId" value="<?php echo htmlspecialchars($product['category_id']); ?>" required><br><br>
                    <input type="submit" name="update" value="Update Product">
                </form>
    <?php
            } else {
                echo "<script>Swal.fire('No product found.', '', 'info');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>Swal.fire('Error: " . $e->getMessage() . "', '', 'error');</script>";
        }
    } else {
        echo "<script>Swal.fire('No product ID provided.', '', 'error');</script>";
    }
    ?>
</body>
</html>
