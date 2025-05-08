@extends('app')
<link rel="icon" href="{{ asset('images/logo/favicon.png') }}" type="image/png" />
@section('styles')
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <h3>Produk</h3>
        <hr>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="productContainer">
            @foreach ($data_produk as $key => $item)
                @php
                    $harga = (int)$item['harga_produk'];
                    $diskon = (int)$item['diskon_prpduk'];
                    $harga_akhir = $diskon > 0 ? $harga - ($harga * $diskon / 100) : $harga;
                @endphp
                <div class="col">
                    <div class="card h-100" id="cardproduct">
                        <img src="{{ $item['gambar_produk'] }}" class="card-img-top"
                            alt="{{ $item['nama_produk'] }}" height="200">
                        <div class="card-body">
                            <h5 class="card-title product-name">{{ $item['nama_produk'] }}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            @if($diskon > 0)
                                <li class="list-group-item">Diskon : {{ number_format($diskon, 0, ',', '.') }}%</li>
                                <li class="list-group-item" style="text-decoration: line-through;">Rp. {{ number_format($harga, 0, ',', '.') }}</li>
                            @endif
                            <li class="list-group-item">Rp. {{ number_format($harga_akhir, 0, ',', '.') }} </li>
                        </ul>
                        <div class="card-footer">
                            <button class="btn btn-success add-to-cart-button"
                                data-id="{{ $item['id_produk'] }}"
                                data-name="{{ $item['nama_produk'] }}"
                                data-price="{{ $harga_akhir }}"
                                data-stock="{{ $item['stok_produk'] }}"
                                data-diskon="{{ $diskon }}">Add</button>
                            <span id="stokbrg" class="form-text">
                                Stok : {{ $item['stok_produk'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-4">
        <h3>Keranjang</h3>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Keranjang</h5>
                <form action="{{ URL::asset('/kasir/transaksi/add') }}" method="POST" enctype="multipart/form-data"
                    id="checkoutForm">
                    @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select" aria-label="Default select example" id="member_transaksi"
                            name="member_transaksi" required>
                            @foreach ($data_member as $member)
                                <option value="{{ $member['id_customers'] }}"
                                    data-db-value="{{ $member['id_customers'] }}">{{ $member['nama_customers'] }}
                                </option>
                            @endforeach
                        </select>
                        <label for="member_transaksi">Member</label>
                    </div>

                    <!-- Informasi barang -->
                    <div class="mb-1" id="card-details">
                        <label class="form-label">Barang</label>
                    </div>
                    <hr>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                        <div class="form-floating is-invalid">
                            <input type="hidden" class="form-control-plaintext border-0" id="totalPriceRaw" name="totalharga_transaksi" readonly>
                            <input type="text" class="form-control-plaintext border-0" id="totalPrice" readonly>
                            <label for="harga_addproduk">Total Harga :</label>
                        </div>
                    </div>
                    <hr>

                    <!-- Total Bayar dan Kembalian -->
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control-plaintext border-0" id="totalPayment" name="totalbayar_transaksi">
                            <label for="harga_addproduk">Total Bayar :</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                        <div class="form-floating is-invalid">
                            <input type="hidden" class="form-control-plaintext border-0" id="changeRaw" name="kembalian_transaksi" readonly>
                            <input type="text" class="form-control-plaintext border-0" id="change" readonly>
                            <label for="harga_addproduk">Kembalian :</label>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    <button type="button" class="btn btn-danger" id="clearCart">Clear Keranjang</button>
                    <input type="hidden" id="cartData" name="cartData">
                </form>
            </div>
        </div>
    </div>
</div>

    @extends('kasir.modal.member.addmember')
@endsection
@section('scripts')
    <script>
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function unformatNumber(num) {
            return num.toString().replace(/\./g, "").replace(/[^0-9]/g, "");
        }

        $(document).ready(function () {
            var cartItems = [];



        // Formatting angka saat input
        const hargaInput = document.getElementById('totalPayment');

        [hargaInput].forEach(input => {
            input.addEventListener('input', function (e) {
                const raw = unformatNumber(e.target.value);
                if (!isNaN(raw)) {
                    e.target.value = formatNumber(raw);
                }
            });
        });

            // Disable tombol add-to-cart dari awal jika stok 0
            $('.add-to-cart-button').each(function () {
                var stock = $(this).data('stock');
                if (stock === null || stock === undefined || stock <= 0) {
                    $(this).prop('disabled', true);
                }
            });

            // Function to add product to cart
            function addToCart(product) {
                var stok = parseInt(product.siblings('#stokbrg').text().trim().split(':')[1].trim());

                if (stok <= 0) {
                    product.prop('disabled', true);
                    return;
                }

                var productId = product.data('id');
                var productName = product.data('name');
                var productPrice = parseInt(product.data('price'));
                var discountPrice = parseInt(product.data('diskon'));
                var quantity = 1;

                var existingProduct = $('#card-details').find('input[value="' + productName + '"]').closest('.row');

                if (existingProduct.length) {
                    quantity = parseInt(existingProduct.find('.product-quantity').val().replace('x', '')) + 1;
                    existingProduct.find('.product-quantity').val(quantity + 'x');
                } else {
                    var formattedPrice = 'Rp. ' + productPrice.toLocaleString('id-ID');

                    $('#card-details').append(
                        '<div class="mb-1">' +
                        '<div class="row">' +
                        '<div class="col-md-5">' +
                        '<input type="hidden" class="form-control-plaintext border-0 product-id" value="' + productId + '" readonly>' +
                        '<input type="text" class="form-control-plaintext border-0 product-name" value="' + productName + '" readonly>' +
                        '</div>' +
                        '<div class="col-md-5">' +
                        '<input type="text" class="form-control-plaintext border-0 product-priceshow" value="' + formattedPrice + '" readonly>' +
                        '<input type="hidden" class="product-price" value="' + productPrice + '">' +
                        '<input type="hidden" class="product-discount" value="' + discountPrice + '">' +
                        '</div>' +
                        '<div class="col-md-2">' +
                        '<input type="text" class="form-control-plaintext border-0 product-quantity" value="1x" readonly>' +
                        '</div>' +
                        '</div>'
                    );
                }

                // Update stok barang di UI
                stok--;
                product.siblings('#stokbrg').text('Stok : ' + stok);
                if (stok <= 0) {
                    product.prop('disabled', true);
                }

                calculateTotalPrice();
                calculateChange();
            }

            // Recalculate total
            function calculateTotalPrice() {
                var totalPrice = 0;
                $('.product-price').each(function () {
                    var price = parseInt($(this).val());
                    var quantity = parseInt($(this).closest('.row').find('.product-quantity').val());
                    totalPrice += price * quantity;
                });

                $('#totalPrice').data('raw-value', totalPrice);
                $('#totalPriceRaw').val(totalPrice.toFixed(0));
                $('#totalPrice').val(totalPrice.toLocaleString('id-ID'));
            }

            function calculateChange() {
                var totalPayment = parseFloat(unformatNumber($("#totalPayment").val())) || 0;
                var totalPriceRaw = parseFloat($("#totalPrice").data('raw-value')) || 0;
                var change = totalPayment - totalPriceRaw;

                $('#change').val(change.toLocaleString('id-ID'));
                $('#changeRaw').val(change.toFixed(0));

                // Enable/disable submit
                if (change >= 0 && totalPriceRaw > 0) {
                    $('button[type="submit"]').prop('disabled', false);
                } else {
                    $('button[type="submit"]').prop('disabled', true);
                }
            }

            function collectCartData() {
                var cartData = [];
                $('.row').each(function () {
                    var productId = $(this).find('.product-id').val();
                    var productName = $(this).find('.product-name').val();
                    var productPrice = parseFloat($(this).find('.product-price').val());
                    var quantity = parseInt($(this).find('.product-quantity').val());
                    var discount = parseInt($(this).find('.product-discount').val());
                    if (productName) {
                        cartData.push({
                            namaproduk_transaksi: productId,
                            hargaproduk_transaksi: productPrice,
                            kuantitas_transaksi: quantity,
                            potongan_transaksi: discount
                        });
                    }
                });
                $('#cartDataInput').val(JSON.stringify(cartData));
                return cartData;
            }

            // Button add-to-cart click
            $('.add-to-cart-button').click(function () {
                addToCart($(this));
            });

            $("#totalPayment").on("input", function () {
                calculateChange();
            });

            $("#checkoutForm").submit(function (event) {
                event.preventDefault();
                var cartData = collectCartData();
                $("#cartData").val(JSON.stringify(cartData.length > 0 ? cartData : []));
                $('#totalPayment').val(unformatNumber($('#totalPayment').val()));
                this.submit();
            });

            function resetCartItems() {
                cartItems = [];
            }

            $("#clearCart").click(function () {
                $('#card-details').children(':not(:first-child)').remove();
                $('#totalPrice').val('');
                $("#totalPayment").val('');
                $("#change").val('');
                $("#changeRaw").val('');
                $('#totalPriceRaw').val('');
                $('button[type="submit"]').prop('disabled', true);

                // Reset stok dan aktifkan tombol
                $('.add-to-cart-button').each(function () {
                    var stock = $(this).data('stock');
                    $(this).siblings('#stokbrg').text('Stok : ' + stock);
                    if (stock > 0) {
                        $(this).prop('disabled', false);
                    }
                });

                resetCartItems();
            });
        });
    </script>
@endsection
