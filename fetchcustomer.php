<?php

include("./data/config.php");

$searchTerm = '';
$customers = [];

if (isset($_GET['searchdocs']) && !empty(trim($_GET['searchdocs']))) {
    $searchTerm = trim($_GET['searchdocs']);
    $search = '%' . $searchTerm . '%';

    $sql = "SELECT * FROM customers WHERE CONCAT(first_name, ' ', last_name) LIKE :search 
            OR email LIKE :search OR phone_number LIKE :search OR address LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT * FROM customers";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Search</title>
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($customers) > 0): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($customer['address']); ?></td>
                            <td>
                                <a href='customerview.php?id=<?php echo htmlspecialchars($customer['customer_id']); ?>' class='btn btn-warning btn-sm'>View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <?php echo "Customer has not been found"; ?>
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
