<?php
// Created by Aditya_Bhole

// API URL
$api_url = "http://52.66.71.147/XpressPP_Running/vegonlyothers.php";

// Input data
$input_data = [
  [
    "Parameter" => "QUxnWDFSNWVscHdJYTJXZzBjTmFyZz09",
    "UserName" => "hotelorder@6262",
    "Password" => "hotelorder@4474",
    "VegOnly" => 1
  ]
];

// Convert the input data to JSON
$json_input = json_encode($input_data);

// Initialize cURL
$curl = curl_init($api_url);

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($curl, CURLOPT_POSTFIELDS, $json_input);

// Execute the API call
$response = curl_exec($curl);

// Check for cURL errors
if ($response === false) {
  echo "cURL Error: " . curl_error($curl);
  exit;
}

// Close cURL
curl_close($curl);

// Decode the JSON response
$data = json_decode($response, true);

// Handle JSON decoding errors
if (json_last_error() !== JSON_ERROR_NONE) {
  echo "Failed to decode JSON: " . json_last_error_msg();
  exit;
}

// Extract menu items
$menu_items = $data['result'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Design</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * {

margin: 0;
padding: 0;
box-sizing: border-box;
font-family: Tahoma, sans-serif;
font-size: 12px;
}

h3 {
margin-top: 20px;

font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}

/* For general layout */
.d-flex.align-items-center.text-right {
margin-top: 40px;
/* Adjust the margin as needed */
}



@media (max-width: 768px) {
.d-flex.align-items-center.text-right {
    margin: 10px;
    flex-direction: column;
    text-align: center;
}
}

.add-btn {
width: 100px;
height: 40px;
font-size: 16px;
line-height: 1.5;
margin: 0 auto;
display: block;
padding-bottom: 10px;
background-color: #007bff;
color: white;
border: none;
border-radius: 4px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
.add-btn {
    width: 100px;
    /* Adjust width for mobile view */
    height: 40px;
    /* Adjust height for mobile view */
    font-size: 16px;
    /* Adjust font size for mobile view */
}
}

/* Additional media queries for other viewports if needed */
@media (min-width: 769px) and (max-width: 992px) {
.add-btn {
    width: 90px;
    /* Adjust width for tablets or medium screens */
    height: 38px;
    /* Adjust height for tablets or medium screens */
    font-size: 15px;

}
}

/* Remove left and right padding from the container */
.container {
padding-left: 0;
padding-right: 0;
}

/* Remove margins between rows to ensure no space between borders */
.row.no-gutters {
margin-left: 0;
margin-right: 0;
}

.row.no-gutters>.col-md-12 {
padding-left: 0;
padding-right: 0;
}

/* Remove card borders but add bottom border */
.card {
border: none;
border-bottom: 1px solid #bec2c2;
/* Adjust color as needed */
margin-bottom: 0;
/* Ensure no extra space at the bottom */
}

/* Optional: Adjust spacing for mobile view */
@media (max-width: 768px) {
.container {
    padding-left: 0;
    padding-right: 0;
}
}

.menu-name {
font-size: 13px;
font-weight: bold;
}
  </style>
</head>

<body>
  <!-- <div class="container mt-4"> -->
  <div class="container mt-4 p-0">
    <!-- <h1 class="text-center">Menu Items</h1> -->
    <div class="row no-gutters">
      <?php foreach ($menu_items as $item): ?>
        <?php
        
        // Determine the icon based on MenuTypeId
        $menuTypeIcon = $item['MenuTypeId'] == 1 ? 'veg_icon.png' : 'nonvegicon.png';
        ?>
        <div class="col-md-12">
          <div class="card p-3 d-flex flex-row align-items-start position-relative menu-card">
            <div class="menu-details" style="flex-grow: 1;">
              <h6 class="card-title" style="font-size:18px; display: flex; align-items: center;">
                <!-- Veg/Non-Veg Icon before the menu name -->
                <img src="<?php echo $menuTypeIcon; ?>" alt="Menu Type Icon" style="width: 20px; margin-right: 8px;">
                <b style="font-size: 13px;">
                  <?php echo htmlspecialchars($item['MenuName']); ?>
                </b>
              </h6>
              <p class="card-text" style="font-size:14px;">
                <strong></strong> ₹
                <?php echo htmlspecialchars($item['Rate']); ?>
              </p>
              <?php if (trim($item['Description'])): ?>
                <p class="card-text" style="font-size:10px;">
                  <?php echo nl2br(htmlspecialchars($item['Description'])); ?>
                </p>
              <?php endif; ?>
            </div>
            <div class="menu-image text-right" style="width: 100px; position: relative; height: auto;">
              <?php if (trim($item['MenuImageUrl'])): ?>
                <img src="<?php echo htmlspecialchars($item['MenuImageUrl']); ?>" class="img-fluid mb-2" alt="">
              <?php else: ?>
                <img src="placeholder.jpg" class="img-fluid mb-2" alt="">
              <?php endif; ?>
              <button class="btn btn-primary add-btn" onclick="addToCart(this)">ADD</button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>


  <script>
    function addToCart(button) {
      alert('Added to cart');
    }
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>