-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 26 Nis 2022, 12:55:31
-- Sunucu sürümü: 5.7.36
-- PHP Sürümü: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `library`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `durumlar`
--

CREATE TABLE `durumlar` (
  `Id` int(11) NOT NULL,
  `Ad` varchar(30) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `durumlar`
--

INSERT INTO `durumlar` (`Id`, `Ad`) VALUES
(1, 'Kiralanmadı'),
(2, 'Kiralandı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `emanetler`
--

CREATE TABLE `emanetler` (
  `Id` int(11) NOT NULL,
  `KullaniciId` int(11) NOT NULL,
  `KitapId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `emanetler`
--

INSERT INTO `emanetler` (`Id`, `KullaniciId`, `KitapId`) VALUES
(2, 3, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kitaplar`
--

CREATE TABLE `kitaplar` (
  `Id` int(11) NOT NULL,
  `Ad` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `Yazar` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `Tur` int(11) NOT NULL,
  `Durum` int(11) NOT NULL,
  `Resim` longtext COLLATE utf8_turkish_ci NOT NULL,
  `Isbn` varchar(15) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kitaplar`
--

INSERT INTO `kitaplar` (`Id`, `Ad`, `Yazar`, `Tur`, `Durum`, `Resim`, `Isbn`) VALUES
(1, 'Nutuk', 'Mustafa Kemal Atatürk', 1, 1, 'data:image/jpeg;base64,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', '9786051711577'),
(2, 'Melankoli', 'Sabahattin Ali', 1, 2, '1650968957261.jpeg', '9789750830617'),
(3, 'Yeşil Gece', 'Reşat Nuri Güntekin', 1, 1, '1650977571422.jpeg', '9789751001863');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `Id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`Id`, `username`, `name`, `password`, `email`, `Admin`) VALUES
(3, 'kaan', 'Kaan Erböcü', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'akaan@hotmail.com', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `turler`
--

CREATE TABLE `turler` (
  `Id` int(11) NOT NULL,
  `Ad` varchar(30) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `turler`
--

INSERT INTO `turler` (`Id`, `Ad`) VALUES
(1, 'Söylev');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `durumlar`
--
ALTER TABLE `durumlar`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `emanetler`
--
ALTER TABLE `emanetler`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `kitaplar`
--
ALTER TABLE `kitaplar`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`Id`);

--
-- Tablo için indeksler `turler`
--
ALTER TABLE `turler`
  ADD PRIMARY KEY (`Id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `durumlar`
--
ALTER TABLE `durumlar`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `emanetler`
--
ALTER TABLE `emanetler`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kitaplar`
--
ALTER TABLE `kitaplar`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `turler`
--
ALTER TABLE `turler`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
