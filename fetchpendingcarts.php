<?php include 'data/config.php'; ?>
    <?php

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
        $sql = 'SELECT * FROM `order`';
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
            foreach ($result as $row ) {
                $statusClass = '';
                switch (htmlspecialchars($row['status'])) {
                    case 'pending':
                        $statusClass = 'text-bg-warning  text-white  rounded-5 fw-light   small m-1 " style="width: 50px;  "';
                        break;
                    case 'completed':
                        $statusClass = 'text-bg-success text-white rounded-5 small fw-light m-1"style="width: 50px; "' ;
                        break;
                    case 'cancelled':
                        $statusClass = 'text-bg-danger text-white rounded-5 small fw-light m-2 style="width: 50px; "';
                        break;
                    default:
                        $statusClass = 'text-bg-secondary text-white rounded-5 small fw-light m-2 style="width: 50px; "';
                }
                

                if($row['status']=="pending"){
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['order_id']) . '</td>';
               echo '<td>' . htmlspecialchars($row['customer_id']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['order_date']) . '</td>';
                                echo '<td class="' . $statusClass .   ' mb-4"> ' . htmlspecialchars($row['status']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['total_amount']) . '</td>';
                                echo '<td>' . htmlspecialchars(is_null($row['updated_at']) ? 'null' : $row['updated_at']) . '</td>';
                echo '</tr>';
            }}
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
