<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require('config.php');
require('Razorpay.php');
require_once 'common.php';

// test data
$Sub_Admin_ID = "1010101010";
$acc_type = "acc_type";
$Group = "group_name";
$date = date("Y-m-d");
$date_time = date("Y-m-d H:i:s");
$name = "user_name";
$email = "email@gmail.com";
$phone = "1010101010";


$applicatF = new STUDENT();

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
	$api = new Api($keyId, $keySecret);

	try {
		$attributes = array(
			'razorpay_order_id' => $_SESSION['razorpay_order_id'],
			'razorpay_payment_id' => $_POST['razorpay_payment_id'],
			'razorpay_signature' => $_POST['razorpay_signature']
		);

		$api->utility->verifyPaymentSignature($attributes);
	} catch (SignatureVerificationError $e) {
		$success = false;
		$error = 'Razorpay Error : ' . $e->getMessage();
	}
}

if ($success === true) {
	$razorpayOrderId = $_SESSION['razorpay_order_id'];
	$razorpayPaymentId = $_POST['razorpay_payment_id'];
	$name = $_SESSION['name'];
	$email = $_SESSION['email'];
	$phone = $_SESSION['phone'];
	$service = $_SESSION['service'];
	$typeProduct = $_SESSION['typeProduct'];
	$toValue = $_SESSION['toValue'];
	$message = $_SESSION['message'];
	$paymentStatus = 'SUCCESS';
	$updatestamp = date('Y-m-d h:i:s');
	$stmt = $applicatF->runQuery("SELECT * FROM `subadmin_onlinepayment` WHERE email=:email1 and razorpayOrderId='$razorpayOrderId' and paymentStatus ='Pending';");
	$stmt->execute(array(":email1" => $email));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($stmt->rowCount() > 0) {
		$successMSG = "Your payment has been completed successfuly";
		//$html = "{$_POST['razorpay_payment_id']}";
	} else {
		// $errMSG = "Payment Completed, <a href='../CollectPayment/'>Collect your Points</a>";
		$errMSG = "Payment Completed";
	}
} else {
	$paymentStatus = 'FAILURE';
	$updatestamp = date('Y-m-d h:i:s');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Payment Verification</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100vh;
			margin: 0;
		}

		.custom-heading {
			text-align: center;
			padding: 15px;
			border-radius: 5px;
		}

		.danger {
			background-color: #f8d7da;
			border: 1px solid #f5c6cb;
			color: #721c24;
		}

		.primary {
			background-color: #CCE5FF;
			border: 1px solid #CCE5FF;
			color: #6AB8FF;
		}
	</style>
</head>

<body>
	<?php
	if (isset($errMSG)) {
	?>
		<div class="custom-heading danger">
			<h1>
				<?php echo $errMSG; ?>
			</h1>
		</div>
	<?php
	} else if (isset($successMSG)) {
		// header("location:../CollectPayment/");
		header("location:../../");
	?>
		<div class="custom-heading primary">
			<h1>
				<?php echo $successMSG; ?>
			</h1>
		</div>
	<?php
	}
	?>
</body>

</html>