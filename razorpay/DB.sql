SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `u836745399_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `onlinepayment`
--

CREATE TABLE `onlinepayment` (
  `pID` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `service` varchar(300) NOT NULL,
  `typeProduct` varchar(300) NOT NULL,
  `toValue` varchar(300) NOT NULL,
  `message` varchar(300) NOT NULL,
  `razorpayOrderId` varchar(300) NOT NULL,
  `razorpayPaymentId` varchar(300) NOT NULL,
  `paymentStatus` varchar(300) NOT NULL,
  `makerstamp` datetime NOT NULL,
  `updatestamp` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `onlinepayment`
--
ALTER TABLE `onlinepayment`
  ADD PRIMARY KEY (`pID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `onlinepayment`
--
ALTER TABLE `onlinepayment`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;