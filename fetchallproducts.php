<?php
include('data/config.php');

try {
    $sql = "SELECT * FROM product";
    $stmt = $conn->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) > 0) {
        echo "<table border='1' cellpadding='10' cellspacing='0'>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Category ID</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>";
        foreach ($result as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars(is_null($row['product_id']) ? '' : $row['product_id']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['product_name']) ? '' : $row['product_name']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['description']) ? '' : $row['description']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['price']) ? '' : $row['price']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['stock_quantity']) ? '' : $row['stock_quantity']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['category_id']) ? '' : $row['category_id']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['created_at']) ? '' : $row['created_at']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['updated_at']) ? '' : $row['updated_at']) . "</td>
                    <td>
                        <a href='view.php?id=" . htmlspecialchars($row['product_id']) . "' class='btn btn-warning btn-sm'>View</a>
                    
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='alert alert-warning text-center mt-3'>No records found.</div>";
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger text-center mt-3'>Error: " . $e->getMessage() . "</div>";
}
?>
