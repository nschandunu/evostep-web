<div
  id="cart-popup" 
  class="relative w-screen max-w-sm border border-gray-600 bg-gray-100 px-4 py-8 sm:px-6 lg:px-8 hidden"
  aria-modal="true"
  role="dialog"
  tabindex="-1"
>
  <button id="close-popup" class="absolute end-4 top-4 text-gray-600 transition hover:scale-110">
    <span class="sr-only">Close cart</span>

    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="size-5"
    >
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>

  <div class="mt-4 space-y-6">
    <ul class="space-y-4">
      <!-- PHP Loop to generate cart items dynamically -->
      <?php foreach ($cartItems as $item): ?>
        <li class="flex items-center gap-4">
          <img
            src="<?php echo $item['image_url']; ?>"
            alt="<?php echo $item['name']; ?>"
            class="size-16 rounded object-cover"
          />
          <div>
            <h3 class="text-sm text-gray-900"><?php echo $item['name']; ?></h3>
            <dl class="mt-0.5 space-y-px text-[10px] text-gray-600">
              <div>
                <dt class="inline">Size:</dt>
                <dd class="inline"><?php echo $item['size']; ?></dd>
              </div>
              <div>
                <dt class="inline">Color:</dt>
                <dd class="inline"><?php echo $item['color']; ?></dd>
              </div>
            </dl>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="space-y-4 text-center">
      <a
        href="view_cart.php"
        class="block rounded border border-gray-600 px-5 py-3 text-sm text-gray-600 transition hover:ring-1 hover:ring-gray-400"
      >
        View my cart (<?php echo count($cartItems); ?>)
      </a>

      <a
        href="checkout.php"
        class="block rounded bg-gray-700 px-5 py-3 text-sm text-gray-100 transition hover:bg-gray-600"
      >
        Checkout
      </a>

      <a
        href="#"
        class="inline-block text-sm text-gray-500 underline underline-offset-4 transition hover:text-gray-600"
        id="continue-shopping"
      >
        Continue shopping
      </a>
    </div>
  </div>
</div>