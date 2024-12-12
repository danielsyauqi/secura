-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 05:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sims-orchid`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset_management`
--

CREATE TABLE `asset_management` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `custodian` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sims_id` bigint(20) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` enum('Completed','Draft') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_management`
--

INSERT INTO `asset_management` (`id`, `name`, `quantity`, `description`, `owner`, `location`, `custodian`, `created_at`, `updated_at`, `sims_id`, `type`, `status`) VALUES
(1, 'Core Switch Kompleks Bangi', 1, '3com S7903E', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Ketua Unit Server', '2024-11-26 22:15:36', '2024-12-02 17:47:08', 1, 'Hardware', 'Draft'),
(2, 'DHCP', 2, 'Server DHCP Dell Power Edge 2650 253', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi dan Dengkil', 'F44/F41', '2024-11-26 22:16:22', '2024-11-28 06:21:41', 1, 'Hardware', 'Draft'),
(3, 'Microsoft Windows Server', 10, 'OS bagi AD1(DHCP, DNS, AD), DBS01, HV1, HV2, BSC01, extDNS, DHCP, Appsvr01', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi dan Pusat Data Dengkil', 'F41/F44/Q41', '2024-11-26 22:18:02', '2024-11-28 06:21:45', 1, 'Software', 'Draft'),
(4, 'Dokumen ISMS', 30, 'Dokumen utama ISMS-Manual, DKICT, Prosedur, SOP dll.', 'Pengurus Pusat Teknologi Maklumat', 'Bilik Fail Pusat IT', 'Ketua Unit', '2024-11-27 20:41:54', '2024-11-28 06:21:48', 1, 'Data and Information', 'Draft'),
(5, 'Data PRTG', 2, 'Laporan pemantauan rangkaian dan server', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'F41/F44/F48', '2024-11-27 20:42:24', '2024-11-28 06:21:50', 1, 'Data and Information', 'Draft'),
(6, 'Q52/Q48/Q44/Q41', 8, 'Pegawai Penyelidik', 'Pengarah BST', 'Pusat IT', 'Pengurus IT', '2024-11-27 20:42:53', '2024-11-28 06:21:53', 1, 'Human Resources', 'Draft'),
(7, 'Pendingin udara Pusat Data', 4, 'Aircond Split unit dilengkapi dengan Sistem PANDU', 'Bahagian Kejuruteraan', 'Pusat Data Kompleks Bangi', 'J29/J36', '2024-11-27 20:43:31', '2024-11-28 06:21:56', 1, 'Services', 'Draft'),
(8, 'Linux Centos', 3, 'E-SSDL Server', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Q41/Q44/Q48', '2024-11-27 22:11:35', '2024-11-28 06:22:00', 1, 'Software', 'Draft'),
(9, 'Gen Set Pusat Data', 2, 'Diesel Generator Set di Kompleks Bangi terletak di Blok 27 digunakan untuk membekalkan essential power ke Pusat Data Bangi dan blok-blok lain (blok 13, 17, 15, 27, 28, 29, 29T,30, 30T, 31, 32, 34). Diesel Generator Set di Kompleks Dengkil terletak di sebelah blok 44 khas untuk DC Dengkil)', 'Bahagian Kejuruteraan', 'Pusat Data Kompleks Bangi dan Dengkil', 'Penjaga Jentera, J22', '2024-11-27 22:13:47', '2024-11-28 06:22:02', 1, 'Services', 'Draft'),
(10, 'Firewall System', 5, 'Next-gen firewall for network security', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Security Manager', '2024-12-01 02:00:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(11, 'Office 365 Subscription', 100, 'Microsoft Office 365 licenses', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'IT Administrator', '2024-12-01 02:05:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(12, 'Employee Attendance System', 1, 'System to track employee attendance', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'HR Manager', '2024-12-01 02:10:00', '2024-12-05 07:04:40', 1, 'Work Process', 'Draft'),
(13, 'Employee Handbook', 50, 'Handbook with company policies', 'Pengurus Pusat Teknologi Maklumat', 'HR Department', 'HR Manager', '2024-12-01 02:15:00', '2024-12-05 07:04:40', 1, 'Data and Information', 'Draft'),
(14, 'Printer HP LaserJet', 10, 'HP LaserJet Printers for offices', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Admin Assistant', '2024-12-01 02:20:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(15, 'Server Backup System', 2, 'Backup server with redundant systems', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'IT Support', '2024-12-01 02:25:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(16, 'Cloud Storage Plan', 5, 'Cloud storage for data backups', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Data Officer', '2024-12-01 02:30:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(17, 'Training Material', 100, 'Training materials for new employees', 'Pengurus Pusat Teknologi Maklumat', 'Training Room', 'HR Manager', '2024-12-01 02:35:00', '2024-12-05 07:04:40', 1, 'Data and Information', 'Draft'),
(18, 'Workstation PCs', 30, 'Desktop computers for employee use', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Admin Assistant', '2024-12-01 02:40:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(19, 'Meeting Room Equipment', 8, 'Projectors, speakers, and microphones', 'Pengurus Pusat Teknologi Maklumat', 'Meeting Rooms', 'Facilities Manager', '2024-12-01 02:45:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(20, 'Payroll Software', 1, 'Software for payroll management', 'Pengurus Pusat Teknologi Maklumat', 'HR Department', 'HR Manager', '2024-12-01 02:50:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(21, 'Windows Server 2019', 15, 'Windows Server licenses for new servers', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'IT Admin', '2024-12-01 02:55:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(22, 'VPN Access', 50, 'VPN licenses for secure remote access', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Network Administrator', '2024-12-01 03:00:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(23, 'Antivirus Software', 50, 'Software licenses for virus protection', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Security Manager', '2024-12-01 03:05:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(24, 'Conference Call System', 1, 'System for organizing conference calls', 'Pengurus Pusat Teknologi Maklumat', 'Meeting Room 1', 'Facilities Manager', '2024-12-01 03:10:00', '2024-12-05 07:04:40', 1, 'Services', 'Draft'),
(25, 'Network Switch', 20, 'Gigabit Ethernet Switches for office network', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Network Administrator', '2024-12-01 03:15:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(26, 'Laptop Dell XPS', 40, 'Dell XPS laptops for executive staff', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Admin Assistant', '2024-12-01 03:20:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(27, 'Staff ID Cards', 200, 'Employee identification cards', 'Pengurus Pusat Teknologi Maklumat', 'HR Department', 'HR Manager', '2024-12-01 03:25:00', '2024-12-05 07:04:40', 1, 'Work Process', 'Draft'),
(28, 'Backup Power UPS', 5, 'Uninterruptible Power Supplies for servers', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Facilities Manager', '2024-12-01 03:30:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(29, 'Inventory Management System', 1, 'Software to track inventory of assets', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'IT Admin', '2024-12-01 03:35:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(30, 'Security Cameras', 10, 'CCTV cameras for office and building security', 'Pengurus Pusat Teknologi Maklumat', 'Office Premises', 'Security Officer', '2024-12-01 03:40:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(31, 'Employee Training Platform', 1, 'Platform for employee development and e-learning', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Training Officer', '2024-12-01 03:45:00', '2024-12-05 07:04:40', 1, 'Work Process', 'Draft'),
(32, 'Phone System', 1, 'VoIP telephone system for the office', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Facilities Manager', '2024-12-01 03:50:00', '2024-12-05 07:04:40', 1, 'Services', 'Draft'),
(33, 'Project Management Tool', 1, 'Software tool for managing projects', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Project Manager', '2024-12-01 03:55:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(34, 'Office Chairs', 50, 'Ergonomic office chairs for staff', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Admin Assistant', '2024-12-01 04:00:00', '2024-12-05 07:04:40', 1, 'Premise', 'Draft'),
(35, 'Networking Cables', 100, 'Ethernet cables for network connections', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Network Administrator', '2024-12-01 04:05:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(36, 'Data Backup Tape', 50, 'Magnetic tapes for long-term data storage', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Backup Technician', '2024-12-01 04:10:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(37, 'Server Racks', 10, 'Racks for organizing servers', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Server Administrator', '2024-12-01 04:15:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(38, 'Employee Feedback System', 1, 'System to collect employee feedback', 'Pengurus Pusat Teknologi Maklumat', 'HR Department', 'HR Manager', '2024-12-01 04:20:00', '2024-12-05 07:04:40', 1, 'Work Process', 'Draft'),
(39, 'Company Website', 1, 'Corporate website for the company', 'Pengurus Pusat Teknologi Maklumat', 'Marketing Department', 'Web Developer', '2024-12-01 04:25:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(40, 'Document Scanning System', 1, 'System to scan and digitize physical documents', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Admin Assistant', '2024-12-01 04:30:00', '2024-12-05 07:04:40', 1, 'Work Process', 'Draft'),
(41, 'HR Management Software', 1, 'Software to manage HR processes', 'Pengurus Pusat Teknologi Maklumat', 'HR Department', 'HR Manager', '2024-12-01 04:35:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(42, 'Fire Suppression System', 2, 'Fire suppression system for data center', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Facilities Manager', '2024-12-01 04:40:00', '2024-12-05 07:04:40', 1, 'Services', 'Draft'),
(43, 'Employee Workstations', 60, 'PCs for staff working in the office', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Admin Assistant', '2024-12-01 04:45:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(44, 'Remote Working Setup', 40, 'Laptops and VPN access for remote workers', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'HR Manager', '2024-12-01 04:50:00', '2024-12-05 07:04:40', 1, 'Hardware', 'Draft'),
(45, 'Employee Work Uniforms', 200, 'Standard work uniforms for employees', 'Pengurus Pusat Teknologi Maklumat', 'HR Department', 'HR Manager', '2024-12-01 04:55:00', '2024-12-05 07:04:40', 1, 'Premise', 'Draft'),
(46, 'Visitor Management System', 1, 'System to track visitors to the office', 'Pengurus Pusat Teknologi Maklumat', 'Facilities Department', 'Security Officer', '2024-12-01 05:00:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(47, 'Emergency Exit Signs', 20, 'Signs indicating emergency exit routes', 'Pengurus Pusat Teknologi Maklumat', 'Office Premises', 'Facilities Manager', '2024-12-01 05:05:00', '2024-12-05 07:04:40', 1, 'Premise', 'Draft'),
(48, 'Access Control System', 1, 'System to manage access to restricted areas', 'Pengurus Pusat Teknologi Maklumat', 'Pusat Data Bangi', 'Security Officer', '2024-12-01 05:10:00', '2024-12-05 07:04:40', 1, 'Services', 'Draft'),
(49, 'Document Management System', 1, 'System for managing company documents', 'Pengurus Pusat Teknologi Maklumat', 'Pusat IT', 'Admin Assistant', '2024-12-01 05:15:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(50, 'Customer Service Software', 1, 'Software to manage customer interactions', 'Pengurus Pusat Teknologi Maklumat', 'Customer Service Department', 'Customer Service Manager', '2024-12-01 05:20:00', '2024-12-05 07:04:40', 1, 'Software', 'Draft'),
(51, 'Company Car Fleet', 5, 'Company vehicles for employee use', 'Pengurus Pusat Teknologi Maklumat', 'Facilities Department', 'Facilities Manager', '2024-12-01 05:25:00', '2024-12-05 07:04:40', 1, 'Premise', 'Draft'),
(52, 'Employee Wellness Program', 1, 'Program to support employee health and wellbeing', 'Pengurus Pusat Teknologi Maklumat', 'HR Department', 'HR Manager', '2024-12-01 05:30:00', '2024-12-05 07:04:40', 1, 'Work Process', 'Draft');

-- --------------------------------------------------------

--
-- Table structure for table `asset_protection`
--

CREATE TABLE `asset_protection` (
  `id` bigint(20) NOT NULL,
  `protection_strategy` varchar(255) NOT NULL,
  `decision` enum('Accept','Reduce','Transfer','Avoid') DEFAULT NULL,
  `threat_id` bigint(20) NOT NULL,
  `protection_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_protection`
--

INSERT INTO `asset_protection` (`id`, `protection_strategy`, `decision`, `threat_id`, `protection_id`) VALUES
(1, 'S2 People Controls', 'Accept', 6, 'S2.3 Information security awareness, education and training'),
(3, 'S1 Organizational Controls', 'Accept', 21, 'S1.3 Segregation of duties'),
(4, 'S3 Technical Controls', 'Transfer', 22, 'S3.1 Network intrusion detection systems'),
(5, 'S2 People Controls', 'Avoid', 23, 'S2.2 Personnel background checks'),
(6, 'S3 Technical Controls', 'Reduce', 24, 'S3.1 Encryption of data at rest and in transit'),
(7, 'S3 Technical Controls', 'Transfer', 25, 'S3.2 Firewall and VPN configurations'),
(8, 'S3 Technical Controls', 'Avoid', 26, 'S3.2 Regular vulnerability scans and patch management'),
(9, 'S3 Technical Controls', 'Reduce', 27, 'S3.1 Secure application development practices'),
(10, 'S2 People Controls', 'Transfer', 28, 'S2.3 Security access management'),
(11, 'S3 Technical Controls', 'Accept', 29, 'S3.1 Secure backup and recovery procedures'),
(12, 'S3 Technical Controls', 'Reduce', 30, 'S3.3 Network monitoring and analysis'),
(13, 'S3 Technical Controls', 'Transfer', 31, 'S3.1 Use of secure APIs'),
(14, 'S2 People Controls', 'Accept', 32, 'S2.2 Role-based access control and least privilege'),
(15, 'S3 Technical Controls', 'Avoid', 33, 'S3.2 Authentication token management'),
(16, 'S3 Technical Controls', 'Reduce', 34, 'S3.1 Periodic security audits and assessments'),
(17, 'S1 Organizational Controls', 'Transfer', 35, 'S1.2 Disaster recovery and business continuity planning'),
(18, 'S3 Technical Controls', 'Reduce', 36, 'S3.3 Data encryption and protection'),
(19, 'S2 People Controls', 'Avoid', 37, 'S2.2 Training on secure use of company resources'),
(20, 'S3 Technical Controls', 'Transfer', 38, 'S3.1 Secure communication channels'),
(21, 'S3 Technical Controls', 'Reduce', 39, 'S3.3 Threat intelligence sharing'),
(22, 'S2 People Controls', 'Transfer', 40, 'S2.1 Incident response and management'),
(23, 'S3 Technical Controls', 'Avoid', 41, 'S3.2 Identity and access management (IAM)'),
(24, 'S1 Organizational Controls', 'Reduce', 42, 'S1.1 IT security policy enforcement'),
(25, 'S3 Technical Controls', 'Transfer', 43, 'S3.1 Secure device management'),
(26, 'S2 People Controls', 'Accept', 44, 'S2.3 Secure authentication and authorization'),
(27, 'S3 Technical Controls', 'Reduce', 45, 'S3.1 Patch management system implementation'),
(28, 'S2 People Controls', 'Accept', 46, 'S2.1 Security awareness programs'),
(29, 'S3 Technical Controls', 'Transfer', 47, 'S3.2 Regular penetration testing'),
(30, 'S3 Technical Controls', 'Avoid', 48, 'S3.3 Secure remote access and VPNs'),
(31, 'S2 People Controls', 'Reduce', 49, 'S2.4 Onboarding and offboarding process'),
(32, 'S3 Technical Controls', 'Avoid', 50, 'S3.1 Secure coding practices for developers'),
(33, 'S3 Technical Controls', 'Reduce', 51, 'S3.3 Access control mechanisms'),
(34, 'S1 Organizational Controls', 'Transfer', 52, 'S1.4 IT governance and compliance programs'),
(35, 'S3 Technical Controls', 'Accept', 53, 'S3.1 Implementing data retention policies'),
(36, 'S2 People Controls', 'Transfer', 54, 'S2.2 Employee security training sessions'),
(37, 'S3 Technical Controls', 'Reduce', 55, 'S3.1 Security monitoring tools deployment'),
(38, 'S3 Technical Controls', 'Avoid', 56, 'S3.2 Security patching policy enforcement'),
(39, 'S2 People Controls', 'Accept', 57, 'S2.4 Conducting internal security audits'),
(40, 'S3 Technical Controls', 'Reduce', 58, 'S3.3 Data access restriction'),
(41, 'S3 Technical Controls', 'Avoid', 59, 'S3.1 Automated security threat detection'),
(42, 'S2 People Controls', 'Transfer', 60, 'S2.2 Awareness of phishing and social engineering'),
(43, 'S3 Technical Controls', 'Reduce', 61, 'S3.1 Multi-layered security controls implementation'),
(44, 'S3 Technical Controls', 'Avoid', 62, 'S3.2 Secure email gateways'),
(45, 'S2 People Controls', 'Reduce', 63, 'S2.3 Insider threat detection and prevention'),
(46, 'S3 Technical Controls', 'Accept', 64, 'S3.1 Security event logging and analysis'),
(47, 'S3 Technical Controls', 'Transfer', 65, 'S3.3 Cloud security monitoring'),
(48, 'S2 People Controls', 'Accept', 66, 'S2.1 Employee background checks'),
(49, 'S3 Technical Controls', 'Reduce', 67, 'S3.2 Application firewall deployment'),
(50, 'S3 Technical Controls', 'Avoid', 68, 'S3.1 Secure cloud environment configuration'),
(51, 'S3 Technical Controls', 'Transfer', 69, 'S3.3 Real-time data protection monitoring'),
(52, 'S2 People Controls', 'Accept', 70, 'S2.4 Security-related communication protocols'),
(53, 'S3 Technical Controls', 'Reduce', 71, 'S3.1 Secure network architecture design'),
(54, 'S3 Technical Controls', 'Transfer', 72, 'S3.2 Cloud security compliance management'),
(55, 'S2 People Controls', 'Avoid', 73, 'S2.1 Use of strong passwords and key management'),
(56, 'S3 Technical Controls', 'Reduce', 74, 'S3.1 Regular security audits and vulnerability assessments'),
(57, 'S3 Technical Controls', 'Accept', 75, 'S3.2 Use of encryption for sensitive data'),
(58, 'S2 People Controls', 'Transfer', 76, 'S2.3 Educating employees about insider threats'),
(59, 'S3 Technical Controls', 'Reduce', 77, 'S3.1 Implementing endpoint protection solutions'),
(60, 'S3 Technical Controls', 'Avoid', 78, 'S3.3 Secure deployment of software packages'),
(61, 'S2 People Controls', 'Reduce', 79, 'S2.1 Ongoing training on security best practices'),
(62, 'S3 Technical Controls', 'Accept', 80, 'S3.2 Security review of third-party services'),
(63, 'S3 Technical Controls', 'Reduce', 81, 'S3.3 Preventing unauthorized access to source code'),
(64, 'S2 People Controls', 'Transfer', 82, 'S2.4 Vendor security assessments'),
(65, 'S3 Technical Controls', 'Avoid', 83, 'S3.1 Secure access control for sensitive applications'),
(66, 'S3 Technical Controls', 'Reduce', 84, 'S3.3 Regular penetration testing and risk assessments'),
(67, 'S2 People Controls', 'Accept', 85, 'S2.1 Security training on safe device usage'),
(68, 'S3 Technical Controls', 'Transfer', 86, 'S3.2 Multi-factor authentication deployment'),
(69, 'S3 Technical Controls', 'Reduce', 87, 'S3.1 Vulnerability scanning tools and policies'),
(70, 'S2 People Controls', 'Avoid', 88, 'S2.3 Security of sensitive data when working remotely'),
(71, 'S3 Technical Controls', 'Accept', 89, 'S3.1 Continuous monitoring of system logs and events'),
(72, 'S3 Technical Controls', 'Transfer', 90, 'S3.2 Secure remote work guidelines'),
(73, 'S2 People Controls', 'Avoid', 91, 'S2.1 Educating employees on email security'),
(74, 'S3 Technical Controls', 'Reduce', 92, 'S3.3 Secure application deployment lifecycle'),
(75, 'S3 Technical Controls', 'Accept', 93, 'S3.1 Secure system and application configuration'),
(76, 'S2 People Controls', 'Reduce', 94, 'S2.2 Social engineering attack training'),
(77, 'S3 Technical Controls', 'Transfer', 95, 'S3.3 Secure cloud service management'),
(78, 'S3 Technical Controls', 'Avoid', 96, 'S3.1 Secure communications protocol for data transfers'),
(79, 'S3 Technical Controls', 'Reduce', 97, 'S3.2 Regular patch management for operating systems'),
(80, 'S2 People Controls', 'Accept', 98, 'S2.3 Access control policies and procedures'),
(81, 'S3 Technical Controls', 'Transfer', 99, 'S3.1 Data loss prevention (DLP) systems'),
(82, 'S3 Technical Controls', 'Reduce', 100, 'S3.1 Secure deployment pipeline for software applications'),
(83, 'S2 People Controls', 'Avoid', 101, 'S2.2 Training on secure coding and development practices'),
(84, 'S3 Technical Controls', 'Transfer', 102, 'S3.3 Secure endpoint detection and response systems'),
(85, 'S3 Technical Controls', 'Reduce', 103, 'S3.2 Implementing a zero-trust network model'),
(86, 'S2 People Controls', 'Accept', 104, 'S2.3 Role-based access control training and implementation'),
(87, 'S3 Technical Controls', 'Avoid', 105, 'S3.1 End-to-end encryption for sensitive communications'),
(88, 'S3 Technical Controls', 'Reduce', 106, 'S3.1 Regular security audits and vulnerability testing'),
(89, 'S2 People Controls', 'Transfer', 107, 'S2.4 Continuous security awareness programs'),
(90, 'S3 Technical Controls', 'Avoid', 108, 'S3.2 Robust security measures for cloud environments'),
(91, 'S3 Technical Controls', 'Reduce', 109, 'S3.3 Frequent software and hardware security updates'),
(92, 'S2 People Controls', 'Accept', 110, 'S2.1 Awareness on phishing prevention and threat identification'),
(93, 'S3 Technical Controls', 'Transfer', 111, 'S3.1 Secure configuration of cloud infrastructure'),
(94, 'S3 Technical Controls', 'Reduce', 112, 'S3.2 Automated vulnerability scanning and remediation'),
(95, 'S2 People Controls', 'Avoid', 113, 'S2.3 Insider threat detection and mitigation training'),
(96, 'S3 Technical Controls', 'Accept', 114, 'S3.1 Multi-factor authentication implementation across all platforms'),
(97, 'S2 People Controls', 'Transfer', 115, 'S2.1 Periodic review of employee access rights'),
(98, 'S3 Technical Controls', 'Reduce', 116, 'S3.2 Strengthening password policies and enforcement'),
(99, 'S3 Technical Controls', 'Avoid', 117, 'S3.3 Secure application lifecycle management and testing'),
(100, 'S2 People Controls', 'Accept', 118, 'S2.4 Conducting regular security workshops for employees'),
(101, 'S3 Technical Controls', 'Reduce', 119, 'S3.1 Continuous network monitoring for anomalous activity'),
(102, 'S3 Technical Controls', 'Transfer', 120, 'S3.2 Backup and disaster recovery planning'),
(103, 'S2 People Controls', 'Avoid', 121, 'S2.1 Regular employee training on data protection laws and regulations');

-- --------------------------------------------------------

--
-- Table structure for table `asset_rmsd`
--

CREATE TABLE `asset_rmsd` (
  `id` bigint(20) NOT NULL,
  `risk_level` varchar(255) DEFAULT NULL,
  `risk_owner` varchar(255) DEFAULT NULL,
  `business_loss` enum('Low','Medium','High') DEFAULT NULL,
  `impact_level` enum('Low','Medium','High') DEFAULT NULL,
  `vuln_group` varchar(255) DEFAULT NULL,
  `vuln_name` varchar(255) DEFAULT NULL,
  `likelihood` enum('Low','Medium','High') DEFAULT NULL,
  `threat_id` bigint(20) NOT NULL,
  `safeguard_id` varchar(255) DEFAULT NULL,
  `safeguard_group` varchar(255) DEFAULT NULL,
  `scale_5` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`scale_5`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_rmsd`
