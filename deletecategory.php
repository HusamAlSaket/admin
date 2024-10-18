<?php include('./data/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete category</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        echo "
        <script>
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = '404.php';
                });
            } else {
                window.location.href = '404.php';
            }
        });
        </script>
        ";
        try {
            $sql = "DELETE FROM category WHERE category_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            exit();
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger text-center mt-3'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning text-center mt-3'>No category ID provided.</div>";
    }
    ?>
</body>
</html>
