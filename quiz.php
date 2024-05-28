<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO users (name, class, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $class, $phone);
    $stmt->execute();

    $userId = $stmt->insert_id;
    $stmt->close();
} else {
    die("Invalid request.");
}

session_start();
$_SESSION['user_id'] = $userId;
$_SESSION['score'] = 0;

$questions = [
    ["question" => "Apa ibu kota Indonesia?", "answer" => "Jakarta"],
    ["question" => "Siapa penemu bola lampu?", "answer" => "Thomas Alva Edison"],
    ["question" => "Apa zat kimia yang memiliki rumus H2O?", "answer" => "Air"],
    ["question" => "Siapa yang menulis novel 'Harry Potter'?", "answer" => "J.K. Rowling"],
    ["question" => "Apa nama ibukota Australia?", "answer" => "Canberra"],
    ["question" => "Siapa presiden pertama Indonesia?", "answer" => "Ir. Soekarno"],
    ["question" => "Apa nama sungai terpanjang di dunia?", "answer" => "Sungai Nil"],
    ["question" => "Siapa penulis 'Laskar Pelangi'?", "answer" => "Andrea Hirata"],
    ["question" => "Apa simbol kimia untuk emas?", "answer" => "Au"],
    ["question" => "Di negara manakah Menara Eiffel berada?", "answer" => "Prancis"],
    ["question" => "Siapa pencipta teori relativitas?", "answer" => "Albert Einstein"],
    ["question" => "Apa nama ibukota Jepang?", "answer" => "Tokyo"],
    ["question" => "Siapa tokoh utama dalam film 'Titanic'?", "answer" => "Jack dan Rose"],
    ["question" => "Apa nama laut terbesar di dunia?", "answer" => "Samudra Pasifik"],
    ["question" => "Siapa pencipta karakter Mickey Mouse?", "answer" => "Walt Disney"],
    ["question" => "Apa nama benua terkecil di dunia?", "answer" => "Australia"],
    ["question" => "Apa warna primer dalam seni rupa?", "answer" => "Merah, Biru, Kuning"],
    ["question" => "Siapa yang menemukan telepon?", "answer" => "Alexander Graham Bell"],
    ["question" => "Apa ibu kota India?", "answer" => "New Delhi"],
    ["question" => "Apa nama tarian tradisional dari Bali?", "answer" => "Tari Kecak"],
    ["question" => "Siapa pelukis Mona Lisa?", "answer" => "Leonardo da Vinci"],
    ["question" => "Apa nama satelit alami Bumi?", "answer" => "Bulan"],
    ["question" => "Siapa penulis Romeo dan Juliet?", "answer" => "William Shakespeare"],
    ["question" => "Apa simbol kimia untuk oksigen?", "answer" => "O"],
    ["question" => "Apa nama gunung tertinggi di dunia?", "answer" => "Gunung Everest"],
    ["question" => "Siapa yang menciptakan komputer pertama kali?", "answer" => "Charles Babbage"],
    ["question" => "Apa nama planet terbesar di tata surya?", "answer" => "Jupiter"],
    ["question" => "Apa ibu kota Inggris?", "answer" => "London"],
    ["question" => "Siapa penyanyi lagu Thriller?", "answer" => "Michael Jackson"],
    ["question" => "Apa nama hewan tercepat di darat?", "answer" => "Cheetah"],
    ["question" => "Apa nama ibukota Rusia?", "answer" => "Moskow"],
    ["question" => "Apa nama senyawa yang terdiri dari natrium dan klor?", "answer" => "Garam dapur (NaCl)"],
    ["question" => "Siapa penemu pesawat terbang?", "answer" => "Wright bersaudara (Orville dan Wilbur Wright)"],
    ["question" => "Apa nama benua terbesar di dunia?", "answer" => "Asia"],
    ["question" => "Apa nama negara dengan jumlah penduduk terbesar di dunia?", "answer" => "Tiongkok"],
    ["question" => "Apa nama ibu kota Mesir?", "answer" => "Kairo"],
    ["question" => "Siapa penulis buku '1984'?", "answer" => "George Orwell"],
    ["question" => "Apa nama ibukota Kanada?", "answer" => "Ottawa"],
    ["question" => "Siapa pencipta karakter Sherlock Holmes?", "answer" => "Arthur Conan Doyle"],
    ["question" => "Apa nama alat musik tradisional dari Sunda?", "answer" => "Angklung"],
    ["question" => "Siapa penemu mesin uap?", "answer" => "James Watt"],
    ["question" => "Apa nama sungai yang melintasi kota Paris?", "answer" => "Sungai Seine"],
    ["question" => "Siapa penyanyi lagu 'Like a Virgin'?", "answer" => "Madonna"],
    ["question" => "Apa simbol kimia untuk karbon dioksida?", "answer" => "CO2"],
    ["question" => "Apa nama mata uang Jepang?", "answer" => "Yen"],
    ["question" => "Apa nama ibukota Thailand?", "answer" => "Bangkok"],
    ["question" => "Siapa pencipta teori evolusi?", "answer" => "Charles Darwin"],
    ["question" => "Apa nama lautan yang mengelilingi Antartika?", "answer" => "Lautan Selatan"],
    ["question" => "Apa nama gunung berapi tertinggi di Indonesia?", "answer" => "Gunung Kerinci"],
    ["question" => "Siapa penulis buku 'To Kill a Mockingbird'?", "answer" => "Harper Lee"],
    ["question" => "Apa nama ibukota Vietnam?", "answer" => "Hanoi"],
    ["question" => "Apa nama ibu kota Norwegia?", "answer" => "Oslo"],
    ["question" => "Apa nama makanan khas Italia yang berbentuk adonan pipih?", "answer" => "Pizza"],
    ["question" => "Siapa penemu radio?", "answer" => "Guglielmo Marconi"],
    ["question" => "Apa nama hewan terbesar di laut?", "answer" => "Paus Biru"],
    ["question" => "Apa nama alat untuk mengukur suhu?", "answer" => "Termometer"],
    ["question" => "Apa nama bahasa yang paling banyak digunakan di dunia?", "answer" => "Mandarin"],
    ["question" => "Siapa penulis 'The Great Gatsby'?", "answer" => "F. Scott Fitzgerald"],
    ["question" => "Apa nama ibukota Jerman?", "answer" => "Berlin"],
    ["question" => "Apa nama senyawa yang digunakan dalam pembuatan kaca?", "answer" => "Silika"],
    ["question" => "Siapa penulis novel 'Pride and Prejudice'?", "answer" => "Jane Austen"],
    ["question" => "Apa nama mata uang resmi di Uni Eropa?", "answer" => "Euro"],
    ["question" => "Apa nama ibukota Korea Selatan?", "answer" => "Seoul"],
    ["question" => "Siapa yang menemukan vaksin polio?", "answer" => "Jonas Salk"],
    ["question" => "Apa nama gunung tertinggi di Afrika?", "answer" => "Gunung Kilimanjaro"],
    ["question" => "Apa nama planet terdekat dengan Matahari?", "answer" => "Merkurius"],
    ["question" => "Siapa yang menciptakan karakter Superman?", "answer" => "Jerry Siegel dan Joe Shuster"],
    ["question" => "Apa nama zat yang dibutuhkan tumbuhan untuk fotosintesis?", "answer" => "Karbon dioksida"],
    ["question" => "Apa nama benua yang terletak di Kutub Selatan?", "answer" => "Antartika"],
    ["question" => "Apa nama alat musik yang berasal dari Jepang?", "answer" => "Koto"],
    ["question" => "Siapa pelukis 'The Starry Night?", "answer" => "Vincent van Gogh"],
    ["question" => "Apa nama ibukota Argentina?", "answer" => "Buenos Aires"],
    ["question" => "Apa nama senyawa yang ditemukan di garam dapur dan air laut?", "answer" => "NaCl"],
    ["question" => "Siapa penulis 'The Catcher in the Rye'?", "answer" => "J.D. Salinger"],
    ["question" => "Apa nama ibu kota Meksiko?", "answer" => "Mexico City"],
    ["question" => "Apa nama zat yang memberi warna hijau pada daun?", "answer" => "Klorofil"],
    ["question" => "Siapa yang menemukan penisilin?", "answer" => "Alexander Fleming"],
    ["question" => "Apa nama satelit terbesar di Tata Surya?", "answer" => "Ganymede"],
    ["question" => "Siapa penulis 'Don Quixote'?", "answer" => "Miguel de Cervantes"],
    ["question" => "Apa kepanjangan dari HTML?", "answer" => "HyperText Markup Language"],
    ["question" => "Tag HTML apa yang digunakan untuk membuat hyperlink?", "answer" => "<a>"],
    ["question" => "Apa fungsi dari atribut alt pada tag <img>?", "answer" => "Memberikan teks alternatif jika gambar tidak bisa ditampilkan."],
    ["question" => "Tag HTML apa yang digunakan untuk membuat tabel?", "answer" => "`<table>`,`<tr>`,`<td>`,`<th>`"],
    ["question" => "Apa kepanjangan dari CSS?", "answer" => "Cascading Style Sheets"],
    ["question" => "Apa fungsi dari properti `display: none;` di CSS?", "answer" => "Menyembunyikan elemen dari tampilan, elemen tetap ada di DOM tapi tidak terlihat dan tidak mempengaruhi layout."],
    ["question" => "Apa perbedaan antara padding dan margin di CSS?", "answer" => "Padding adalah ruang di dalam batas elemen, sedangkan margin adalah ruang di luar batas elemen."]
];

// Acak urutan pertanyaan
shuffle($questions);

$_SESSION['questions'] = $questions;
$_SESSION['current_question'] = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kuis</title>
</head>
<body>
    <h1>Kuis</h1>
    <form action="process.php" method="post">
        <p><?php echo $_SESSION['questions'][0]['question']; ?></p>
        <input type="text" name="answer" required><br><br>
        <button type="submit" name="action" value="next">Next</button>
        <button type="submit" name="action" value="stop">Stop</button>
    </form>
</body>
</html>
