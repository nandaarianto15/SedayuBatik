<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Kami - SEDAYU BATIK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
    .lokasi-kami {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
}

.lokasi-kami h1 {
    margin-bottom: 20px;
}

.lokasi-container {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    flex-wrap: wrap; /* Responsif untuk layar kecil */
}

.map-container iframe {
    /* width: 100%; */
    max-width: 550px;
    height: 400px;
    border: 0;
    border-radius: 8px;
}

.lokasi-list {
    flex: 1;
    min-width: 300px;
    max-height: 400px;
    overflow-y: auto;
    padding-right: 5px;
}

.search-bar {
    display: flex;
    gap: 30px;
    margin-bottom: 20px;
}

.search-bar input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.search-bar button {
    padding: 10px 30px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.search-bar button:hover {
    background-color: #0056b3;
}

.lokasi-item {
    /* display: flex; */
    /* flex-direction: column; */
    position: relative;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
    /* background-color: #f9f9f9; */
    text-align: start;
    cursor: pointer;
}

.lokasi-item:hover {
    background-color: #eee;
}

.lokasi-item h3 {
    margin-bottom: 15px;
}

.lokasi-item p {
    margin: 5px 0 0;
    font-size: 14px;
    color: #555;
}

.lokasi-item i {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 20px;
    color: #595959;
}

</style>
<body>

    <?php include 'assets/components/navbar.php' ?>

    <div class="lokasi-kami">
    <h1>TOKO KAMI</h1>
    <div class="lokasi-container">
        <div class="map-container">
            <!-- Embed Google Maps -->
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6640524455893!2d117.15561146386142!3d-0.5038488247624902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f9e7cce7495%3A0x61022452c2cacfea!2sSamarinda%20Central%20Plaza!5e0!3m2!1sid!2sid!4v1732005236839!5m2!1sid!2sid" 
                width="600" 
                height="450"
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="lokasi-list">
            <div class="search-bar">
                <input type="text" placeholder="Alamat Toko">
                <button>Cari</button>
            </div>
            <div class="lokasi-item">
                <h3>Samarinda Central Plaza</h3>
                <p>Jl. P. Irian No.1, Pelabuhan, Samarinda Kota, KT 75112</p>
                <a href="https://maps.app.goo.gl/xc45dnZVqpBbrHju7" target="_blank">
                    <i class="fa-regular fa-map"></i>
                </a>
            </div>
            <div class="lokasi-item">
                <h3>BIGmall Samarinda</h3>
                <p>Jl. Untung Suropati, Karang Asam Ulu, Samarinda Kota, KT 75112</p>
                <a href="https://maps.app.goo.gl/LmZh2e5BiURfasb87" target="_blank">
                    <i class="fa-regular fa-map"></i>
                </a>
            </div>
            <div class="lokasi-item">
                <h3>Mall Lembuswana Samarinda</h3>
                <p>Jl. S. Parman, Gunung Kelua, Samarinda Ulu, KT 75124</p>
                <a href="https://maps.app.goo.gl/6oDwLXj64TV7an1V7" target="_blank">
                    <i class="fa-regular fa-map"></i>
                </a>
            </div>
            <!-- <div class="lokasi-item">
                <h3>City Centrum Samarinda</h3>
                <p>Jl. S. Parman, Gunung Kelua, Samarinda Ulu, KT 75124</p>
                <a href="https://maps.app.goo.gl/eUsM3ByunaUFAabv5" target="_blank">
                    <i class="fa-regular fa-map"></i>
                </a>
            </div>
            <div class="lokasi-item">
                <h3>Samarinda Square Mall</h3>
                <p>Jl. S. Parman, Gunung Kelua, Samarinda Ulu, KT 75124</p>
                <a href="">
                    <i class="fa-regular fa-map"></i>
                </a>
            </div> -->
            <div class="lokasi-item">
                <h3>Ewalk Balikpapan</h3>
                <p>Jl. S. Parman, Gunung Kelua, Samarinda Ulu, KT 75124</p>
                <a href="https://maps.app.goo.gl/8PfPdme8wBQ8hEmk7" target="_blank">
                    <i class="fa-regular fa-map"></i>
                </a>
            </div>
            <div class="lokasi-item">
                <h3>Plaza Balikpapan</h3>
                <p>Jl. S. Parman, Gunung Kelua, Samarinda Ulu, KT 75124</p>
                <a href="https://maps.app.goo.gl/13MPCQPcsopibsFG9" target="_blank">
                    <i class="fa-regular fa-map"></i>
                </a>
            </div>
        </div>
    </div>
</div>


    <?php include 'assets/components/footer.php' ?>

</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    const lokasiItems = document.querySelectorAll(".lokasi-item");
    const mapIframe = document.querySelector(".map-container iframe");
    const searchInput = document.querySelector(".search-bar input");

    // Data lokasi dengan URL Google Maps masing-masing
    const lokasiData = [
        {
            name: "Samarinda Central Plaza",
            url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6640524455893!2d117.15561146386142!3d-0.5038488247624902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f9e7cce7495%3A0x61022452c2cacfea!2sSamarinda%20Central%20Plaza!5e0!3m2!1sid!2sid!4v1732005236839!5m2!1sid!2sid"
        },
        {
            name: "BIGmall Samarinda",
            url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1994.825072470343!2d117.11514426297666!3d-0.5260703601831488!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f540a726c0d%3A0x1028f1a62624ffcb!2sBIGmall%20Samarinda!5e0!3m2!1sid!2sid!4v1732005261248!5m2!1sid!2sid"
        },
        {
            name: "Mall Lembuswana Samarinda",
            url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2372.2786015191987!2d117.1454673861278!3d-0.47511848038169635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f46a2d47d2f%3A0x907e27c39da576ed!2sMall%20Lembuswana%20Samarinda!5e0!3m2!1sid!2sid!4v1732005290431!5m2!1sid!2sid"
        },
        // {
        //     name: "City Centrum Samarinda",
        //     url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6645041695724!2d117.14946557627276!3d-0.5031105994919569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67faef674329b%3A0xad261ffa8714f2eb!2sCity%20Centrum%20Mall!5e0!3m2!1sid!2sid!4v1732005314330!5m2!1sid!2sid"
        // },
        // {
        //     name: "Samarinda Square Mall",
        //     url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.684099390506!2d117.14557965455452!3d-0.46997249976270716!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f2759d2a5c5%3A0xe804f5f99711bd4a!2sSamarinda%20Square%20Mal!5e0!3m2!1sid!2sid!4v1732005361291!5m2!1sid!2sid"
        // },
        {
            name: "Ewalk Balikpapan",
            url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4743.547696163461!2d116.85430599720665!3d-1.273864513329652!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df146e83289d193%3A0x16f3e8f377ffdff8!2seWalk!5e0!3m2!1sid!2sid!4v1732005490618!5m2!1sid!2sid"
        },
        {
            name: "Plaza Balikpapan",
            url: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7977.648973305084!2d116.8292330935791!3d-1.278871599999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df14725d5537ced%3A0x871680f80ece006c!2sPlaza%20Balikpapan!5e0!3m2!1sid!2sid!4v1732005540408!5m2!1sid!2sid"
        }
    ];

    // Fungsi untuk mengubah peta
    const updateMap = (url) => {
        mapIframe.src = url;
    };

    // Event Listener untuk klik pada lokasi-item
    lokasiItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            updateMap(lokasiData[index].url);
        });
    });

    // Fungsi untuk live search
    searchInput.addEventListener("input", (event) => {
        const searchTerm = event.target.value.toLowerCase();

        lokasiItems.forEach((item, index) => {
            const lokasiName = lokasiData[index].name.toLowerCase();
            if (lokasiName.includes(searchTerm)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
});

</script>
</html>