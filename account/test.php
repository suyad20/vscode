<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi Digital</title>
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- QR Code generation library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <!-- Signature Pad library -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <!-- SheetJS (XLSX) library for Excel export -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    
    <style>
        /* Custom styles for a cleaner look */
        body {
            font-family: 'Inter', sans-serif;
        }
        .signature-pad-container {
            border: 2px dashed #ccc;
            border-radius: 0.5rem;
            background-color: #f8f9fa;
        }
        canvas {
            width: 100%;
            height: 200px;
            cursor: crosshair;
        }
        /* Simple loading spinner */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body class="bg-gray-100 text-gray-800">

    <div id="app-container" class="container mx-auto p-4 md:p-8 max-w-4xl">
        <header class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-700">Aplikasi Absensi Digital</h1>
            <p class="text-gray-500 mt-2">Solusi paperless untuk acara dan rapat Anda.</p>
        </header>

        <!-- Loading Indicator -->
        <div id="loading-indicator" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="loader"></div>
        </div>
        
        <!-- Message/Alert Box -->
        <div id="message-box" class="fixed top-5 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg hidden transition-transform transform translate-x-full">
            <p id="message-text"></p>
        </div>

        <!-- PAGE 1: Organizer - Create Event -->
        <div id="page-organizer-create">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-center">Buat Acara Baru</h2>
                <div class="space-y-4">
                    <input type="text" id="eventName" placeholder="Masukkan Nama Acara (e.g., Rapat Kuartal Q3)" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button id="createEventBtn" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300">Buat Acara & Dapatkan QR Code</button>
                </div>
            </div>
        </div>

        <!-- PAGE 2: Organizer - Display QR Code & Attendance List -->
        <div id="page-organizer-dashboard" class="hidden">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-semibold mb-1">Acara: <span id="dashboardEventName" class="text-blue-600"></span></h2>
                <p class="text-sm text-gray-500 mb-4">Bagikan QR Code ini kepada peserta untuk melakukan absensi.</p>
                
                <div class="flex flex-col md:flex-row gap-6 items-center justify-center">
                    <div id="qrcode" class="p-4 border rounded-lg bg-white flex justify-center items-center"></div>
                    <div class="text-center md:text-left">
                         <p class="font-semibold">Pindai untuk Absen</p>
                         <p class="text-gray-600">Atau bagikan link di bawah ini:</p>
                         <input type="text" id="eventLink" readonly class="w-full mt-2 p-2 border rounded-lg bg-gray-100 text-sm">
                         <button id="copyLinkBtn" class="mt-2 text-sm bg-gray-200 py-1 px-3 rounded-md hover:bg-gray-300">Salin Link</button>
                    </div>
                </div>

                <hr class="my-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Daftar Hadir (<span id="attendeeCount">0</span> Peserta)</h3>
                    <button id="downloadExcelBtn" class="bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Download Excel
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-left">No.</th>
                                <th class="py-2 px-4 border-b text-left">Nama</th>
                                <th class="py-2 px-4 border-b text-left">Jabatan</th>
                                <th class="py-2 px-4 border-b text-left">Waktu Absen</th>
                                <th class="py-2 px-4 border-b text-center">Tanda Tangan</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceList">
                            <!-- Data absensi akan muncul di sini -->
                            <tr id="no-data-row"><td colspan="5" class="text-center py-4 text-gray-500">Belum ada peserta yang melakukan absensi.</td></tr>
                        </tbody>
                    </table>
                </div>
                 <button id="backToCreateBtn" class="mt-6 w-full bg-gray-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-600 transition duration-300">Buat Acara Lain</button>
            </div>
        </div>

        <!-- PAGE 3: Participant - Attendance Form -->
        <div id="page-participant-form" class="hidden">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-semibold mb-1 text-center">Formulir Kehadiran</h2>
                <p class="text-center text-gray-600 mb-6">Acara: <span id="formEventName" class="font-bold text-blue-600"></span></p>
                <div class="space-y-4">
                    <input type="text" id="participantName" placeholder="Nama Lengkap Anda" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" id="participantPosition" placeholder="Jabatan Anda" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    
                    <div>
                        <label class="block font-medium mb-2">Tanda Tangan Digital:</label>
                        <div class="signature-pad-container">
                            <canvas id="signature-pad"></canvas>
                        </div>
                        <button id="clearSignatureBtn" class="text-sm text-blue-600 hover:underline mt-2">Hapus Tanda Tangan</button>
                    </div>

                    <button id="submitAttendanceBtn" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300">Kirim Absensi</button>
                </div>
            </div>
        </div>
        
        <!-- PAGE 4: Thank You Page -->
        <div id="page-thank-you" class="hidden">
            <div class="bg-white p-8 rounded-xl shadow-md text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-4" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <h2 class="text-2xl font-bold">Terima Kasih!</h2>
                <p class="text-gray-600 mt-2">Absensi Anda telah berhasil direkam.</p>
            </div>
        </div>

        <!-- Copyright Footer -->
        <footer class="text-center mt-12 text-gray-500 text-sm">
            <p>Copyright &copy; 2025 by Hanjaya. All Rights Reserved.</p>
        </footer>

    </div>

    <!-- Firebase SDK -->
    <script type="module">
        // Import necessary Firebase modules
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getFirestore, collection, addDoc, doc, getDoc, onSnapshot, query, where, serverTimestamp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";
        import { getAuth, signInAnonymously, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";

        // --- CONFIGURATION ---
        // These variables will be provided by the environment.
        const firebaseConfig = {
  apiKey: "AIzaSyDIybpE6ETCw6nBz_OMxS2slo5MYm7a3m0",
  authDomain: "aplikasi-absensi-digital.firebaseapp.com",
  projectId: "aplikasi-absensi-digital",
  storageBucket: "aplikasi-absensi-digital.firebasestorage.app",
  messagingSenderId: "404105790571",
  appId: "1:404105790571:web:bb372dda36ad3f7f309d2e",
  measurementId: "G-SKSDS0VQ0L"
};
 // Fallback for local dev
        
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-absensi-app';

        // --- INITIALIZATION ---
        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);
        const auth = getAuth(app);

        // --- STATE MANAGEMENT ---
        let currentUser = null;
        let currentEventId = null;
        let signaturePad;
        let attendeesData = []; // To store data for Excel export

        // --- UI ELEMENTS ---
        const pages = {
            create: document.getElementById('page-organizer-create'),
            dashboard: document.getElementById('page-organizer-dashboard'),
            form: document.getElementById('page-participant-form'),
            thankYou: document.getElementById('page-thank-you'),
        };
        const loadingIndicator = document.getElementById('loading-indicator');

        // --- HELPER FUNCTIONS ---
        const showLoading = (show) => {
            loadingIndicator.classList.toggle('hidden', !show);
        };
        
        const showMessage = (text, isError = false) => {
            const box = document.getElementById('message-box');
            const textEl = document.getElementById('message-text');
            textEl.textContent = text;
            box.className = `fixed top-5 right-5 text-white py-2 px-4 rounded-lg shadow-lg transition-transform transform ${isError ? 'bg-red-500' : 'bg-green-500'}`;
            box.classList.remove('translate-x-full');
            setTimeout(() => {
                box.classList.add('translate-x-full');
            }, 3000);
        };

        const showPage = (pageName) => {
            Object.values(pages).forEach(page => page.classList.add('hidden'));
            if (pages[pageName]) {
                pages[pageName].classList.remove('hidden');
            }
        };
        
        // --- FIREBASE COLLECTIONS ---
        // Using a public path as attendance data is shared between organizer and participants
        const eventsCollection = collection(db, `artifacts/${appId}/public/data/events`);
        const attendeesCollection = collection(db, `artifacts/${appId}/public/data/attendees`);

        // --- CORE LOGIC ---

        // 1. Handle Page Routing on Load
        const handleRouting = async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const eventId = urlParams.get('eventId');
            
            if (eventId) {
                // This is a participant
                currentEventId = eventId;
                await setupParticipantForm(eventId);
            } else {
                // This is an organizer
                showPage('create');
            }
        };

        // 2. Setup for Participant Form
        const setupParticipantForm = async (eventId) => {
            showLoading(true);
            try {
                const eventRef = doc(db, `artifacts/${appId}/public/data/events`, eventId);
                const eventSnap = await getDoc(eventRef);

                if (eventSnap.exists()) {
                    document.getElementById('formEventName').textContent = eventSnap.data().name;
                    showPage('form');
                    initializeSignaturePad();
                } else {
                    showMessage('Acara tidak ditemukan. Pastikan link atau QR Code benar.', true);
                    showPage('create'); // Fallback to create page
                }
            } catch (error) {
                console.error("Error fetching event details:", error);
                showMessage('Gagal memuat detail acara.', true);
                showPage('create');
            } finally {
                showLoading(false);
            }
        };

        // 3. Initialize Signature Pad
        const initializeSignaturePad = () => {
            const canvas = document.getElementById('signature-pad');
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(248, 249, 250)'
            });
            document.getElementById('clearSignatureBtn').addEventListener('click', () => {
                signaturePad.clear();
            });
        };

        // 4. Organizer Creates an Event
        document.getElementById('createEventBtn').addEventListener('click', async () => {
            const eventName = document.getElementById('eventName').value.trim();
            if (!eventName) {
                showMessage('Nama acara tidak boleh kosong.', true);
                return;
            }
            if (!currentUser) {
                showMessage('Harap tunggu, sedang mengautentikasi...', true);
                return;
            }

            showLoading(true);
            try {
                const newEvent = await addDoc(eventsCollection, {
                    name: eventName,
                    organizerId: currentUser.uid,
                    createdAt: serverTimestamp()
                });
                currentEventId = newEvent.id;
                setupOrganizerDashboard(eventName, newEvent.id);
                showMessage('Acara berhasil dibuat!');
            } catch (error) {
                console.error("Error creating event:", error);
                showMessage('Gagal membuat acara. Coba lagi.', true);
            } finally {
                showLoading(false);
            }
        });
        
        // 5. Setup Organizer Dashboard
        const setupOrganizerDashboard = (eventName, eventId) => {
            document.getElementById('dashboardEventName').textContent = eventName;
            
            // Generate QR Code
            const qrCodeContainer = document.getElementById('qrcode');
            qrCodeContainer.innerHTML = ''; // Clear previous QR code
            const eventUrl = `${window.location.origin}${window.location.pathname}?eventId=${eventId}`;
            new QRCode(qrCodeContainer, {
                text: eventUrl,
                width: 180,
                height: 180,
            });

            // Display and copy link
            const eventLinkInput = document.getElementById('eventLink');
            eventLinkInput.value = eventUrl;
            document.getElementById('copyLinkBtn').addEventListener('click', () => {
                eventLinkInput.select();
                document.execCommand('copy');
                showMessage('Link berhasil disalin!');
            });

            showPage('dashboard');
            listenForAttendees(eventId);
        };

        // 6. Listen for New Attendees in Real-time
        let unsubscribe; // To store the listener cleanup function
        const listenForAttendees = (eventId) => {
            const q = query(attendeesCollection, where("eventId", "==", eventId));
            
            // Unsubscribe from previous listener if it exists
            if (unsubscribe) {
                unsubscribe();
            }

            unsubscribe = onSnapshot(q, (querySnapshot) => {
                const listElement = document.getElementById('attendanceList');
                listElement.innerHTML = ''; // Clear list
                attendeesData = []; // Clear data for export
                let count = 0;

                if (querySnapshot.empty) {
                    listElement.innerHTML = `<tr id="no-data-row"><td colspan="5" class="text-center py-4 text-gray-500">Belum ada peserta yang melakukan absensi.</td></tr>`;
                } else {
                    querySnapshot.forEach(doc => {
                        count++;
                        const data = doc.data();
                        attendeesData.push(data); // Add to export data array
                        
                        const timestamp = data.timestamp?.toDate ? data.timestamp.toDate().toLocaleString('id-ID') : 'N/A';
                        const row = `
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b">${count}</td>
                                <td class="py-2 px-4 border-b">${data.name}</td>
                                <td class="py-2 px-4 border-b">${data.position}</td>
                                <td class="py-2 px-4 border-b">${timestamp}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    <img src="${data.signature}" alt="Tanda tangan" class="h-8 w-20 object-contain mx-auto">
                                </td>
                            </tr>
                        `;
                        listElement.innerHTML += row;
                    });
                }
                document.getElementById('attendeeCount').textContent = count;
            }, (error) => {
                console.error("Error listening for attendees:", error);
                showMessage("Gagal memuat data absensi secara real-time.", true);
            });
        };

        // 7. Participant Submits Attendance
        document.getElementById('submitAttendanceBtn').addEventListener('click', async () => {
            const name = document.getElementById('participantName').value.trim();
            const position = document.getElementById('participantPosition').value.trim();

            if (!name || !position) {
                showMessage('Nama dan Jabatan harus diisi.', true);
                return;
            }
            if (signaturePad.isEmpty()) {
                showMessage('Tanda tangan tidak boleh kosong.', true);
                return;
            }

            showLoading(true);
            const signatureDataURL = signaturePad.toDataURL('image/png');

            try {
                await addDoc(attendeesCollection, {
                    eventId: currentEventId,
                    name: name,
                    position: position,
                    signature: signatureDataURL,
                    timestamp: serverTimestamp()
                });
                showPage('thankYou');
            } catch (error) {
                console.error("Error submitting attendance:", error);
                showMessage('Gagal mengirim absensi. Coba lagi.', true);
            } finally {
                showLoading(false);
            }
        });
        
        // 8. Download Data as Excel
        document.getElementById('downloadExcelBtn').addEventListener('click', () => {
            if (attendeesData.length === 0) {
                showMessage('Tidak ada data untuk diunduh.', true);
                return;
            }

            const dataToExport = attendeesData.map(item => ({
                'Nama': item.name,
                'Jabatan': item.position,
                'Waktu Absen': item.timestamp?.toDate ? item.timestamp.toDate().toLocaleString('id-ID') : 'N/A',
                'Tanda Tangan (Data URL)': item.signature
            }));

            const worksheet = XLSX.utils.json_to_sheet(dataToExport);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Daftar Hadir");

            // Auto-adjust column widths
            const cols = Object.keys(dataToExport[0]);
            const colWidths = cols.map(key => ({
                wch: Math.max(...dataToExport.map(item => item[key] ? item[key].toString().length : 0), key.length) + 2
            }));
            worksheet['!cols'] = colWidths;

            const eventName = document.getElementById('dashboardEventName').textContent;
            XLSX.writeFile(workbook, `Absensi - ${eventName}.xlsx`);
            showMessage('Laporan Excel sedang diunduh.');
        });
        
        // 9. Go back to create another event
        document.getElementById('backToCreateBtn').addEventListener('click', () => {
            // Clear dashboard state
            if (unsubscribe) unsubscribe();
            document.getElementById('eventName').value = '';
            document.getElementById('attendanceList').innerHTML = `<tr id="no-data-row"><td colspan="5" class="text-center py-4 text-gray-500">Belum ada peserta yang melakukan absensi.</td></tr>`;
            document.getElementById('attendeeCount').textContent = '0';
            currentEventId = null;
            // Reset URL
            history.pushState({}, '', window.location.pathname);
            showPage('create');
        });

        // --- AUTHENTICATION & APP START ---
        onAuthStateChanged(auth, (user) => {
            if (user) {
                // User is signed in.
                currentUser = user;
                handleRouting(); // Start the app logic after auth is ready
            } else {
                // User is signed out. Sign in anonymously.
                signInAnonymously(auth).catch((error) => {
                    console.error("Anonymous sign-in failed:", error);
                    showMessage("Gagal menginisialisasi sesi. Harap refresh halaman.", true);
                });
            }
        });

    </script>
</body>
</html>