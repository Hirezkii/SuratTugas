@extends('layout')

@section('container')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
            `,
                showConfirmButton: true
            });
        </script>
    @endif

    <div class="mb-4 mt-4">
        <a href={{ route('Pimpinan.create') }}><button type="button" class="btn btn-success">Tambah
                Data</button></a>
    </div>
    <div class="table-wrapper">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-secondary">
                <tr>
                    <th scope="col">NIP</th>
                    <th scope="col">Nama Pimpinan</th>
                    <th scope="col">Pangkat Golongan</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Bagian Kerja</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Tipe Pimpinan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $pegawai)
                    <tr>
                        <td>{{ $pegawai->nip }}</td>
                        <td>{{ $pegawai->nama_pegawai }}</td>
                        <td>{{ $pegawai->pangkat_golongan }}</td>
                        <td>{{ $pegawai->jabatan }}</td>
                        <td>{{ $pegawai->bagian_kerja }}</td>
                        <td>{{ $pegawai->tanggal_lahir }}</td>
                        <td>
                            @if (is_array($pegawai->wewenang))
                                {{ implode(', ', $pegawai->wewenang) }}
                            @else
                                {{ $pegawai->wewenang }}
                            @endif
                        </td>
                        <td>
                            {{-- <a href="{{ route('Pimpinan.edit', $pegawai->id_pegawai) }}"
                                class="btn btn-outline-primary btn-sm">Edit</a> --}}

                            <button class="btn btn-outline-danger btn-sm"
                                onclick="confirmDelete({{ $pegawai->id_pegawai }})">Downgrade</button>

                            <form id="delete-form-{{ $pegawai->id_pegawai }}"
                                action="{{ route('Pimpinan.destroy', $pegawai->id_pegawai) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(pimpinanId) {
            Swal.fire({
                title: 'Ubah pimpinan ini jadi pegawai?',
                html: "Pimpinan yang di-<i>downgrade</i> akan menjadi pegawai biasa, silahkan hapus permanen di menu data pegawai",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ubah jadi Pegawai Biasa',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(`Submitting delete form for pimpinan ID: ${pimpinanId}`);
                    document.getElementById(`delete-form-${pimpinanId}`).submit();
                }
            });
        }
    </script>
@endsection
