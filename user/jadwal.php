<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jadwal Kegiatan - User</title>
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
          <a href="./dashboard.html" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-house-user mr-2"></i>Dashboard</a
          >
        </li>
        <li>
          <a href="#" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-book mr-2"></i>Informasi</a
          >
        </li>
        <li>
          <a href="#" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-file mr-2"></i>Absensi</a
          >
        </li>
        <li>
          <a href="#" class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-calendar-check mr-2"></i>Jadwal</a
          >
        </li>
      </ul>
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col">
      <!-- Top Bar -->
      <div
        class="md:hidden bg-sky-600 text-white p-4 flex items-center justify-between"
      >
        <h1 class="text-lg font-bold">Jadwal Kegiatan</h1>
        <button id="toggleSidebar" class="text-white focus:outline-none">
          ☰
        </button>
      </div>

      <!-- Main Content -->
      <main class="p-4">
        <h1 class="text-2xl font-bold mb-4 text-sky-600">
          Jadwal Kegiatan Mingguan
        </h1>

        <!-- Tabel Jadwal -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
          <table class="min-w-full border border-sky-500">
            <thead>
              <tr class="bg-sky-500 text-white">
                <th class="py-2 px-4 border border-sky-500">Nama Kegiatan</th>
                <th class="py-2 px-4 border border-sky-500">Waktu</th>
                <th class="py-2 px-4 border border-sky-500">Tempat</th>
                <th class="py-2 px-4 border border-sky-500">Pemateri</th>
              </tr>
            </thead>
            <tbody id="jadwalTable"></tbody>
          </table>
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

      function renderTable() {
        const jadwal = JSON.parse(localStorage.getItem("jadwal")) || [];
        const tableBody = document.getElementById("jadwalTable");
        tableBody.innerHTML = "";

        jadwal.forEach((item, index) => {
          tableBody.innerHTML += `
          <tr class="${index % 2 === 0 ? "bg-white" : "bg-sky-50"}">
            <td class="py-2 px-4 border border-sky-500">${item.nama}</td>
            <td class="py-2 px-4 border border-sky-500">${item.waktu}</td>
            <td class="py-2 px-4 border border-sky-500">${item.tempat}</td>
            <td class="py-2 px-4 border border-sky-500">${item.pemateri}</td>
          </tr>
        `;
        });
      }

      // Load jadwal saat halaman dibuka
      renderTable();
    </script>
  </body>
</html>
