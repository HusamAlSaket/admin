<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
</body>
</html>





<?php include 'data/config.php'; ?>
<?php
$filter = '';
$filterCondition = '';

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
        // $sql = 'SELECT * FROM order';
        $sql = 'SELECT * FROM `order` $filterCondition';
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($result);
        if (count($result) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table text-center" style="border: none;">';
            echo '<thead>';
            echo '<tr style="background-color: transparent;">';
            echo '<th>Order</th>';
            echo '<th>Customer</th>';
            echo '<th>Created at</th>';
            echo '<th>Status</th>';
            echo '<th>Total amount</th>';
            echo '<th>Updated at</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($result as $row) {
                $statusClass = '';
                switch (htmlspecialchars($row['status'])) {
                    case 'pending':
                        $statusClass = 'text-bg-warning fw-bold';
                        break;
                    case 'completed':
                        $statusClass = 'text-bg-success fw-bold';
                        break;
                    case 'cancelled':
                        $statusClass = 'text-secondary fw-bold';
                        break;
                    default:
                        $statusClass = 'text-secondary fw-bold';
                }
                if ($row['status'] == "cancelled") {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['order_id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['customer_id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['order_date']) . '</td>';
                    echo '<td class="' . $statusClass . ' mb-4"> ' . htmlspecialchars($row['status']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['total_amount']) . '</td>';
                    echo '<td>' . htmlspecialchars(is_null($row['updated_at']) ? 'null' : $row['updated_at']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['updated_at'] == "NULL") . '</td>';
                    echo '</tr>';
                }
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
