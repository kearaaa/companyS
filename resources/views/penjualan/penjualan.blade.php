<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Penjualan') }}
    </h2>
  </x-slot>

  <div class="px-12 flex justify-between">
    <!-- Open the modal using ID.showModal() method -->
    <button class="rounded-b-lg text-white p-2 outline outline-1 outline-blue-500 hover:bg-blue-500"
      onclick="my_modal_3.showModal()">Input Data</button>

      @if (Session::has('status'))
      <div class="toast">
        <div class="alert alert-{{ Session::get('status') }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ Session::get('message') }}</span>
          <button class="close" onclick="closeAlert(this)">×</button>
        </div>
      </div>
    @endif

    @if ($errors->any())
      <div class="toast">
        <div class="alert alert-error">
          <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button class="close" onclick="closeAlert(this)">×</button>
        </div>
      </div>
    @endif
  </div>

  <dialog id="my_modal_3" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>

      <form action="{{ route('penjualan') }}" method="post" autocomplete="off">
        @csrf
        <h2 class="text-2xl font-bold mb-4">Input Penjualan</h2>
        <div class="mb-4">
          <label for="id_pembelian" class="block text-sm font-medium text-white">Tanggal Stok Pembelian:</label>
          <select id="id_pembelian" name="id_pembelian" required
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            @foreach ($pembelian as $pem)
              <option value="{{ $pem->id_pembelian }}">{{ $pem->tgl_pembelian . ' - ' . $pem->pemasok->nama_pemasok }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-4">
          <label for="tgl_penjualan" class="block text-sm font-medium text-white">Tanggal Penjualan:</label>
          <input type="date" id="tgl_penjualan" name="tgl_penjualan" required
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
        </div>

        <!-- Sisipkan elemen-elemen input lainnya sesuai kebutuhan Anda -->
        <div class="mb-4">
          <label for="id_pelanggan" class="block text-sm font-medium text-white">Nama Pelanggan:</label>
          <select id="id_pelanggan" name="id_pelanggan" required
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            <option selected>select pelanggan</option>
            @foreach ($pelanggan as $p)
              <option value="{{ $p->id_pelanggan }}">{{ $p->nama_pelanggan }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-4">
          <label for="id_produk" class="block text-sm font-medium text-white">Nama Produk:</label>
          <select id="id_produk" name="id_produk" required
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            <option selected>select produk</option>
            @foreach ($produk as $p)
              <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-4">
          <label for="jumlah_produk" class="block text-sm font-medium text-white">Jumlah Produk:</label>
          <input type="number" id="jumlah_produk" name="jumlah_produk" required min="1"
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
          Input
        </button>
      </form>
    </div>
  </dialog>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <table class="w-full table">
            <thead>
              <tr>
                <th class="text-left">Nomer</th>
                <th class="text-left">Tanggal Penjualan</th>
                <th class="text-left">Stok Tanggal Pembelian</th>
                <th class="text-left">Nama Pelanggan</th>
                <th class="text-left">Nama Produk</th>
                <th class="text-left">Jumlah Produk</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Isi dengan data dari database -->
              @foreach ($penjualan as $data)
                <tr class="border-b">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ date('d F Y', strtotime($data->tgl_penjualan)) }}</td>
                  <td>{{ date('d F Y', strtotime($data->pembelian->tgl_pembelian)) }}</td>
                  <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                  <td>{{ $data->produk->nama_produk }}</td>
                  <td>{{ $data->jumlah_produk }}</td>
                  <td class="space-x-2">
                    <!-- Tambahkan tombol edit dan hapus di sini -->
                    <a href="{{ route('penjualan.edit', $data->id_penjualan) }}"
                      class="text-blue-500 hover:underline">Edit</a>
                    <a href="{{ route('penjualan.destroy', $data->id_penjualan) }}"
                      class="text-red-500 hover:underline"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

<script>
  function closeAlert(element) {
    // Menggunakan JavaScript untuk menyembunyikan alert saat tombol "Close" diklik
    element.parentNode.style.display = 'none';
  }
</script>
