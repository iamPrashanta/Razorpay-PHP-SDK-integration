<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fill This Form</title>
    <style>
        body {
            background: #f7f7f7;
        }

        .form-box {
            max-width: 500px;
            margin: auto;
            padding: 50px;
            background: #ffffff;
            border: 10px solid #f2f2f2;
        }

        h1,
        p {
            text-align: center;
        }

        input,
        textarea {
            width: 100%;
        }

        .t_head h2 {
            text-align: center;
        }

        .m-t-50 {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <header class="sideMenu">
        <div class="menuIcon">
            <span></span>
        </div>
        <ul>
            <li><a href="../">Back</a></li>
            <li><a href="./CollectPayment/">Collect Payment</a></li>
        </ul>
    </header>
    <div class="t_head m-t-50">
        <h2>Fill This Form</h2>
    </div>
    <div class="container" id="container">
        <div class="form-box">
            <form action="razorpay/pay.php" method="GET">
                <div class="form-group">
                    <label for="amount">Select Amount</label>
                    <select id="total" name="total" class="form-control" required>
                        <option value="50">50 (500 Points) Test</option>
                        <option value="100">100 (1000 Points)</option>
                        <option value="200">200 (2000 Points)</option>
                        <option value="300">300 (3000 Points)</option>
                        <option value="500">500 (5000 Points)</option>
                        <option value="1000">1000 (10000 Points)</option>
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" value="Pay Now" />
            </form>
        </div>
    </div>
    </div>
</body>

</html>