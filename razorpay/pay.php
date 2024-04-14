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



use Razorpay\Api\Api;

$onlinePay = new STUDENT();
$sql9 = $DB_con->prepare("select max(pID) as pID from `subadmin_onlinepayment`");
$sql9->execute();
$result9 = $sql9->fetch(PDO::FETCH_ASSOC);
$pID = $result9['pID'];
$mOrderID = "0000" . $pID;
$api = new Api($keyId, $keySecret);

$n = strtoupper($name);

$toValue = "1000"; // Test Amount
$message = "Paid";
$razorpayPaymentId = "";
$paymentStatus = "PENDING";
$makerstamp = date('Y-m-d h:i:s');
$updatestamp = date('Y-m-d h:i:s');
$typeProduct = '';
for ($i = 0; $i < 10; $i++) {
  $typeProduct .= mt_rand(0, 9);
}


$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
$_SESSION['service'] = $Sub_Admin_ID;
$_SESSION['typeProduct'] = $typeProduct;
$_SESSION['toValue'] = $toValue;
$_SESSION['message'] = $message;

$orderData = [
  'receipt'         => 3456,
  'amount'          => $toValue * 100,
  'currency'        => 'INR',
  'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR') {
  $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
  $exchange = json_decode(file_get_contents($url), true);

  $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$data = [
  "key"               => $keyId,
  "amount"            => $amount,
  "name"              => "$n",
  "description"       => "Buying the prodcut of Learning Mobile app development",
  "image"             => "https://icon-library.com/images/rupees-icon/rupees-icon-3.jpg",
  "prefill"           => [
    "name"              => $name,
    "email"             => $email,
    "contact"           => $phone,
  ],
  "notes"             => [
    "address"           => "Online Payments",
    "merchant_order_id" => $mOrderID,
  ],
  "theme"             => [
    "color"             => "#72ff0d"
  ],
  "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR') {
  $data['display_currency']  = $displayCurrency;
  $data['display_amount']    = $displayAmount;
}

if ($onlinePay->razorPayOnline($name, $email, $phone, $Sub_Admin_ID, $typeProduct, $toValue, $message, $razorpayOrderId, $razorpayPaymentId, $paymentStatus, $makerstamp, $updatestamp)) {
  //$successMSG = "Your payment has been done successfully.";
  $json = json_encode($data);
} else {
  $errMSG = "sorry , Query could no execute...";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Razorpay | Payment Gateway Integration</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style>
    div {

      justify-content: center;
    }
  </style>
  <!--===============================================================================================-->
</head>

<body>

  <div class="container-contact100">
    <div class="wrap-contact100">

      <style type="text/css">
        body {
          font-family: 'Open Sans', sans-serif;
        }

        .custom-modal {
          background-color: rgba(0, 0, 0, 0.4);
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .modal-content {
          background-color: #fff;
          padding: 20px;
          border-radius: 5px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tg {
          width: 100%;
          margin-bottom: 1rem;
          text-align: left;
        }

        .tg td,
        .tg th {
          padding: 12px;
          border: 1px solid #ddd;
        }

        .tg th {
          background-color: #007bff;
          color: #fff;
          font-weight: bold;
        }
      </style>
      <table class="tg">
        <thead>
          <tr>
            <th class="tg-hrow"><b><?php echo $name; ?></b> You are Paying Rs.<?php echo $toValue ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-0pky">
              ✅ You Can make the Payment using Google Pay, PhonePe, Paytm for UPI.<br>
              ✅ Wallets, Debit Card and Credit Card is also accepted.<br>

            </td>
          </tr>

        </tbody>
      </table>

      <div class="payment">
        <form action="verify.php" method="POST" name="member_signu">
          <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $data['key'] ?>" data-amount="<?php echo $data['amount'] ?>" data-currency="INR" data-name="<?php echo $data['name'] ?>" data-image="<?php echo $data['image'] ?>" data-description="<?php echo $data['description'] ?>" data-prefill.name="<?php echo $data['prefill']['name'] ?>" data-prefill.email="<?php echo $data['prefill']['email'] ?>" data-prefill.contact="<?php echo $data['prefill']['contact'] ?>" data-notes.shopping_order_id="3456" data-order_id="<?php echo $data['order_id'] ?>" <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount'] ?>" <?php } ?> <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency'] ?>" <?php } ?>>
          </script>
          <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
          <input type="hidden" name="shopping_order_id" value="3456">
          <input type="hidden" name="callback_url" value="verify.php">
          <input type="hidden" name="cancel_url" value="verify.php">

        </form>
      </div>

    </div>
  </div>
  <!--===============================================================================================-->
  <script src="js/main.js"></script>

</body>

</html>