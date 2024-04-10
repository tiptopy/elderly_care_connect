<link rel="stylesheet" href="../css/profile.css">

<?php
include 'header.php';
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

$transactions = iterator_to_array($db->transactions->find());
if (isLoggedIn()) {
    if (isAdmin()) {
        if (count($transactions) > 0) {
            echo "<table id='transactionTable'>";
            echo "<thead><tr><th data-sort-order='asc'>Transaction ID</th><th data-sort-order='asc'>Amount</th><th data-sort-order='asc'>Paid At</th><th data-sort-order='asc'>Donated By</th></tr></thead>";
            echo "<tbody>";

            foreach ($transactions as $transaction) {
                echo "<tr>";
                echo "<td>" . $transaction['data']['reference'] . "</td>";
                echo "<td>" . 'KES ' . $transaction['data']['amount'] / 100 . "</td>";
                echo "<td>" . $transaction['data']['paidAt'] . "</td>";
                echo "<td>" . $transaction['data']['authorization']['bin'] . $transaction['data']['authorization']['last4'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No donations have ever been made to this profile";
        }
    } else {
        header("Location: ./access_denied.php");
    }
} else{
    header("Location: login.php");
}

include 'footer.php';
?>