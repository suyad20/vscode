<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}
include "../koneksi.php";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Sidebar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
  />
</head>
<body class="flex min-h-screen bg-gray-100">

  <!-- Sidebar -->
  <div
    id="sidebar"
    class="fixed md:static top-0 left-0 h-screen w-64 bg-sky-600 text-white p-4 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50"
  >
    <h2 class="text-xl font-bold mb-4">Sidebar</h2>
    <ul class="space-y-2">
      <li>
        <a href="dashboard.php" class="block p-2 hover:bg-sky-700 rounded">
          <i class="fa-solid fa-house-user mr-2"></i>Dashboard
        </a>
      </li>
      <li>
        <a href="informasi.php" class="block p-2 hover:bg-sky-700 rounded">
          <i class="fa-solid fa-book mr-2"></i>Manajemen Informasi
        </a>
      </li>
      <li>
        <a href="#" class="block p-2 hover:bg-sky-700 rounded">
          <i class="fa-solid fa-file mr-2"></i>Manajemen Absensi
        </a>
      </li>
      <li>
        <a href="jadwal.php" class="block p-2 hover:bg-sky-700 rounded">
          <i class="fa-solid fa-calendar-check mr-2"></i>Manajemen Jadwal
        </a>
      </li>
      <li>
        <a href="statistik.php" class="block p-2 hover:bg-sky-700 rounded">
          <i class="fa-solid fa-chart-simple mr-2"></i>Statistik Kehadiran
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">
    <!-- Top Bar -->
    <div class="md:hidden bg-sky-800 text-white p-4 flex items-center justify-between fixed w-full z-40">
      <h1 class="text-lg font-bold">My Website</h1>
      <button id="toggleSidebar" class="text-white focus:outline-none text-2xl">
        ☰
      </button>
    </div>

    <!-- Main Area -->
    <main class="p-4 pt-16 md:pt-4">
      <h1 class="text-2xl font-bold mb-4">Welcome</h1>
      <p class="mb-4">This is the main content area.</p>

      <!-- Responsive Stat Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 mt-6">
        <div class="bg-white p-6 rounded-xl shadow cursor-pointer transform hover:scale-105 duration-200">
          <p class="text-3xl font-bold flex items-center justify-between">
            100 <i class="fa-solid fa-users"></i>
          </p>
          <p class="text-gray-500">Members</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow cursor-pointer transform hover:scale-105 duration-200">
          <p class="text-3xl font-bold flex items-center justify-between">
            100 <i class="fa-solid fa-chalkboard-user"></i>
          </p>
          <p class="text-gray-500">Speakers</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow cursor-pointer transform hover:scale-105 duration-200">
          <p class="text-3xl font-bold">##</p>
          <p class="text-gray-500">Lorem</p>
        </div>
        <div class="bg-sky-500 p-6 rounded-xl shadow cursor-pointer transform hover:scale-105 duration-200 text-white">
          <p class="text-3xl font-bold">Lorem</p>
          <p>Lorem</p>
        </div>
      </div>
    </main>
  </div>

  <!-- Script -->
  <script>
    const toggleBtn = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");

    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("-translate-x-full");
    });
  </script>
</body>
</html>
