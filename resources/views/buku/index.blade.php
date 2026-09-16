<h1>Daftar Buku</h1>
<ul>
    @foreach ($daftarBuku as $id => $buku)
        <li><a href="/buku/{{ $id }}">{{ $buku['judul'] }}</a></li>
        @endforeach
</ul>
