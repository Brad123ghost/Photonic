-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2021 at 07:04 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photography`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brandid` int(11) NOT NULL,
  `brandname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brandid`, `brandname`) VALUES
(1, 'Sony'),
(2, 'Canon'),
(3, 'WeiFeng'),
(4, 'Manfrotto\r\n'),
(5, 'Atomos'),
(6, 'Red Digital Cinema'),
(7, 'Fujifilm'),
(8, 'Kodak'),
(9, 'SanDisk'),
(10, 'Nikon');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryid` int(11) NOT NULL,
  `categorytype` varchar(200) NOT NULL,
  `categoryimage` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryid`, `categorytype`, `categoryimage`) VALUES
(1, 'DSLR Camera', 'images/categories/apimcxezr__94956.1595387047.jpg'),
(2, 'Mirrorless Camera', 'images/categories/MIR-SON-A7R4A.jpg'),
(3, 'Lens', 'images/categories/LENS-CAN-2470f2.8LII.jpg'),
(4, 'Tripods', 'images/categories/CAAWFT6662__1.png'),
(5, 'Video Tools\r\n', 'images/categories/1631190690_IMG_1607465.jpg'),
(6, 'Film', 'images/categories/apiggn7oo__36333.1601332139.jpg'),
(7, 'Accessories', 'images/categories/ACC-SAND-EXTRMPRO128GB.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupid` int(11) NOT NULL,
  `groupname` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupid`, `groupname`) VALUES
(1, 'Admin'),
(2, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `productid`, `quantity`) VALUES
(1, 11, 1),
(1, 12, 1),
(2, 13, 1),
(2, 14, 1),
(2, 15, 1),
(3, 11, 1),
(4, 13, 1),
(4, 14, 1),
(5, 11, 1),
(5, 12, 1),
(6, 11, 1),
(7, 12, 1),
(8, 13, 1),
(8, 15, 1),
(9, 11, 1),
(9, 12, 1),
(10, 8, 1),
(10, 14, 1),
(11, 14, 1),
(11, 15, 1),
(12, 8, 1),
(12, 9, 1),
(12, 12, 1),
(13, 9, 1),
(13, 14, 1),
(14, 7, 1),
(14, 13, 1),
(15, 7, 1),
(15, 15, 1),
(16, 10, 1),
(16, 14, 1),
(17, 14, 1),
(18, 12, 1),
(18, 14, 1),
(18, 15, 1),
(19, 13, 1),
(19, 14, 1),
(19, 15, 1),
(20, 12, 1),
(20, 13, 1),
(21, 12, 8),
(21, 13, 44);

-- --------------------------------------------------------

--
-- Table structure for table `productbrand`
--

CREATE TABLE `productbrand` (
  `productid` int(11) NOT NULL,
  `brandid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productbrand`
--

INSERT INTO `productbrand` (`productid`, `brandid`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 3),
(7, 4),
(8, 5),
(9, 2),
(10, 7),
(11, 8),
(12, 6),
(13, 9),
(14, 2),
(15, 4),
(16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `productid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`productid`, `categoryid`) VALUES
(1, 2),
(2, 2),
(3, 1),
(4, 1),
(5, 3),
(6, 4),
(6, 7),
(7, 4),
(7, 7),
(8, 5),
(8, 7),
(9, 3),
(10, 6),
(11, 6),
(12, 5),
(13, 7),
(14, 3),
(15, 1),
(16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `features` varchar(400) NOT NULL,
  `description` varchar(800) NOT NULL,
  `code` varchar(100) NOT NULL,
  `price` decimal(65,0) NOT NULL,
  `stockquantity` int(5) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `features`, `description`, `code`, `price`, `stockquantity`, `image`) VALUES
