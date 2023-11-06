<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Produk') }}
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
      <form action="{{ route('produk') }}" method="post" autocomplete="off">
        @csrf
        <h2 class="text-2xl font-bold mb-4">Input Produk</h2>
        <div class="mb-4">
          <label for="nama_produk" class="block text-sm font-medium text-white">Nama Produk:</label>
          <input type="text" id="nama_produk" name="nama_produk" required
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white"
            value="{{ old('nama_produk') }}">
          @error('nama_produk')
            <p class="text-red-500 text-sm">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="deskripsi" class="block text-sm font-medium text-white">Deskripsi:</label>
          <textarea type="text" id="deskripsi" name="deskripsi" required
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-4">
          <label for="harga" class="block text-sm font-medium text-white">Harga:</label>
          <input type="number" id="harga" name="harga" required min="0"
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white"
            value="{{ old('harga') }}">
        </div>

        <div class="mb-4">
          <label for="id_perusahaan" class="block text-sm font-medium text-white">Nama Perusahaan:</label>
          <select id="id_perusahaan" name="id_perusahaan" required
            class="border rounded-md py-2 px-3 w-full focus:outline-none focus:ring focus:border-blue-300 bg-slate-500 text-white">
            <option selected>select perusahaan</option>
            @foreach ($perusahaan as $p)
              <option value="{{ $p->id_perusahaan }}" @if (old('id_perusahaan') == $p->id_perusahaan) selected @endif>
                {{ $p->nama_perusahaan }}</option>
            @endforeach
          </select>
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
                <th class="text-left">Nama Produk</th>
                <th class="text-left">Deskripsi</th>
                <th class="text-left">Harga</th>
                <th class="text-left">Nama Perusahaan</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Isi dengan data dari database -->
              @foreach ($produk as $data)
                <tr class="border-b">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $data->nama_produk }}</td>
                  <td>{{ Str::limit($data->deskripsi, 34, '...') }}</td>
                  <td>{{ 'Rp ' . number_format($data->harga, 0, ',', '.') }}</td>
                  <td>{{ $data->perusahaan->nama_perusahaan }}</td>
                  <td class="space-x-2">
                    <!-- Tambahkan tombol edit dan hapus di sini -->
                    <a href="{{ route('produk.edit', $data->id_produk) }}"
                      class="text-blue-500 hover:underline">Edit</a>
                    <a href="{{ route('produk.destroy', $data->id_produk) }}" class="text-red-500 hover:underline"
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
