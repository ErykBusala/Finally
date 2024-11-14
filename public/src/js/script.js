
//scrollbar card
const scrollableContainer = document.getElementById('scrollable-Pre-Order');
const scrollLeftBtn = document.getElementById('scrollLeftS');
const scrollRightBtn = document.getElementById('scrollRightS');

// Pastikan bahwa semua elemen ditemukan sebelum menggunakan scrollBy
if (scrollableContainer && scrollLeftBtn && scrollRightBtn) {
    scrollLeftBtn.style.display = 'block';
    scrollRightBtn.style.display = 'block';

    scrollLeftBtn.addEventListener('click', () => {
        scrollableContainer.scrollBy({
            left: -250, // Ganti sesuai dengan jumlah piksel untuk menggulir
            behavior: 'smooth'
        });
    });

    scrollRightBtn.addEventListener('click', () => {
        scrollableContainer.scrollBy({
            left: 250, // Ganti sesuai dengan jumlah piksel untuk menggulir
            behavior: 'smooth'
        });
    });
} else {
    console.error("Element scrollableContainer or buttons not found.");
}

//nyembunyiin di mobile
document.addEventListener("DOMContentLoaded", function() {
    const rentalItem = document.querySelector('.nav-item-rental');
    const purchaseItem = document.querySelector('.nav-item-purchase');

    function toggleMenuItems() {
        if (window.innerWidth <= 576) { // Ukuran mobile
            rentalItem.classList.add('d-none'); // Sembunyikan menu Penyewaan
            purchaseItem.classList.add('d-none');
        } else {
            rentalItem.classList.remove('d-none'); // Tampilkan menu Penyewaan
            purchaseItem.classList.remove('d-none');
        }
    }

    // Inisialisasi pada load
    toggleMenuItems();

    // Menyembunyikan atau menampilkan item menu saat ukuran jendela berubah
    window.addEventListener('resize', toggleMenuItems);
});

 document.addEventListener("DOMContentLoaded", function() {
     const left = document.getElementById('scrollLeftS');
     const right = document.getElementById('scrollRightS');

     function toggleMenubutton() {
         if (window.innerWidth <= 576) { // Ukuran mobile
             left.classList.add('d-none'); // Sembunyikan menu Penyewaan
             right.classList.add('d-none'); // Sembunyikan menu Pembelian
         } else {
             left.classList.remove('d-none'); // Tampilkan menu Penyewaan
             right.classList.remove('d-none'); // Tampilkan menu Pembelian
         }
     }

     // Inisialisasi pada load
     toggleMenubutton();

     // Menyembunyikan atau menampilkan item menu saat ukuran jendela berubah
     window.addEventListener('resize', toggleMenubutton);
 });



 // nyembunyiin produk
 document.addEventListener("DOMContentLoaded", function() {
     const pForm = document.getElementById('produk');

     function togglePForm() {
         if (window.innerWidth > 576) { // Ukuran desktop
             pForm.classList.add('p-none'); // Sembunyikan form pencarian
         } else {
             pForm.classList.remove('p-none'); // Tampilkan form pencarian
         }
     }

     // Inisialisasi pada load
     togglePForm();

     // Menyembunyikan atau menampilkan form pencarian saat ukuran jendela berubah
     window.addEventListener('resize', toggleSearchForm);
 });
 document.addEventListener("DOMContentLoaded", function() {
     const searchForm = document.getElementById('searcah2');

     function toggleSearchForm() {
         if (window.innerWidth > 576) { // Ukuran desktop
             searchForm.classList.add('d-none'); // Sembunyikan form pencarian
         } else {
             searchForm.classList.remove('d-none'); // Tampilkan form pencarian
         }
     }

     // Inisialisasi pada load
     toggleSearchForm();

     // Menyembunyikan atau menampilkan form pencarian saat ukuran jendela berubah
     window.addEventListener('resize', toggleSearchForm);
 });

 // Menyembunyikan tombol pencarian saat navbar dibuka di perangkat mobile
 const navbarToggler = document.querySelector('.navbar-toggler');
 const searchButton = document.querySelector('#search');

 navbarToggler.addEventListener('click', function() {
     // Toggle class 'd-none' pada tombol pencarian
     searchButton.classList.toggle('d-none');
 });

 document.addEventListener("DOMContentLoaded", function() {
     const searchButton = document.querySelector('button[type="submit"]');
     const searchInput = document.querySelector('.form-control');

     searchButton.addEventListener('click', function(event) {
         event.preventDefault(); // Mencegah form untuk disubmit saat tombol diklik
         searchInput.classList.toggle('expanded'); // Toggle kelas expanded
     });
 });
 document.addEventListener("DOMContentLoaded", function() {
     const scrollLeftBtn = document.getElementById('scrollLeftS');
     const scrollRightBtn = document.getElementById('scrollRightS');
     
     function toggleScrollButtons() {
         if (window.innerWidth <= 576) { // On mobile
             scrollLeftBtn.classList.add('d-none'); // Hide left scroll button
             scrollRightBtn.classList.add('d-none'); // Hide right scroll button
         } else {
             scrollLeftBtn.classList.remove('d-none'); // Show left scroll button
             scrollRightBtn.classList.remove('d-none'); // Show right scroll button
         }
     }
     
     // Initialize on page load
     toggleScrollButtons();
     
     // Update buttons visibility on window resize
     window.addEventListener('resize', toggleScrollButtons);
 });

//  video

function expandCard(selectedCard) {
    // Menghapus kelas 'active' dari semua card
    let cards = document.querySelectorAll('.card');
    cards.forEach(card => {
      card.classList.remove('active');
    });
  
    // Menambahkan kelas 'active' ke card yang diklik
    selectedCard.classList.add('active');
  }
  


  document.addEventListener('DOMContentLoaded', function () {
    // Mengambil semua notifikasi item
    const notificationItems = document.querySelectorAll('.notification-item');

    notificationItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();  // Mencegah aksi default link

            const notificationId = this.dataset.id;
            const productId = this.dataset.productId;

            // Menandai notifikasi sebagai sudah dibaca dengan AJAX
            fetch(`world.php?mark_as_read=${notificationId}`)
                .then(response => response.text())
                .then(data => {
                    // Update badge dengan 0 (notifikasi sudah dibaca)
                    document.getElementById('notificationBadge').textContent = '0';

                    // Menampilkan detail pesanan produk terkait
                    fetch(`get_product_details.php?product_id=${productId}`)
                        .then(response => response.json())
                        .then(productData => {
                            // Menampilkan detail pesanan dalam modal atau box
                            displayProductDetails(productData);
                        })
                        .catch(error => console.error('Error fetching product details:', error));
                })
                .catch(error => console.error('Error marking notification as read:', error));
        });
    });
});

// Fungsi untuk menampilkan detail produk dalam sebuah modal atau box
function displayProductDetails(productData) {
    const detailsBox = document.getElementById('productDetailsBox');

    // Jika box tidak ada, buat dulu
    if (!detailsBox) {
        const newBox = document.createElement('div');
        newBox.id = 'productDetailsBox';
        newBox.className = 'product-details-box';
        document.body.appendChild(newBox);
    }

    // Menampilkan data produk di dalam box
    const productBox = document.getElementById('productDetailsBox');
    productBox.innerHTML = `
        <h3>Detail Produk</h3>
        <p><strong>Nama Produk:</strong> ${productData.name}</p>
        <p><strong>Stok:</strong> ${productData.stock}</p>
        <p><strong>Harga:</strong> ${productData.price}</p>
        <p><strong>Tanggal Selesai Penyewaan:</strong> ${productData.rental_end_date}</p>
    `;
}