(1, 'Sony Alpha a7R IVA Mirrorless Digital Camera (Body Only)', 'Key Features\r\n - 61MP Full-Frame Exmor R BSI CMOS Sensor\r\n - BIONZ X Image Processor & Front-End LSI\r\n - 567-Point Phase-Detection AF System\r\n - UHD 4K30p Video with HLG & S-Log3 Gammas', 'This fourth edition of the a7R sees the inclusion of an updated 61MP Exmor R BSI CMOS sensor and enhanced BIONZ X image processor, which afford impressive imaging results with marked smoothness, a 15-stop dynamic range, and, of course, speed. Up to 10 fps shooting is possible along with the ability to record UHD 4K30 video, both with support for Real-time Eye AF and Tracking AF technologies. The revised sensor design uses a Fast Hybrid AF System, with 567 phase-detection autofocus points, for notably fast and accurate focusing performance. ', 'MIR-SON-A7R4A', '6299', 5, 'images/products/MIR-SON-A7R4A.jpg'),
(2, 'Canon EOS R5 Body Mirrorless Digital Camera with EOS R Adapter', 'Key Features \r\n - 45MP Full-Frame CMOS Sensor\r\n - DIGIC X Image Processor\r\n - 8K30 Raw and 4K120 10-Bit Internal Video\r\n - Sensor-Shift 5-Axis Image Stabilization\r\n - Canon Brand-backed New Zealand Warranty', 'For the professional image-maker who needs resolution, speed, and video capabilities, there is the Canon EOS R5. Setting a new standard for versatility, this full-frame mirrorless camera features a newly developed 45MP CMOS sensor, which offers 8K raw video recording, 12 fps continuous shooting with a mechanical shutter, and is the first EOS camera to feature 5-axis sensor-shift image stabilization.', 'MIR-CAN-R5-AD', '6887', 2, 'images/products/MIR-CAN-R5-AD.jpg'),
(3, 'Canon EOS 90D DSLR Camera with Canon 18-135mm Lens Kit', 'Key Features\r\n - EF-S 18-135mm f/3.5-5.6 IS USM Lens\r\n - Memory Card\r\n - 2 x Spare Batteries\r\n - External Battery Charger\r\n - Canon Brand-backed New Zealand Warranty', 'Situated as a versatile camera with capable photo and video traits, the Canon EOS 90D is a sleek DSLR also characterized by its high-resolution 32.5MP APS-C CMOS sensor. This updated sensor design achieves enhanced image clarity, resolution, and dynamic range, along with adept sensitivity to ISO 25600 and low noise to suit working in a variety of situations. Combined with advanced image processing, this sensor is also capable of outputting UHD 4K30p and Full HD 120p video, as well as supporting continuous stills shooting rates up to 10 fps.', 'DSLR-CAN-90D-18135', '2450', 10, 'images/products/DSLR-CAN-90D-18135.jpg'),
(4, 'Canon EOS 1500D DSLR APS-C + 18-55mm Lens Kit', 'Key Features\r\n - 24.1MP APS-C CMOS image sensor DIGIC4+ processor\r\n - ISO range from 100-6400 (expandable to 12800)\r\n - Full HD 1080p video up to 30fps and \r\n - Video Snapshot mode\r\n - 3fps continuous shooting\r\n - 9-point autofocus\r\n - 3\" (7.5 cm) 920k-dot TFT LCD monitor with inbuilt Feature Guide', 'The newest addition to Canon\'s entry-level DSLR range, the EOS 1500D has been designed for people who seek out new experiences and want to share their adventures seamlessly to social media. The cameras\' powerful combination of APS-C sensor technology, DIGIC 4+ image processor, Wi-Fi connectivity and straightforward in-camera feature guides enable stories to be captured and shared with highly detailed photos and Full HD movies.', 'DSLR-CAN-1500D-1855', '899', 4, 'images/products/DSLR-CAN-1500D-1855.jpg'),
(5, 'Sony FE 70-200mm f/2.8 GM OSS Lens', 'Key Features\r\n - E-Mount Lens/Full-Frame Format\r\n - Aperture Range: f/2.8 to f/22\r\n - One XA Element, Two Aspherical Elements\r\n - Four ED Elements, Two Super ED Elements\r\n - Optical SteadyShot Image Stabilization\r\n - Dust and Moisture-Resistant Construction\r\n - Eleven-Blade Circular Diaphragm', 'A popular telephoto zoom focal length featuring a bright constant maximum aperture, the FE 70-200mm f/2.8 GM OSS from Sonycovers portrait-length to telephoto perspectives and is designed for E-mount mirrorless cameras. Characterized by both its fast f/2.8 maximum aperture and inclusion of OSS (Optical SteadyShot) image stabilization, this lens is ideally-suited for handheld shooting of distant and fast-moving subjects.', 'LENS-SON-70200f2.8-GMOSS', '4297', 12, 'images/products/LENS-SON-70200f2.8-GMOSS.jpg'),
(6, 'WeiFeng WT-6662A Professional Ball head Tripod', 'Key Features\r\n - 22 inches (folded)\r\n - Max weight 17.6 Ibs', 'The Weifeng WF-6662A tripod with included ball head is a portable camera tripod that is ideal for the busy photographer. This Weifeng tripod is made of aluminum alloy and plastic and can be extended to a maximum height of 64 inches. As a durable and multi-action tripod, the Weifeng WF-6662A tripod swivels 90 degrees vertically and 360 degrees horizontally, and it contains a reversible center column.\r\n', 'TRI-WEI-WT66624', '98', 10, 'images/products/TRI-WEI-WT66624.jpg'),
(7, 'Manfrotto Befree GT XPRO Carbon Fiber Travel Tripod', 'Key Features: \r\n- Load Capacity: 22.1 lb\r\n - Maximum Height: 64.6″\r\n - Minimum Height: 3.5″\r\n - Folded Length: 16.9″', 'The 3.9 lb Befree GT XPRO Carbon Fiber Travel Tripod with 496 Center Ball Head from Manfrotto is a 4-section support with the twist M-Lock leg system that quickly unlocks with a 90° turn, enabling you to extend the legs along with the rapid center column to a maximum height of 64.6″. The ergonomic leg-angle button disengages the legs, so you can splay the legs at different heights, and you can completely splay the legs out to a minimum height of 3.5″ for low-angle or macro photography.', 'TRI-MAN-GTXPRO', '999', 12, 'images/products/TRI-MAN-GTXPRO.jpg'),
(8, 'Atomos Shinobi 7', 'Key Features\r\n - 7\" 1920 x 1200 Touchscreen Display\r\n - 4K60 HDMI 2.0 In/Out, 2K60 3G-SDI In/Out\r\n - 2200 cd/m² Brightness\r\n - HDMI/SDI Cross Conversion', 'Add a bright, high-resolution monitor to view your 4K/2K footage from a cinema camera such as a Z CAM E2, Panasonic BGH1, or RED KOMODO with the Shinobi 7\" 4K HDMI/SDI Monitor from Atomos. This 7\" on-camera monitor features a 1920 x 1200 10-bit FRC IPS display with a brightness of 2200 cd/m², which makes it suitable for use in both exterior and interior conditions.', 'VID-ATM-SHINOBI7', '1169', 56, 'images/products/VID-ATM-SHINOBI7.jpg'),
(9, 'Canon EF 70-200mm f/2.8L IS III USM Lens', ' - Fast and constant maximum f/2.8 aperture\r\n - High quality zoom\r\n - L-Series quality\r\n - Ultrasonic focusing in near silence', 'For most photographers, a high quality 70-200mm f/2.8 image stabilized lens is one of the most important and most frequently used lenses in the kit and Canon\'s current version of this lens is always at the top or very close to the top of our most popular lens list. The reasons for this popularity include usefulness, performance and affordability.', 'LENS-CAN-70200f2.8IS-MKIII', '3600', 3, 'images/products/LENS-CAN-70200f2.8IS-MKIII.jpg'),
(10, 'Fujifilm Fujicolor C200 35mm 36 Exposures', ' - Daylight-Balanced Color Negative Film\r\n - ISO 200/24° in C-41 Process\r\n - Fine Grain and High Sharpness\r\n - Wide Exposure Latitude', 'Fujicolor 200 from Fujifilm is a medium speed daylight-balanced color negative film offering a vivid color palette with accurate skin tones and color reproduction in a variety of lighting conditions. It features a nominal sensitivity of ISO 200/24° along with a wide exposure latitude for use in a variety of conditions, even under fluorescent lighting. ', 'FILM-FUJ-C200-35mm', '10', 121, 'images/products/FILM-FUJ-C200-35mm.jpg'),
(11, 'Kodak Professional Portra 400 Color Negative Film', ' - Daylight-Balanced Color Negative Film\r\n - ISO 400/27° in C-41 Process\r\n - Very Fine Grain, VISION Film Technology\r\n - High Color Saturation, Low Contrast\r\n - Accurate Color and Neutral Skin Tones', 'Kodak\'s Professional Portra 400 is a high-speed daylight-balanced color negative film offering a smooth and natural color palette that is balanced with vivid saturation and low contrast for accurate skin tones and consistent results.', 'FILM-KOD-P400-35MM', '27', 321, 'images/products/FILM-KOD-P400-35MM.jpg'),
(12, 'RED DIGITAL CINEMA V-RAPTOR 8K', ' - 35.4MP Full-Frame, Rolling Shutter CMOS\r\n - Lightweight & Compact DSMC3 Design\r\n - Canon RF Lens & CFexpress Type-B Support\r\n - Up to 8K120 17:9, 6K198 S35 & 4K240 17:9', 'Compact, fast, and full-frame—the black V-RAPTOR 8K VV + 6K S35 Dual-Format Camera is an impressive introduction to RED DIGITAL CINEMA\'s new DSMC3 platform. Sized only slightly larger than the KOMODO but boasting a new sensor, the V-RAPTOR offers multi-format capture in 8K VistaVision, 6K Super35, 4K, 3K Super16, and anamorphic options.', 'VID-RED-VRAPTOR8k', '34266', 2, 'images/products/VID-RED-VRAPTOR8k.jpg'),
(13, 'SanDisk Extreme Pro 128GB SDXC', ' - Transfer speeds up to 170MB/S\r\n - Perfect for 4k UHD Video\r\n - Stunning sequential burst mode shots\r\n - Durability you can coun on', 'Designed for SD devices that can capture Full HD, 3D, and 4K video, as well as raw and burst photography, the 128GB Extreme PRO UHS-I SDXC Memory Card from SanDisk has a capacity of 128GB, is compatible with the UHS-I bus, and features a speed class rating of V30, which guarantees minimum write speeds of 30 MB/s.', 'ACC-SAND-EXTRMPRO128GB', '125', 36, 'images/products/ACC-SAND-EXTRMPRO128GB.jpg'),
(14, 'Canon EF 24-70mm f/2.8 L II USM Lens', ' - EF-Mount Lens/Full-Frame Format\r\n - Aperture Range: f/2.8 to f/22\r\n - One Super UD Element, Two UD Elements\r\n - Three Aspherical Elements\r\n - Super Spectra and Fluorine Coatings', 'Spanning a popular and versatile range of focal lengths, the EF 24-70mm f/2.8L II USM is a Canon L-series zoom commonly thought of as the workhorse of lenses. Ranging from wide-angle to portrait length, this lens is also distinguished by its constant f/2.8 maximum aperture to benefit working in difficult lighting conditions and to afford greater control over depth of field.', 'LENS-CAN-2470f2.8L-II', '3348', 6, 'images/products/LENS-CAN-2470f2.8LII.jpg'),
(15, 'Nikon D850 DSLR Camera (Body Only)', '45.7MP FX-Format BSI CMOS Sensor\r\n - EXPEED 5 Image Processor\r\n - 3.2\" 2.36m-Dot Tilting Touchscreen LCD\r\n - 4K UHD Video Recording at 30 fps\r\n - Multi-CAM 20K 153-Point AF System\r\n - Native ISO: 64-25600,Extended: 32-102400\r\n - 7 fps Shooting for 51 Frames with AE/AF', 'Proving that speed and resolution can indeed coexist, the Nikon D850 is a multimedia DSLR that brings together robust stills capabilities along with apt movie and time-lapse recording. Revolving around a newly designed 45.7MP BSI CMOS sensor and proven EXPEED 5 image processor, the D850 is clearly distinguished by its high resolution for recording detailed imagery.', 'DSLR-NIK-D850', '4780', 36, 'images/products/DSLR-NIK-D850.jpg'),
(16, 'Final Test Product Edited', 'Final Test Product', 'Final Test Product', 'Final Test Product Edited', '123', 123, 'images/products/phones.tnzimage.skuDevice736.png');

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usergroup`
--

INSERT INTO `usergroup` (`userid`, `groupid`) VALUES
(1, 2),
(2, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `userorders`
--

CREATE TABLE `userorders` (
  `userid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `orderdate` datetime NOT NULL,
  `firstproductcode` varchar(256) NOT NULL,
  `totalordered` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userorders`
--

INSERT INTO `userorders` (`userid`, `orderid`, `orderdate`, `firstproductcode`, `totalordered`) VALUES
(1, 1, '2021-12-06 01:08:12', 'FILM-KOD-P400-35MM', 34293),
(2, 8, '2021-12-07 03:36:59', 'ACC-SAND-EXTRMPRO128GB', 4905),
(1, 9, '2021-12-07 03:39:31', 'FILM-KOD-P400-35MM', 34293),
(1, 10, '2021-12-07 03:40:34', 'LENS-CAN-2470f2.8L-II', 4517),
(2, 11, '2021-12-07 04:40:11', 'LENS-CAN-2470f2.8L-II', 8128),
(2, 12, '2021-12-07 04:40:29', 'VID-ATM-SHINOBI7', 39035),
(2, 13, '2021-12-07 09:35:17', 'LENS-CAN-70200f2.8IS-MKIII', 6948),
(2, 14, '2021-12-07 09:35:30', 'ACC-SAND-EXTRMPRO128GB', 1124),
(3, 15, '2021-12-08 00:55:03', 'TRI-MAN-GTXPRO', 5779),
(2, 16, '2021-12-09 03:19:29', 'LENS-CAN-2470f2.8L-II', 3358),
(2, 17, '2021-12-09 04:23:42', 'LENS-CAN-2470f2.8L-II', 3348),
(2, 18, '2021-12-09 04:44:56', 'VID-RED-VRAPTOR8k', 42394),
(4, 19, '2021-12-09 10:25:38', 'LENS-CAN-2470f2.8L-II', 8253),
(4, 20, '2021-12-09 10:27:10', 'ACC-SAND-EXTRMPRO128GB', 34391),
(5, 21, '2021-12-10 06:32:14', 'ACC-SAND-EXTRMPRO128GB', 279628);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(100) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` varchar(256) NOT NULL,
  `streetadd` varchar(256) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `suburb` varchar(100) DEFAULT NULL,
  `country` varchar(256) DEFAULT NULL,
  `psw` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `streetadd`, `city`, `suburb`, `country`, `psw`) VALUES
