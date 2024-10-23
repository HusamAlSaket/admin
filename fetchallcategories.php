<?php
include('data/config.php');

try {
    $sql = "SELECT * FROM categories";  // Update table name to 'categories'
    $stmt = $conn->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($result) > 0) {
        echo "<div class='col-12'>
        <table class='table table-bordered'>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>";

        foreach ($result as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars(is_null($row['category_id']) ? '' : $row['category_id']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['category_name']) ? '' : $row['category_name']) . "</td>
                    <td>
                        <img src='" . htmlspecialchars(is_null($row['image_url']) ? 'default-image.jpg' : $row['image_url']) . "' alt='Category Image' style='width: 50px; height: 50px;' />
                    </td>
                    <td>" . htmlspecialchars(is_null($row['created_at']) ? '' : $row['created_at']) . "</td>
                    <td>" . htmlspecialchars(is_null($row['updated_at']) ? '' : $row['updated_at']) . "</td>
                    <td>
                        <a href='categoryview.php?id=" . htmlspecialchars($row['category_id']) . "' class='btn btn-warning btn-sm'>View</a>
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
