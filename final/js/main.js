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