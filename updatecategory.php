<?php
include('./data/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Update</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $categoryName = $_POST['categoryName'];
        $categoryId = $_POST['CategoryId'];

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
                                window.location.href = '404.php';
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
                echo "<form action='' method='POST'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($category['category_id']) . "'>
                        <label>Category name:</label>
                        <input type='text' name='categoryName' value='" . htmlspecialchars($category['category_name']) . "' required><br><br>
                        <label>Category ID:</label>
                        <input type='number' name='CategoryId' value='" . htmlspecialchars($category['category_id']) . "' required><br><br>
                        <input type='submit' name='update' value='Update category'>
                      </form>";
            } else {
                echo "<script>Swal.fire('No category found.', '', 'info');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>Swal.fire('Error: " . $e->getMessage() . "', '', 'error');</script>";
        }
    } else {
        echo "<script>Swal.fire('No category ID provided.', '', 'error');</script>";
    }
    ?>
</body>
</html>
