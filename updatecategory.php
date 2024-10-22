<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-4">
        <?php
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $categoryName = $_POST['categoryName'];
            try {
                $sql = "UPDATE category SET category_name = :category_name WHERE category_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':category_name', $categoryName, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Category updated successfully.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'categories.php';
                                }
                            });
                          </script>";
                } else {
                    echo "<script>Swal.fire('Error updating category.', '', 'error');</script>";
                }
            } catch (PDOException $e) {
                echo "<script>Swal.fire('Error: " . $e->getMessage() . "', '', 'error');</script>";
            }
            exit();
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $sql = "SELECT * FROM category WHERE category_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $category = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($category) {
                    echo "<form action='' method='POST' class='mt-4'>
                            <div class='mb-3'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($category['category_id']) . "'>
                            </div>
                            <div class='mb-3'>
                                <label for='categoryName' class='form-label'>Category Name</label>
                                <input type='text' class='form-control' id='categoryName' name='categoryName' value='" . htmlspecialchars($category['category_name']) . "' required>
                            </div>
                            <div class='mb-3'>
                                <label for='categoryId' class='form-label'>Category ID</label>
                                <input type='number' class='form-control' id='categoryId' name='CategoryId' value='" . htmlspecialchars($category['category_id']) . "' required>
                            </div>
                            <button type='submit' name='update' class='btn btn-primary'>Update Category</button>
                          </form>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>No category found.</div>";
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