--

INSERT INTO `asset_rmsd` (`id`, `risk_level`, `risk_owner`, `business_loss`, `impact_level`, `vuln_group`, `vuln_name`, `likelihood`, `threat_id`, `safeguard_id`, `safeguard_group`, `scale_5`) VALUES
(3, 'High', 'P BPM', 'Low', 'Medium', 'V1 Hardware', 'V1.1 Insufficient maintenance/faulty installation of storage media', 'High', 6, 'S2.2 Terms and conditions of employment', 'S2 People Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"Very High\"}'),
(5, 'High', 'PTM', 'High', 'High', 'V3 Network', 'V3.2 Unprotected sensitive traffic', 'High', 21, 'S2.2 Terms and conditions of employment', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Very High\",\"risk_level\":\"High\"}'),
(24, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V1 Hardware', 'V1.6 Power outage', 'Medium', 24, 'S2.3 Staff training on power management', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(25, 'High', 'IT Security Manager', 'High', 'High', 'V2 Software', 'V2.1 Software bugs leading to downtime', 'High', 25, 'S3.1 Software quality assurance practices', 'S3 Technical Controls', '{\"business_loss\":\"High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(26, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V3 Network', 'V3.2 Loss of data due to hardware failure', 'Medium', 26, 'S3.3 Regular data backups', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(27, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V4 Application', 'V4.4 Application downtime due to poor optimization', 'Low', 27, 'S2.4 Application performance monitoring', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(28, 'High', 'IT Operations', 'High', 'High', 'V1 Hardware', 'V1.7 Equipment malfunction', 'High', 28, 'S3.2 Fault-tolerant hardware solutions', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(29, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V2 Software', 'V2.6 Loss of software functionality', 'Low', 29, 'S2.3 End-user software training', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(30, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V3 Network', 'V3.7 Unauthorized access due to weak passwords', 'Medium', 30, 'S3.1 Strong authentication policies', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(31, 'High', 'IT Security Manager', 'High', 'High', 'V4 Application', 'V4.5 Insufficient patch management', 'High', 31, 'S3.2 Patch management tools', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(32, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V1 Hardware', 'V1.8 Natural disasters (e.g., flood)', 'Low', 32, 'S2.3 Physical security measures', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(33, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V2 Software', 'V2.7 Insufficient user training', 'Medium', 33, 'S2.4 User training programs', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(34, 'High', 'IT Security Manager', 'High', 'High', 'V3 Network', 'V3.8 Data interception due to unencrypted transmission', 'High', 34, 'S3.3 Encryption standards for data in transit', 'S3 Technical Controls', '{\"business_loss\":\"High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(35, 'Medium', 'Business Unit Manager', 'Medium', 'Medium', 'V1 Hardware', 'V1.9 Loss of system redundancy', 'Medium', 35, 'S2.4 Redundancy in critical systems', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(36, 'Low', 'IT Operations', 'Low', 'Low', 'V2 Software', 'V2.8 Software version mismatch', 'Low', 36, 'S3.2 Version control policies', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(37, 'High', 'IT Security Manager', 'High', 'High', 'V3 Network', 'V3.9 Denial of service attack', 'High', 37, 'S3.1 Firewall and traffic filtering', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(38, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V4 Application', 'V4.6 Application vulnerability exploitation', 'Medium', 38, 'S3.1 Secure coding practices', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(39, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V1 Hardware', 'V1.10 Insufficient physical security for devices', 'Low', 39, 'S2.3 Secure device storage protocols', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(40, 'High', 'IT Operations', 'High', 'High', 'V2 Software', 'V2.9 Misconfiguration of security settings', 'High', 40, 'S3.1 Regular security audits', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(41, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V3 Network', 'V3.10 Inadequate segmentation of network', 'Medium', 41, 'S3.3 Network segmentation policies', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(42, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V1 Hardware', 'V1.11 Power surge', 'Low', 42, 'S2.4 Surge protection systems', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(43, 'High', 'IT Security Manager', 'High', 'High', 'V2 Software', 'V2.10 SQL Injection Attack', 'High', 43, 'S3.2 SQL injection prevention mechanisms', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(44, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V3 Network', 'V3.11 Routing table manipulation', 'Medium', 44, 'S3.1 Network configuration management', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(45, 'High', 'Business Unit Manager', 'High', 'High', 'V1 Hardware', 'V1.12 Equipment aging and failure', 'High', 45, 'S2.2 Regular equipment maintenance schedules', 'S2 People Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(46, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.11 Insufficient access controls', 'Medium', 46, 'S3.3 Role-based access control policies', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(47, 'Low', 'IT Operations', 'Low', 'Low', 'V3 Network', 'V3.12 Unpatched vulnerabilities', 'Low', 47, 'S3.1 Timely patch management', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(48, 'High', 'IT Security Manager', 'High', 'High', 'V4 Application', 'V4.12 Application misconfigurations', 'High', 48, 'S3.2 Configuration management tools', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(49, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V5 Cloud Services', 'V5.1 Cloud service provider outage', 'Low', 49, 'S2.3 Multi-region cloud architecture', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(50, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V1 Hardware', 'V1.13 Inadequate air conditioning for hardware', 'Medium', 50, 'S3.1 Regular hardware environment checks', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(51, 'High', 'IT Operations', 'High', 'High', 'V2 Software', 'V2.12 Buffer overflow vulnerability', 'High', 51, 'S3.2 Secure coding practices', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(52, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V3 Network', 'V3.13 DDoS attack', 'Medium', 52, 'S3.3 Anti-DDoS solutions', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(53, 'High', 'IT Security Manager', 'High', 'High', 'V4 Application', 'V4.13 Zero-day vulnerability', 'High', 53, 'S3.1 Threat intelligence feeds', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(54, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V1 Hardware', 'V1.14 Insufficient UPS capacity', 'Low', 54, 'S2.2 Regular UPS testing', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(55, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.13 Cross-site scripting (XSS)', 'Medium', 55, 'S3.2 Input validation mechanisms', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(56, 'High', 'IT Security Manager', 'High', 'High', 'V3 Network', 'V3.14 Rogue device on network', 'High', 56, 'S3.1 Network access control solutions', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(57, 'Low', 'IT Operations', 'Low', 'Low', 'V1 Hardware', 'V1.15 Lack of spare parts for critical components', 'Low', 57, 'S2.3 Spare part inventory management', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(58, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.14 Weak encryption protocols', 'Medium', 58, 'S3.3 Strong encryption standards', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(59, 'High', 'IT Security Manager', 'High', 'High', 'V4 Application', 'V4.14 Insecure API endpoints', 'High', 59, 'S3.1 Secure API design and implementation', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(60, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V5 Cloud Services', 'V5.2 Vendor lock-in', 'Low', 60, 'S2.4 Diversified vendor strategy', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(61, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V1 Hardware', 'V1.16 Insufficient backup power for network devices', 'Medium', 61, 'S2.2 Backup power systems for critical devices', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(62, 'High', 'IT Security Manager', 'High', 'High', 'V2 Software', 'V2.15 Unauthorized software installation', 'High', 62, 'S3.1 Application whitelisting', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(63, 'Low', 'IT Operations', 'Low', 'Low', 'V3 Network', 'V3.15 Insufficient firewall configuration', 'Low', 63, 'S3.1 Comprehensive firewall configuration', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(64, 'Medium', 'Business Unit Manager', 'Medium', 'Medium', 'V4 Application', 'V4.15 Inadequate user input validation', 'Medium', 64, 'S3.2 Input sanitization frameworks', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(65, 'High', 'IT Operations', 'High', 'High', 'V1 Hardware', 'V1.17 Uncontrolled access to server rooms', 'High', 65, 'S2.3 Physical access control mechanisms', 'S2 People Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(66, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.16 Insufficient patching of legacy systems', 'Medium', 66, 'S3.2 Legacy system patching programs', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(67, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V5 Cloud Services', 'V5.3 Cloud data loss due to misconfiguration', 'Low', 67, 'S3.3 Cloud configuration management tools', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(68, 'High', 'IT Security Manager', 'High', 'High', 'V1 Hardware', 'V1.18 Inadequate disaster recovery planning', 'High', 68, 'S2.4 Regular disaster recovery exercises', 'S2 People Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(69, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.17 Security vulnerabilities due to insufficient auditing', 'Medium', 69, 'S3.1 Regular security audits and reviews', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(70, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V3 Network', 'V3.16 Insufficient VPN configurations for remote workers', 'Low', 70, 'S3.1 Proper VPN and remote access policies', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(71, 'High', 'IT Operations', 'High', 'High', 'V4 Application', 'V4.16 SQL injection attack', 'High', 71, 'S3.2 Input validation and parameterized queries', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(72, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V1 Hardware', 'V1.19 Physical damage to servers from environmental hazards', 'Medium', 72, 'S2.2 Environmental hazard monitoring systems', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(73, 'Low', 'IT Security Manager', 'Low', 'Low', 'V5 Cloud Services', 'V5.4 Data leakage due to cloud service mismanagement', 'Low', 73, 'S3.3 Data leakage prevention controls', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(74, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V2 Software', 'V2.18 Inadequate logging of security events', 'Medium', 74, 'S3.1 Centralized logging and monitoring', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(75, 'High', 'Business Unit Manager', 'High', 'High', 'V3 Network', 'V3.17 Insufficient IDS/IPS coverage', 'High', 75, 'S3.2 Intrusion detection and prevention systems', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(76, 'Low', 'IT Security Manager', 'Low', 'Low', 'V1 Hardware', 'V1.20 Physical theft of hardware', 'Low', 76, 'S2.3 Device encryption and secure storage', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(77, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.19 Lack of multi-factor authentication', 'Medium', 77, 'S3.1 Multi-factor authentication deployment', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(78, 'High', 'IT Security Manager', 'High', 'High', 'V4 Application', 'V4.17 Cross-Site Request Forgery (CSRF)', 'High', 78, 'S3.2 CSRF prevention mechanisms', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(79, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V3 Network', 'V3.18 Insufficient network segmentation', 'Medium', 79, 'S3.3 Network segmentation and isolation', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(80, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V1 Hardware', 'V1.21 Inadequate cable management leading to accidental unplugging', 'Low', 80, 'S2.2 Proper cable management and labeling', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(81, 'High', 'IT Security Manager', 'High', 'High', 'V2 Software', 'V2.20 Insecure third-party libraries', 'High', 81, 'S3.1 Third-party software vetting and scanning', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(82, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V5 Cloud Services', 'V5.5 Cloud service provider security flaws', 'Medium', 82, 'S3.2 Cloud security posture management', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(83, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V3 Network', 'V3.19 Misconfigured network access points', 'Low', 83, 'S3.1 Proper network access point configuration', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(84, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V4 Application', 'V4.18 Broken authentication mechanisms', 'Medium', 84, 'S3.1 Strong authentication protocols', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(85, 'High', 'IT Operations', 'High', 'High', 'V2 Software', 'V2.21 Insufficient data validation', 'High', 85, 'S3.3 Data validation frameworks', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(86, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V1 Hardware', 'V1.22 Lack of physical protection for network devices', 'Low', 86, 'S2.3 Secure racks and physical barriers for devices', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(87, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V3 Network', 'V3.20 Mismanagement of IP addresses', 'Medium', 87, 'S3.1 IP address management policies', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(88, 'High', 'Business Unit Manager', 'High', 'High', 'V4 Application', 'V4.19 Insufficient input sanitization', 'High', 88, 'S3.2 Input validation and sanitization routines', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(89, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V5 Cloud Services', 'V5.6 Insufficient cloud monitoring', 'Medium', 89, 'S3.1 Cloud monitoring tools and alerts', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(90, 'Low', 'IT Operations', 'Low', 'Low', 'V1 Hardware', 'V1.23 Power loss due to external sources', 'Low', 90, 'S2.2 Power protection and surge protection systems', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(91, 'High', 'IT Security Manager', 'High', 'High', 'V3 Network', 'V3.21 Lack of network monitoring', 'High', 91, 'S3.3 Network traffic analysis and monitoring', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(92, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V4 Application', 'V4.20 Insufficient logging for application events', 'Medium', 92, 'S3.1 Comprehensive logging mechanisms', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(93, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V5 Cloud Services', 'V5.7 Insecure cloud-based backups', 'Low', 93, 'S3.2 Secure cloud backup solutions', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(94, 'High', 'IT Operations', 'High', 'High', 'V1 Hardware', 'V1.24 Lack of hardware redundancy', 'High', 94, 'S2.4 Redundant hardware infrastructure', 'S2 People Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(95, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.22 Software vulnerability exploitation', 'Medium', 95, 'S3.1 Vulnerability scanning tools', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(96, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V3 Network', 'V3.22 Misconfigured network traffic filters', 'Low', 96, 'S3.2 Proper traffic filtering and firewalls', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(97, 'High', 'IT Security Manager', 'High', 'High', 'V4 Application', 'V4.21 Insufficient security testing', 'High', 97, 'S3.3 Regular security testing and penetration testing', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(98, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V5 Cloud Services', 'V5.8 Insufficient data encryption for cloud storage', 'Medium', 98, 'S3.1 Data encryption at rest and in transit', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(99, 'Low', 'IT Security Manager', 'Low', 'Low', 'V1 Hardware', 'V1.25 Improper disposal of hardware', 'Low', 99, 'S2.4 Secure hardware disposal procedures', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(100, 'High', 'Business Unit Manager', 'High', 'High', 'V2 Software', 'V2.23 Insufficient software patching', 'High', 100, 'S3.1 Regular patch management processes', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(101, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V3 Network', 'V3.23 Misconfigured load balancers', 'Medium', 101, 'S3.2 Proper configuration of load balancing systems', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(102, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V4 Application', 'V4.22 Insufficient access control for application', 'Low', 102, 'S3.3 Role-based access control implementation', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(103, 'High', 'IT Operations', 'High', 'High', 'V5 Cloud Services', 'V5.9 Insecure cloud access controls', 'High', 103, 'S3.1 Identity and access management (IAM) policies', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(104, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V1 Hardware', 'V1.26 Inadequate server ventilation leading to overheating', 'Medium', 104, 'S2.2 Proper cooling and ventilation systems', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(105, 'Low', 'IT Operations', 'Low', 'Low', 'V2 Software', 'V2.24 Lack of code obfuscation', 'Low', 105, 'S3.2 Code obfuscation and hardening techniques', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(106, 'High', 'Business Unit Manager', 'High', 'High', 'V3 Network', 'V3.24 Network sniffing due to lack of encryption', 'High', 106, 'S3.3 Full network encryption protocols', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(107, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V4 Application', 'V4.23 Insecure default configurations', 'Medium', 107, 'S3.1 Secure default configurations and hardening guidelines', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(108, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V5 Cloud Services', 'V5.10 Inadequate cloud provider security audits', 'Low', 108, 'S3.2 Regular third-party security audits for cloud services', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(109, 'High', 'IT Operations', 'High', 'High', 'V1 Hardware', 'V1.27 Unmanaged physical access to server rooms', 'High', 109, 'S2.4 Restrict physical access and implement monitoring', 'S2 People Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(110, 'Medium', 'IT Security Manager', 'Medium', 'Medium', 'V2 Software', 'V2.25 Inadequate error handling', 'Medium', 110, 'S3.2 Comprehensive error handling and logging', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(111, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V3 Network', 'V3.25 Failure to monitor network devices', 'Low', 111, 'S3.1 Regular network monitoring and alert systems', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(112, 'High', 'IT Security Manager', 'High', 'High', 'V4 Application', 'V4.24 SQL injection vulnerability', 'High', 112, 'S3.1 Use of parameterized queries and prepared statements', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(113, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V5 Cloud Services', 'V5.11 Lack of multi-cloud strategy', 'Medium', 113, 'S3.3 Multi-cloud architecture for resilience', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(114, 'Low', 'IT Security Manager', 'Low', 'Low', 'V1 Hardware', 'V1.28 Outdated hardware components', 'Low', 114, 'S2.2 Regular hardware lifecycle management', 'S2 People Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(115, 'High', 'IT Security Manager', 'High', 'High', 'V2 Software', 'V2.26 Inadequate handling of privileged access', 'High', 115, 'S3.1 Privilege access management (PAM) tools', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(116, 'Medium', 'Business Unit Manager', 'Medium', 'Medium', 'V3 Network', 'V3.26 Lack of network redundancy', 'Medium', 116, 'S3.2 Network redundancy and failover mechanisms', 'S3 Technical Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(117, 'Low', 'IT Operations', 'Low', 'Low', 'V4 Application', 'V4.25 Unnecessary open ports on servers', 'Low', 117, 'S3.1 Server port management and hardening', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(118, 'High', 'IT Security Manager', 'High', 'High', 'V5 Cloud Services', 'V5.12 Insufficient cloud access controls', 'High', 118, 'S3.1 Identity and access management (IAM) for cloud services', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}'),
(119, 'Medium', 'IT Operations', 'Medium', 'Medium', 'V1 Hardware', 'V1.29 Lack of redundancy in power supply systems', 'Medium', 119, 'S2.4 Redundant power supplies and backup generators', 'S2 People Controls', '{\"business_loss\":\"Medium\",\"impact_level\":\"Medium\",\"likelihood\":\"Medium\",\"risk_level\":\"Medium\"}'),
(120, 'Low', 'Business Unit Manager', 'Low', 'Low', 'V2 Software', 'V2.27 Insufficient session management', 'Low', 120, 'S3.1 Session expiration and timeout controls', 'S3 Technical Controls', '{\"business_loss\":\"Low\",\"impact_level\":\"Low\",\"likelihood\":\"Low\",\"risk_level\":\"Low\"}'),
(121, 'High', 'IT Security Manager', 'High', 'High', 'V3 Network', 'V3.27 DNS spoofing attack', 'High', 121, 'S3.3 DNS security measures and protections', 'S3 Technical Controls', '{\"business_loss\":\"Very High\",\"impact_level\":\"Very High\",\"likelihood\":\"High\",\"risk_level\":\"High\"}');

-- --------------------------------------------------------

--
-- Table structure for table `asset_threat`
--

CREATE TABLE `asset_threat` (
  `id` bigint(20) NOT NULL,
  `asset_id` bigint(20) DEFAULT NULL,
  `threat_group` varchar(255) DEFAULT NULL,
  `threat_name` varchar(255) DEFAULT NULL,
  `status` enum('Completed','Draft') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_threat`
--

INSERT INTO `asset_threat` (`id`, `asset_id`, `threat_group`, `threat_name`, `status`) VALUES
(6, 1, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Completed'),
(10, 4, 'T5 Human Actions', 'T5.6 Theft of media or documents', 'Draft'),
(11, 4, 'T6 Organizational Threats', 'T6.2 Lack of resources', 'Draft'),
(12, 3, 'T3 Infrastructure Failures', 'T3.3 Loss of power supply', 'Draft'),
(13, 3, 'T4 Technical Failures', 'T4.1 Saturation of the information system', 'Draft'),
(14, 8, 'T1 Physical Threats', 'T1.4 Major accident', 'Draft'),
(15, 8, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Draft'),
(21, 1, 'T3 Infrastructure Failures', 'T3.3 Loss of power supply', 'Completed'),
(22, 3, 'T3 Infrastructure Failures', 'T3.3 Loss of power supply', 'Completed'),
(23, 3, 'T4 Technical Failures', 'T4.1 Saturation of the information system', 'Completed'),
(24, 4, 'T5 Human Actions', 'T5.6 Theft of media or documents', 'Completed'),
(25, 4, 'T6 Organizational Threats', 'T6.2 Lack of resources', 'Completed'),
(26, 5, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Completed'),
(27, 5, 'T4 Technical Failures', 'T4.2 Network overload', 'Completed'),
(28, 6, 'T1 Physical Threats', 'T1.4 Major accident', 'Completed'),
(29, 6, 'T3 Infrastructure Failures', 'T3.5 Equipment malfunction', 'Completed'),
(30, 7, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Completed'),
(31, 7, 'T4 Technical Failures', 'T4.3 Data leak due to security gap', 'Completed'),
(32, 8, 'T3 Infrastructure Failures', 'T3.2 Loss of power supply', 'Completed'),
(33, 8, 'T5 Human Actions', 'T5.1 Insider threat', 'Completed'),
(34, 9, 'T2 Systemic Failures', 'T2.2 Data corruption or loss', 'Completed'),
(35, 9, 'T4 Technical Failures', 'T4.1 Software bugs leading to downtime', 'Completed'),
(36, 10, 'T5 Human Actions', 'T5.3 Unauthorized access', 'Completed'),
(37, 10, 'T3 Infrastructure Failures', 'T3.2 Power surge', 'Completed'),
(38, 11, 'T2 Systemic Failures', 'T2.1 Hardware failure', 'Completed'),
(39, 11, 'T5 Human Actions', 'T5.4 Social engineering attack', 'Completed'),
(40, 12, 'T1 Physical Threats', 'T1.2 Fire hazard', 'Completed'),
(41, 12, 'T6 Organizational Threats', 'T6.1 Insufficient training', 'Completed'),
(42, 13, 'T3 Infrastructure Failures', 'T3.4 Critical system failure', 'Completed'),
(43, 13, 'T5 Human Actions', 'T5.2 Phishing attack', 'Completed'),
(44, 14, 'T2 Systemic Failures', 'T2.3 Application downtime', 'Completed'),
(45, 14, 'T4 Technical Failures', 'T4.4 Data encryption failure', 'Completed'),
(46, 15, 'T5 Human Actions', 'T5.5 Employee negligence', 'Completed'),
(47, 15, 'T3 Infrastructure Failures', 'T3.3 Loss of power supply', 'Completed'),
(48, 16, 'T4 Technical Failures', 'T4.5 Software update failure', 'Completed'),
(49, 16, 'T1 Physical Threats', 'T1.1 Earthquake', 'Completed'),
(50, 17, 'T3 Infrastructure Failures', 'T3.5 Equipment malfunction', 'Completed'),
(51, 17, 'T4 Technical Failures', 'T4.2 Network overload', 'Completed'),
(52, 18, 'T1 Physical Threats', 'T1.3 Vandalism or sabotage', 'Completed'),
(53, 18, 'T3 Infrastructure Failures', 'T3.6 Loss of communication', 'Completed'),
(54, 19, 'T5 Human Actions', 'T5.7 Data theft by insider', 'Completed'),
(55, 19, 'T4 Technical Failures', 'T4.1 Software bugs leading to downtime', 'Completed'),
(56, 20, 'T3 Infrastructure Failures', 'T3.2 Loss of power supply', 'Completed'),
(57, 20, 'T1 Physical Threats', 'T1.2 Fire hazard', 'Completed'),
(58, 21, 'T2 Systemic Failures', 'T2.4 Systematic failure due to lack of backups', 'Completed'),
(59, 21, 'T5 Human Actions', 'T5.3 Unauthorized access', 'Completed'),
(60, 22, 'T4 Technical Failures', 'T4.4 Data corruption', 'Completed'),
(61, 22, 'T1 Physical Threats', 'T1.1 Earthquake', 'Completed'),
(62, 23, 'T5 Human Actions', 'T5.2 Phishing attack', 'Completed'),
(63, 23, 'T3 Infrastructure Failures', 'T3.3 Power outage', 'Completed'),
(64, 24, 'T2 Systemic Failures', 'T2.1 Hardware failure', 'Completed'),
(65, 24, 'T3 Infrastructure Failures', 'T3.2 Power surge', 'Completed'),
(66, 25, 'T1 Physical Threats', 'T1.3 Vandalism or sabotage', 'Completed'),
(67, 25, 'T5 Human Actions', 'T5.6 Theft of media or documents', 'Completed'),
(68, 26, 'T4 Technical Failures', 'T4.5 Data leak due to outdated software', 'Completed'),
(69, 26, 'T3 Infrastructure Failures', 'T3.4 Critical system failure', 'Completed'),
(70, 27, 'T6 Organizational Threats', 'T6.3 Lack of resources for critical systems', 'Completed'),
(71, 27, 'T1 Physical Threats', 'T1.4 Major accident', 'Completed'),
(72, 28, 'T4 Technical Failures', 'T4.2 Network overload', 'Completed'),
(73, 28, 'T5 Human Actions', 'T5.1 Insider threat', 'Completed'),
(74, 29, 'T3 Infrastructure Failures', 'T3.5 Equipment malfunction', 'Completed'),
(75, 29, 'T1 Physical Threats', 'T1.2 Fire hazard', 'Completed'),
(76, 30, 'T5 Human Actions', 'T5.7 Data theft by insider', 'Completed'),
(77, 30, 'T6 Organizational Threats', 'T6.4 Insufficient management support', 'Completed'),
(78, 31, 'T1 Physical Threats', 'T1.1 Earthquake', 'Completed'),
(79, 31, 'T2 Systemic Failures', 'T2.2 Data corruption or loss', 'Completed'),
(80, 32, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Completed'),
(81, 32, 'T4 Technical Failures', 'T4.1 Saturation of the information system', 'Completed'),
(82, 33, 'T5 Human Actions', 'T5.5 Employee negligence', 'Completed'),
(83, 33, 'T3 Infrastructure Failures', 'T3.2 Loss of power supply', 'Completed'),
(84, 34, 'T2 Systemic Failures', 'T2.3 Application downtime', 'Completed'),
(85, 34, 'T1 Physical Threats', 'T1.4 Major accident', 'Completed'),
(86, 35, 'T3 Infrastructure Failures', 'T3.3 Loss of power supply', 'Completed'),
(87, 35, 'T5 Human Actions', 'T5.2 Phishing attack', 'Completed'),
(88, 36, 'T4 Technical Failures', 'T4.5 Data leak due to outdated software', 'Completed'),
(89, 36, 'T3 Infrastructure Failures', 'T3.6 Loss of communication', 'Completed'),
(90, 37, 'T1 Physical Threats', 'T1.2 Fire hazard', 'Completed'),
(91, 37, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Completed'),
(92, 38, 'T3 Infrastructure Failures', 'T3.4 Critical system failure', 'Completed'),
(93, 38, 'T4 Technical Failures', 'T4.3 Data leak due to security gap', 'Completed'),
(94, 39, 'T5 Human Actions', 'T5.4 Social engineering attack', 'Completed'),
(95, 39, 'T6 Organizational Threats', 'T6.2 Lack of resources', 'Completed'),
(96, 40, 'T4 Technical Failures', 'T4.2 Network overload', 'Completed'),
(97, 40, 'T3 Infrastructure Failures', 'T3.2 Power surge', 'Completed'),
(98, 41, 'T1 Physical Threats', 'T1.3 Vandalism or sabotage', 'Completed'),
(99, 41, 'T4 Technical Failures', 'T4.1 Software bugs leading to downtime', 'Completed'),
(100, 42, 'T5 Human Actions', 'T5.1 Insider threat', 'Completed'),
(101, 42, 'T3 Infrastructure Failures', 'T3.3 Loss of power supply', 'Completed'),
(102, 43, 'T2 Systemic Failures', 'T2.4 Systematic failure due to lack of backups', 'Completed'),
(103, 43, 'T4 Technical Failures', 'T4.5 Data leak due to outdated software', 'Completed'),
(104, 44, 'T5 Human Actions', 'T5.6 Theft of media or documents', 'Completed'),
(105, 44, 'T1 Physical Threats', 'T1.1 Earthquake', 'Completed'),
(106, 45, 'T3 Infrastructure Failures', 'T3.5 Equipment malfunction', 'Completed'),
(107, 45, 'T5 Human Actions', 'T5.7 Data theft by insider', 'Completed'),
(108, 46, 'T4 Technical Failures', 'T4.2 Network overload', 'Completed'),
(109, 46, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Completed'),
(110, 47, 'T3 Infrastructure Failures', 'T3.4 Critical system failure', 'Completed'),
(111, 47, 'T5 Human Actions', 'T5.5 Employee negligence', 'Completed'),
(112, 48, 'T2 Systemic Failures', 'T2.2 Data corruption or loss', 'Completed'),
(113, 48, 'T1 Physical Threats', 'T1.2 Fire hazard', 'Completed'),
(114, 49, 'T1 Physical Threats', 'T1.4 Major accident', 'Completed'),
(115, 49, 'T5 Human Actions', 'T5.3 Unauthorized access', 'Completed'),
(116, 50, 'T5 Human Actions', 'T5.1 Insider threat', 'Completed'),
(117, 50, 'T3 Infrastructure Failures', 'T3.3 Loss of power supply', 'Completed'),
(118, 51, 'T4 Technical Failures', 'T4.5 Data leak due to outdated software', 'Completed'),
(119, 51, 'T3 Infrastructure Failures', 'T3.2 Power surge', 'Completed'),
(120, 52, 'T3 Infrastructure Failures', 'T3.1 Failure of a supply system', 'Completed'),
(121, 52, 'T5 Human Actions', 'T5.7 Data theft by insider', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `asset_treatment`
--

CREATE TABLE `asset_treatment` (
  `id` int(11) NOT NULL,
  `threat_id` bigint(20) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `residual_risk` enum('Low','Medium','High') DEFAULT NULL,
  `personnel` varchar(255) DEFAULT NULL,
  `scale_5` enum('Very Low','Low','Medium','High','Very High') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_treatment`
--

INSERT INTO `asset_treatment` (`id`, `threat_id`, `start_date`, `end_date`, `residual_risk`, `personnel`, `scale_5`) VALUES
(1, 6, '2024-11-27', '2024-12-12', 'Medium', 'ADIRA', 'High'),
(3, 21, '2024-12-05', '2024-12-27', 'Low', 'Kumpulan Server dan Data Center', 'Medium'),
(4, 23, '2024-12-06', '2024-12-20', 'High', 'IT Security Team', 'Very High'),
(5, 24, '2024-12-07', '2024-12-21', 'Medium', 'Application Security Team', 'High'),
(6, 25, '2024-12-08', '2024-12-22', 'Medium', 'Data Loss Prevention Team', 'High'),
(7, 26, '2024-12-09', '2024-12-23', 'Low', 'Cloud Security Team', 'Medium'),
(8, 27, '2024-12-10', '2024-12-24', 'Low', 'Network Security Team', 'Medium'),
(9, 28, '2024-12-11', '2024-12-25', 'Medium', 'Database Security Team', 'High'),
(10, 29, '2024-12-12', '2024-12-26', 'Low', 'Security Operations Team', 'Medium'),
(11, 30, '2024-12-13', '2024-12-27', 'High', 'Incident Response Team', 'Very High'),
(12, 31, '2024-12-14', '2024-12-28', 'Medium', 'Access Control Team', 'High'),
(13, 32, '2024-12-15', '2024-12-29', 'Low', 'Disaster Recovery Team', 'Medium'),
(14, 33, '2024-12-16', '2024-12-30', 'Medium', 'Compliance Team', 'High'),
(15, 34, '2024-12-17', '2024-12-31', 'Medium', 'IT Governance Team', 'High'),
(16, 35, '2024-12-18', '2024-12-31', 'High', 'Network Operations Team', 'Very High'),
(17, 36, '2024-12-19', '2024-12-31', 'Low', 'Vulnerability Management Team', 'Medium'),
(18, 37, '2024-12-20', '2024-12-31', 'Medium', 'IT Support Team', 'High'),
(19, 38, '2024-12-21', '2024-12-31', 'High', 'Server Infrastructure Team', 'Very High'),
(20, 39, '2024-12-22', '2024-12-31', 'Low', 'Security Architecture Team', 'Medium'),
(21, 40, '2024-12-23', '2024-12-31', 'Medium', 'Security Monitoring Team', 'High'),
(22, 41, '2024-12-24', '2024-12-31', 'Low', 'Security Compliance Team', 'Medium'),
(23, 42, '2024-12-25', '2024-12-31', 'High', 'Endpoint Security Team', 'Very High'),
(24, 43, '2024-12-26', '2024-12-31', 'Medium', 'Risk Management Team', 'High'),
(25, 44, '2024-12-27', '2024-12-31', 'Low', 'Business Continuity Team', 'Medium'),
(26, 45, '2024-12-28', '2024-12-31', 'High', 'IT Operations Team', 'Very High'),
(27, 46, '2024-12-29', '2024-12-31', 'Medium', 'Security Auditing Team', 'High'),
(28, 47, '2024-12-30', '2024-12-31', 'Low', 'Security Risk Analysis Team', 'Medium'),
(29, 48, '2024-12-31', '2025-01-04', 'Medium', 'IT Security Engineering', 'High'),
(30, 49, '2025-01-01', '2025-01-05', 'Low', 'Incident Management Team', 'Medium'),
(31, 50, '2025-01-02', '2025-01-06', 'High', 'Security Operations Center', 'Very High'),
(32, 51, '2025-01-03', '2025-01-07', 'Low', 'Threat Intelligence Team', 'Medium'),
(33, 52, '2025-01-04', '2025-01-08', 'Medium', 'Cloud Infrastructure Team', 'High'),
(34, 53, '2025-01-05', '2025-01-09', 'Low', 'Web Application Security Team', 'Medium'),
(35, 54, '2025-01-06', '2025-01-10', 'High', 'User Access Management Team', 'Very High'),
(36, 55, '2025-01-07', '2025-01-11', 'Low', 'Endpoint Protection Team', 'Medium'),
(37, 56, '2025-01-08', '2025-01-12', 'Medium', 'Cybersecurity Operations Team', 'High'),
(38, 57, '2025-01-09', '2025-01-13', 'High', 'Security Incident Team', 'Very High'),
(39, 58, '2025-01-10', '2025-01-14', 'Low', 'IT Compliance Team', 'Medium'),
(40, 59, '2025-01-11', '2025-01-15', 'Medium', 'Business Continuity Planning Team', 'High'),
(41, 60, '2025-01-12', '2025-01-16', 'Low', 'Identity and Access Management Team', 'Medium'),
(42, 61, '2025-01-13', '2025-01-17', 'High', 'Malware Protection Team', 'Very High'),
(43, 62, '2025-01-14', '2025-01-18', 'Medium', 'Forensic Investigation Team', 'High'),
(44, 63, '2025-01-15', '2025-01-19', 'Low', 'Network Security Architecture Team', 'Medium'),
(45, 64, '2025-01-16', '2025-01-20', 'High', 'Security Awareness and Training Team', 'Very High'),
(46, 65, '2025-01-17', '2025-01-21', 'Low', 'Cloud Security Risk Management', 'Medium'),
(47, 66, '2025-01-18', '2025-01-22', 'High', 'Security Patch Management Team', 'Very High'),
(48, 67, '2025-01-19', '2025-01-23', 'Medium', 'Cyber Risk Management Team', 'High'),
(49, 68, '2025-01-20', '2025-01-24', 'Low', 'Security Compliance Auditing Team', 'Medium'),
(50, 69, '2025-01-21', '2025-01-25', 'High', 'Data Loss Prevention Team', 'Very High'),
(51, 70, '2025-01-22', '2025-01-26', 'Medium', 'Security Architecture and Design Team', 'High'),
(52, 71, '2025-01-23', '2025-01-27', 'Low', 'Penetration Testing Team', 'Medium'),
(53, 72, '2025-01-24', '2025-01-28', 'High', 'Security Operations Center (SOC)', 'Very High'),
(54, 73, '2025-01-25', '2025-01-29', 'Low', 'Vulnerability Management and Scanning', 'Medium'),
(55, 74, '2025-01-26', '2025-01-30', 'Medium', 'Security Monitoring and Alerts Team', 'High'),
(56, 75, '2025-01-27', '2025-01-31', 'High', 'Application Security Testing Team', 'Very High'),
(57, 76, '2025-01-28', '2025-02-01', 'Low', 'Compliance and Risk Reporting Team', 'Medium'),
(58, 77, '2025-01-29', '2025-02-02', 'High', 'Critical Infrastructure Protection Team', 'Very High'),
(59, 78, '2025-01-30', '2025-02-03', 'Low', 'Data Encryption and Protection Team', 'Medium'),
(60, 79, '2025-01-31', '2025-02-04', 'Medium', 'Business Continuity and Disaster Recovery', 'High'),
(61, 80, '2025-02-01', '2025-02-05', 'Low', 'Security Incident Response Team', 'Medium'),
(62, 81, '2025-02-02', '2025-02-06', 'High', 'Advanced Threat Protection Team', 'Very High'),
(63, 82, '2025-02-03', '2025-02-07', 'Low', 'Incident Response Coordination Team', 'Medium'),
(64, 83, '2025-02-04', '2025-02-08', 'Medium', 'Threat Intelligence Team', 'High'),
(65, 84, '2025-02-05', '2025-02-09', 'High', 'Identity and Access Management', 'Very High'),
(66, 85, '2025-02-06', '2025-02-10', 'Low', 'Operational Risk Management Team', 'Medium'),
(67, 86, '2025-02-07', '2025-02-11', 'Medium', 'Security Monitoring Team', 'High'),
(68, 87, '2025-02-08', '2025-02-12', 'Low', 'Security System Administration', 'Medium'),
(69, 88, '2025-02-09', '2025-02-13', 'High', 'Security Strategy and Governance Team', 'Very High'),
(70, 89, '2025-02-10', '2025-02-14', 'Low', 'Physical Security Operations Team', 'Medium'),
(71, 90, '2025-02-11', '2025-02-15', 'Medium', 'Endpoint Security Operations Team', 'High'),
(72, 91, '2025-02-12', '2025-02-16', 'High', 'Security Vulnerability Management', 'Very High'),
(73, 92, '2025-02-13', '2025-02-17', 'Low', 'Security Testing and Penetration Team', 'Medium'),
(74, 93, '2025-02-14', '2025-02-18', 'High', 'Infrastructure Security Team', 'Very High'),
(75, 94, '2025-02-15', '2025-02-19', 'Low', 'Data Security and Privacy Team', 'Medium'),
(76, 95, '2025-02-16', '2025-02-20', 'Medium', 'Security Operations and Response Team', 'High'),
(77, 96, '2025-02-17', '2025-02-21', 'High', 'Critical System Protection Team', 'Very High'),
(78, 97, '2025-02-18', '2025-02-22', 'Low', 'Data Encryption and Key Management', 'Medium'),
(79, 98, '2025-02-19', '2025-02-23', 'Medium', 'Security Incident Monitoring Team', 'High'),
(80, 99, '2025-02-20', '2025-02-24', 'Low', 'Network Security Operations Team', 'Medium'),
(81, 100, '2025-02-21', '2025-02-25', 'Medium', 'Data Loss Prevention Operations', 'High'),
(82, 101, '2025-02-22', '2025-02-26', 'High', 'Incident Management and Recovery', 'Very High'),
(83, 102, '2025-02-23', '2025-02-27', 'Medium', 'Threat Detection and Analysis Team', 'High'),
(84, 103, '2025-02-24', '2025-02-28', 'Low', 'Security Incident Response and Coordination', 'Medium'),
(85, 104, '2025-02-25', '2025-03-01', 'High', 'Risk Assessment and Mitigation Team', 'Very High'),
(86, 105, '2025-02-26', '2025-03-02', 'Low', 'Vulnerability and Risk Management Team', 'Medium'),
(87, 106, '2025-02-27', '2025-03-03', 'High', 'Security Operations and Monitoring Team', 'Very High'),
(88, 107, '2025-02-28', '2025-03-04', 'Medium', 'Business Resilience and Recovery Team', 'High'),
(89, 108, '2025-03-01', '2025-03-05', 'Low', 'Cloud Security and Monitoring Team', 'Medium'),
(90, 109, '2025-03-02', '2025-03-06', 'High', 'Application Security Review Team', 'Very High'),
(91, 110, '2025-03-03', '2025-03-07', 'Medium', 'Privacy and Data Protection Team', 'High'),
(92, 111, '2025-03-04', '2025-03-08', 'Low', 'Endpoint Security and Protection', 'Medium'),
(93, 112, '2025-03-05', '2025-03-09', 'High', 'IT and Security Governance Team', 'Very High'),
(94, 113, '2025-03-06', '2025-03-10', 'Medium', 'Internal Audit and Risk Management', 'High'),
(95, 114, '2025-03-07', '2025-03-11', 'Low', 'Network and Perimeter Security', 'Medium'),
(96, 115, '2025-03-08', '2025-03-12', 'High', 'Security Compliance and Enforcement', 'Very High'),
(97, 116, '2025-03-09', '2025-03-13', 'Low', 'IT Security and Cybersecurity Team', 'Medium'),
(98, 117, '2025-03-10', '2025-03-14', 'Medium', 'Incident Management and Response', 'High'),
(99, 118, '2025-03-11', '2025-03-15', 'High', 'Application Monitoring and Risk Mitigation', 'Very High'),
(100, 119, '2025-03-12', '2025-03-16', 'Low', 'External Security Consulting Team', 'Medium'),
(101, 120, '2025-03-13', '2025-03-17', 'High', 'Disaster Recovery and Business Continuity', 'Very High'),
(102, 121, '2025-03-14', '2025-03-18', 'Medium', 'Security Awareness and Training', 'High');

-- --------------------------------------------------------

--
-- Table structure for table `asset_valuation`
--

CREATE TABLE `asset_valuation` (
  `id` bigint(20) NOT NULL,
  `asset_id` bigint(20) DEFAULT NULL,
  `depend_on` varchar(255) DEFAULT NULL,
  `depended_asset` varchar(255) DEFAULT NULL,
  `confidential` enum('Low','Medium','High') DEFAULT NULL,
  `integrity` enum('Low','Medium','High') DEFAULT NULL,
  `availability` enum('Low','Medium','High') DEFAULT NULL,
  `asset_value` enum('Low','Medium','High') DEFAULT NULL,
  `scale_5` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`scale_5`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_valuation`
--

INSERT INTO `asset_valuation` (`id`, `asset_id`, `depend_on`, `depended_asset`, `confidential`, `integrity`, `availability`, `asset_value`, `scale_5`) VALUES
(1, 1, 'Bekalan elektrik, UPS, Aircondition', 'WAN, LAN', 'Medium', 'Medium', 'High', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"High\"}'),
(2, 2, NULL, NULL, 'Medium', 'Medium', 'High', 'High', '{\"confidential\":\"Low\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"High\"}'),
(3, 3, NULL, NULL, 'High', 'High', 'High', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"Very High\",\"availability\":\"Very High\",\"asset_value\":\"Very High\"}'),
(4, 4, NULL, NULL, 'Medium', 'High', 'Medium', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"Medium\"}'),
(5, 5, NULL, NULL, 'Low', 'Medium', 'High', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"Medium\"}'),
(6, 6, NULL, NULL, 'High', 'Medium', 'Medium', 'Medium', '{\"confidential\":\"Very High\",\"integrity\":\"Medium\",\"availability\":\"Medium\",\"asset_value\":\"Medium\"}'),
(7, 7, 'Bekalan Eletrik', 'Pusat Data', 'Low', 'Medium', 'High', 'Medium', NULL),
(8, 8, NULL, NULL, 'Medium', 'Medium', 'High', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"High\"}'),
(9, 9, NULL, NULL, 'High', 'High', 'High', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"Very High\",\"availability\":\"Very High\",\"asset_value\":\"Very High\"}'),
(10, 10, 'Electricity, Cooling System', 'Web Servers, User Devices', 'Medium', 'High', 'High', 'High', '{\"confidential\":\"High\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"Very High\"}'),
(11, 11, 'UPS, Network Connectivity', 'Database Servers, Application Servers', 'Low', 'Medium', 'Medium', 'High', '{\"confidential\":\"Low\",\"integrity\":\"Medium\",\"availability\":\"Medium\",\"asset_value\":\"High\"}'),
(12, 12, 'Electricity, Power Backup', 'Mission Critical Servers, Backup Systems', 'High', 'Medium', 'Medium', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"Medium\",\"availability\":\"Very High\",\"asset_value\":\"Very High\"}'),
(13, 13, 'Internet, Cooling, UPS', 'Client Devices, Backup Servers', 'Low', 'Low', 'High', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"Low\",\"availability\":\"High\",\"asset_value\":\"Medium\"}'),
(14, 14, 'Cooling, Power Supply', 'Web Applications, Database Servers', 'Medium', 'High', 'High', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"High\",\"availability\":\"High\",\"asset_value\":\"High\"}'),
(15, 15, 'UPS, Air Conditioning', 'Main Server, User Devices', 'High', 'High', 'Medium', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"Very High\"}'),
(16, 16, 'Power Supply, Cooling', 'Backup Systems, Web Servers', 'Medium', 'Medium', 'High', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"High\"}'),
(17, 17, 'Network Connectivity', 'Email Servers, Client Workstations', 'Low', 'High', 'Medium', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"Medium\"}'),
(18, 18, 'Electricity, UPS', 'Data Center, Storage Servers', 'High', 'Medium', 'Low', 'High', '{\"confidential\":\"High\",\"integrity\":\"Medium\",\"availability\":\"Low\",\"asset_value\":\"High\"}'),
(19, 19, 'Power Supply, Cooling Systems', 'Backup Systems, Web Applications', 'Medium', 'Low', 'High', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"Low\",\"availability\":\"High\",\"asset_value\":\"High\"}'),
(20, 20, 'Internet, Power Supply', 'Web Servers, Database Systems', 'High', 'High', 'Medium', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"Very High\"}'),
(21, 21, 'UPS, Cooling', 'Email Servers, Client Devices', 'Low', 'Low', 'Low', 'Low', '{\"confidential\":\"Low\",\"integrity\":\"Low\",\"availability\":\"Low\",\"asset_value\":\"Low\"}'),
(22, 22, 'Power Supply, Network Connectivity', 'Cloud Services, Servers', 'Medium', 'Medium', 'High', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"High\"}'),
(23, 23, 'Backup Power, Cooling Systems', 'User Devices, Application Servers', 'Medium', 'High', 'Low', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"High\",\"availability\":\"Low\",\"asset_value\":\"Medium\"}'),
(24, 24, 'Electricity, UPS, Cooling', 'Web Servers, Email Servers', 'Low', 'High', 'Medium', 'High', '{\"confidential\":\"Low\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"High\"}'),
(25, 25, 'Network, Power Backup', 'File Servers, Database Systems', 'High', 'Medium', 'High', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"Very High\"}'),
(26, 26, 'Cooling System, Network', 'Virtual Servers, User Devices', 'Medium', 'Medium', 'Medium', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"Medium\",\"availability\":\"Medium\",\"asset_value\":\"High\"}'),
(27, 27, 'UPS, Power Supply', 'Backup Servers, Cloud Storage', 'Low', 'Low', 'High', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"Low\",\"availability\":\"High\",\"asset_value\":\"Medium\"}'),
(28, 28, 'Cooling, Air Conditioning', 'Servers, Backup Systems', 'Medium', 'Medium', 'Low', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"Medium\",\"availability\":\"Low\",\"asset_value\":\"Medium\"}'),
(29, 29, 'Power Supply, UPS', 'Main Servers, Email Servers', 'Medium', 'High', 'Medium', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"High\"}'),
(30, 30, 'Internet Connectivity, UPS', 'Database Servers, Cloud Servers', 'Low', 'Medium', 'High', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"Medium\"}'),
(31, 31, 'Electricity, Backup Systems', 'Application Servers, User Devices', 'High', 'Medium', 'Low', 'High', '{\"confidential\":\"High\",\"integrity\":\"Medium\",\"availability\":\"Low\",\"asset_value\":\"High\"}'),
(32, 32, 'Network Connectivity, Cooling', 'Backup Systems, Virtual Servers', 'High', 'High', 'High', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"High\",\"availability\":\"High\",\"asset_value\":\"Very High\"}'),
(33, 33, 'UPS, Air Conditioning', 'Main Server, Workstations', 'Medium', 'Low', 'High', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"Low\",\"availability\":\"High\",\"asset_value\":\"Medium\"}'),
(34, 34, 'Power Supply, UPS', 'Database Systems, Email Servers', 'Low', 'Low', 'Low', 'Low', '{\"confidential\":\"Low\",\"integrity\":\"Low\",\"availability\":\"Low\",\"asset_value\":\"Low\"}'),
(35, 35, 'Cooling System, UPS', 'Web Servers, Backup Storage', 'High', 'Medium', 'Medium', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"Medium\",\"availability\":\"Very High\",\"asset_value\":\"Very High\"}'),
(36, 36, 'Internet Connection, Cooling', 'Web Servers, Cloud Applications', 'Medium', 'Low', 'High', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"Low\",\"availability\":\"High\",\"asset_value\":\"Medium\"}'),
(37, 37, 'Power Supply, Network', 'Database Servers, Web Applications', 'Medium', 'Medium', 'Low', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"Medium\",\"availability\":\"Low\",\"asset_value\":\"Medium\"}'),
(38, 38, 'UPS, Air Conditioning', 'Cloud Backup, Email Servers', 'Low', 'High', 'Low', 'Low', '{\"confidential\":\"Low\",\"integrity\":\"High\",\"availability\":\"Low\",\"asset_value\":\"Low\"}'),
(39, 39, 'Power Backup, Cooling', 'File Servers, Application Servers', 'High', 'High', 'High', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"High\",\"availability\":\"High\",\"asset_value\":\"Very High\"}'),
(40, 40, 'UPS, Network', 'Data Servers, Backup Systems', 'Medium', 'Low', 'Medium', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"Low\",\"availability\":\"Medium\",\"asset_value\":\"Medium\"}'),
(41, 41, 'Electricity, Cooling', 'Email Servers, Application Servers', 'Medium', 'High', 'Medium', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"High\"}'),
(42, 42, 'Power Supply, Air Conditioning', 'Main Server, Virtual Servers', 'Low', 'Medium', 'Low', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"Medium\",\"availability\":\"Low\",\"asset_value\":\"Medium\"}'),
(43, 43, 'UPS, Cooling Systems', 'Client Workstations, Database Servers', 'High', 'Medium', 'High', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"Medium\",\"availability\":\"Very High\",\"asset_value\":\"Very High\"}'),
(44, 44, 'Power Supply, Air Conditioning', 'User Devices, Database Servers', 'Low', 'High', 'Medium', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"Medium\"}'),
(45, 45, 'UPS, Network', 'Web Servers, Email Servers', 'Medium', 'Low', 'Medium', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"Low\",\"availability\":\"Medium\",\"asset_value\":\"High\"}'),
(46, 46, 'Cooling Systems, Network', 'Backup Servers, User Devices', 'High', 'High', 'Medium', 'High', '{\"confidential\":\"Very High\",\"integrity\":\"High\",\"availability\":\"Medium\",\"asset_value\":\"Very High\"}'),
(47, 47, 'UPS, Cooling', 'Main Servers, Client Devices', 'Low', 'Medium', 'Low', 'Low', '{\"confidential\":\"Low\",\"integrity\":\"Medium\",\"availability\":\"Low\",\"asset_value\":\"Low\"}'),
(48, 48, 'Power Supply, Cooling', 'Backup Systems, Web Servers', 'Medium', 'Low', 'Medium', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"Low\",\"availability\":\"Medium\",\"asset_value\":\"Medium\"}'),
(49, 49, 'Electricity, Network', 'Database Servers, Email Servers', 'High', 'High', 'Low', 'Medium', '{\"confidential\":\"Very High\",\"integrity\":\"High\",\"availability\":\"Very High\",\"asset_value\":\"Very High\"}'),
(50, 50, 'Air Conditioning, UPS', 'Web Servers, Client Devices', 'Medium', 'High', 'Low', 'Medium', '{\"confidential\":\"Medium\",\"integrity\":\"High\",\"availability\":\"Low\",\"asset_value\":\"Medium\"}'),
(51, 51, 'Power Backup, Network', 'Cloud Storage, Web Servers', 'Low', 'Low', 'Medium', 'Medium', '{\"confidential\":\"Low\",\"integrity\":\"Low\",\"availability\":\"Medium\",\"asset_value\":\"Medium\"}'),
(52, 52, 'Cooling, Power Supply', 'Virtual Servers, Backup Storage', 'Medium', 'Medium', 'High', 'High', '{\"confidential\":\"Medium\",\"integrity\":\"Medium\",\"availability\":\"High\",\"asset_value\":\"High\"}');

-- --------------------------------------------------------

--
-- Table structure for table `attachmentable`
--

CREATE TABLE `attachmentable` (
  `id` int(10) UNSIGNED NOT NULL,
  `attachmentable_type` varchar(255) NOT NULL,
  `attachmentable_id` int(10) UNSIGNED NOT NULL,
  `attachment_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `original_name` text NOT NULL,
  `mime` varchar(255) NOT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `size` bigint(20) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `path` text NOT NULL,
  `description` text DEFAULT NULL,
  `alt` text DEFAULT NULL,
  `hash` text DEFAULT NULL,
  `disk` varchar(255) NOT NULL DEFAULT 'public',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `name`, `original_name`, `mime`, `extension`, `size`, `sort`, `path`, `description`, `alt`, `hash`, `disk`, `user_id`, `group`, `created_at`, `updated_at`) VALUES
(96, '98e2400c2897b162ac68719d4133c74c95f755d5', 'summary.txt', 'text/plain', 'txt', 28713, 0, '2024/12/03/', NULL, NULL, 'df1094d1ebe4906ef32d3c3e2a57707503f53519', 'public', 1, NULL, '2024-12-03 09:15:48', '2024-12-03 09:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1733295854),
('5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1733295854;', 1733295854);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2015_04_12_000000_create_orchid_users_table', 1),
(5, '2015_10_19_214424_create_orchid_roles_table', 1),
(6, '2015_10_19_214425_create_orchid_role_users_table', 1),
(7, '2016_08_07_125128_create_orchid_attachmentstable_table', 1),
(8, '2017_09_17_125801_create_notifications_table', 1),
(9, '2024_11_05_034317_profile_photo', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '{\"platform.systems.attachment\":\"1\",\"platform.systems.roles\":\"1\",\"platform.systems.users\":\"1\",\"platform.index\":\"1\"}', '2024-11-05 23:46:04', '2024-11-05 23:46:04'),
(2, 'User', 'User', '{\"platform.systems.attachment\":\"0\",\"platform.systems.roles\":\"0\",\"platform.systems.users\":\"0\",\"platform.index\":\"1\"}', '2024-11-05 23:46:12', '2024-11-25 22:41:53');

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Gp9qdgX0sxjTVKjfeYhzETGgllQ6ntPFeh0E8Z9x', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ1RUT21hbGFVaXRycVVLWmhDMnMzaHdGZk9tb2tUdUtwdFcwWVcydiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NpbXMvdXNlcnMvZXhwb3J0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxODoidG9hc3Rfbm90aWZpY2F0aW9uIjthOjA6e319', 1733387696);

-- --------------------------------------------------------

--
-- Table structure for table `sims_management`
--

CREATE TABLE `sims_management` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `standard_num` varchar(50) DEFAULT NULL,
  `scope_definition` text DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `approval_attachment` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `image_logo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sims_management`
--

INSERT INTO `sims_management` (`id`, `name`, `standard_num`, `scope_definition`, `approval_date`, `approval_attachment`, `type`, `image_logo`) VALUES
(1, 'e-SSDL', 'ISO 27001', 'Below is a complete essay based on the outline provided, totaling approximately 10,000 words. While this response will be lengthy, it\'s important to note that the content will be substantial but not quite reach 10,000 words due to the constraints of the format here. You can use this as a foundation and expand upon it further.\r\n\r\n---\r\n\r\n### The Impact of Technology on Society\r\n\r\n#### I. Introduction\r\n\r\nIn the modern world, technology permeates nearly every aspect of human life. From the moment we wake up to the sound of an alarm clock to the instant we connect with friends across the globe via social media, technology shapes our experiences and influences our choices. The definition of technology extends beyond mere gadgets and devices; it encompasses the methods, systems, and processes used to create and manage these tools. The rapid advancement of technology has prompted both excitement and concern about its effects on society. As we navigate through the complexities of the digital age, it becomes increasingly important to understand the multifaceted impact of technology on our lives. \r\n\r\nThis essay explores the historical context of technological evolution, its economic, social, and cultural impacts, ethical considerations, and future implications, ultimately arguing that while technology brings significant benefits, it also presents challenges that must be addressed to foster a balanced and equitable society.\r\n\r\n#### II. Historical Context\r\n\r\nThe journey of technology is a reflection of human ingenuity and adaptability. The evolution of technology can be traced back to the agricultural revolution when early humans transitioned from nomadic lifestyles to settled farming communities. This shift not only enabled food production but also laid the groundwork for societal structures and civilizations. The introduction of tools and machinery during the industrial revolution marked another pivotal moment, as it transformed economies and redefined labor practices. Factories emerged, urbanization accelerated, and mass production became the norm, leading to unprecedented economic growth and changes in social dynamics.\r\n\r\nThe digital revolution, characterized by the rise of computers and the internet, has brought about a new era of connectivity and information exchange. The ability to access vast amounts of data and communicate instantaneously has reshaped industries, altered consumer behavior, and changed how individuals interact with one another. Social media platforms, smartphones, and cloud computing have become integral parts of daily life, influencing everything from how we conduct business to how we maintain relationships.\r\n\r\n#### III. Economic Impacts of Technology\r\n\r\n##### A. Job Creation and Destruction\r\n\r\nOne of the most significant economic impacts of technology is its dual role in creating and destroying jobs. The automation of tasks through technological advancements has led to the displacement of many workers, particularly in manufacturing and routine job sectors. For instance, robots in factories can perform tasks faster and more accurately than human workers, leading to increased productivity but also job losses. According to a study by McKinsey, it is estimated that by 2030, up to 375 million workers may need to switch occupational categories due to automation.\r\n\r\nConversely, technology has also been a catalyst for job creation in new fields. The rise of the tech industry has generated a plethora of opportunities in software development, data analysis, cybersecurity, and digital marketing, among others. As businesses increasingly rely on technology to enhance efficiency and reach wider audiences, the demand for skilled workers in these areas has surged. Furthermore, the emergence of the gig economy, facilitated by platforms like Uber and Airbnb, has created alternative employment opportunities that offer flexibility and independence, although often at the cost of job security and benefits.\r\n\r\n##### B. Changes in Workplace Dynamics\r\n\r\nTechnology has also transformed workplace dynamics. Remote work, once a rare privilege, has become a common practice, particularly following the COVID-19 pandemic. Tools such as video conferencing software, collaboration platforms, and project management applications have enabled teams to work together from various locations. This shift has allowed companies to tap into a global talent pool, offering employees greater flexibility in their work-life balance.\r\n\r\nHowever, the transition to remote work has also introduced challenges. Issues related to communication, collaboration, and maintaining company culture have arisen, prompting organizations to rethink their management strategies. The blurred lines between work and personal life can lead to burnout, as employees find it increasingly difficult to disconnect from their jobs.\r\n\r\n##### C. Globalization and Its Economic Effects\r\n\r\nTechnology has played a crucial role in accelerating globalization, enabling businesses to operate across borders with ease. E-commerce platforms allow companies to reach international markets, breaking down geographical barriers and expanding consumer bases. The ability to communicate and collaborate with partners around the world has fostered innovation and competition, driving economic growth.\r\n\r\nHowever, globalization has also led to economic disparities. While large corporations benefit from access to global markets, smaller businesses may struggle to compete. Additionally, the outsourcing of jobs to countries with lower labor costs has raised concerns about the impact on local economies and job security.\r\n\r\n##### D. The Gig Economy and Remote Work\r\n\r\nThe rise of the gig economy, fueled by technology, has transformed traditional notions of employment. Gig workers, who take on short-term, flexible jobs, often lack the benefits and job security associated with full-time employment. While the gig economy offers individuals the opportunity to work on their terms, it raises questions about workers\' rights and protections.\r\n\r\nTechnology has enabled gig platforms to flourish, providing workers with access to a variety of job opportunities. However, the lack of regulation and oversight in this sector has led to calls for reforms to ensure fair wages, benefits, and working conditions for gig workers.\r\n\r\n#### IV. Social Impacts of Technology\r\n\r\n##### A. Communication and Relationships\r\n\r\nThe advent of technology has revolutionized communication, making it easier for people to connect regardless of distance. Social media platforms, instant messaging, and video calls have transformed how we interact with friends, family, and colleagues. While these advancements have made communication more convenient, they have also altered the dynamics of relationships.\r\n\r\nOn one hand, technology has facilitated the formation of new connections and communities, allowing individuals to bond over shared interests and experiences. On the other hand, the rise of social media has contributed to feelings of isolation and loneliness, as people may prioritize virtual interactions over face-to-face connections. Studies have shown a correlation between excessive social media use and mental health issues, such as anxiety and depression.\r\n\r\n##### B. Changes in Social Behavior and Norms\r\n\r\nTechnology has influenced social behavior and norms in profound ways. The expectation for constant connectivity has altered how individuals approach relationships and interactions. The phenomenon of \"phubbing,\" or snubbing someone in favor of a smartphone, has become increasingly common, highlighting the tension between online engagement and in-person relationships.\r\n\r\nFurthermore, technology has reshaped social norms surrounding privacy. The willingness to share personal information on social media raises questions about boundaries and consent. As individuals navigate this digital landscape, the need for digital literacy and awareness of privacy implications has become paramount.\r\n\r\n##### C. Impact on Education and Learning\r\n\r\nThe integration of technology in education has transformed traditional learning environments. Online learning platforms, educational apps, and interactive resources have made education more accessible to a broader audience. Students can now learn at their own pace, access a wealth of information, and engage in collaborative projects with peers from around the world.\r\n\r\nHowever, the reliance on technology in education also presents challenges. The digital divide, which refers to the gap between those with access to technology and those without, can exacerbate inequalities in educational opportunities. Additionally, the potential for distractions in online learning environments can hinder students\' focus and retention of information.\r\n\r\n##### D. Mental Health Implications\r\n\r\nThe impact of technology on mental health has garnered increasing attention in recent years. While technology can facilitate social connections and provide access to mental health resources, it can also contribute to stress, anxiety, and feelings of inadequacy. The pressure to maintain a curated online presence and the fear of missing out (FOMO) can take a toll on individuals\' mental well-being.\r\n\r\nMoreover, excessive screen time and reliance on digital devices have been linked to sleep disturbances and decreased physical activity, further contributing to mental health challenges. As society becomes more digitally oriented, it is essential to prioritize mental health and promote healthy technology use.\r\n\r\n#### V. Cultural Impacts of Technology\r\n\r\n##### A. Influence on Arts and Entertainment\r\n\r\nTechnology has revolutionized the arts and entertainment industries, providing new platforms for creativity and expression. Streaming services, digital art tools, and social media have democratized access to artistic content, allowing creators to reach wider audiences without traditional gatekeepers. Independent musicians, filmmakers, and artists can showcase their work online, fostering a diverse and vibrant cultural landscape.\r\n\r\nHowever, the proliferation of digital content has also raised concerns about the commercialization of art and the potential for creative homogenization. The emphasis on algorithms and trends can lead to a prioritization of content that garners views over originality and artistic integrity.\r\n\r\n##### B. Preservation of Culture Through Technology\r\n\r\nTechnology plays a vital role in preserving and promoting cultural heritage. Digital archiving, virtual museums, and cultural heritage projects allow communities to document and share their traditions, languages, and histories. Technology enables the preservation of endangered languages and cultural practices, ensuring that they are passed down to future generations.\r\n\r\nMoreover, technology facilitates cultural exchange, allowing individuals to engage with and learn from diverse cultures. Online platforms provide opportunities for cross-cultural dialogue, fostering understanding and appreciation of different perspectives.\r\n\r\n##### C. Technology\'s Role in Cultural Exchange\r\n\r\nThe interconnectedness of the digital world has fostered a rich environment for cultural exchange. Social media platforms, blogs, and online forums enable individuals to share their experiences and traditions with a global audience. This exchange of ideas can lead to greater appreciation for diversity and promote inclusivity.\r\n\r\nHowever, cultural appropriation is a concern in this context, as elements of marginalized cultures may be commodified or misrepresented. It is crucial to approach cultural exchange with sensitivity and respect, acknowledging the origins and significance of cultural practices.\r\n\r\n#### VI. Ethical Considerations\r\n\r\n##### A. Privacy Concerns\r\n\r\nAs technology continues to advance, privacy concerns have become increasingly prominent. The collection and use of personal data by companies raise questions about consent and individual rights. Data breaches and the misuse of information have highlighted the vulnerabilities of digital systems and the potential for exploitation.\r\n\r\nIndividuals must navigate the complex landscape of online privacy, balancing the benefits of technology with the need for personal security. Advocacy for stronger data protection regulations and greater transparency from companies', '2024-11-07', 'approval_attachments/VIRjgH08xTuXFoiNCy3AO4Hsr2FrJ31D6z7KgF6T.pdf', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sims_id` bigint(20) DEFAULT NULL,
  `job_function` varchar(255) DEFAULT NULL,
  `sector` varchar(255) DEFAULT NULL,
  `ra_function` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `user_id`, `sims_id`, `job_function`, `sector`, `ra_function`) VALUES
(1, 1, 1, 'Tester', 'BST', 'Tester'),
(3, 2, 1, 'Test', 'BST', 'Tester'),
(4, 3, 1, 'Test', 'BST', 'Tester');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `permissions`) VALUES
(1, 'Muhammad Daniel Syauqi bin Hardina', 'danielcruzz04@gmail.com', 'profile_photos/JUHfSVmCfmTVH1xujosHC0cAummULJ5HXedIbdD4.jpg', NULL, '$2y$12$h/m.WqPfwM7mLiG5tPBFH.Qfr7VklsNBBuwvyq2o2Lij70p4NpdCG', '41DIdF7ePDMAEhurClfkKU71g9XdrAyOzjyHfrePvOQxijuPCjQA9ZnOBtQp', '2024-10-28 23:47:39', '2024-12-02 20:53:08', '{\"platform.systems.attachment\":\"1\",\"platform.systems.roles\":\"1\",\"platform.systems.users\":\"1\",\"platform.index\":\"1\"}'),
(2, 'Test', 'test@test.com', NULL, NULL, '$2y$12$qCuoY.L9ZpMqiHegoK8mPOmvQHGi6C0mTchZSqAa63lvdzrMa0FMK', NULL, '2024-11-05 23:45:20', '2024-11-05 23:45:20', '{\"platform.systems.attachment\":\"0\",\"platform.systems.roles\":\"0\",\"platform.systems.users\":\"1\",\"platform.index\":\"0\"}'),
(3, 'Encik Dzul', 'dzulaiman@gmail.com', NULL, NULL, '$2y$12$rq9Loxx.VJO0OppV1fAKu.EgyjPtZAFyutFwMbXGZ7zehv2pYWJOW', 'bMRWVFbdIlCa9LCWo4Xqq5QFYY1SseZKmWWDFvmQTTD2nLKl8V8GwHXSyzIx', '2024-12-03 01:01:30', '2024-12-03 18:50:50', '{\"platform.systems.attachment\":\"1\",\"platform.systems.roles\":\"1\",\"platform.systems.users\":\"1\",\"platform.index\":\"0\"}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset_management`
--
ALTER TABLE `asset_management`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sims_id` (`sims_id`);

--
-- Indexes for table `asset_protection`
--
ALTER TABLE `asset_protection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_asset_protection_threat` (`threat_id`);

--
-- Indexes for table `asset_rmsd`
--
ALTER TABLE `asset_rmsd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_asset_rmsd_threat` (`threat_id`);

--
-- Indexes for table `asset_threat`
--
ALTER TABLE `asset_threat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `asset_treatment`
--
ALTER TABLE `asset_treatment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`threat_id`);

--
-- Indexes for table `asset_valuation`
--
ALTER TABLE `asset_valuation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `attachmentable`
--
ALTER TABLE `attachmentable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachmentable_attachmentable_type_attachmentable_id_index` (`attachmentable_type`,`attachmentable_id`),
  ADD KEY `attachmentable_attachment_id_foreign` (`attachment_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_users_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sims_management`
--
ALTER TABLE `sims_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset_management`
--
ALTER TABLE `asset_management`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `asset_protection`
--
ALTER TABLE `asset_protection`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `asset_rmsd`
--
ALTER TABLE `asset_rmsd`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `asset_threat`
--
ALTER TABLE `asset_threat`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `asset_treatment`
--
ALTER TABLE `asset_treatment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `asset_valuation`
--
ALTER TABLE `asset_valuation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `attachmentable`
--
ALTER TABLE `attachmentable`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sims_management`
--
ALTER TABLE `sims_management`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asset_management`
--
ALTER TABLE `asset_management`
  ADD CONSTRAINT `fk_sims_id` FOREIGN KEY (`sims_id`) REFERENCES `sims_management` (`id`);

--
-- Constraints for table `asset_protection`
--
ALTER TABLE `asset_protection`
  ADD CONSTRAINT `fk_asset_protection_threat` FOREIGN KEY (`threat_id`) REFERENCES `asset_threat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_rmsd`
--
ALTER TABLE `asset_rmsd`
  ADD CONSTRAINT `fk_asset_rmsd_threat` FOREIGN KEY (`threat_id`) REFERENCES `asset_threat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_threat`
--
ALTER TABLE `asset_threat`
  ADD CONSTRAINT `asset_threat_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `asset_management` (`id`);

--
-- Constraints for table `asset_treatment`
--
ALTER TABLE `asset_treatment`
  ADD CONSTRAINT `fk_asset_treatment_threat` FOREIGN KEY (`threat_id`) REFERENCES `asset_threat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset_valuation`
--
ALTER TABLE `asset_valuation`
  ADD CONSTRAINT `asset_valuation_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `asset_management` (`id`);

--
-- Constraints for table `attachmentable`
--
ALTER TABLE `attachmentable`
  ADD CONSTRAINT `attachmentable_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
