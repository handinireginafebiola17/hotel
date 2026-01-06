// js/3d-effects.js

// Fungsi untuk membuat partikel mengambang
function createFloatingParticles() {
    const container = document.createElement('div');
    container.className = 'particles-container';
    document.body.prepend(container);
    
    const colors = [
        'rgba(0, 219, 222, 0.1)',
        'rgba(252, 0, 255, 0.1)',
        'rgba(255, 255, 255, 0.05)',
        'rgba(71, 118, 230, 0.1)',
        'rgba(46, 204, 113, 0.1)'
    ];
    
    for (let i = 0; i < 25; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        
        const size = Math.random() * 60 + 20;
        const left = Math.random() * 100;
        const delay = Math.random() * 20;
        const duration = Math.random() * 25 + 20;
        
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${left}%`;
        particle.style.animationDelay = `${delay}s`;
        particle.style.animationDuration = `${duration}s`;
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];
        
        container.appendChild(particle);
    }
}

// Fungsi untuk menambahkan glass effect ke semua card
function applyGlassEffects() {
    // Tambah class ke semua card yang ada
    const cards = document.querySelectorAll('.card, .panel, .box');
    cards.forEach(card => {
        if (!card.classList.contains('glass-card')) {
            card.classList.add('glass-card');
        }
    });
    
    // Jika ada elemen dengan id content, main, container
    const mainContainers = document.querySelectorAll('#content, #main, .container, .content');
    mainContainers.forEach(container => {
        if (!container.classList.contains('glass-card')) {
            container.classList.add('glass-card');
        }
    });
}

// Fungsi untuk mengubah tabel menjadi 3D
function convertTablesTo3D() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        if (!table.classList.contains('table-3d')) {
            table.classList.add('table-3d');
        }
    });
}

// Fungsi untuk mengubah tombol menjadi 3D
function convertButtonsTo3D() {
    const buttons = document.querySelectorAll('button, .btn, input[type="submit"], a.btn');
    buttons.forEach(btn => {
        if (!btn.classList.contains('btn-3d') && !btn.classList.contains('btn-secondary')) {
            btn.classList.add('btn-3d');
        }
    });
}

// Fungsi untuk menambahkan efek parallax pada mouse movement
function addParallaxEffect() {
    document.addEventListener('mousemove', (e) => {
        const x = (e.clientX / window.innerWidth) * 10;
        const y = (e.clientY / window.innerHeight) * 10;
        
        // Efek pada glass cards
        document.querySelectorAll('.glass-card').forEach(card => {
            card.style.transform = `translate(${x/15}px, ${y/15}px)`;
        });
        
        // Efek pada sidebar jika ada
        const sidebar = document.querySelector('.sidebar, aside, nav');
        if (sidebar) {
            sidebar.style.transform = `translate(${x/30}px, ${y/30}px)`;
        }
    });
}

// Fungsi untuk menambahkan efek ketik pada judul
function typewriterEffect() {
    const titles = document.querySelectorAll('h1, h2');
    titles.forEach(title => {
        if (!title.classList.contains('h1-3d') && title.tagName === 'H1') {
            title.classList.add('h1-3d');
        }
        if (!title.classList.contains('h2-3d') && title.tagName === 'H2') {
            title.classList.add('h2-3d');
        }
    });
}

// Fungsi untuk mengubah form inputs
function styleFormInputs() {
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (!input.classList.contains('input-3d')) {
            input.classList.add('input-3d');
        }
    });
}

// Inisialisasi semua efek 3D
function init3DEffects() {
    // Tambah class ke body
    document.body.classList.add('background-3d');
    
    // Buat partikel
    createFloatingParticles();
    
    // Terapkan efek glass
    applyGlassEffects();
    
    // Konversi tabel
    convertTablesTo3D();
    
    // Konversi tombol
    convertButtonsTo3D();
    
    // Efek judul
    typewriterEffect();
    
    // Style form inputs
    styleFormInputs();
    
    // Tambah efek parallax
    addParallaxEffect();
    
    console.log('✅ 3D Effects Activated!');
}

// Jalankan ketika halaman siap
document.addEventListener('DOMContentLoaded', init3DEffects);