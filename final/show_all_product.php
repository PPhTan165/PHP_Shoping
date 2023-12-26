<?php
?>

<!DOCTYPE html>
<html>

<head>
  <title>Shopping-brand</title>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
      .search {
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .btn {
        border: 6px solid black;
      }

      .btn:hover {
        background-color: #0d4438;
        color: white;
      }

      .Searching {
        margin: 10px 10px;
      }

      .card-item {
        margin-top: 10px;
      }

      .num-page {
        color: black;
        margin: 0px 15px;
      }
    </style>
</head>

<body>
 

  <!-- Header-->
  <?php require_once('head.php'); ?>
      
  <!-- Container -->
  <div class="container">
    

    <div class='container text-center'>
      <div class='row'>
       
      <!-- Phan trang -->
      <?php 
      require_once("list_product.php")
      ?>

      </div>
    </div>

  </div>

  <!-- Footer -->
  <?php require_once("footer.php");?>

  <script>
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartCountElement = document.getElementById('cart-count');
    let cartCount = 0;

    addToCartButtons.forEach(button => {
      button.addEventListener('click', () => {
        cartCount++;
        cartCountElement.textContent = cartCount;
      });
    });

    // Ngăn chặn sự kiện mặc định khi nhấp vào liên kết giỏ hàng
    const cartLink = document.getElementById('cart-link');
    cartLink.addEventListener('click', (event) => {
      event.preventDefault();
    });
  </script>

</body>

</html>