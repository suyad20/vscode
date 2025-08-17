// const express = require("express");
// const fs = require("fs");
// const app = express();

// app.use(express.json());
// app.use(express.static("public")); // supaya HTML/CSS/JS bisa diakses

// // Ambil jadwal
// app.get("/api/jadwal", (req, res) => {
//   const data = fs.readFileSync("jadwal.json");
//   res.json(JSON.parse(data));
// });

// // Simpan atau update jadwal
// app.post("/api/jadwal", (req, res) => {
//   fs.writeFileSync("jadwal.json", JSON.stringify(req.body, null, 2));
//   res.json({ message: "Jadwal berhasil disimpan" });
// });

// app.listen(3000, () => console.log("Server jalan di http://localhost:3000"));
