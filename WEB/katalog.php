<?php include 'koneksi.php'; ?> <!-- Hubungkan ke file koneksi -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav>
        <ul class="navbar">
            <li><a href="index.html">Kembali ke Beranda</a></li>
        </ul>
    </nav>

    <h1>Katalog Barang</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data dari tabel barang
            $sql = "SELECT * FROM barang";
            $result = $conn->query($sql);
            $no = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>" . htmlspecialchars($row['nama']) . "</td>
                        <td>" . htmlspecialchars($row['deskripsi']) . "</td>
                        <td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>
                        <td><button class='add-to-cart' data-nama='" . htmlspecialchars($row['nama']) . "' data-harga='" . $row['harga'] . "'>Tambah</button></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <h2>Keranjang</h2>
    <div id="cart">
        <table border="1" id="cart-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <h3>Total Harga: Rp <span id="total-price">0</span></h3>
    </div>

    <script>
        let cart = [];
        const cartTable = document.querySelector("#cart-table tbody");
        const totalPriceElement = document.getElementById("total-price");

        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", () => {
                const nama = button.getAttribute("data-nama");
                const harga = parseFloat(button.getAttribute("data-harga"));

                const itemIndex = cart.findIndex(item => item.nama === nama);
                if (itemIndex !== -1) {
                    cart[itemIndex].jumlah++;
                    cart[itemIndex].total = cart[itemIndex].jumlah * cart[itemIndex].harga;
                } else {
                    cart.push({ nama, harga, jumlah: 1, total: harga });
                }

                renderCart();
            });
        });

        function renderCart() {
            cartTable.innerHTML = "";
            let totalPrice = 0;

            cart.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.nama}</td>
                    <td>Rp ${item.harga.toLocaleString()}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${item.total.toLocaleString()}</td>
                `;
                cartTable.appendChild(row);
                totalPrice += item.total;
            });

            totalPriceElement.textContent = totalPrice.toLocaleString();
        }
    </script>
</body>
</html>