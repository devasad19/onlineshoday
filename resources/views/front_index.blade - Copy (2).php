<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Shoday.com - আপনার বাজার এখন অনলাইনে</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- 🔝 Navbar -->
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-3">
      <h1 class="text-3xl font-bold text-green-600">
        Online Shoday<span class="text-gray-800">.com</span>
      </h1>

      <nav class="hidden md:flex space-x-6 text-sm font-medium">
        <a href="#" class="hover:text-green-600 transition">হোম</a>
        <a href="#" class="hover:text-green-600 transition">বাজার</a>
        <a href="#" class="hover:text-green-600 transition">দোকানদার</a>
        <a href="#" class="hover:text-green-600 transition">যোগাযোগ</a>
      </nav>

      <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition text-sm">
        লগইন / রেজিস্টার
      </button>
    </div>
  </header>

  <!-- 🌿 Hero Section -->
  <section class="bg-gradient-to-r from-green-100 via-green-50 to-white py-12">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6">
      <!-- Text -->
      <div class="md:w-1/2 text-center md:text-left mb-8 md:mb-0">
        <h2 class="text-4xl font-extrabold text-green-700 mb-4 leading-tight">
          আপনার স্থানীয় বাজার <br class="hidden md:block"/> এখন ঘরে বসেই 🛒
        </h2>
        <p class="text-gray-700 mb-6 text-lg">
          সবজি, মাছ, ফল, মাংস বা ইলেকট্রনিকস — যা চান, অর্ডার করুন Online Shoday থেকে। 
          বাজারে না গিয়ে ঘরেই ডেলিভারি পান।
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
          <input type="text" placeholder="আপনার বাজারের নাম লিখুন" class="px-4 py-3 border rounded-lg w-72 focus:ring-2 focus:ring-green-400 outline-none">
          <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
            এখনই খুঁজুন
          </button>
        </div>
      </div>

      <!-- Image -->
      <div class="md:w-1/2 flex justify-center">
        <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" alt="Online Shoday illustration" class="w-72 md:w-96 drop-shadow-lg">
      </div>
    </div>
  </section>

  <!-- 🔍 Filter Section -->
  <section class="max-w-7xl mx-auto px-6 py-8">
    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
      <h3 class="text-xl font-bold mb-4 text-green-700 flex items-center gap-2">
        🔎 পণ্য ফিল্টার করুন
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <select class="border px-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-400">
          <option>বাজার নির্বাচন করুন</option>
          <option>সাভার বাজার</option>
          <option>রাজশাহী বাজার</option>
          <option>চাঁদপুর বাজার</option>
        </select>

        <select class="border px-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-400">
          <option>দোকানের ধরন</option>
          <option>সবজি</option>
          <option>মাছ</option>
          <option>ইলেকট্রনিকস</option>
        </select>

        <select class="border px-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-400">
          <option>মূল্য সীমা</option>
          <option>৳০ - ৳১০০</option>
          <option>৳১০০ - ৳৫০০</option>
          <option>৳৫০০+</option>
        </select>

        <input type="text" placeholder="পণ্যের নাম লিখুন" class="border px-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-400">

        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
          ফিল্টার প্রয়োগ করুন
        </button>
      </div>
    </div>
  </section>

  <!-- 🛍️ Product Section -->
  <section class="max-w-7xl mx-auto px-6 pb-16">
    <div class="flex justify-between items-center mb-6">
      <h3 class="text-2xl font-bold text-green-700">🛒 জনপ্রিয় পণ্যসমূহ</h3>
      <a href="#" class="text-sm text-green-600 hover:underline">সব পণ্য দেখুন →</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      
      <!-- Product Card -->
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 relative group">
        <img src="https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?auto=format&fit=crop&w=600&q=60" 
             alt="সবজি" 
             class="rounded-lg w-full h-44 object-cover group-hover:scale-105 transition duration-300">
        <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500">
          ❤️
        </button>
        <div class="mt-4">
          <h4 class="font-bold text-lg">তাজা বেগুন</h4>
          <p class="text-green-600 font-semibold">৳৬০ / কেজি</p>
          <p class="text-sm text-gray-500">দোকান: আজিজ সবজি ঘর</p>
          <p class="text-sm text-gray-500 mb-3">বাজার: রাজশাহী বাজার</p>
          <button class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700 transition">
            বিস্তারিত দেখুন
          </button>
        </div>
      </div>

      <!-- আরও প্রোডাক্ট কপি করা যাবে -->
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 relative group">
        <img src="https://images.unsplash.com/photo-1580910051073-d943d77abc2a?auto=format&fit=crop&w=600&q=60" 
             alt="মাছ" 
             class="rounded-lg w-full h-44 object-cover group-hover:scale-105 transition duration-300">
        <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500">
          ❤️
        </button>
        <div class="mt-4">
          <h4 class="font-bold text-lg">রুই মাছ</h4>
          <p class="text-green-600 font-semibold">৳৩৫০ / কেজি</p>
          <p class="text-sm text-gray-500">দোকান: হোসেন ফিশ হাউস</p>
          <p class="text-sm text-gray-500 mb-3">বাজার: সাভার বাজার</p>
          <button class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700 transition">
            বিস্তারিত দেখুন
          </button>
        </div>
      </div>

    </div>
  </section>

  <!-- 🌱 Footer -->
  <footer class="bg-gray-900 text-gray-300 text-center py-6">
    <p>© ২০২৫ Online Shoday.com | আপনার বাজার, আপনার ঘরে 🏡</p>
  </footer>

</body>
</html>
