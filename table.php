<?php 
$date->modify('first day of next month');
echo "<tr>
<td>$i</td>
<td>".$date->format('m/d/Y') ."</td>
<td>$" . number_format($monthly_payment,2) . "</td>
<td>$" . number_format($monthly_interest,2) . "</td>
<td>$" . number_format($principle,2) . "</td>
<td>$" . number_format($extra_payment,2) . "</td>
<td>$" . number_format($remaining_balance,2) . "</td>
</tr>";
?>
