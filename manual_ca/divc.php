<?php
print "Cash Dividend";

?>
<table>
<form action="p_divc.php" method="POST" target="_self">
<tr><td>Symbol:</td><td><input type="text" name="symbol"></td></tr>
<tr><td>Name:</td><td><input type="text" name="name"></td></tr>
<tr><td>CUSIP:</td><td><input type="text" name="cusip"></td></tr>
<tr><td>Issue Date:</td><td><input type="text" name="issue_date"> (YYYY-MM-DD)</td></tr>
<tr><td>Update Date:</td><td><input type="text" name="update_date"> (YYYY-MM-DD)</td></tr>
<tr><td>Effective Date:</td><td><input type="text" name="effective_date"> (YYYY-MM-DD)</td></tr>
<tr><td>Record Date:</td><td><input type="text" name="record_date"> (YYYY-MM-DD)</td></tr>
<tr><td>Pay Date:</td><td><input type="text" name="pay_date"> (YYYY-MM-DD)</td></tr>
<tr><td>Frequency:</td><td><input type="text" name="frequency"></td></tr>
<tr><td>Net Amount:</td><td><input type="text" name="net_amount"></td></tr>
<tr><td>Gross Amount:</td><td><input type="text" name="gross_amount"></td></tr>
<tr><td>Currency:</td><td><input type="text" name="currency"></td></tr>
<tr><td style="vertical-align: top">Notes:</td><td><textarea name="notes" rows="4" cols="22"></textarea></td></tr>
<tr><td colspan="2" style="text-align: center"><input type="submit" value="Submit"></td></tr>
</form>
</table>
<?php

?>