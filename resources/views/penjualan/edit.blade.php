<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Penjualan') }}
    </h2>
  </x-slot>
  @if (Session::has('status'))
    <div class="alert alert-{{ Session::get('status') }} w-1/2">
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <span>{{ Session::get('message') }}</span>
      <button class="close" onclick="closeAlert(this)">×</button>
    </div>
  @endif
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{ route('penjualan.update', $penjualan->id_penjualan) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <h2 class="text-2xl font-bold mb-4">Edit Penjualan</h2>
            <div class="mb-4">
              <label for="id_pembelian" class="block text-sm font-medium text-white">Tanggal Stok Pembelian:</label>
              <select id="id_pembelian" name="id_pembelian" required
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
                <option value="{{ $penjualan->pembelian->id_pembelian }}">{{ $penjualan->pembelian->tgl_pembelian . ' - ' . $penjualan->pembelian->pemasok->nama_pemasok }}</option>
                @foreach ($pembelian as $pem)
                  <option value="{{ $pem->id_pembelian }}">{{ $pem->tgl_pembelian . ' - ' . $pem->pemasok->nama_pemasok }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-4">
              <label for="tgl_penjualan" class="block text-sm font-medium text-white">Tanggal Penjualan:</label>
              <input type="date" id="tgl_penjualan" name="tgl_penjualan" required
                value="{{ $penjualan->tgl_penjualan }}"
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            </div>

            <div class="mb-4">
              <label for="id_pelanggan" class="block text-sm font-medium text-white">Nama Pelanggan:</label>
              <select id="id_pelanggan" name="id_pelanggan" required
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
                <option value="{{ $penjualan->pelanggan->id_pelanggan }}">{{ $penjualan->pelanggan->nama_pelanggan }}
                </option>
                @foreach ($pelanggan as $p)
                  <option value="{{ $p->id_pelanggan }}">{{ $p->nama_pelanggan }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-4">
              <label for="id_produk" class="block text-sm font-medium text-white">Nama Produk:</label>
              <select id="id_produk" name="id_produk" required
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
                <option value="{{ $penjualan->produk->id_produk }}">{{ $penjualan->produk->nama_produk }}</option>
                @foreach ($produk as $p)
                  <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-4">
              <label for="jumlah_produk" class="block text-sm font-medium text-white">Jumlah Produk:</label>
              <input type="number" id="jumlah_produk" name="jumlah_produk" required min="0"
                value="{{ $penjualan->jumlah_produk }}"
                class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
              Edit
            </button>
            <a href="/penjualan" class="btn">back</a>
          </form>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
