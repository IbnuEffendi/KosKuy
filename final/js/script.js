const kosList = JSON.parse(document.getElementById('kosData').textContent);
let currentIndex = 0;
const itemsPerPage = 3;

function displayKos(startIndex) {
    const kosContainer = document.getElementById('kosContainer');
    kosContainer.innerHTML = '';

    for (let i = startIndex; i < startIndex + itemsPerPage && i < kosList.length; i++) {
        const kos = kosList[i];
        const kosItem = `
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="asset/kos/${kos.image_url}" class="card-img-top" alt="${kos.nama_kos}">
                    <div class="card-body">
                        <div class="price-and-button">
                            <h5 class="card-title"><strong>${kos.nama_kos}</strong></h5>
                            <p class="card-text"><i class="bi bi-star-fill highlight"></i><strong> 4.5</strong></p>
                        </div>
                        <p class="card-text"><i class="bi bi-geo-alt-fill highlight"></i> ${kos.alamat}</p>
                        <p class="card-text taggar">${kos.deskripsi}</p>
                        <p class="card-text"><i class="bi bi-tag-fill highlight"></i> <span class="highlight"><strong>Rp ${parseFloat(kos.harga).toLocaleString()}</strong></span>/bulan</p>
                        <a href="#" class="btn btn-primary">Sewa</a>
                    </div>
                </div>
            </div>
        `;
        kosContainer.insertAdjacentHTML('beforeend', kosItem);
    }
}

document.getElementById('nextBtn').addEventListener('click', () => {
    if (currentIndex + itemsPerPage < kosList.length) {
        currentIndex += itemsPerPage;
        displayKos(currentIndex);
    }
});

document.getElementById('prevBtn').addEventListener('click', () => {
    if (currentIndex - itemsPerPage >= 0) {
        currentIndex -= itemsPerPage;
        displayKos(currentIndex);
    }
});

// Initial display
displayKos(currentIndex);
displayKos(currentIndex);



