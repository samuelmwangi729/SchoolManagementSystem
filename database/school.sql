-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2019 at 09:29 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `catresults`
--

CREATE TABLE `catresults` (
  `id` int(11) NOT NULL,
  `exam` varchar(5) NOT NULL,
  `term` varchar(4) NOT NULL,
  `Class` varchar(10) NOT NULL,
  `Stream` varchar(20) NOT NULL,
  `Year` int(4) NOT NULL,
  `studentReg` int(11) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `marks` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catresults`
--

INSERT INTO `catresults` (`id`, `exam`, `term`, `Class`, `Stream`, `Year`, `studentReg`, `subject`, `marks`, `status`) VALUES
(1, 'CAT 2', 'I', '1', 'East', 2019, 1900, 'English', 11, 1),
(2, 'CAT 2', 'I', '1', 'East', 2019, 1905, 'English', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

CREATE TABLE `cats` (
  `id` int(11) NOT NULL,
  `catName` varchar(20) NOT NULL,
  `class` varchar(15) NOT NULL,
  `term` varchar(1) NOT NULL,
  `year` varchar(4) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cats`
--

INSERT INTO `cats` (`id`, `catName`, `class`, `term`, `year`, `status`) VALUES
(1, 'CAT 2', '1', 'I', '2019', 1);

-- --------------------------------------------------------

--
-- Table structure for table `catsubject`
--

CREATE TABLE `catsubject` (
  `id` int(11) NOT NULL,
  `catName` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catsubject`
--

INSERT INTO `catsubject` (`id`, `catName`, `status`) VALUES
(2, 'Languages', 1),
(3, 'Technicals', 1),
(4, 'Sciences', 1),
(5, 'Humanities', 1),
(6, 'Business', 1),
(7, 'Engineering', 1);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `form` int(1) NOT NULL,
  `stream` varchar(10) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `form`, `stream`, `status`) VALUES
(1, 1, '0', 1),
(2, 2, '0', 1),
(3, 3, '0', 1),
(4, 4, '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `classmeans`
--

CREATE TABLE `classmeans` (
  `id` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `stream` varchar(10) NOT NULL,
  `term` varchar(1) NOT NULL,
  `year` int(11) NOT NULL,
  `exam` varchar(15) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classmeans`
--

INSERT INTO `classmeans` (`id`, `class`, `stream`, `term`, `year`, `exam`, `total`) VALUES
(1, 1, 'East', 'I', 2019, 'Opener Exams', 1.62);

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `clubName` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`id`, `clubName`, `status`) VALUES
(1, 'Computer Club', 1),
(2, 'Science ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clubsmembers`
--

CREATE TABLE `clubsmembers` (
  `id` int(11) NOT NULL,
  `studentId` varchar(20) NOT NULL,
  `club` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clubsmembers`
--

INSERT INTO `clubsmembers` (`id`, `studentId`, `club`, `status`) VALUES
(1, '1', 'Computer Club', 1),
(2, '1901', 'Computer Club', 0),
(3, '1902', 'Science', 1),
(4, '1903', 'Computer Club', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currentsession`
--

CREATE TABLE `currentsession` (
  `id` int(11) NOT NULL,
  `currentSession` varchar(10) NOT NULL DEFAULT 'I'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currentsession`
--

INSERT INTO `currentsession` (`id`, `currentSession`) VALUES
(1, 'I');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`, `status`) VALUES
(1, 'Humanities', 0),
(2, 'Sciences', 1),
(3, 'Mathematics', 0),
(4, 'ICT', 1),
(5, 'Games ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `designation`, `status`) VALUES
(1, 'Principal', 1),
(2, 'Senior Teacher', 1),
(3, 'HOD', 0),
(4, 'DOD', 0),
(5, 'Games Master', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dorm`
--

CREATE TABLE `dorm` (
  `id` int(11) NOT NULL,
  `dormName` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dorm`
--

INSERT INTO `dorm` (`id`, `dormName`, `status`) VALUES
(1, 'Malaba', 1);

-- --------------------------------------------------------

--
-- Table structure for table `endadm`
--

CREATE TABLE `endadm` (
  `endAdm` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `endadm`
--

INSERT INTO `endadm` (`endAdm`) VALUES
('1900');

-- --------------------------------------------------------

--
-- Table structure for table `examinations`
--

CREATE TABLE `examinations` (
  `id` int(11) NOT NULL,
  `examTitle` varchar(20) NOT NULL,
  `Term` varchar(2) NOT NULL,
  `Year` varchar(4) NOT NULL,
  `Class` varchar(15) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `examTotalsUpdated` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `examinations`
--

INSERT INTO `examinations` (`id`, `examTitle`, `Term`, `Year`, `Class`, `status`, `examTotalsUpdated`) VALUES
(1, 'Opener Exams', 'I', '2019', 'All Classes', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `examresults`
--

CREATE TABLE `examresults` (
  `id` int(11) NOT NULL,
  `exam` varchar(20) NOT NULL,
  `term` varchar(1) NOT NULL,
  `Class` int(11) NOT NULL,
  `Stream` varchar(10) NOT NULL,
  `Year` varchar(4) NOT NULL,
  `studentReg` varchar(7) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `marks` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `examresults`
--

INSERT INTO `examresults` (`id`, `exam`, `term`, `Class`, `Stream`, `Year`, `studentReg`, `subject`, `marks`, `status`) VALUES
(1, 'Opener Exams', 'I', 1, 'East', '2019', '1900', 'English', 78, 0),
(2, 'Opener Exams', 'I', 1, 'East', '2019', '1905', 'English', 89, 0),
(3, 'Opener Exams', 'I', 1, 'East', '2019', '1905', 'English', 78, 0),
(4, 'Opener Exams', 'I', 1, 'East', '2019', '1900', 'Mathematics', 90, 0),
(5, 'Opener Exams', 'I', 1, 'East', '2019', '1905', 'Mathematics', 77, 0),
(6, 'Opener Exams', 'I', 1, 'East', '2019', '1905', 'Mathematics', 65, 0),
(7, 'Opener Exams', 'I', 1, 'East', '2019', '1900', 'German', 80, 0),
(8, 'Opener Exams', 'I', 1, 'East', '2019', '1905', 'German', 90, 0);

-- --------------------------------------------------------

--
-- Table structure for table `examtotals`
--

CREATE TABLE `examtotals` (
  `id` int(11) NOT NULL,
  `studentReg` varchar(6) NOT NULL,
  `exam` varchar(20) NOT NULL,
  `total` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `Stream` varchar(16) NOT NULL,
  `term` varchar(3) NOT NULL,
  `year` varchar(4) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `examtotals`
--

INSERT INTO `examtotals` (`id`, `studentReg`, `exam`, `total`, `Class`, `Stream`, `term`, `year`, `position`) VALUES
(1, '1900', 'Opener Exams', 203, 1, 'East', 'I', '2019', 0),
(2, '1905', 'Opener Exams', 256, 1, 'East', 'I', '2019', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `votehead` varchar(20) NOT NULL,
  `term` varchar(3) NOT NULL,
  `class` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `year` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `votehead`, `term`, `class`, `amount`, `year`) VALUES
(1, 'Lunch', 'I', 1, 5000, '2019'),
(2, 'Boarding', 'I', 1, 8000, '2019'),
(3, 'Games', 'I', 1, 2000, '2019'),
(4, 'Caution Money', 'I', 1, 1000, '2019'),
(5, 'Medical', 'I', 1, 2000, '2019'),
(6, 'PTA', 'I', 1, 2000, '2019'),
(7, 'Lunch', 'I', 4, 9000, '2019'),
(8, 'Boarding', 'II', 1, 10000, '2019');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `subCat` varchar(20) NOT NULL,
  `Min` int(11) NOT NULL,
  `Max` int(11) NOT NULL,
  `Notation` varchar(2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `subCat`, `Min`, `Max`, `Notation`, `status`) VALUES
(1, 'Languages', 1, 29, 'E', 0),
(2, 'Languages', 30, 34, 'D-', 1),
(3, 'Languages', 35, 39, 'D', 0),
(4, 'Languages', 40, 44, 'D+', 1),
(5, 'Languages', 45, 49, 'C-', 0),
(6, 'Languages', 50, 54, 'C', 1),
(7, 'Languages', 55, 59, 'C+', 1),
(8, 'Languages', 60, 64, 'B-', 1),
(9, 'Languages', 65, 69, 'B', 0),
(10, 'Languages', 70, 74, 'B+', 1),
(11, 'Languages', 75, 79, 'A-', 1),
(12, 'Languages', 80, 99, 'A', 1),
(13, 'Technicals', 1, 29, 'E', 1),
(14, 'Technicals', 30, 34, 'D-', 1),
(15, 'Technicals', 35, 39, 'D', 1),
(16, 'Technicals', 40, 44, 'D+', 1),
(19, 'Technicals', 45, 49, 'C-', 1),
(20, 'Technicals', 50, 54, 'C+', 1),
(21, 'Technicals', 60, 64, 'B-', 1),
(22, 'Technicals', 65, 69, 'B', 1),
(23, 'Technicals', 70, 74, 'B+', 1),
(24, 'Technicals', 75, 79, 'A-', 1),
(26, 'Technicals', 80, 99, 'A', 1),
(27, 'Technicals', 55, 59, 'C', 1),
(28, 'Sciences', 1, 19, 'E', 1),
(29, 'Sciences', 20, 29, 'D-', 1),
(30, 'Sciences', 30, 34, 'D', 1),
(31, 'Sciences', 35, 39, 'D+', 1),
(32, 'Sciences', 40, 44, 'C-', 1),
(33, 'Sciences', 45, 49, 'C', 1),
(34, 'Sciences', 50, 55, 'C+', 1),
(35, 'Sciences', 56, 59, 'B-', 1),
(36, 'Sciences', 60, 64, 'B', 1),
(37, 'Sciences', 65, 69, 'B+', 1),
(38, 'Sciences', 70, 79, 'A-', 1),
(39, 'Sciences', 80, 99, 'A', 1),
(40, 'Humanities', 1, 29, 'E', 1),
(41, 'Humanities', 30, 40, 'D-', 1),
(42, 'Humanities', 41, 45, 'D', 1),
(43, 'Languages', 46, 49, 'D+', 1),
(44, 'Humanities', 50, 54, 'C-', 1),
(45, 'Humanities', 55, 59, 'C+', 1),
(46, 'Humanities', 60, 64, 'B-', 1),
(47, 'Humanities', 65, 69, 'B', 1),
(48, 'Humanities', 70, 74, 'B', 1),
(49, 'Humanities', 75, 79, 'B+', 1),
(50, 'Humanities', 80, 84, 'A-', 1),
(51, 'Humanities', 85, 99, 'A', 1),
(52, 'Engineering', 1, 19, 'E', 1),
(53, 'Business', 45, 49, 'C-', 0);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `Descr` text NOT NULL,
  `Amount` int(11) NOT NULL,
  `Dater` varchar(15) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `DateA` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `Descr`, `Amount`, `Dater`, `status`, `DateA`) VALUES
(1, 'stolem', 1000, '2019-Sep-13', 1, '2019-Sep-14'),
(2, 'We will be attending all African games for a match between kenya and Uganda. We thus would like to have all our expenses covered. Thanks', 100000, '2019-Sep-14', 0, ''),
(3, 'We will be attending all African games for a match', 60000, '2019-Sep-14', 1, '2019-Sep-14'),
(4, 'The library burnt down. Lib restoration', 5000, '2019-Sep-25', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `studentReg` varchar(10) NOT NULL,
  `term` varchar(2) NOT NULL,
  `Amount` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `mode` varchar(20) NOT NULL,
  `Date` varchar(15) NOT NULL,
  `Year` int(11) NOT NULL,
  `receiptNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `studentReg`, `term`, `Amount`, `class`, `mode`, `Date`, `Year`, `receiptNumber`) VALUES
(1, '1900', 'II', 50000, 1, 'Cheque', '2019-Sep-29', 2019, '1900');

-- --------------------------------------------------------

--
-- Table structure for table `prole`
--

CREATE TABLE `prole` (
  `id` int(11) NOT NULL,
  `prole` varchar(40) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prole`
--

INSERT INTO `prole` (`id`, `prole`, `status`) VALUES
(1, 'BOM chairman', 1),
(4, 'PTA  chair', 1),
(5, 'School Spokesperson', 1),
(6, 'Head Parent Association', 1),
(7, 'Chair', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `sName` varchar(100) NOT NULL,
  `Image` varchar(100) NOT NULL DEFAULT '0',
  `Phone` int(15) NOT NULL,
  `pBox` int(11) NOT NULL,
  `pCode` int(11) NOT NULL,
  `pCity` varchar(25) NOT NULL,
  `bName` varchar(30) NOT NULL DEFAULT '-',
  `aNumber` varchar(20) NOT NULL DEFAULT '-',
  `sReceipt` varchar(20) NOT NULL,
  `dWatermark` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `sName`, `Image`, `Phone`, `pBox`, `pCode`, `pCity`, `bName`, `aNumber`, `sReceipt`, `dWatermark`) VALUES
(1, 'Sample Secondary School', 'IMG_20181213_115152.jpg', 70563884, 100, 39293, 'Nakuru', '-', '-', '8938892', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stream`
--

CREATE TABLE `stream` (
  `id` int(11) NOT NULL,
  `streamName` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stream`
--

INSERT INTO `stream` (`id`, `streamName`, `status`) VALUES
(1, 'East', '1'),
(2, 'West', '1');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `names` varchar(60) NOT NULL,
  `parent` varchar(50) NOT NULL,
  `class` varchar(15) NOT NULL,
  `stream` varchar(10) NOT NULL,
  `regNo` varchar(10) NOT NULL,
  `Birthday` varchar(10) NOT NULL,
  `Year` varchar(5) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `dorm` varchar(15) NOT NULL,
  `photo` varchar(15) NOT NULL,
  `fees` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `names`, `parent`, `class`, `stream`, `regNo`, `Birthday`, `Year`, `gender`, `dorm`, `photo`, `fees`, `balance`, `status`) VALUES
(1, 'samuel mwangi', 'parent parent1', '1', 'East', '1900', '2019-09-14', '2019', 'Male', '--N/A--', 'rect8027.png', 20000, 30000, 1),
(3, 'sam mwangi', 'james kan maina', '1', 'West', '1901', '2019-09-14', '2019', 'Male', 'Malaba', 'title.png', 20000, 84000, 0),
(4, 'Pentellis alehandro', 'parent parent1', '2', 'East', '1902', '2019-09-14', '2019', 'Male', '--N/A--', 'rect8027.png', 20000, 60000, 1),
(8, 'mary njeri', 'parent parent1', '1', 'East', '1905', '2002-01-27', '', 'Female', '--N/A--', 'WhatsApp Image ', 0, 0, 1),
(9, 'joseph kiarie ', 'parent parent1', '1', 'East', '1904', '2019-10-05', '', 'Male', '--N/A--', '', 20000, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subjectName` varchar(40) NOT NULL,
  `subjectCode` int(4) NOT NULL,
  `subjectAbbr` varchar(10) NOT NULL,
  `subCategory` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subjectName`, `subjectCode`, `subjectAbbr`, `subCategory`, `status`) VALUES
(1, 'English', 101, 'Eng', 'Languages', 1),
(2, 'Computer', 383, 'Comp', 'Technicals', 1),
(3, 'Kiswahili', 102, 'Kisw', 'Languages', 1),
(4, 'Mathematics', 121, 'Math', 'Sciences', 1),
(5, 'Biology', 231, 'Bio', 'Sciences', 1),
(6, 'Physics', 232, 'Phy', 'Sciences', 1),
(7, 'Chemistry', 233, 'Chem', 'Sciences', 1),
(9, 'History & Government', 311, 'Hist & Gov', 'Humanities', 1),
(10, 'Geography', 312, 'Geo', 'Humanities', 1),
(11, 'Christian Religion Education', 313, 'C.R.E', 'Humanities', 1),
(16, 'Agriculture', 443, 'Agric', 'Technicals', 1),
(17, 'French', 501, 'Fren', 'Languages', 1),
(18, 'German', 502, 'Ger', 'Languages', 1),
(19, 'Arabic', 503, 'Ar', 'Languages', 1),
(22, 'Business Studies', 565, 'B/S', 'Business', 1),
(23, 'Automotive', 309, 'Aut.', 'Technicals', 1),
(24, 'Home Science', 848, 'HSC', 'Technicals', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjectteachers`
--

CREATE TABLE `subjectteachers` (
  `id` int(11) NOT NULL,
  `teacherName` varchar(20) NOT NULL,
  `Subject` varchar(20) NOT NULL,
  `class` int(2) NOT NULL,
  `stream` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjectteachers`
--

INSERT INTO `subjectteachers` (`id`, `teacherName`, `Subject`, `class`, `stream`, `status`) VALUES
(1, 'samuel mwangi', 'English', 1, 'East', 1),
(2, 'deputy principal', 'Computer', 1, 'East', 1),
(3, 'samuel mwangi', 'Physics', 1, 'West', 1),
(4, 'mary njeri', 'English', 1, 'East', 1),
(5, 'samuel mwangi', 'Biology', 1, 'East', 1),
(6, 'mary njeri', 'Physics', 1, 'East', 1),
(7, 'deputy principal', 'Chemistry', 1, 'East', 1),
(8, 'deputy principal', 'History & Government', 2, 'West', 1),
(9, 'samuel mwangi', 'Christian Religion E', 1, 'West', 1),
(10, 'mary njeri', 'Agriculture', 1, 'West', 1),
(11, 'samuel mwangi', 'Kiswahili', 1, 'East', 1),
(12, 'deputy principal', 'Mathematics', 1, 'East', 1),
(13, 'mary njeri', 'History & Government', 1, 'East', 1),
(14, 'deputy principal', 'Agriculture', 1, 'East', 1),
(15, 'samuel mwangi', 'Business Studies', 1, 'East', 1),
(16, 'deputy principal', 'Geography', 1, 'East', 1),
(17, 'mary njeri', 'Home Science', 1, 'East', 1),
(18, 'deputy principal', 'Christian Religion E', 1, 'East', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `names` varchar(75) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `bdate` varchar(20) NOT NULL,
  `empNumber` varchar(20) NOT NULL,
  `designation` varchar(20) DEFAULT NULL,
  `department` varchar(20) NOT NULL,
  `major` varchar(20) NOT NULL,
  `minor` varchar(20) NOT NULL,
  `academicLevel` varchar(20) NOT NULL,
  `salary` int(7) NOT NULL,
  `health` varchar(3) NOT NULL,
  `password` varchar(72) NOT NULL,
  `empType` varchar(20) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `phone` int(11) NOT NULL,
  `kraPin` varchar(20) NOT NULL,
  `idNumber` int(8) NOT NULL,
  `previousEmployer` varchar(20) NOT NULL,
  `passportName` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `empDate` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `roled` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `names`, `email`, `gender`, `bdate`, `empNumber`, `designation`, `department`, `major`, `minor`, `academicLevel`, `salary`, `health`, `password`, `empType`, `nationality`, `phone`, `kraPin`, `idNumber`, `previousEmployer`, `passportName`, `status`, `empDate`, `role`, `roled`) VALUES
(1, 'samuel mwangi', 'samuelmwangi729@gmail.com', '----Ma', '', 'gdt122', '--Senior Teacher--', '----Humanities----', '----English----', '----English----', 'Bachelors', 19999, 'Yes', '603011e54ca13fc16988f28465b5ee885f188f27', '----Permanent----', 'Kenyan', 0, '', 0, 'knec', 'bitmap.png', 0, '19-Aug-30', 'teacher', 0),
(2, 'parent parent1', 'parent@parent.com', 'Male', '', '', 'PTA chair', '', '', '', 'BAchelors', 0, 'Yes', '', '', 'Kenyan', 709688506, '', 0, '', '2.png', 1, '19-Aug-30', 'Parent', 1),
(7, 'James maina maina ', 'maina@james.com', 'Male', '', '', 'BOM chairman', '', '', '', 'Bachelorss', 0, 'Yes', '', '', 'Kenyan', 609458843, '', 0, '', 'bitmap.png', 1, '19-Aug-30', 'Parent', 1),
(9, 'john ndungu', 'johnndungu@gmail.com', 'Male', '', '234445', NULL, '', '', '', 'Degree', 1000, 'Yes', '603011e54ca13fc16988f28465b5ee885f188f27', '--Permanent--', 'Kenyan', 704922042, 'A009989675u', 44322212, 'kenya govt', 'bitmap.png', 0, '19-Aug-30', 'Accountant', 0),
(10, 'deputy principal', 'deputy@principal.com', 'Male', '2019-08-30', 'tsc001', 'Senior Teacher', 'Humanities', 'English', 'English', 'Bachelors', 30000, 'Yes', '05e9967c738016cfbc4248bf2b75bf425ef3370c', 'Permanent', 'Kenyan', 704922042, 'A009987645Y', 33213387, 'no one', '1.png', 1, '19-Aug-30', 'teacher', 0),
(11, 'aCCOUNTANT ', 'accountant@accountant.com', 'Male', '2019-08-30', 'SCE/123/45', NULL, '', '', '', 'bACHELORS', 23000, 'Yes', '39a64a24e67cb19631a5fb55720a1734810778b8', 'Permanent', 'kENYAN', 698577432, 'A009987656T', 33453345, 'NONE', '1.png', 1, '19-Aug-30', 'Accountant', 0),
(12, 'librarian librarian ', 'librarian@librarian.com', 'Male', '', 'sam', NULL, '', '', '', 'Bachelors', 12000, 'Yes', '603011e54ca13fc16988f28465b5ee885f188f27', 'Permanent', 'Kenyan', 704922942, 'A0088964783', 33214456, 'Kenyan', 'bitmap.png', 0, '19-Aug-30', 'Librarian', 0),
(13, 'samwel Mwangi ', 'sam@sam.com1', 'Male', '2019-09-10', '347834g', NULL, '', '', '', 'Bachelors', 5000, 'Yes', '94a9b733000316fec2688d4f93f9ba9ed2dbd3c7', 'Permanent', 'Kenyan', 796978905, 'A00OO98576T', 55906697, 'None', 'IMG-20190905-WA0005.', 1, '19-Sep-09', 'Librarian', 0),
(14, 'james kan maina ', 'james@kan.com', 'Male', '', '', 'Chair', '', '', '', 'Bachelors', 0, 'No', '', '', 'Kenyan', 604944567, '', 0, '', 'bitmap.png', 1, '19-Sep-09', 'Parent', 1),
(15, 'james maina ', 'james@maina.com1', 'Male', '2019-09-26', 'shjs62', NULL, '', '', '', 'Bachelors', 20000, 'Yes', 'c48523f85a0f55272fb62a65a378ba507a8ea9b6', 'Permanent', 'Kenyan', 695099594, 'A00889987654r', 66789909, 'KBL', 'title.png', 0, '19-Sep-25', 'Accountant', 0),
(16, 'mary njeri', 'maryNjeri@gmail.com', 'Female', '2019-09-19', 'wssdsd', 'Principal', 'Sciences', 'Mathematics', 'Computer', 'Masters', 783333, 'No', '5a6493f1992efd7d6c11d067230cb7a53560474b', 'Permanent', 'Kenyan', 690599405, 'A008899564', 332126638, 'BOM', 'logo1.png', 0, '19-Sep-25', 'teacher', 0),
(17, 'nancy Njeri', 'nancy@njeri.com', 'Male', '1988-09-29', 'dhdsyuwe', 'Principal', 'Sciences', 'Biology', 'Chemistry', 'Bachelors', 56000, 'No', '3b711146df0ea95d85e9ef5fe250e01bd0bd80f2', 'Permanent', 'Kenyan', 605933023, 'A00OOJFI85Y', 99457784, 'N/A', 'WhatsApp Image 2019-', 0, '19-Sep-29', 'teacher', 0);

-- --------------------------------------------------------

--
-- Table structure for table `totals`
--

CREATE TABLE `totals` (
  `id` int(11) NOT NULL,
  `examTitle` varchar(11) NOT NULL,
  `studentReg` varchar(11) NOT NULL,
  `total` int(11) NOT NULL,
  `Year` varchar(11) NOT NULL,
  `Term` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `totals`
--

INSERT INTO `totals` (`id`, `examTitle`, `studentReg`, `total`, `Year`, `Term`) VALUES
(1, 'Opener Exam', '1900', 579, '2019', 'I'),
(2, 'Opener Exam', '1901', 916, '2019', 'I');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `role` varchar(15) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'samuel mwangi', 'c3b38d5e462b1f400da6511e47929908dee2249a', 'Administrator', 1),
(2, 'james maina ', 'c3b38d5e462b1f400da6511e47929908dee2249a', 'Accountant', 0),
(3, 'mary njeri', '1cfc1bd537eabe6299c8d99f5da00c632f4913b8', 'teacher', 1),
(4, 'admin', 'dd94709528bb1c83d08f3088d4043f4742891f4f', 'Administrator', 1),
(5, 'nancy Njeri', '3b711146df0ea95d85e9ef5fe250e01bd0bd80f2', 'teacher', 0);

-- --------------------------------------------------------

--
-- Table structure for table `votehead`
--

CREATE TABLE `votehead` (
  `id` int(11) NOT NULL,
  `voteHead` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votehead`
--

INSERT INTO `votehead` (`id`, `voteHead`, `status`) VALUES
(1, 'Lunch ', 1),
(2, 'Boarding ', 1),
(3, 'Games', 1),
(4, 'Caution Money', 1),
(5, 'Medical', 1),
(6, 'PTA', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catresults`
--
ALTER TABLE `catresults`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catsubject`
--
ALTER TABLE `catsubject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form` (`form`);

--
-- Indexes for table `classmeans`
--
ALTER TABLE `classmeans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clubName` (`clubName`);

--
-- Indexes for table `clubsmembers`
--
ALTER TABLE `clubsmembers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currentsession`
--
ALTER TABLE `currentsession`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department` (`department`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designation` (`designation`);

--
-- Indexes for table `dorm`
--
ALTER TABLE `dorm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dormName` (`dormName`);

--
-- Indexes for table `examinations`
--
ALTER TABLE `examinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examresults`
--
ALTER TABLE `examresults`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examtotals`
--
ALTER TABLE `examtotals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prole`
--
ALTER TABLE `prole`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prole` (`prole`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stream`
--
ALTER TABLE `stream`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjectName` (`subjectName`),
  ADD KEY `subjectCode` (`subjectCode`);

--
-- Indexes for table `subjectteachers`
--
ALTER TABLE `subjectteachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `names` (`names`,`empNumber`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `totals`
--
ALTER TABLE `totals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `votehead`
--
ALTER TABLE `votehead`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catresults`
--
ALTER TABLE `catresults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `catsubject`
--
ALTER TABLE `catsubject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `classmeans`
--
ALTER TABLE `classmeans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clubsmembers`
--
ALTER TABLE `clubsmembers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `currentsession`
--
ALTER TABLE `currentsession`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dorm`
--
ALTER TABLE `dorm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `examinations`
--
ALTER TABLE `examinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `examresults`
--
ALTER TABLE `examresults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `examtotals`
--
ALTER TABLE `examtotals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prole`
--
ALTER TABLE `prole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stream`
--
ALTER TABLE `stream`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `subjectteachers`
--
ALTER TABLE `subjectteachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `totals`
--
ALTER TABLE `totals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votehead`
--
ALTER TABLE `votehead`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
