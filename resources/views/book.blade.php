<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Log</title>
</head>
<body>
    <form action="/book" method="POST">
        @csrf
        <h1>FORM INPUT BUKU</h1>
        <h2>Judul</h2>
        <input type="text" name="judul">
        <h2>Total Halaman</h2>
        <input type="text" name="jumlah_halaman">
        <br>
        <button type="submit">SUBMIT</button>
    </form>
    <table border="1">
        <thead>
            <tr>
                <td>JUDUL</td>
                <td>TOTAL HALAMAN</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $b)
                <tr>
                    <td><a href="/book/{{$b->id}}">{{$b->judul}}</a></td>
                    <td>{{$b->jumlah_halaman}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>