<?php
// get the data from the form
$loan_amount = filter_input(INPUT_POST, 'loan_amount',
                            FILTER_VALIDATE_FLOAT);
$interest_rate = filter_input(INPUT_POST, 'interest_rate',
                              FILTER_VALIDATE_FLOAT);
$loan_length = filter_input(INPUT_POST, 'loan_length',
                            FILTER_VALIDATE_INT);
$extra_payment = filter_input(INPUT_POST, 'extra_payment',
                              FILTER_VALIDATE_FLOAT);
$time_unit = filter_input(INPUT_POST, 'time_unit');
// validate Loan amount
if ($loan_amount === FALSE ) {
    $error_message = 'Loan amount must be a valid number.'; 
} else if ( $loan_amount <= 0 ) {
    $error_message = 'Loan Amount must be greater than zero.'; 
    // validate interest rate
} else if ( $interest_rate === FALSE )  {
    $error_message = 'Interest rate must be a valid number.'; 
} else if ( $interest_rate <= 0 ) {
    $error_message = 'Interest rate must be greater than zero.'; 
} else if ( $interest_rate > 15 ) {
    $error_message = 'Interest rate must be 15 or less.';
    // validate years
} else if ( $loan_length === FALSE ) {
    $error_message = 'Loan length must be a valid whole number.';
} else if ( $loan_length <= 0 ) {
    $error_message = 'Loan length must be greater than zero.';
} else if ( $time_unit == 'years' && $loan_length > 30 ) {
    $error_message = 'Years must be less than 31.';
} else if ($time_unit =='months' && $loan_length > 360 ) {
    $error_message = 'Months must be less than than 361.';


// set error message to empty string if no invalid entries
} else {
    $error_message = ''; 
}
// if an error message exists, go to the index page
if ($error_message != '') {
    include('index.php');
    exit(); }
// calculate the monthly interest rate
$interest = ($interest_rate / 100) / 12;
//make sure the loan length is in months
if ($time_unit == 'years'){
    $loan_length = $loan_length * 12;
}
//make sure that if the extra payment is left blank, it shows as $0.00
//because prettier
if ($extra_payment == NULL) {
    $extra_payment = 0;
}

//calculate the monthly payment
$monthly_payment = $loan_amount * (($interest * pow($interest + 1, $loan_length)) / (pow($interest + 1, $loan_length) - 1));

//calculate the total interest paid when there is no extra payment
$total_interest = ($monthly_payment * ($loan_length)) - $loan_amount;

//calculate the total (interest + principle) amount paid when there is no extra payment
$total_paid = ((($monthly_payment * ($loan_length)) - $loan_amount) + $loan_amount);

//give remaining balance the loan amount value
$remaining_balance = $loan_amount;

//calculate the amount of interest if there is an extra payment
for ($i=1; $i<=$loan_length; $i++) {
    if ($monthly_payment > ($remaining_balance * $interest) + $remaining_balance){
        $monthly_interest = $remaining_balance * $interest;
        $full_interest += $monthly_interest;
        break;
    }elseif($monthly_payment + $extra_payment > ($remaining_balance * $interest) + $remaining_balance ) {
        $monthly_interest = $remaining_balance * $interest;
        $full_interest += $monthly_interest;
        break;
    } 
    $monthly_interest = $remaining_balance * $interest;
    $principle = $monthly_payment - $monthly_interest;
    $remaining_balance = $remaining_balance - $principle - $extra_payment;
    $full_interest += $monthly_interest;
}

if ($i > $loan_length){
	$i = $loan_length;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Loan Amortization Calculator
        </title>
        <link rel="stylesheet" type="text/css" href="styles/main.css">
    </head>
    <body>
        <header>
  <img src="/2351/final/final_jun_19/img/loancalc.png" alt="Loan Calculator">
</header>
        <main>
        <img src="/2351/final/final_jun_19/img/loansummary.png" alt="Loan Summary" height="50px" class="leftimage"><img src="/2351/final/final_jun_19/img/amortizationschedule.png" class="rightimage" alt="Amortization Schedule" height="50px">
        <div style="clear: both;">
            <div class="left">
                
                <fieldset>
                    <label>Loan Amount:</label>
                    <span><?php echo '$'. number_format($loan_amount, 2); ?></span>
                    <br>
                    <label>Yearly Interest Rate:</label>
                    <span><?php echo $interest_rate.'%'; ?></span>
                    <br>
                    <label>Number of Months:</label>
                    <span><?php echo $i; ?></span>
                    <br>
                    <label>Monthly Payment:</label>
                    <span><?php echo '$' . number_format($monthly_payment, 2); ?></span>
                    <br>
                    <label>Total Interest:</label>
                    <span><?php echo '$' . number_format($full_interest, 2); ?></span>
                    <br>
                    <label>Additional Principle:</label>
                    <span><?php echo '$' . number_format($extra_payment, 2); ?></span>
                    <br>
                    <label>Total Amount Paid:</label>
                    <span><?php echo '$' . number_format($loan_amount + $full_interest, 2); ?></span>
                    <br>
                    <label>Interest Saved:</label>
                    <span><?php echo '$' . number_format(abs($total_interest - $full_interest), 2); ?></span>
                    <br>
                </fieldset>
            </div>
            <div class="right">
               
                <table  align='center'>
                    <tr>
                        <th>
                            Pmt
                            <br>
                            No.
                        </th>
                        <th>
                            Due
                            <br>
                            m-d-y
                        </th>
                        <th>
                            Monthly
                            <br>
                            Payment
                        </th>
                        <th>
                            Payment
                            <br>
                            Interest
                            <br>
                        </th>
                        <th>
                            Payment
                            <br>
                            Principle
                        </th>
                        <th>
                            Extra
                            <br>
                            Principle
                        </th>
                        <th>
                            Loan
                            <br>
                            Balance
                        </th>
                    </tr>
                    <?php 
//reset the remaining balance variable
$remaining_balance = $loan_amount;

//create a time stamp for current date
$date = new DateTime('now');

//This for loop will calculate the variables that will be needed to 
//populate the amortization table. It will take into account the 
//changes that occur if an extra payment is made each month.
for ($i = 1; $i <= $loan_length; $i++) {
    if ($monthly_payment > ($remaining_balance * $interest) + $remaining_balance){
        $monthly_interest = $remaining_balance * $interest;
        $principle = $remaining_balance;
        $monthly_payment = $remaining_balance + $monthly_interest;
        $extra_payment = 0;
        $remaining_balance = 0;
        include 'table.php';
        break;
    }elseif($monthly_payment + $extra_payment > ($remaining_balance * $interest) + $remaining_balance ) {
        $monthly_interest = $remaining_balance * $interest;
        $principle = $monthly_payment - $monthly_interest;
        $extra_payment = $remaining_balance - $monthly_payment;
        $remaining_balance = 0;
        include 'table.php';
        break;
    } 
    $monthly_interest = $remaining_balance * $interest;
    $principle = $monthly_payment - $monthly_interest;
    $remaining_balance = $remaining_balance - $principle - $extra_payment;
    include 'table.php';
}
                    ?>
                    </div>
                </table>
            </div>
            <div style="clear: both;">
        </main>
        <?php include '../../footer.php'; ?>
    </body>
</html>
