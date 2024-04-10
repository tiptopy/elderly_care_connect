<link rel="stylesheet" href="../css/profile.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php
include 'header.php';
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';

$transactions = iterator_to_array($db->transactions->find());
if (isLoggedIn()) {
    if (isAdmin()) {
        if (count($transactions) > 0) {
            // Output search input and filter options
            echo '<input type="text" id="searchInput" placeholder="Search transactions">';
            echo 'From: <input type="date" id="startDate">';
            echo 'To: <input type="date" id="endDate">';
            echo '<select id="filterSelect">';
            echo '<option value="all">All</option>';
            echo '<option value="General Donation">General Donation</option>';
            // Add more filter options as needed
            echo '</select>';
            
            // Download/Print button
            echo '<button id="downloadPrintButton">Download/Print</button>';

            echo "<table id='transactionTable'>";
            echo "<thead><tr><th data-sort-order='asc'>Transaction ID</th><th data-sort-order='asc'>M-Pesa Code</th><th data-sort-order='asc'>Amount</th><th data-sort-order='asc'>Paid At</th><th data-sort-order='asc'>Donated By</th><th data-sort-order='asc'>Donated To</th></tr></thead>";
            echo "<tbody>";

            $totalAmount = 0;

            foreach ($transactions as $transaction) {
                echo "<tr>";
                echo "<td>" . $transaction['data']['reference'] . "</td>";
                echo "<td>" . $transaction['data']['receipt_number'] . "</td>";
                echo "<td class='amount'>" . 'KES ' . $transaction['data']['amount'] / 100 . "</td>";
                echo "<td class='paidAt'>" . $transaction['data']['paidAt'] . "</td>";
                echo "<td>" . $transaction['data']['authorization']['mobile_money_number'] . "</td>";
                echo "<td>";
                if (isset($transaction['DonationTo'])) {
                    echo "<a href='profile.php?id=" . $transaction['DonationTo'] . "'>" . $transaction['DonationTo'] . "</a>";
                } else {
                    echo "General Donation";
                }
                echo "</td>";
                echo "</tr>";
                $totalAmount += $transaction['data']['amount'] / 100;
            }

            echo "</tbody>";
            echo "</table>";
            echo '<P id="totalAmount" style="text-align:center">Total Donations: KES ' . $totalAmount . '</p>';


            // JavaScript for search and filter functionality
            echo "<script>
            $(document).ready(function() {
                $('#searchInput').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('#transactionTable tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                    updateTotalAmount();
                });
                
                $('#filterSelect').on('change', function() {
                    var value = $(this).val().toLowerCase();
                    $('#transactionTable tbody tr').filter(function() {
                        var text = $(this).find('td:last').text().toLowerCase();
                        if (value === 'all') {
                            $(this).show();
                        } else {
                            $(this).toggle(text.indexOf(value) > -1);
                        }
                    });
                    updateTotalAmount();
                });

                $('#startDate, #endDate').on('change', function() {
                    var startDate = $('#startDate').val();
                    var endDate = $('#endDate').val();
                    $('#transactionTable tbody tr').each(function() {
                        var paidAt = $(this).find('.paidAt').text();
                        if ((startDate && paidAt < startDate) || (endDate && paidAt > endDate)) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                    updateTotalAmount();
                });

                $('#downloadPrintButton').on('click', function() {
                    window.print();
                });
                
                function updateTotalAmount() {
                    var total = 0;
                    $('#transactionTable tbody tr:visible').each(function() {
                        var amountText = $(this).find('.amount').text();
                        total += parseFloat(amountText.replace('KES ', ''));
                    });
                    $('#totalAmount').text('Total Donations: KES ' + total);
                }
            });
            </script>";
        } else {
            echo "No donations have ever been made to this profile";
        }
    } else {
        header("Location: ./access_denied.php");
    }
} else {
    header("Location: login.php");
}

include 'footer.php';
?>
