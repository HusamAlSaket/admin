<?php

include("./data/config.php");

$searchTerm = '';
$users = [];

if (isset($_GET['searchdocs']) && !empty(trim($_GET['searchdocs']))) {
    $searchTerm = trim($_GET['searchdocs']);
    $search = '%' . $searchTerm . '%';

    $sql = "SELECT * FROM users WHERE fullname LIKE :search OR email LIKE :search OR phonenumber LIKE :search OR role LIKE :search OR city LIKE :search OR address LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <form method="get" class="mb-4">
            <div class="form-row">
                <div class="col-md-8">
                    <input type="text" name="searchdocs" class="form-control" placeholder="Search by name, email, etc."
                        value="<?php echo htmlspecialchars($searchTerm); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phonenumber']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars($user['city']); ?></td>
                            <td><?php echo htmlspecialchars($user['address']); ?></td>
                            <td>
                                <a href='customerview.php?id=<?php echo htmlspecialchars($user['id']); ?>' class='btn btn-warning btn-sm'>View</a>
                            
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            <?php echo "User has not been found"; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
