<?php 
    //set default value of variables for initial page load
    if (!isset($loan_amount)) { $loan_amount = ''; } 
    if (!isset($interest_rate)) { $interest_rate = ''; } 
    if (!isset($loan_length)) { $loan_length = ''; } 
?> 
<!DOCTYPE html>
<html>
<head>
    <title>Loan Calculator</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
    
    <header>
  <img src="/2351/final/final_jun_19/img/loancalc.png" alt="Loan Calculator">
</header>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php } ?>
    <main>
 
    <form action="display_results.php" method="post">
        
            <label>Loan Amount:&nbsp;&nbsp;<!--<div class="tooltip">?
  <span class="tooltiptext">If this is a new loan, this number will be the total amount you are borrowing. 
  If you have already made payments, look at your monthly statement and locate the remaining amount of principle 
  owed after the last payement. Enter that amount.</span>-->
</div><span class="dollar_sign">$</span></label>
            <input type="text" name="loan_amount"
                   value="<?php echo htmlspecialchars($loan_amount); ?>"
                   placeholder ="How much?">
            <br>

            <label>Interest Rate:&nbsp;&nbsp;<!--<div class="tooltip">?
  <span class="tooltiptext">Your interest rate is typically stated as a yearly rate, 
  such as 5.5%.</span>-->
</div></label>
            <input type="text" name="interest_rate"
                   value="<?php echo htmlspecialchars($interest_rate); ?>"
                   placeholder ="Your interest rate."><span class="percent">%</span>
            <br>

            <label>Loan Length:&nbsp;&nbsp;<!--<div class="tooltip">?
  <span class="tooltiptext">This is the full length of your loan in years or months. If this is an existing loan, 
  subtract the number of payments you have already made from the original number of payments. If entering years, 
  enter whole years. If you need to break it down to partial years, enter it as months. For instance, 10 1/2 years 
  would be 12 x 10 = 120 months plus another 6 months, for a total of 126 months.</span>-->
</div></label>
            <input id="loan_length" type="text" name="loan_length"
                   value="<?php echo htmlspecialchars($loan_length); ?>"
                   placeholder ="How long?">&nbsp;
               
            <select name="time_unit">
                   <option value="months">Months</option>
                   <option value="years" selected>Years</option>
                   </select><br></div>
            <label>Additional Principle:&nbsp;&nbsp;<!--<div class="tooltip">?
  <span class="tooltiptext">If you intend to add an additional principle payment each month, enter that amount here, 
  otherwise, leave it blank. Additional principle payments will result in significant savings over the life of your 
  loan.</span>-->
</div><span class="dollar_sign">$</span></label>
            <input type="text" name="extra_payment"
                   value="<?php echo htmlspecialchars($extra_payment); ?>"
                   placeholder ="Pay if off faster!">
                   <br>
        <div id="buttons">
            <label></label>
            <input type="submit" class="myButton" value="Calculate">
             <br>
        </div>
    </form>
    
    <?php include '../faq.php' ?>
    </main>
    
    <?php include '../../footer.php' ?>
</body>
</html>