(1, 'Billy', 'Bob', 'billy.bob@email.com', '38 Fake Road', 'Auckland', 'City', 'New Zealand', '$2y$10$tUi3M0LWZ.4xtzVxOcXeT./K5kI/2g3HSGIAAier2sKlXYML6JIIS'),
(2, 'Admin', 'Account', 'admin@mail.com', '123', '123', '123', '123', '$2y$10$.TmsbxowvvugrMiriGVJDuV0l2gCmu2FJqlJ5SzLmkY25D7aoOSTW'),
(3, 'jane', 'smith', 'janesmith@gmail.com', '69 peepo road', 'Auckland', 'Henderson', 'New Zealand', '$2y$10$xbmvXpp86hhr/NqaKbL.auwPkhfyx80991CDn1N3TM/N55KnVgvGy'),
(4, 'John Edited', 'Smith Edited', 'john.smith@gmail.com ', '69 Rathgar Road', 'Auckland', 'Henderson', 'Canada Edited', '$2y$10$kiWQvY5q4/RrE9/Bdy5BZ.wCpQbFPzfugLJ/TX.BDLIPf6TCWRWu6'),
(5, 'doe', 'jane', 'doejane@gmail.com', '234 halpoid road', 'Auckland', 'Auckland', 'Australia', '$2y$10$gO7K2WULDPkRgQMoKQglv.LQlon/wiojnGsk18h9Z6IEI28LZgutu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brandid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`,`productid`);

--
-- Indexes for table `productbrand`
--
ALTER TABLE `productbrand`
  ADD PRIMARY KEY (`productid`,`brandid`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`productid`,`categoryid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usergroup`
--
ALTER TABLE `usergroup`
  ADD PRIMARY KEY (`userid`,`groupid`);

--
-- Indexes for table `userorders`
--
ALTER TABLE `userorders`
  ADD PRIMARY KEY (`orderid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brandid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
