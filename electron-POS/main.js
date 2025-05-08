const { app, BrowserWindow } = require('electron');
const { exec } = require('child_process');
const path = require('path');

let phpServer;

function createWindow () {
  const win = new BrowserWindow({
    width: 1280,
    height: 800,
    webPreferences: {
      contextIsolation: true,
    }
  });

  // Jalankan Laravel dengan php artisan serve
  const laravelPath = path.join(__dirname, '../Ujikom-POS');
  phpServer = exec(`php artisan serve --host=0.0.0.0 --port=1234`, { cwd: laravelPath });

  // Tunggu sebentar sebelum loadURL agar server sempat menyala
  setTimeout(() => {
    win.loadURL('http://168.168.10.12:1234');
  }, 2000); // atau 3000 ms kalau perlu

  // Optional: debug output
  phpServer.stdout.on('data', data => console.log(`[Laravel] ${data}`));
  phpServer.stderr.on('data', data => console.error(`[Laravel Error] ${data}`));
}

app.whenReady().then(createWindow);

app.on('will-quit', () => {
  if (phpServer) phpServer.kill();
});
