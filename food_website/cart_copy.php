<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            font-size: 10px;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .cart-item img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .item-quantity input {
            width: 50px;
            text-align: center;
        }

        .bill-details {
            margin-top: 20px;
            font-size: 14px;
        }

        .bill-details .total {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Back and Checkout Buttons -->
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-secondary" onclick="window.location.href='back_page.php'">Back</button>
            <button class="btn btn-primary" onclick="window.location.href='checkout_page.php'">Checkout</button>
        </div>

        <h2>Your Cart</h2>

        <?php
        // Database connection and fetching, similar to your original logic
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "restaurant_db";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        function getTaxRates()
        {
            return ['cgst' => 2.50, 'sgst' => 2.50]; // Simulating tax rates, e.g., 2.5% each
        }

        $taxRates = getTaxRates();
        $cgstRate = $taxRates['cgst'];
        $sgstRate = $taxRates['sgst'];

        $sql = "SELECT MenuID, MenuName, Rate, Quantity, MenuTypeId FROM menu_items";
        $result = mysqli_query($conn, $sql);

        $item_total = 0;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $menuTypeIcon = $row['MenuTypeId'] == 1 ? 'vegicon.png' : 'nonvegicon.png';
                $menuTypeAltText = $row['MenuTypeId'] == 1 ? 'Veg' : 'Non-Veg';

                $item_price = $row["Rate"] * $row["Quantity"];
                $item_total += $item_price;

                echo "<div class='cart-item row py-2 border-bottom' data-menuid='{$row['MenuID']}'>
                        <div class='col-5 d-flex align-items-center'>
                            <img src='$menuTypeIcon' alt='$menuTypeAltText' />
                            <h6 class='mb-0'>{$row['MenuName']} (₹" . number_format($row['Rate'], 2) . ")</h6>
                        </div>
                        <div class='col-4 item-quantity d-flex justify-content-between align-items-center'>
                            <button class='btn btn-sm btn-outline-primary decrease-qty'>&ndash;</button>
                            <input type='text' class='form-control form-control-sm quantity' value='{$row['Quantity']}' readonly>
                            <button class='btn btn-sm btn-outline-primary increase-qty'>+</button>
                        </div>
                       <div class='col-3 text-right item-price' data-price='{$row['Rate']}' style='font-size:18px;'>
    ₹" . number_format($item_price, 2) . "
</div>

                    </div>";
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }

        mysqli_close($conn);
        ?>
        <!-- Bill Details -->
        <!-- Bill Details -->
        <div class="bill-details mt-3">
            <div class="d-flex justify-content-between">
                <span>Item Total</span><span id="item-total">₹0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>CGST (
                    <?php echo $cgstRate; ?>%)
                </span><span id="cgst-total">₹0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>SGST (
                    <?php echo $sgstRate; ?>%)
                </span><span id="sgst-total">₹0.00</span>
            </div>

            <!-- Display for fractional part -->
            <div class="d-flex justify-content-between">
                <span>Round Off</span>
                <span id="fractional-amount">₹0.00</span>
            </div>

            <!-- Show the rounded total -->
            <div class="d-flex justify-content-between total">
                <span>To Pay</span>
                <span id="rounded-total">₹0.00</span>
            </div>
        </div>


        <div class="text-center">
            <button class="btn btn-primary my-2" id="place_order">Place Order</button>
        </div>


        `
        <script>
            document.getElementById('place_order').addEventListener('click', function () {
                if (confirm('Are you sure you want to confirm the order?')) {
                    // Gather cart data
                    const cartData = [];
                    document.querySelectorAll('.cart-item').forEach((item) => {
                        const menuId = item.getAttribute('data-menuid');
                        const quantity = parseInt(item.querySelector('.quantity').value);
                        const rate = parseFloat(item.querySelector('.item-price').getAttribute('data-price'));
                        const amount = quantity * rate;

                        // Create a new object for each item and add order details
                        cartData.push({
                            "hotel_id": "value", // Replace with actual value
                            "mobile_no": "value", // Replace with actual value
                            "product_id": menuId,
                            "qty": quantity,
                            "rate": rate,
                            "amount": amount,
                            "sub_total": parseFloat(document.getElementById('item-total').innerText.replace('₹', '').trim()),
                            "total_discount": parseFloat(document.getElementById('item-total').innerText.replace('₹', '').trim()), // Replace with actual discount value if applicable
                            "total_taxable_amt": parseFloat(document.getElementById('item-total').innerText.replace('₹', '').trim()),
                            "total_tax_amt": parseFloat(document.getElementById('cgst-total').innerText.replace('₹', '').trim()) +
                                parseFloat(document.getElementById('sgst-total').innerText.replace('₹', '').trim()),
                            "extra_charges": "value", // Replace with actual value if applicable
                            "rounded_amt": parseFloat(document.getElementById('rounded-total').innerText.replace('₹', '').trim()),
                            "grand_amt": parseFloat(document.getElementById('rounded-total').innerText.replace('₹', '').trim()),
                            "delivery_mode": "value" // Replace with actual value
                        });
                    });

                    // Convert the cartData array into a single JSON structure
                    const combinedData = cartData.map(item => ({
                        "hotel_id": item.hotel_id,
                        "mobile_no": item.mobile_no,
                        "product_id": item.product_id,
                        "qty": item.qty,
                        "rate": item.rate,
                        "amount": item.amount,
                        "sub_total": item.sub_total,
                        "total_discount": item.total_discount,
                        "total_taxable_amt": item.total_taxable_amt,
                        "total_tax_amt": item.total_tax_amt,
                        "extra_charges": item.extra_charges,
                        "rounded_amt": item.rounded_amt,
                        "grand_amt": item.grand_amt,
                        "delivery_mode": item.delivery_mode
                    }));

                    console.log(combinedData); // Display the combined JSON data in the console

                    // Display combinedData in an alert
                    alert(JSON.stringify(combinedData, null, 2));

                    // Send the JSON data via a POST request
                    fetch('https://cors-anywhere.herokuapp.com/http://52.66.71.147/XpressPP_Running/placeorder.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(combinedData),
                    })
                        .then(response => {
                            // Check if the response is ok
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            // Try to parse the response as JSON
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Order confirmed!');
                                window.location.href = 'confirmation_page.php'; // Redirect to a confirmation page or handle success as needed
                            } else {
                                alert('Failed to confirm the order.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('There was a problem with your request. Please try again later.');
                        });
                } else {
                    alert('Order not confirmed.');
                }
            });
        </script>`



        <!-- JavaScript for updating totals -->
        <script>
            function updateTotals() {
                let itemTotal = 0;
                let cgstRate = 2.50;
                let sgstRate = 2.50;

                // Calculate the item total
                document.querySelectorAll('.cart-item').forEach((item) => {
                    let rate = parseFloat(item.querySelector('.item-price').getAttribute('data-price'));
                    let quantity = parseInt(item.querySelector('.quantity').value);

                    if (!isNaN(rate) && !isNaN(quantity) && quantity > 0) {
                        let totalPerItem = rate * quantity;
                        item.querySelector('.item-price').innerText = `₹${totalPerItem.toFixed(2)}`;
                        itemTotal += totalPerItem;
                    }
                });

                // Calculate CGST and SGST
                let cgstTotal = itemTotal * (cgstRate / 100);
                let sgstTotal = itemTotal * (sgstRate / 100);
                let totalToPay = itemTotal + cgstTotal + sgstTotal;

                // Calculate fractional part and rounded total
                let fractionalPart = totalToPay % 1; // Get fractional part (e.g., 0.50)
                let roundedTotalToPay = (fractionalPart >= 0.50) ? Math.ceil(totalToPay) : Math.floor(totalToPay);

                // Update the DOM with totals
                document.getElementById('item-total').innerText = `₹${itemTotal.toFixed(2)}`;
                document.getElementById('cgst-total').innerText = `₹${cgstTotal.toFixed(2)}`;
                document.getElementById('sgst-total').innerText = `₹${sgstTotal.toFixed(2)}`;

                // Display fractional amount (e.g., 0.50) and rounded total
                document.getElementById('fractional-amount').innerText = `₹${fractionalPart.toFixed(2)}`;
                document.getElementById('rounded-total').innerText = `₹${roundedTotalToPay.toFixed(2)}`;
            }

            // Ensure the updateTotals function runs when quantities change
            updateTotals();


            document.querySelectorAll('.increase-qty').forEach((button, index) => {
                button.addEventListener('click', () => {
                    let quantityInput = document.querySelectorAll('.quantity')[index];
                    let newQuantity = parseInt(quantityInput.value) + 1;
                    quantityInput.value = newQuantity;

                    let menuId = document.querySelectorAll('.cart-item')[index].getAttribute('data-menuid');
                    updateQuantityInDatabase(menuId, newQuantity);
                    updateTotals();
                });
            });

            document.querySelectorAll('.decrease-qty').forEach((button, index) => {
                button.addEventListener('click', () => {
                    let quantityInput = document.querySelectorAll('.quantity')[index];
                    let quantity = parseInt(quantityInput.value);

                    if (quantity > 1) {
                        let newQuantity = quantity - 1;
                        quantityInput.value = newQuantity;

                        let menuId = document.querySelectorAll('.cart-item')[index].getAttribute('data-menuid');
                        updateQuantityInDatabase(menuId, newQuantity);
                    } else if (quantity === 1) {
                        let cartItem = document.querySelectorAll('.cart-item')[index];
                        cartItem.remove();
                    }
                    updateTotals();
                });
            });

            function updateQuantityInDatabase(menuId, quantity) {
                let formData = new FormData();
                formData.append('menu_id', menuId);
                formData.append('quantity', quantity);

                fetch('update_quantity.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Failed to update quantity in the database');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            updateTotals();
        </script>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>