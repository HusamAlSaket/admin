<?php include('data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_GET['id'])) {
            $category_id = $_GET['id'];
            try {
                $sql = "SELECT * FROM category WHERE category_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $category_id, PDO::PARAM_INT);
                $stmt->execute();
                $category = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($category) {
                    echo "<table class='table table-bordered'>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>" . htmlspecialchars($category['category_id']) . "</td>
                                <td>" . htmlspecialchars($category['category_name']) . "</td>
                                <td>" . htmlspecialchars($category['created_at']) . "</td>
                                <td>" . htmlspecialchars(is_null($category['updated_at']) ? '' : $category['updated_at']) . "</td>
                                <td>
                                    <a href='updatecategory.php?id=" . htmlspecialchars($category['category_id']) . "' class='btn btn-warning btn-sm'>Update</a>
                                    <form method='POST' action='deletecategory.php' style='display: inline-block;'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($category['category_id']) . "' />
                                        <input type='submit' class='btn btn-danger btn-sm' value='Delete' />
                                    </form>
                                </td>
                            </tr>
                        </table>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>Category not found.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>No category ID provided.</div>";
        }
        ?>
    </div>
</body>
</html>
