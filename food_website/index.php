<?php
//   session_start();
//   if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     $parameter = $_POST['parameter'];
  

   
//     $_SESSION['s_parameter'] = $parameter;

//     $url = "http://52.66.71.147/XpressPP_Running/hotel_details_for_ordering.php?parameter=$parameter";
  
//     $res = file_get_contents($url);
//     $result = json_decode($res, true);

  
//     foreach ($result['result'] as $res) {
//       $parameter = $res['s_parameter'];
   

    //   if ($userName == 'X' && $Password == 'X') {
    //     echo '<script>alert("Username & Password is wrong..");</script>';
    //   } else {
    //     header("Location:home.php");

    //   }

//     }

//   }
include("constant.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xpress Hotel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
            .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        height: calc(100% - 73px);
    }

    .card {
        width: 100%;
        max-width: 900px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-top: 10%;
        margin-left: 25%;
        align-items: center;
        justify-content: center;
        overflow-x: hidden;
    }

    .card-body {
        padding: 2rem;
    }

    .hidden {
        display: none;
    }

    .btn-blue {
        background-color: #137ebc;
        color: white;
    }

    .bg-primary-custom {
        background-color: #137ebc !important;
    }

    .page-title {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

   
    @media (max-width: 1024px) {
        .card {
            margin-left: 10%;
            margin-right: 10%;
        }
    }

    @media (max-width: 768px) { 
        .card {
            margin-left: 5%;
            margin-right: 5%;
            margin-top: 5%;
        }

        .page-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 450px) { 
        .h-custom {
            height: 100%;
        }

        .card {
            margin-left: 2%;
            margin-right: 2%;
            margin-top: 5%;
        }

        .card-body {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .btn-blue {
            width: 100%;
        }
    }

    </style>
    <script>
        $(document).ready(function() {
            $('#sendOtpButton').click(function() {
                const phoneNumber = $('#phoneNumber').val();

                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ mob_no: phoneNumber }),
                    success: function(data) {
                        alert('OTP sent successfully!');
                        hideOtpField(); // Show OTP section
                    },
                    error: function(xhr, status, error) {
                        alert('Error sending OTP. Please try again.');
                    }
                });
            });

            function hideOtpField() {
                document.getElementById('otpSection').style.display = 'block';
                document.getElementById('verifyOtpSection').style.display = 'block';
                document.getElementById('phoneSection').style.display = 'none';
            }
        });
    </script>
</head>
<body>
<?php
session_start();
$parameter = $_GET['parameter'];


function generateOTP() {
    return rand(100000, 999999); // 6 digit OTP
}

$otp = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $mobile = $data['mob_no'] ?? '';

    if ($mobile) {
        $otp = generateOTP();
        echo $otp;
        $_SESSION['otp'] = $otp;
   
        $_SESSION['otp_time'] = time();

        // API integration for sending OTP
        $Authkey = '359180AQrwQK5INrDt607e889fP1';
        $customer_phone = '91' . $mobile;
        $ebill_msg = "Dear User, Welcome to the MMD(Make My Day). Use below OTP No. $otp to verify your mobile number - Vision by XPRESSHOTELERP";
        $SenderId = "RNSERP";
        $route = 4;
        $country_code = 91;
        $TemplateId = '1207169703350434137';

        $url_ebill = "https://otpsms.vision360solutions.in/api/sendhttp.php?authkey=" . $Authkey . "&mobiles=" . $customer_phone . "&message=" . urlencode($ebill_msg) . "&sender=" . $SenderId . "&route=" . $route . "&country=" . $country_code . "&DLT_TE_ID=" . $TemplateId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_ebill);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $message = "OTP sent successfully!";
        echo json_encode(['status' => 'success', 'message' => $message]);
    } else {
    //    echo json_encode(['status' => 'error', 'message' => 'Mobile number is required']);
    }
}

if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    $session_otp = $_SESSION['otp'];
    $mobile = $_POST['mob_no'];

    if ($entered_otp == $session_otp) {
        $_SESSION['mobile'] = $mobile;
        $_SESSION['parameter'] = $parameter;
        $message = "OTP verified successfully!";
        echo "<script>alert('$message'); window.location.href = 'home.php';</script>";
        exit();
    } else {
        $message = "Invalid OTP. Please try again.";
        echo "<script>alert('$message');</script>";
    }
}
?>

    <div class="login-container">
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12">
                                <div class="page-title">Xpress Hotel</div>
                            </div>
                            <div class="col-md-9 col-lg-6 col-xl-5">
                                <img src="login.png" class="img-fluid" alt="Sample image">
                            </div>
                            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                                <form id="otpForm" method="POST" action="">
                                    <div class="form-outline mb-4" id="phoneSection">
                                        <input type="text" id="phoneNumber" class="form-control form-control-lg" name="mob_no" placeholder="Enter your phone number" required />
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <div class="text-center text-lg-start mt-4 pt-2">
                                            <button type="button" name="send_otp" id="sendOtpButton" class="btn btn-blue btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Send OTP</button>
                                        </div>
                                    </div>
                                    
                                    <!-- OTP Section (Hidden initially) -->
                                    <div class="form-outline mb-4" id="otpSection" style="display:none;">
                                        <input type="text" id="otp" class="form-control form-control-lg" name="otp" placeholder="Enter OTP" />
                                        <label class="form-label" for="otp">OTP</label>
                                    </div>
                                    <div class="text-center text-lg-start mt-4 pt-2" id="verifyOtpSection" style="display:none;">
                                        <button type="submit" name="verify_otp" class="btn btn-blue btn-lg">Verify OTP</button>
                                        <button id="resendBtn" type="button" class="btn btn-link" disabled onclick="window.location='send_otp.php'">
                                            Resend OTP (<span id="time">60</span>s)
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<script>
    // Function to start the countdown
    function startTimer(duration, display) {
        var timer = duration, seconds;
        var end = setInterval(function () {
            seconds = parseInt(timer % 60, 10);
            seconds = seconds < 10 ? "0" + seconds : seconds;
            display.textContent = seconds;

            if (--timer < 0) {
                clearInterval(end);
                document.getElementById("resendBtn").disabled = false; // Enable the resend button
                display.textContent = ""; // Clear the countdown text
            }
        }, 1000);
    }

    // Start the countdown when the page loads
    window.onload = function () {
        var sixtySeconds = 59, // Start the countdown at 59 seconds
            display = document.querySelector('#time');
        startTimer(sixtySeconds, display);
    };
</script>
</body>
</html>
