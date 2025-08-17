<?php
include "../koneksi.php";

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="../src/output.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
    />
  </head>
  <body class="flex min-h-screen">
    <!-- Sidebar -->
    <div
      id="sidebar"
      class="fixed md:static top-0 left-0 h-screen w-64 bg-sky-600 text-white p-4 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50"
    >
      <h2 class="text-xl font-bold mb-4">Sidebar</h2>
      <ul class="space-y-2">
        <li>
          <a href="dashboard.php" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-house-user mr-2"></i>Dashboard</a
          >
        </li>
        <li>
          <a href="informasi.php" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-book mr-2"></i>Manajemen Informasi</a
          >
        </li>
        <li>
          <a
            href="#"
            class="block p-2 hover:bg-sky-700 rounded bg-sky-500"
            ><i class="fa-solid fa-file mr-2"></i>Manajemen Absensi</a
          >
        </li>
        <li>
          <a href="jadwal.php" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-calendar-check mr-2"></i>Manajemen Jadwal</a
          >
        </li>
        <li>
          <a href="statistik.php" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-chart-simple mr-2"></i>Statistik Kehadiran</a
          >
        </li>
      </ul>
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col">
      <!-- Top Bar -->
      <div
        class="md:hidden bg-gray-800 text-white p-4 flex items-center justify-between"
      >
        <h1 class="text-lg font-bold">My Website</h1>
        <button id="toggleSidebar" class="text-white focus:outline-none">
          ☰
        </button>
      </div>

      <!-- Main Content -->
      <main class="p-4">
        <h1 class="text-2xl font-bold mb-4">Welcome</h1>
        <p>This is the main content area.</p>
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
