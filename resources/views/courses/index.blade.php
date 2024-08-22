<h4 class="text-center font-weight-bold m-4">KURSUS</h4>
<div class="row mx-auto">
    @foreach($products as $product)
    <div class="card mr-2 ml-2 mb-4" style="width: 16rem;">
        <img src="{{ asset('images/produk/' . $product->foto_produk) }}" class="card-img-top" alt="...">
        <div class="card-body bg-light">
            <h5 class="card-title">{{ $product->nama_produk }}</h5>
            <p class="card-text">{{ 'Rp ' . number_format($product->hargaproduk, 0, ',', '.') }}</p>
            @if($product->stok_produk != 0)
                <a href="{{ route('detail', ['id' => $product->id_produk]) }}" class="btn btn-info">Detail</a>
            @else
                <strong class="badge badge-warning text-weight-bold">PENUH</strong>
            @endif
        </div>
    </div>
    @endforeach
</div>
