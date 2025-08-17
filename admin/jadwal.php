<?php
include "../koneksi.php";

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jadwal Kegiatan</title>
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
            href="absensi.php"
            class="block p-2 hover:bg-sky-700 rounded"
            ><i class="fa-solid fa-file mr-2"></i>Manajemen Absensi</a
          >
        </li>
        <li>
          <a href="#" class="block p-2 hover:bg-sky-700 rounded bg-sky-500"
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

        <!-- Form Admin -->
        <div class="bg-white p-4 rounded-lg shadow-lg mb-4">
          <h2 class="font-semibold mb-2">Tambah / Edit Jadwal</h2>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
            <input
              id="nama"
              type="text"
              placeholder="Nama Kegiatan"
              class="border p-2 rounded"
            />
            <input
              id="waktu"
              type="text"
              placeholder="Waktu"
              class="border p-2 rounded"
            />
            <input
              id="tempat"
              type="text"
              placeholder="Tempat"
              class="border p-2 rounded"
            />
            <input
              id="pemateri"
              type="text"
              placeholder="Pemateri"
              class="border p-2 rounded"
            />
          </div>
          <button
            id="saveBtn"
            class="bg-sky-500 text-white px-4 py-2 rounded mt-2 cursor-pointer hover:bg-sky-700"
          >
            Simpan
          </button>
        </div>

        <!-- Tabel Jadwal -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
          <table class="min-w-full border border-sky-500">
            <thead>
              <tr class="bg-sky-500 text-white">
                <th class="py-2 px-4 border border-sky-500">Nama Kegiatan</th>
                <th class="py-2 px-4 border border-sky-500">Waktu</th>
                <th class="py-2 px-4 border border-sky-500">Tempat</th>
                <th class="py-2 px-4 border border-sky-500">Pemateri</th>
                <th class="py-2 px-4 border border-sky-500">Aksi</th>
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

      let jadwal = JSON.parse(localStorage.getItem("jadwal")) || [
        {
          nama: "Rapat Koordinasi",
          waktu: "Senin, 10:00",
          tempat: "Ruang Meeting 1",
          pemateri: "----",
        },
      ];

      let editIndex = null;

      function renderTable() {
        const tableBody = document.getElementById("jadwalTable");
        tableBody.innerHTML = "";
        jadwal.forEach((item, index) => {
          tableBody.innerHTML += `
          <tr class="${index % 2 === 0 ? "bg-white" : "bg-sky-50"}">
            <td class="py-2 px-4 border border-sky-500">${item.nama}</td>
            <td class="py-2 px-4 border border-sky-500">${item.waktu}</td>
            <td class="py-2 px-4 border border-sky-500">${item.tempat}</td>
            <td class="py-2 px-4 border border-sky-500">${item.pemateri}</td>
            <td class="py-2 px-4 border border-sky-500">
              <button onclick="editJadwal(${index})" class="bg-yellow-400 px-2 py-1 rounded">Edit</button>
              <button onclick="hapusJadwal(${index})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
            </td>
          </tr>
        `;
        });
      }

      function simpanJadwal() {
        const nama = document.getElementById("nama").value;
        const waktu = document.getElementById("waktu").value;
        const tempat = document.getElementById("tempat").value;
        const pemateri = document.getElementById("pemateri").value;

        if (!nama || !waktu || !tempat || !pemateri) {
          alert("Semua field harus diisi!");
          return;
        }

        if (editIndex === null) {
          jadwal.push({ nama, waktu, tempat, pemateri });
        } else {
          jadwal[editIndex] = { nama, waktu, tempat, pemateri };
          editIndex = null;
        }

        localStorage.setItem("jadwal", JSON.stringify(jadwal));
        renderTable();

        document.getElementById("nama").value = "";
        document.getElementById("waktu").value = "";
        document.getElementById("tempat").value = "";
        document.getElementById("pemateri").value = "";
      }

      function editJadwal(index) {
        const item = jadwal[index];
        document.getElementById("nama").value = item.nama;
        document.getElementById("waktu").value = item.waktu;
        document.getElementById("tempat").value = item.tempat;
        document.getElementById("pemateri").value = item.pemateri;
        editIndex = index;
      }

      function hapusJadwal(index) {
        if (confirm("Hapus jadwal ini?")) {
          jadwal.splice(index, 1);
          localStorage.setItem("jadwal", JSON.stringify(jadwal));
          renderTable();
        }
      }

      document
        .getElementById("saveBtn")
        .addEventListener("click", simpanJadwal);

      renderTable();
    </script>
  </body>
</html>
