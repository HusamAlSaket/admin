<?php include 'data/config.php'; ?>

<?php
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

$filter = '';
$filterCondition = '';

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
    // Use the correct table name 'orders' and add a status filter
    $sql = 'SELECT * FROM `orders`';
    
    // Check if there are any filter conditions
    if (!empty($filterCondition)) {
        $sql .= ' ' . $filterCondition; // Add the filter condition
    }
    
    // Always add the status condition
    // Use 'WHERE' if filterCondition is not empty, otherwise use 'WHERE'
    if (empty($filterCondition)) {
        $sql .= ' WHERE status = "pending"'; // First condition
    } else {
        $sql .= ' AND status = "pending"'; // Subsequent condition
    }
        $stmt = $conn->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        echo '<div class="table-responsive">';
        echo '<table class="table text-center" style="border: none;">';
        echo '<thead>';
        echo '<tr style="background-color: transparent;">';
        echo '<th>Order ID</th>';  // Changed to 'Order ID'
        echo '<th>Customer ID</th>'; // Changed to 'Customer ID'
        echo '<th>Order Date</th>'; // Changed to 'Order Date'
        echo '<th>Status</th>';
        echo '<th>Total Amount</th>'; // Changed to 'Total Amount'
        echo '<th>Updated At</th>'; // Added 'Updated At'
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($result as $row) {
            // Define status classes
            $statusClass = '';
            switch (htmlspecialchars($row['status'])) {
                case 'pending':
                    $statusClass = 'text-warning fw-bold';
                    break;
                case 'completed':
                    $statusClass = 'text-success fw-bold';
                    break;
                case 'cancelled':
                    $statusClass = 'text-danger fw-bold';
                    break;
                default:
                    $statusClass = 'text-secondary fw-bold';
            }

            // Output only pending orders
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['order_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['customer_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['order_date']) . '</td>';
            echo '<td class="text-center"><span class="' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span></td>';
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
