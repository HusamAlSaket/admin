<?php
include('data/config.php');

try {
    $sql = "SELECT * FROM products";
    $stmt = $conn->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) > 0) {
        echo "<table class='table table-bordered'>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Category ID</th>
                    <th>Average Rating</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>";
        foreach ($result as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['product_id']) . "</td>
                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                    <td>" . htmlspecialchars($row['price']) . "</td>
                    <td>" . htmlspecialchars($row['stock_quantity']) . "</td>
                    <td>" . htmlspecialchars($row['category_id']) . "</td>
                    <td>" . htmlspecialchars($row['average_rating']) . "</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td>
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
