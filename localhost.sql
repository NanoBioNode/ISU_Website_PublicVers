-- phpMyAdmin SQL Dump
-- version 4.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 04, 2015 at 05:44 PM
-- Server version: 5.6.26
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `isu_experimental`
--

-- --------------------------------------------------------

--
-- Table structure for table `experimentaldesign`
--

CREATE TABLE IF NOT EXISTS `experimentaldesign` (
  `username` varchar(32) NOT NULL DEFAULT '',
  `experiment` int(11) NOT NULL DEFAULT '0',
  `exp-knockout` varchar(16) NOT NULL DEFAULT '',
  `exp-plasmid` varchar(16) NOT NULL DEFAULT '',
  `exp-strain` varchar(32) NOT NULL DEFAULT '',
  `exp-results` int(11) DEFAULT NULL,
  `control-strain` varchar(32) NOT NULL DEFAULT '',
  `control-results` int(11) DEFAULT NULL,
  `tablesaved` int(11) NOT NULL DEFAULT '0',
  `tablesavedy` int(11) NOT NULL DEFAULT '0',
  `comments` text,
  `exp-plasmid2` varchar(16) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experimentaldesign`
--

INSERT INTO `experimentaldesign` (`username`, `experiment`, `exp-knockout`, `exp-plasmid`, `exp-strain`, `exp-results`, `control-strain`, `control-results`, `tablesaved`, `tablesavedy`, `comments`, `exp-plasmid2`) VALUES
('', 1, 'dos2', 'pDOS2-L', 'dos2 + pDOS2-L', NULL, 'dos2-EmptyL', NULL, 5, 4, '=***\r\n\r\n\r\n\r\n\r\n', ''),
('', 2, 'dos2', 'pDOS2-H', 'dos2 + pDOS2-H', NULL, '', NULL, 0, 0, '', ''),
('', 3, 'dos2', 'pOPI1-L', 'dos2 + pOPI1-L', NULL, '', NULL, 0, 0, '', ''),
('', 4, 'dos2', 'pOPI1-H', 'dos2 + pOPI1-H', NULL, '', NULL, 0, 0, '', ''),
('', 5, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('dummy1', 1, 'coa6', 'pOPI1-L', 'coa6 + pOPI1-L + pOPI1-H', NULL, 'hap3-EmptyL', NULL, 3, 3, '***=', 'pOPI1-H'),
('dummy1', 2, '', '', ' + ', NULL, '', NULL, 0, 0, '***=', ''),
('dummy1', 3, '', '', ' + ', NULL, '', NULL, 0, 0, '', ''),
('dummy1', 4, '', '', ' + ', NULL, '', NULL, 0, 0, '', ''),
('dummy1', 5, '', '', ' + ', NULL, 'mgt1-EmptyL', NULL, 0, 0, '', ''),
('dummy1', 6, '', '', ' + ', NULL, '', NULL, 0, 0, '', ''),
('dummy1', 7, '', '', ' + ', NULL, '', NULL, 0, 0, '', ''),
('dummy1', 8, '', '', ' + ', NULL, '', NULL, 0, 0, '', ''),
('dummy1', 9, '', '', ' + ', NULL, '', NULL, 0, 0, '', ''),
('dummy1', 10, '', '', ' + ', NULL, 'csi1-EmptyH', NULL, 0, 0, '', ''),
('dummy1', 11, '', '', ' + ', NULL, '', NULL, 0, 0, '', ''),
('dummy1', 12, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('dummy10', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'meh1-EmptyH', NULL, 4, 5, '', ''),
('dummy2', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'opi1-EmptyH', NULL, 7, 6, '', ''),
('dummy22', 1, 'meh1', 'pDOS2-H', 'meh1 + pDOS2-H + pHAP3-L', NULL, 'opi1-EmptyH', NULL, 4, 5, '***=', 'pHAP3-L'),
('dummy22', 2, 'hap3', 'pHAP3-L', 'hap3 + pHAP3-L', NULL, 'hap3-EmptyL', NULL, 0, 0, 'd c b a', ''),
('dummy22', 3, 'fyv6', 'pHAP3-L', 'fyv6 + pHAP3-L', NULL, 'hap3-EmptyL', NULL, 0, 0, 'd c b a a', ''),
('dummy22', 4, 'ino4', 'pHAP3-H', 'ino4 + pHAP3-H', NULL, 'meh1-EmptyH', NULL, 0, 0, '', ''),
('dummy22', 5, '', '', ' +  + ', NULL, 'fyv6-EmptyH', NULL, 0, 0, '', ''),
('dummy22', 6, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('dummy22', 7, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 8, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 9, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 10, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 11, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 12, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 13, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 14, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 15, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 16, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 17, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 18, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 19, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 20, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 21, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 22, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 23, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 24, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 25, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 26, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 27, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 28, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 29, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('Dummy22', 30, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('dummy3', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'meh1-EmptyH', NULL, 4, 5, '', ''),
('dummy4', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'meh1-EmptyH', NULL, 4, 5, '', ''),
('dummy5', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'meh1-EmptyH', NULL, 4, 5, '', ''),
('dummy55', 1, 'opi1', 'pHAP3-L', 'opi1 + pHAP3-L', NULL, 'opy1-EmptyL', NULL, 4, 4, '***=', ''),
('dummy55', 2, 'gfd1', 'pHAP3-L', 'gfd1 + pHAP3-L', NULL, 'gfd1-EmptyL', NULL, 0, 0, '***=', ''),
('dummy55', 3, 'meh1', 'pHAP3-L', 'meh1 + pHAP3-L', NULL, 'fyv6-EmptyL', NULL, 0, 0, '', ''),
('dummy55', 4, 'WT (BY4741)', 'pHAP3-L', 'WT (BY4741) + pHAP3-L', NULL, 'WT (BY4741)-EmptyL', NULL, 0, 0, '', ''),
('dummy55', 5, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('dummy55', 6, '', '', ' + ', NULL, '', NULL, 0, 0, NULL, ''),
('dummy6', 1, 'meh1', 'pHAP3-L', 'meh1 + pHAP3-L', NULL, 'meh1-EmptyL', NULL, 4, 4, 'Alfredo''s example', ''),
('dummy6', 2, 'fyv6', 'pHAP3-L', 'fyv6 + pHAP3-L', NULL, 'fyv6-EmptyL', NULL, 0, 0, 'Alfredo''s Example', ''),
('dummy6', 3, 'isy1', 'pHAP3-L', 'isy1 + pHAP3-L', NULL, 'isy1-EmptyL', NULL, 0, 0, 'Alfredo''s Example', ''),
('dummy6', 4, 'WT (BY4741)', 'pHAP3-L', 'WT (BY4741) + pHAP3-L', NULL, 'WT (BY4741)-EmptyL', NULL, 0, 0, 'Alfredo''s Example', ''),
('dummy7', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'meh1-EmptyH', NULL, 4, 1, '', ''),
('dummy8', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'meh1-EmptyH', NULL, 1, 1, '', ''),
('dummy9', 1, 'mgt1', 'pPEX13-L', 'mgt1 + pPEX13-L', NULL, 'meh1-EmptyH', NULL, 4, 4, '', '');


-- --------------------------------------------------------

--
-- Table structure for table `experimentresults`
--

CREATE TABLE IF NOT EXISTS `experimentresults` (
  `username` varchar(32) NOT NULL DEFAULT '',
  `plateregion` varchar(16) NOT NULL DEFAULT '',
  `regionnum` int(11) NOT NULL DEFAULT '0',
  `meanrawdensity` varchar(10000) DEFAULT NULL,
  `brep` int(8) DEFAULT '0',
  `trep` int(8) DEFAULT '0',
  `successtrans` varchar(20) NOT NULL DEFAULT '',
  `experiment` int(11) NOT NULL,
  `TAsuccesstrans` varchar(20) NOT NULL DEFAULT '',
  `cbirc` varchar(16) NOT NULL DEFAULT '',
  `fails` int(11) NOT NULL DEFAULT '0',
  `commentsr` varchar(300) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experimentresults`
--

INSERT INTO `experimentresults` (`username`, `plateregion`, `regionnum`, `meanrawdensity`, `brep`, `trep`, `successtrans`, `experiment`, `TAsuccesstrans`, `cbirc`, `fails`, `commentsr`) VALUES
('', 'A1-A6', 0, NULL, 3, 2, 'Yes', 1, '', '1. Contamination', 0, ''),
('', '', 0, NULL, 0, 0, '', 2, '', '', 0, ''),
('', '', 0, NULL, 0, 0, '', 3, '', '', 0, ''),
('', '', 0, NULL, 0, 0, '', 4, '', '', 0, ''),
('', '', 0, NULL, 0, 0, '', 5, '', '', 0, ''),
('', '', 0, NULL, 0, 0, '', 500001, '', '', 0, ''),
('', '', 0, NULL, 0, 0, '', 500002, '', '', 0, ''),
('', '', 0, NULL, 0, 0, '', 500003, '', '', 0, ''),
('dummy1', ' ', 0, 'A1: 69.3757\nA2: 36.219\nA3: 39.1682\nA4: 34.5861\nA5: 36.4465\nA6: 40.8113', 0, 0, 'No', 1, 'No', '2. Keep Plate', 0, ''),
('dummy1', 'A3-B6', 0, 'A3: 39.1682\nA4: 34.5861\nA5: 36.4465\nA6: 40.8113\nB1: 35.8771\nB2: 40.141\nB3: 32.7912\nB4: 40.4877\nB5: 37.9806\nB6: 37.7711', 1, 1, '', 2, '', '', 0, ''),
('dummy1', ' ', 0, 'C1: 39.2817\nC2: 31.3025\nC3: 36.3899\nC4: 33.2465\nC5: 40.5234\nC6: 37.5845', 0, 0, 'No', 3, 'No', '', 0, ''),
('dummy1', 'D1-D6', 0, 'D1: 33.179\nD2: 26.6721\nD3: 39.4829\nD4: 43.684\nD5: 41.7325\nD6: 41.0156', 6, 1, '', 4, 'Yes', '', 0, ''),
('dummy1', '', 0, NULL, NULL, NULL, '', 5, '', '', 0, ''),
('dummy1', 'E1-E3', 0, 'E1: 31.8711\nE2: 43.3445\nE3: 43.1943', 1, 3, 'checked', 500001, '', '', 0, ''),
('dummy1', 'E4-E6', 0, 'E4: 42.0294\nE5: 37.1289\nE6: 32.7024', 1, 3, 'checked', 500002, '', '', 0, ''),
('dummy1', 'F1-F3', 0, 'F1: 32.4964\nF2: 39.9333\nF3: 30.2825', 1, 3, 'checked', 500003, '', '', 0, ''),
('dummy1', 'F4-F6', 0, 'F4: 26.8434\nF5: 35.462\nF6: 35.7203', 1, 3, 'checked', 500004, '', '', 0, ''),
('dummy1', '', 0, NULL, 0, 0, '', 500005, '', '', 0, ''),
('dummy10', '', 0, NULL, NULL, NULL, '', 1, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 1, '', '4. Few Colonies', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 2, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 3, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 4, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 500001, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 500002, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 500003, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 500004, '', '', 0, ''),
('dummy2', '', 0, NULL, 0, 0, '', 500005, '', '', 0, ''),
('dummy22', ' ', 0, NULL, 0, 0, 'No', 1, 'Yes', '1. Contamination', 4, ''),
('dummy22', 'B1-B6', 0, NULL, 3, 2, 'Yes', 2, 'Yes', '', 0, ''),
('dummy22', 'C1-C4', 0, NULL, 2, 2, 'Yes', 3, 'Yes', '', 0, ''),
('Dummy22', ' ', 0, NULL, 0, 0, 'No', 4, '', '', 2, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 5, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 6, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 7, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 8, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 9, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 10, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 11, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 12, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 13, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 14, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 15, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 16, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 17, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 18, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 19, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 20, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 21, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 22, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 23, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 24, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 25, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 26, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 27, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 28, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 29, '', '', 0, ''),
('Dummy22', '', 0, NULL, 0, 0, '', 30, '', '', 0, ''),
('dummy22', 'C5', 0, NULL, 1, 1, '', 500001, '', '', 0, ''),
('dummy22', 'C6', 0, NULL, 1, 1, '', 500002, '', '', 0, ''),
('dummy22', 'D1', 0, NULL, 1, 1, '', 500003, '', '', 0, ''),
('dummy22', '', 0, NULL, 1, 1, '', 500004, '', '', 0, ''),
('dummy22', '', 0, NULL, 1, 1, '', 500005, '', '', 0, ''),
('dummy22', '', 0, NULL, 1, 1, '', 500006, '', '', 0, ''),
('dummy22', '', 0, NULL, NULL, NULL, '', 500007, '', '', 0, ''),
('dummy3', 'A1-A6', 0, NULL, 3, 2, 'Yes', 1, 'Yes', '', 0, ''),
('dummy33', '', 0, NULL, 0, 0, '', 1, '', '', 0, ''),
('dummy33', '', 0, NULL, 0, 0, '', 2, '', '', 0, ''),
('dummy33', '', 0, NULL, 0, 0, '', 3, '', '', 0, ''),
('dummy33', '', 0, NULL, 0, 0, '', 4, '', '', 0, ''),
('dummy4', '', 0, NULL, NULL, NULL, '', 1, '', '', 0, ''),
('dummy4', '', 0, NULL, NULL, NULL, '', 2, '', '', 0, ''),
('dummy4', '', 0, NULL, NULL, NULL, '', 3, '', '', 0, ''),
('dummy4', '', 0, NULL, NULL, NULL, '', 4, '', '', 0, ''),
('dummy5', '', 0, NULL, NULL, NULL, '', 1, '', '', 0, ''),
('dummy55', 'A1-A6', 0, NULL, 3, 2, 'Yes', 1, '', '', 0, ''),
('dummy55', 'B1-B6', 0, NULL, 3, 2, 'Yes', 2, '', '', 0, ''),
('dummy55', 'C1-C6', 0, NULL, 3, 2, 'Yes', 3, '', '', 0, ''),
('dummy55', 'D1-D6', 0, NULL, 3, 2, '', 4, '', '', 0, ''),
('dummy55', '', 0, NULL, 0, 0, '', 5, '', '', 0, ''),
('dummy55', '', 0, NULL, 0, 0, '', 6, '', '', 0, ''),
('dummy55', 'E1-E3', 0, NULL, 3, 1, '', 500001, '', '', 0, ''),
('dummy55', 'E4-E6', 0, NULL, 3, 1, '', 500002, '', '', 0, ''),
('dummy55', 'F1-F3', 0, NULL, 3, 1, '', 500003, '', '', 0, ''),
('dummy55', 'F4-F6', 0, NULL, 3, 1, '', 500004, '', '', 0, ''),
('dummy6', 'A1-A6', 0, NULL, 2, 3, 'checked', 1, '', '', 0, ''),
('dummy6', 'B1-B6', 0, NULL, 2, 3, 'checked', 2, '', '', 0, ''),
('dummy6', 'C1-C6', 0, NULL, 2, 3, 'checked', 3, '', '', 0, ''),
('dummy6', 'D1-D6', 0, NULL, 2, 3, 'checked', 4, '', '', 0, ''),
('dummy6', 'E1-E3', 0, NULL, 1, 3, 'checked', 500001, '', '', 0, ''),
('dummy6', 'E4-E6', 0, NULL, 1, 3, 'checked', 500002, '', '', 0, ''),
('dummy6', 'F1-F3', 0, NULL, 1, 3, 'checked', 500003, '', '', 0, ''),
('dummy6', 'F4-F6', 0, NULL, 1, 3, 'checked', 500004, '', '', 0, ''),
('dummy7', '', 0, NULL, NULL, NULL, '', 1, '', '', 0, ''),
('dummy8', '', 0, NULL, NULL, NULL, '', 1, '', '', 0, ''),
('dummy9', '', 0, NULL, NULL, NULL, '', 1, '', '', 0, ''),
('dummy9', '', 0, NULL, NULL, NULL, '', 2, '', '', 0, ''),
('dummy9', '', 0, NULL, NULL, NULL, '', 3, '', '', 0, ''),
('dummy9', '', 0, NULL, NULL, NULL, '', 4, '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `geneinfo`
--

CREATE TABLE IF NOT EXISTS `geneinfo` (
  `username` varchar(32) NOT NULL DEFAULT '',
  `genename` varchar(16) NOT NULL DEFAULT '',
  `systematicname` varchar(16) NOT NULL DEFAULT '',
  `size` varchar(16) NOT NULL DEFAULT '',
  `info` varchar(512) NOT NULL DEFAULT '',
  `experimentalinfo` varchar(512) NOT NULL DEFAULT '',
  `relationshiptolipids` tinyint(1) NOT NULL DEFAULT '0',
  `function` varchar(512) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geneinfo`
--

INSERT INTO `geneinfo` (`username`, `genename`, `systematicname`, `size`, `info`, `experimentalinfo`, `relationshiptolipids`, `function`) VALUES
('dummy22', 'abc1', '', '', '', '', 0, 'Ubiquitin'),
('dummy22', 'FYV6', '', '', '', '', 0, ''),
('Dummy22', 'Gene Hackman', '', '~220lbs', '', '', 0, 'Other-Metabolic Degradation'),
('dummy22', 'OPI1', '', '', '', '', 0, 'mRNA Splicing/Export'),
('dummy22', 'OPI2', '', '', '', '', 0, ''),
('dummy55', 'IGO1', 'YNL157W', '506', 'Protein required for initiation of G0 program; prevents degradation of nutrient-regulated mRNAs via the 5''-3'' mRNA decay pathway; phosphorylated by Rim15p; GFP protein localizes to the cytoplasm and nucleus; IGO1 has a paralog, IGO2, that arose from the whole genome duplication', 'Positive regulator', 0, 'Protein Trafficking'),
('dummy55', 'OPI1', 'YHL020C', '1214', 'Transcriptional regulator of a variety of genes; phosphorylation by protein kinase A stimulates Opi1p function in negative regulation of phospholipid biosynthetic genes; involved in telomere maintenance; null exhibits disrupted mitochondrial metabolism and low cardiolipin content, strongly correlated with overproduction of inositol', 'Negative regulator', 0, 'Transcription Factor'),
('dummy55', 'VPS1', 'YKR001C', '670', 'Dynamin-like GTPase required for vacuolar sorting; also involved in actin cytoskeleton organization, endocytosis, late Golgi-retention of some proteins, regulation of peroxisome biogenesis', 'knockout strain increased production of fatty acid since it''s significantly different from the wild type strain.', 0, 'Protein Trafficking');

-- --------------------------------------------------------

--
-- Table structure for table `oj_assets`
--

CREATE TABLE IF NOT EXISTS `oj_assets` (
  `name` varchar(64) NOT NULL DEFAULT '',
  `isRemovable` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oj_canRead`
--

CREATE TABLE IF NOT EXISTS `oj_canRead` (
  `role` varchar(64) NOT NULL DEFAULT '',
  `asset` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oj_canWrite`
--

CREATE TABLE IF NOT EXISTS `oj_canWrite` (
  `role` varchar(64) NOT NULL DEFAULT '',
  `asset` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oj_hasRole`
--

CREATE TABLE IF NOT EXISTS `oj_hasRole` (
  `username` varchar(32) NOT NULL DEFAULT '',
  `role` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oj_hasRole`
--

INSERT INTO `oj_hasRole` (`username`, `role`) VALUES
('dummy1', 'Student'),
('dummy10', 'Student'),
('dummy2', 'Student'),
('dummy22', 'Student'),
('dummy3', 'Student'),
('dummy33', 'Student'),
('dummy4', 'Student'),
('dummy44', 'Student'),
('dummy5', 'Student'),
('dummy55', 'Student'),
('dummy6', 'Student'),
('dummy7', 'Student'),
('dummy8', 'Student'),
('dummy9', 'Student'),
('sobhtest', 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `oj_roles`
--

CREATE TABLE IF NOT EXISTS `oj_roles` (
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(256) DEFAULT NULL,
  `isEditable` tinyint(1) NOT NULL DEFAULT '1',
  `isRemovable` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oj_roles`
--

INSERT INTO `oj_roles` (`name`, `description`, `isEditable`, `isRemovable`) VALUES
('Student', NULL, 1, 0),
('Super Admin', NULL, 0, 0),
('Teacher', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `oj_settings`
--

CREATE TABLE IF NOT EXISTS `oj_settings` (
  `id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oj_users`
--

CREATE TABLE IF NOT EXISTS `oj_users` (
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `salt` varchar(64) DEFAULT '',
  `firstname` varchar(64) NOT NULL DEFAULT '',
  `lastname` varchar(64) NOT NULL DEFAULT '',
  `last_access` timestamp NULL DEFAULT NULL,
  `registerDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `studentid` varchar(16) DEFAULT NULL,
  `semester` varchar(16) DEFAULT 'fall2014',
  `section` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oj_users`
--

INSERT INTO `oj_users` (`username`, `password`, `email`, `salt`, `firstname`, `lastname`, `last_access`, `registerDate`, `studentid`, `semester`, `section`) VALUES
('dummy1', '502575877e058bf9ca34d9cb552c568a6adc462f73b9355cfcd45ceb30af3a8c', 'dummy1', 'cb2297f0cb5345dbf0b2b50a46943755dd86a45e14e3647716cb73268be51d90', 'FirstName', 'LastName', '2015-09-01 18:17:28', '0000-00-00 00:00:00', NULL, 'fall2016', '1'),
('dummy10', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '10'),
('dummy12', '3eb797444179881d71b9d535ecbc5f8cc4529115e48e045e5c99c22a54e19bbc', 'dummy12015@iastate.edu', '3b130a80af7988b2f6999778206fc7e825c5e6215ad28855859c5bd2f31b34c9', 'DummyFall', 'One', '2015-09-01 22:10:13', '2015-08-28 01:00:41', '12345678', 'fall2015', '2'),
('dummy2', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'fall2016', '2'),
('dummy22', '6dd30e26b5e78e72239f90f833ed58a0d8f8418942f0e95b042cdf76b121994f', 'dummy22015@iastate.edu', 'e59e44b7df16d002c8f4974ede7b0a956bd568a6db4cf1a81f610ca5b17a9c0e', 'DummyFall', 'Two', '2015-09-01 22:06:52', '2015-08-28 01:01:34', '12345678', 'fall2015', '2'),
('dummy3', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '3'),
('dummy33', 'b90be8f263a44182c0d27128f33be169cf5e87721955d7d75ec8867d6f6789b5', 'dummy32015@iastate.edu', '3128b2206671a0b0d5211693f0b95c7a966b369a6b9d3da3794a9a8ed56cd2c9', 'DummyFall', 'Three', '2015-09-01 18:23:20', '2015-08-28 01:05:40', '12345678', 'fall2015', '3'),
('dummy4', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '4'),
('dummy44', 'e7e42cbbef0ab9d39bc8b511d77f24d9ade7d1b01244bd685c0100fe81d76319', 'dummy42015@iastate.edu', '21d86f6bbfcb720afa73aff512eec75e42edf18f07038a3ee79decd3de84d602', 'DummyFall', 'Four', '2015-08-27 20:05:58', '2015-08-28 01:05:58', '12345678', 'fall2015', '4'),
('dummy5', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '5'),
('dummy55', '783c583c83e4c3a4e539005068769c63904bad615fc99d534a93521b7090a00c', 'dummy52015@iastate.edu', 'b3653eacc94ec6fef300e63871e6dfd5bf308679bf26a23c749583b5a1b7e075', 'DummyFall', 'Five', '2015-09-01 15:39:49', '2015-08-28 01:06:15', '12345678', 'fall2015', '5'),
('dummy6', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '6'),
('dummy7', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '7'),
('dummy8', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '8'),
('dummy9', '', '', '', '', '', NULL, '0000-00-00 00:00:00', NULL, 'spring2015', '9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `experimentaldesign`
--
ALTER TABLE `experimentaldesign`
  ADD PRIMARY KEY (`username`,`experiment`);

--
-- Indexes for table `experimentresults`
--
ALTER TABLE `experimentresults`
  ADD PRIMARY KEY (`username`,`experiment`);

--
-- Indexes for table `geneinfo`
--
ALTER TABLE `geneinfo`
  ADD PRIMARY KEY (`username`,`genename`);

--
-- Indexes for table `oj_assets`
--
ALTER TABLE `oj_assets`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `oj_canRead`
--
ALTER TABLE `oj_canRead`
  ADD PRIMARY KEY (`role`,`asset`), ADD KEY `canReadAsset` (`asset`);

--
-- Indexes for table `oj_canWrite`
--
ALTER TABLE `oj_canWrite`
  ADD PRIMARY KEY (`role`,`asset`), ADD KEY `canWriteAsset` (`asset`);

--
-- Indexes for table `oj_hasRole`
--
ALTER TABLE `oj_hasRole`
  ADD PRIMARY KEY (`username`,`role`), ADD KEY `hasRoleRole` (`role`);

--
-- Indexes for table `oj_roles`
--
ALTER TABLE `oj_roles`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `oj_settings`
--
ALTER TABLE `oj_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oj_users`
--
ALTER TABLE `oj_users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oj_settings`
--
ALTER TABLE `oj_settings`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `oj_canRead`
--
ALTER TABLE `oj_canRead`
ADD CONSTRAINT `canReadAsset` FOREIGN KEY (`asset`) REFERENCES `oj_assets` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `canReadRole` FOREIGN KEY (`role`) REFERENCES `oj_roles` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oj_canWrite`
--
ALTER TABLE `oj_canWrite`
ADD CONSTRAINT `canWriteAsset` FOREIGN KEY (`asset`) REFERENCES `oj_assets` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `canWriteRole` FOREIGN KEY (`role`) REFERENCES `oj_roles` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oj_hasRole`
--
ALTER TABLE `oj_hasRole`
ADD CONSTRAINT `hasRoleRole` FOREIGN KEY (`role`) REFERENCES `oj_roles` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `hasRoleUser` FOREIGN KEY (`username`) REFERENCES `oj_users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Database: `phpmyadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE IF NOT EXISTS `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE IF NOT EXISTS `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE IF NOT EXISTS `pma__column_info` (
  `id` int(5) unsigned NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE IF NOT EXISTS `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE IF NOT EXISTS `pma__history` (
  `id` bigint(20) unsigned NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=587 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

--
-- Dumping data for table `pma__history`
--

INSERT INTO `pma__history` (`id`, `username`, `db`, `table`, `timevalue`, `sqlquery`) VALUES
(562, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:52:56', 'SELECT * FROM `experimentresults`'),
(563, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:53:09', 'SELECT * FROM `experimentresults` ORDER BY `username` ASC  '),
(564, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:53:16', 'SELECT * FROM `experimentresults` ORDER BY `username` ASC  '),
(565, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:53:22', 'SELECT * FROM `experimentresults` ORDER BY `username` ASC  '),
(566, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:53:35', 'SELECT * FROM `experimentresults` ORDER BY `username` ASC  '),
(567, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:53:38', 'SELECT * FROM `experimentresults` ORDER BY `username` ASC  '),
(568, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:53:49', 'SELECT * FROM `experimentresults` ORDER BY `username` ASC  '),
(569, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:56:27', 'SELECT * FROM `experimentresults`'),
(570, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:56:33', 'SELECT * FROM `experimentresults`\nORDER BY `experimentresults`.`username`  DESC'),
(571, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:56:36', 'SELECT * FROM `experimentresults`\nORDER BY `experimentresults`.`username`  ASC'),
(572, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:59:24', 'SELECT * FROM `experimentresults`'),
(573, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 21:59:56', 'SELECT * FROM `experimentresults`'),
(574, 'root', 'isu_experimental', 'experimentresults', '2015-08-28 22:00:45', 'INSERT INTO `experimentresults` (`username`,`experiment`) VALUES ("dummy22",1)'),
(575, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:12:40', 'SELECT * FROM `experimentresults`'),
(576, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:13:39', 'SELECT * FROM `experimentresults`'),
(577, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:24:00', 'SELECT * FROM `experimentresults` where `username`="dummy22"'),
(578, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:30:46', 'SELECT * FROM `experimentresults` where `username`="dummy22"'),
(579, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:36:26', 'SELECT * FROM `experimentresults` where `username`="dummy22"'),
(580, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:36:28', 'SELECT * FROM `experimentresults` where `username`="dummy22"'),
(581, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:38:11', 'SELECT * FROM `experimentresults` where `username`="sobhtest"'),
(582, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:38:16', 'SELECT * FROM `experimentresults` where `username`="dummy22"'),
(583, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:46:09', 'SELECT * FROM `experimentresults`'),
(584, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:51:20', 'SELECT * FROM `experimentresults` where `username`="dummy22"'),
(585, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 15:51:47', 'SELECT * FROM `experimentresults` where `username`="dummy22"'),
(586, 'root', 'isu_experimental', 'experimentresults', '2015-09-01 21:52:47', 'SELECT * FROM `experimentresults`');

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE IF NOT EXISTS `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE IF NOT EXISTS `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) unsigned NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE IF NOT EXISTS `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{"db":"isu_experimental","table":"experimentresults"},{"db":"isu_experimental","table":"experimentaldesign"},{"db":"isu_experimental","table":"oj_users"},{"db":"isu_experimental","table":"oj_assets"},{"db":"isu_experimental","table":"geneinfo"},{"db":"isu_experimental","table":"oj_hasRole"},{"db":"isu_experimental","table":"oj_roles"},{"db":"isu_experimental","table":"oj_settings"},{"db":"isu_experimental","table":"oj_canWrite"},{"db":"isu_experimental","table":"oj_canRead"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE IF NOT EXISTS `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE IF NOT EXISTS `pma__savedsearches` (
  `id` int(5) unsigned NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE IF NOT EXISTS `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float unsigned NOT NULL DEFAULT '0',
  `y` float unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE IF NOT EXISTS `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE IF NOT EXISTS `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'isu_experimental', 'experimentaldesign', '[]', '2015-08-27 00:06:37'),
('root', 'isu_experimental', 'experimentresults', '{"sorted_col":"`experimentresults`.`username` ASC"}', '2015-08-28 21:56:36'),
('root', 'isu_experimental', 'geneinfo', '{"sorted_col":"`geneinfo`.`size` ASC"}', '2015-08-19 15:43:38'),
('root', 'isu_experimental', 'oj_hasRole', '{"sorted_col":"`oj_hasRole`.`role` DESC"}', '2015-08-13 04:19:34'),
('root', 'isu_experimental', 'oj_users', '{"sorted_col":"`oj_users`.`lastname` ASC"}', '2015-08-27 20:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE IF NOT EXISTS `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE IF NOT EXISTS `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2015-02-16 22:13:05', '{"collation_connection":"utf8mb4_unicode_ci"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE IF NOT EXISTS `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE IF NOT EXISTS `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`), ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`), ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`), ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=587;
--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
