<?php
include "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Statistik Kehadiran</title>
  <link rel="stylesheet" href="../src/output.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      <li><a href="dashboard.php" class="block p-2 hover:bg-sky-700 rounded"><i class="fa-solid fa-house-user mr-2"></i>Dashboard</a></li>
      <li><a href="informasi.php" class="block p-2 hover:bg-sky-700 rounded"><i class="fa-solid fa-book mr-2"></i>Manajemen Informasi</a></li>
      <li><a href="absensi.php" class="block p-2 hover:bg-sky-700 rounded"><i class="fa-solid fa-file mr-2"></i>Manajemen Absensi</a></li>
      <li><a href="jadwal.php" class="block p-2 hover:bg-sky-700 rounded"><i class="fa-solid fa-calendar-check mr-2"></i>Manajemen Jadwal</a></li>
      <li><a href="#" class="block p-2 hover:bg-sky-700 rounded bg-sky-500"><i class="fa-solid fa-chart-simple mr-2"></i>Statistik Kehadiran</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">

    <!-- Top Bar -->
    <div class="md:hidden bg-sky-800 text-white p-4 flex items-center justify-between fixed w-full z-40">
      <h1 class="text-lg font-bold">Statistik Kehadiran</h1>
      <button id="toggleSidebar" class="text-2xl focus:outline-none">☰</button>
    </div>

    <!-- Main Area -->
    <main class="p-4 pt-16 md:pt-4">
      
      <!-- Judul dan Filter -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-2xl md:text-3xl font-medium text-sky-600 text-center md:text-left">Statistik Kehadiran Anggota</h1>
        <select id="filterOption" class="p-2 border rounded bg-sky-500 text-white cursor-pointer">
          <option value="weekly">Statistik Mingguan</option>
          <option value="monthly">Statistik Bulanan</option>
        </select>
      </div>

      <!-- Konten Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Tabel Kehadiran -->
        <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
          <h2 class="text-xl font-bold mb-4 text-sky-600">Daftar Kehadiran Anggota</h2>
          <table class="w-full border-collapse min-w-[500px]">
            <thead>
              <tr class="bg-sky-500 text-white">
                <th class="p-2 border">No. Reg</th>
                <th class="p-2 border">Nama Anggota</th>
                <th class="p-2 border">Pelajaran Konsentrasi</th>
              </tr>
            </thead>
            <tbody id="attendanceTable"></tbody>
          </table>
        </div>

        <!-- Grafik Kehadiran -->
        <div class="bg-white shadow rounded-lg p-4">
          <h2 class="text-xl font-bold mb-4 text-sky-600">Grafik Kehadiran</h2>
          <canvas id="attendanceChart"></canvas>
        </div>
      </div>
    </main>
  </div>

 
</body>
</html>
