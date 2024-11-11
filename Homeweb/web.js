// script.js
document.addEventListener('DOMContentLoaded', function() {
    const dropdownLink = document.querySelector('.dropdown-link');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    // Menambahkan event listener untuk mengklik dropdown link
    dropdownLink.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah link melakukan navigasi
        // Toggle display dropdown menu
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        } else {
            dropdownMenu.style.display = 'block';
        }
    });
    function changeCity(city) {
        console.log("City changed to:", city); // Debug log
        document.getElementById('selected-city').textContent = city;
    }
    // Menyembunyikan dropdown jika klik di luar dropdown
    window.addEventListener('click', function(event) {
        if (!dropdownLink.contains(event.target)) {
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            }
        }
    });
});
// script.js
document.addEventListener('DOMContentLoaded', function() {
    const dropdownLink = document.querySelector('.dropdown-link2');
    const dropdownMenu = document.querySelector('.dropdown-menu2');

    // Event listener for clicking the dropdown link
    dropdownLink.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent link navigation
        // Toggle the display of the dropdown menu
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Function to change the selected city
    window.changeCity = function(city) {
        console.log("City changed to:", city); // Debug log
        document.getElementById('selected-city').textContent = city;
        dropdownMenu.style.display = 'none'; // Hide dropdown after selection
    };

    // Hide dropdown if clicking outside of it
    window.addEventListener('click', function(event) {
        if (!dropdownLink.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none'; // Hide dropdown
        }
    });
});

//buat geser
let currentIndex = 1; // Memulai dengan item tengah sebagai aktif

function moveCarousel(direction) {
  const items = document.querySelectorAll('.carousel-item');
  const totalItems = items.length;

  // Hilangkan kelas 'active' dari item saat ini
  items[currentIndex].classList.remove('active');

  // Update index berdasarkan arah
  currentIndex = (currentIndex + direction + totalItems) % totalItems;

  // Tambahkan kelas 'active' ke item baru
  items[currentIndex].classList.add('active');

  // Geser carousel track agar item aktif berada di tengah
  const track = document.querySelector('.carousel-track');
  const offset = -((currentIndex - 1) * 33.33); // Hitung posisi berdasarkan item aktif
  track.style.transform = `translateX(${offset}%)`;
}

//komentar
document.querySelectorAll('.faq-question').forEach((item) => {
    item.addEventListener('click', function () {
      const faqItem = this.parentElement;
      faqItem.classList.toggle('active');
    });
  });


  