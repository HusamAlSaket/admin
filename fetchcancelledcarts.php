<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled Orders</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include 'data/config.php'; ?>

<?php
$filter = '';
$filterCondition = '';

// Display success or error messages
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success text-center mt-3">';
    echo $_SESSION['message'];
    echo '</div>';
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center mt-3">';
    echo $_SESSION['error'];
    echo '</div>';
    unset($_SESSION['error']);
}

// Handle date filtering based on user selection
if (isset($_GET['date_filter'])) {
    $filter = $_GET['date_filter'];
    switch ($filter) {
        case 'option-2':
            $filterCondition = "WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
            break;
        case 'option-3':
            $filterCondition = "WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
            break;
        case 'option-4':
            $filterCondition = "WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
            break;
        case 'option-1':
        default:
            $filterCondition = '';
    }
}

try {
    // Start building the SQL query for cancelled orders
    $sql = 'SELECT * FROM `orders`';
    
    // Add filtering conditions if present
    if (!empty($filterCondition)) {
        $sql .= ' ' . $filterCondition; // Append the filter condition
    }
    
    // Always add the status condition
    // Use 'WHERE' if filterCondition is empty, otherwise use 'AND'
    if (empty($filterCondition)) {
        $sql .= ' WHERE status = "cancelled"'; // First condition
    } else {
        $sql .= ' AND status = "cancelled"'; // Subsequent condition
    }

    $stmt = $conn->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        echo '<div class="table-responsive">';
        echo '<table class="table text-center" style="border: none;">';
        echo '<thead>';
        echo '<tr style="background-color: transparent;">';
        echo '<th>Order ID</th>';
        echo '<th>Customer ID</th>';
        echo '<th>Order Date</th>';
        echo '<th>Status</th>';
        echo '<th>Total Amount</th>';
        echo '<th>Updated At</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($result as $row) {
            $statusClass = 'text-danger fw-bold'; // Class for cancelled status

            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['order_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['customer_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['order_date']) . '</td>';
            echo '<td class="' . $statusClass . '">' . htmlspecialchars($row['status']) . '</td>';
            echo '<td>' . htmlspecialchars($row['total_amount']) . '</td>';
            echo '<td>' . htmlspecialchars(is_null($row['updated_at']) ? 'null' : $row['updated_at']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning text-center mt-3">No records found.</div>';
    }
} catch (PDOException $e) {
    echo '<div class="alert alert-danger text-center mt-3">Error: ' . $e->getMessage() . '</div>';
}
?>

</body>
</html>
