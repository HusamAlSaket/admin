
<?php
include 'data/config.php';

$filter = '';
$filterCondition = '';

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
    // Use the correct table name 'orders'
    $sql = "SELECT * FROM `orders` $filterCondition"; 
    $stmt = $conn->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        echo "<div class='table-responsive'>
                <table class='table text-center'>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>Order Date</th> <!-- Changed header to 'Order Date' -->
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Created At</th> <!-- Added 'Created At' -->
                            <th>Updated At</th> <!-- Added 'Updated At' -->
                        </tr>
                    </thead>
                    <tbody>";

        foreach ($result as $row) {
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

            echo "<tr>
                    <td>" . htmlspecialchars($row['order_id']) . "</td>
                    <td>" . htmlspecialchars($row['customer_id']) . "</td>
                    <td>" . htmlspecialchars($row['order_date']) . "</td>
                    <td class='text-center'><span class='$statusClass'>" . htmlspecialchars($row['status']) . "</span></td>
                    <td>" . htmlspecialchars($row['total_amount']) . "</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td> <!-- Display Created At -->
                    <td>" . htmlspecialchars(is_null($row['updated_at']) ? '' : $row['updated_at']) . "</td> <!-- Display Updated At -->
                  </tr>";
        }

        echo "</tbody>
              </table>
              </div>";
    } else {
        echo '<div class="alert alert-warning text-center mt-3">No records found.</div>';
    }
} catch (PDOException $e) {
    echo '<div class="alert alert-danger text-center mt-3">Error: ' . $e->getMessage() . '</div>';
}
?>
