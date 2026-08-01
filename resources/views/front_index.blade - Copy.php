<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>eBazar.com - আপনার স্থানীয় বাজার এখন অনলাইনে</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- 🌟 হেডার / ন্যাভবার -->
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center px-4 py-3">
      <h1 class="text-2xl font-bold text-green-600">eBazar<span class="text-gray-800">.com</span></h1>
      <nav class="space-x-4 text-sm font-semibold">
        <a href="#" class="hover:text-green-600">হোম</a>
        <a href="#" class="hover:text-green-600">বাজার</a>
        <a href="#" class="hover:text-green-600">দোকানদার</a>
        <a href="#" class="hover:text-green-600">যোগাযোগ</a>
      </nav>
      <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
        লগইন / রেজিস্টার
      </button>
    </div>
  </header>

  <!-- 🌾 হিরো সেকশন -->
  <section class="bg-green-100 py-10">
    <div class="container mx-auto text-center px-4">
      <h2 class="text-3xl md:text-4xl font-bold mb-3 text-green-700">
        আপনার স্থানীয় বাজার এখন ঘরে বসেই
      </h2>
      <p class="text-gray-700 mb-6">
        গ্রামের বা শহরের দোকান থেকে অনলাইনে অর্ডার দিন — তাজা সবজি, ফল, মাছ, মাংস বা ইলেকট্রনিকস, সবকিছু আপনার দোরগোড়ায়।
      </p>
      <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <input type="text" placeholder="আপনার বাজারের নাম লিখুন (যেমন: সাভার বাজার)" class="px-4 py-2 border rounded-lg w-72">
        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
          খুঁজুন
        </button>
      </div>
    </div>
  </section>

  <!-- 🔍 ফিল্টার সেকশন -->
  <section class="container mx-auto px-4 py-6">
    <div class="bg-white p-4 rounded-lg shadow-md">
      <h3 class="text-lg font-bold mb-3">পণ্য ফিল্টার করুন</h3>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <select class="border px-3 py-2 rounded-lg w-full">
          <option>বাজার নির্বাচন করুন</option>
          <option>সাভার বাজার</option>
          <option>রাজশাহী বাজার</option>
          <option>চাঁদপুর বাজার</option>
        </select>

        <select class="border px-3 py-2 rounded-lg w-full">
          <option>দোকানের ধরন</option>
          <option>সবজি</option>
          <option>মাছ</option>
          <option>ইলেকট্রনিকস</option>
        </select>

        <select class="border px-3 py-2 rounded-lg w-full">
          <option>মূল্য সীমা</option>
          <option>৳০ - ৳১০০</option>
          <option>৳১০০ - ৳৫০০</option>
          <option>৳৫০০+</option>
        </select>

        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
          ফিল্টার প্রয়োগ করুন
        </button>
      </div>
    </div>
  </section>

  <!-- 🛒 প্রোডাক্ট সেকশন -->
  <section class="container mx-auto px-4 pb-12">
    <h3 class="text-2xl font-bold mb-6 text-green-700">জনপ্রিয় পণ্যসমূহ</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      
      <!-- 🧺 প্রোডাক্ট কার্ড -->
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 relative">
        <img src="https://images.unsplash.com/photo-1584306670954-c26b0d5b3f5b?auto=format&fit=crop&w=600&q=60" alt="সবজি" class="rounded-lg w-full h-40 object-cover">
        <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500">
          ❤️
        </button>
        <div class="mt-4">
          <h4 class="font-bold text-lg">তাজা টমেটো</h4>
          <p class="text-green-600 font-semibold">৳৭০ / কেজি</p>
          <p class="text-sm text-gray-500">দোকান: রহমান সবজি ঘর</p>
          <p class="text-sm text-gray-500 mb-3">বাজার: সাভার বাজার</p>
          <button class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
            বিস্তারিত দেখুন
          </button>
        </div>
      </div>

      <!-- আরও কার্ড কপি করে বাড়ানো যাবে -->
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 relative">
        <img src="https://images.unsplash.com/photo-1582284447923-4e4fbb7d4d60?auto=format&fit=crop&w=600&q=60" alt="সবজি" class="rounded-lg w-full h-40 object-cover">
        <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500">
          ❤️
        </button>
        <div class="mt-4">
          <h4 class="font-bold text-lg">তাজা শসা</h4>
          <p class="text-green-600 font-semibold">৳৬০ / কেজি</p>
          <p class="text-sm text-gray-500">দোকান: হোসেন স্টোর</p>
          <p class="text-sm text-gray-500 mb-3">বাজার: চাঁদপুর বাজার</p>
          <button class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
            বিস্তারিত দেখুন
          </button>
        </div>
      </div>

    </div>
  </section>

  <!-- ⚙️ ফুটার -->
  <footer class="bg-gray-900 text-gray-300 text-center py-6">
    <p>© ২০২৫ eBazar.com | আপনার বাজার, আপনার ঘরে</p>
  </footer>

</body>
</html>
