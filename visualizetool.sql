-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 4 朁E23 日 02:12
-- サーバのバージョン： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `visualizetool`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `csvs`
--

CREATE TABLE IF NOT EXISTS `csvs` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `model_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `csv_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `graphs`
--

CREATE TABLE IF NOT EXISTS `graphs` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `0` text NOT NULL,
  `1` int(11) NOT NULL,
  `2` int(11) NOT NULL,
  `3` int(11) NOT NULL,
  `4` int(11) NOT NULL,
  `5` int(11) NOT NULL,
  `6` int(11) NOT NULL,
  `7` int(11) NOT NULL,
  `8` int(11) NOT NULL,
  `9` int(11) NOT NULL,
  `10` int(11) NOT NULL,
  `11` int(11) NOT NULL,
  `12` int(11) NOT NULL,
  `13` int(11) NOT NULL,
  `14` int(11) NOT NULL,
  `15` int(11) NOT NULL,
  `16` int(11) NOT NULL,
  `17` int(11) NOT NULL,
  `18` int(11) NOT NULL,
  `19` int(11) NOT NULL,
  `20` int(11) NOT NULL,
  `21` int(11) NOT NULL,
  `22` int(11) NOT NULL,
  `23` int(11) NOT NULL,
  `24` int(11) NOT NULL,
  `25` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `graphs`
--

INSERT INTO `graphs` (`id`, `model`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`) VALUES
(1, 'testA', 'bootable/bootloader/lk/platform/msm_shared/certificate.c', 6, 0, 0, -1, -1, -1, -1, -1, -1, -1, -1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(2, 'testA', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceVideoEncode.cpp', 6, 0, 0, 2089, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 67, 0, 11, 0, 0, 0, 2, 'Miracast'),
(3, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/sensors/chromatix/module/chromatix_sub_module.c', 6, 0, 0, 620, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 13, 1, 0, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(4, 'testA', '\npackages/apps/SmartCardService/src/org/simalliance/openmobileapi/service/security/arf/SecureElement.java', 6, 0, 0, 89, 0, 0, 1, 21, 20, 11, 0, 0, 2, 0, 3, 0, 3, 22, 0, 11, 0, 3, 0, 2, 'FeliCa/NFCã‚¢ãƒ—ãƒª'),
(5, 'testA', '\nvendor/qcom/proprietary/telephony-apps/ims/src/org/codeaurora/ims/ImsConfigImpl.java', 3, 0, 0, 89, 0, 2, 1, 12, 54, 10, 0, 0, 0, 0, 0, 0, 0, 11, 0, 1, 0, 0, 0, 2, ''),
(6, 'testA', '\nhardware/qcom/camera/QCamera2/stack/mm-jpeg-interface/src/mm_jpeg_exif.c', 6, 0, 0, 536, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 7, 1, 2, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(7, 'testA', '\nvendor/qcom/proprietary/qcril/qcril_qmi/qcril.c', 6, 0, 0, 7906, 0, 0, 0, 0, 0, 0, 41, 0, 0, 88, 0, 0, 0, 116, 9, 45, 9, 0, 21, 2, 'QCRIL'),
(8, 'testA', '\nbootable/bootloader/lk/platform/msm_shared/sdhci_msm.c', 6, 0, 0, 676, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 17, 0, 5, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(9, 'testA', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSource.cpp', 6, 0, 0, 3687, 0, 0, 0, 0, 0, 0, 4, 7, 0, 0, 4, 0, 4, 83, 0, 11, 8, 0, 0, 2, 'Miracast'),
(10, 'testA', '\nhardware/qcom/display/liboverlay/overlayMdp.cpp', 6, 0, 0, 364, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 2, 0, 2, 41, 0, 18, 0, 0, 0, 2, 'Display;REGZA/Multimedia'),
(11, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/afd/afd_port.c', 6, 0, 0, 833, 0, -1, -1, -1, -1, -1, -1, 0, 0, 6, 0, 6, 0, 18, 3, 3, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(12, 'testA', '\nkernel/drivers/media/radio/silabs/radio-silabs.c', 6, 0, 0, 1201, 0, 0, 0, 0, 0, 0, 80, 0, 0, 1, 0, 1, 0, 48, 2, 0, 0, 0, 1, 2, 'Connectivity'),
(13, 'testA', '\nkernel/sound/soc/msm/qdsp6v2/q6adm.c', 6, 0, 0, 3175, 0, 0, 0, 0, 0, 0, 27, 0, 0, 0, 0, 0, 0, 47, 0, 22, 0, 0, 3, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(14, 'testA', '\nvendor/qcom/proprietary/mm-audio/audio-acdb-util/acdb-loader/src/family-b/acdb-loader.c', 6, 0, 0, 2961, 0, 0, 0, 0, 0, 0, 27, 0, 0, 0, 0, 0, 0, 35, 1, 3, 3, 0, 6, 2, 'Audio'),
(15, 'testA', '\nkernel/drivers/soc/qcom/socinfo.c', 6, 0, 0, 751, 0, 0, 0, 0, 0, 0, 27, 0, 0, 1, 0, 1, 0, 21, 1, 8, 5, 0, 6, 2, 'BSP'),
(16, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/asd/asd_port.c', 6, 0, 0, 1079, 0, 0, 0, 0, 0, 0, 10, 0, 0, 8, 0, 8, 0, 20, 3, 3, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(17, 'testA', '\nexternal/wpa_supplicant_8/hostapd/src/eap_peer/eap_proxy_qmi.c', 3, 0, 0, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 2, ''),
(18, 'testA', '\nkernel/drivers/base/power/wakeup.c', 6, 0, 0, 534, 0, -1, -1, -1, -1, -1, -1, 0, 0, 3, 0, 3, 0, 51, 1, 8, 1, 0, 2, 2, 'BSP'),
(19, 'testA', '\nkernel/drivers/platform/msm/qpnp-power-on.c', 6, 0, 0, 1413, 0, 0, 0, 0, 0, 0, 28, 0, 0, 0, 0, 0, 0, 67, 1, 1, 0, 0, 3, 2, 'BSP'),
(20, 'testA', '\nkernel/kernel/sysctl.c', 6, 0, 0, 41, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 2, 'BSP'),
(21, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/sub_module/isp_sub_module_port.c', 6, 0, 0, 1802, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 24, 1, 3, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(22, 'testA', '\nkernel/sound/soc/msm/qdsp6v2/msm-pcm-voice-v2.c', 6, 0, 0, 659, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 47, 0, 0, 0, 0, 1, 2, 'Audio'),
(23, 'testA', '\nkernel/kernel/sched/core.c', 6, 0, 0, 2841, 0, -1, -1, -1, -1, -1, -1, 4, 0, 10, 0, 0, 0, 218, 7, 46, 16, 0, 2, 2, 'AndroidPF'),
(24, 'testA', '\nhardware/qcom/display/liboverlay/overlay.cpp', 6, 0, 0, 533, 0, -1, -1, -1, -1, -1, -1, 1, 2, 0, 12, 0, 12, 79, 0, 20, 1, 2, 0, 2, 'Display'),
(25, 'testA', '\nvendor/qcom/opensource/wlan/qcacld-2.0/CORE/MAC/src/pe/lim/limSendManagementFrames.c', 6, 0, 0, 4245, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 110, 0, 19, 0, 0, 2, 2, 'Connectivity'),
(26, 'testA', '\nkernel/fs/read_write.c', 6, 0, 0, 844, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 46, 0, 15, 1, 0, 0, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(27, 'testA', '\nkernel/drivers/video/msm/mdss/mdss_hdmi_util.c', 6, 0, 0, 806, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 12, 1, 10, 0, 0, 3, 2, 'Display'),
(28, 'testA', '\nkernel/arch/arm64/mm/mmap.c', 6, 0, 0, 57, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(29, 'testA', '\nvendor/qcom/proprietary/qcril/qcril_qmi/qcril_qmi_imss.c', 6, 0, 0, 708, 0, 0, 0, 0, 0, 0, 6, 0, 0, 10, 0, 0, 0, 29, 7, 1, 0, 0, 1, 2, 'QCRIL'),
(30, 'testA', '\nkernel/drivers/platform/msm/pft.c', 6, 0, 0, 1241, 0, 0, 0, 0, 0, 0, 17, 0, 0, 0, 0, 0, 0, 37, 0, 0, 0, 0, 2, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(31, 'testA', '\nkernel/drivers/cpufreq/cpufreq.c', 6, 0, 0, 1868, 0, -1, -1, -1, -1, -1, -1, 1, 0, 4, 0, 4, 0, 90, 4, 19, 2, 0, 9, 2, 'BSP'),
(32, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/q3a/af/af_port.c', 6, 0, 0, 4226, 0, 0, 0, 0, 0, 0, 47, 0, 0, 54, 0, 54, 0, 21, 3, 3, 1, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(33, 'testA', '\nkernel/drivers/media/platform/msm/camera_v2/sensor/io/msm_camera_cci_i2c.c', 6, 0, 0, 474, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(34, 'testA', '\nkernel/drivers/clk/qcom/clock-pll.c', 6, 0, 0, 816, 0, -1, -1, -1, -1, -1, -1, 5, 0, 0, 0, 0, 0, 32, 0, 1, 5, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(35, 'testA', '\nkernel/drivers/staging/android/ion/ion_cma_heap.c', 6, 0, 1, 235, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 24, 0, 2, 0, 0, 1, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(36, 'testA', '\nvendor/qcom/opensource/location/loc_api/loc_api_v02/LocApiV02.cpp', 6, 0, 0, 2857, 0, 1, 1, 1, 0, 2, 2, 0, 0, 0, 0, 0, 0, 71, 0, 4, 1, 0, 0, 2, 'GPSãƒ‰ãƒ©ã‚¤ãƒE'),
(37, 'testA', '\nkernel/drivers/leds/leds-qpnp.c', 6, 0, 4, 4518, 0, 0, 0, 0, 0, 0, 98, 1, 0, 0, 0, 0, 0, 87, 2, 0, 9, 0, 6, 2, 'aDriver'),
(38, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/pproc-new/cpp/cpp_hw_params.c', 6, 0, 0, 4847, 0, -1, -1, -1, -1, -1, -1, 0, 0, 1, 0, 0, 0, 21, 33, 11, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(39, 'testA', '\npackages/apps/SmartCardService/openmobileapi/src/org/simalliance/openmobileapi/Session.java', 6, 0, 0, 220, 0, 0, 1, 14, 44, 7, 0, 0, 0, 0, 0, 0, 0, 17, 0, 1, 0, 0, 0, 2, 'FeliCa/NFCã‚¢ãƒ—ãƒª'),
(40, 'testA', '\nvendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/vt/ImsCamera.java', 6, 0, 0, 332, 0, 1, 0, 13, 447, 29, 0, 0, 0, 0, 1, 0, 1, 41, 0, 1, 0, 0, 0, 2, 'é›»è©±'),
(41, 'testA', '\nkernel/drivers/soc/qcom/peripheral-loader.c', 6, 0, 0, 712, 0, 0, 0, 0, 0, 0, 26, 0, 0, 0, 0, 0, 0, 72, 1, 0, 0, 0, 1, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(42, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/iface2/iface_buf_mgr.c', 6, 0, 0, 845, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 16, 0, 17, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(43, 'testA', '\nkernel/kernel/power/qos.c', 6, 0, 0, 465, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 45, 0, 3, 0, 0, 1, 2, 'BSP'),
(44, 'testA', '\nkernel/drivers/staging/android/logger.c', 6, 0, 0, 849, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 1, 2, 'AndroidPF'),
(45, 'testA', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceVideoCapture.cpp', 6, 0, 0, 1545, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 61, 1, 8, 0, 0, 0, 2, 'Miracast'),
(46, 'testA', '\nframeworks/base/core/java/org/codeaurora/Performance.java', 6, 0, 0, 16, 0, 0, 0, 0, 26, 3, 0, 0, 0, 0, 1, 0, 1, 3, 0, 3, 0, 22, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(47, 'testA', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceAudioSource.cpp', 6, 0, 0, 1758, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 3, 0, 3, 72, 1, 8, 2, 0, 0, 2, 'Miracast'),
(48, 'testA', '\nkernel/drivers/misc/qseecom.c', 6, 0, 0, 5971, 0, 0, 0, 0, 0, 0, 77, 0, 0, 6, 0, 2, 0, 98, 3, 5, 0, 0, 4, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(49, 'testA', '\nframeworks/opt/telephony/src/java/com/android/internal/telephony/ModemStackController.java', 6, 0, 0, 636, 0, 1, 2, 60, 379, 18, 0, 0, 0, 0, 8, 0, 8, 87, 0, 10, 0, 1, 1, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(50, 'testA', '\nkernel/drivers/leds/leds-qpnp-wled.c', 6, 0, 0, 1577, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 52, 0, 0, 4, 0, 2, 2, 'Display'),
(51, 'testA', '\nhardware/qcom/camera/QCamera2/HAL/QCamera2HWICallbacks.cpp', 6, 0, 0, 2432, 0, -1, -1, -1, -1, -1, -1, 0, 0, 21, 0, 21, 0, 86, 3, 9, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(52, 'testA', '\nbootable/bootloader/lk/app/aboot/aboot.c', 6, 0, 0, 2955, 0, 0, 0, 0, 0, 0, 11, 3, 0, 7, 0, 2, 0, 96, 2, 4, 11, 0, 4, 2, 'BSP;Display;ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(53, 'testA', '\nvendor/qcom/proprietary/qmi/platform/qmi_platform_qmux_io.c', 6, 0, 0, 527, 0, -1, -1, -1, -1, -1, -1, 1, 0, 1, 0, 0, 0, 34, 1, 5, 3, 0, 2, 2, 'mDriver'),
(54, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/imglib/components/frameproc/frameproc_comp.c', 6, 0, 0, 606, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 22, 1, 0, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(55, 'testA', '\nkernel/drivers/mmc/host/sdhci.c', 6, 0, 0, 3676, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 2, 0, 117, 2, 4, 0, 0, 1, 2, 'BSP'),
(56, 'testA', '\nkernel/drivers/base/dma-contiguous.c', 6, 0, 0, 398, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0, 0, 0, 0, 37, 1, 5, 2, 0, 9, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(57, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/sensors/module/sensor_frame_control.c', 6, 0, 0, 709, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 15, 1, 4, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(58, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/pproc-new/vpe/vpe_hardware.c', 6, 0, 0, 635, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 20, 1, 6, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(59, 'testA', '\nvendor/qcom/proprietary/wfd/wdsm/service/src/com/qualcomm/wfd/service/WfdService.java', 6, 0, 0, 31, 0, 1, 1, 8, 0, 3, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0, 0, 0, 2, 'Miracast'),
(60, 'testA', '\nhardware/qcom/camera/QCamera2/stack/mm-jpeg-interface/src/mm_jpeg.c', 6, 0, 0, 2274, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 57, 1, 5, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(61, 'testA', '\nkernel/drivers/media/platform/msm/camera_v2/sensor/eeprom/msm_eeprom.c', 6, 0, 0, 1368, 0, -1, -1, -1, -1, -1, -1, 1, 0, 1, 0, 1, 0, 48, 1, 0, 2, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(62, 'testA', '\nbootable/bootloader/lk/platform/msm_shared/display.c', 6, 0, 0, 387, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 6, 0, 4, 0, 0, 1, 2, 'Display'),
(63, 'testA', '\nkernel/sound/soc/msm/msm8994.c', 6, 0, 0, 2114, 0, 0, 0, 0, 0, 0, 17, 0, 0, 0, 0, 0, 0, 109, 0, 0, 1, 0, 12, 2, 'Audio'),
(64, 'testA', '\nvendor/qcom/proprietary/sensors/dsps/libhalsensors/src/SensorsContext.cpp', 3, 0, 0, 1464, 0, -1, -1, -1, -1, -1, -1, 0, 0, 18, 0, 0, 0, 130, 2, 8, 0, 0, 1, 2, ''),
(65, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/rolloff/mesh_rolloff44/mesh_rolloff44.c', 6, 0, 0, 3032, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 27, 1, 21, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(66, 'testA', '\nhardware/qcom/camera/QCamera2/HAL/QCameraPostProc.cpp', 6, 0, 0, 2852, 0, -1, -1, -1, -1, -1, -1, 0, 0, 20, 0, 20, 0, 149, 2, 13, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(67, 'testA', '\nkernel/drivers/video/msm/mdss/mdss_dsi_host.c', 6, 0, 1, 2197, 0, 0, 0, 0, 0, 0, 9, 1, 0, 0, 0, 0, 0, 73, 0, 12, 3, 0, 6, 2, 'Display'),
(68, 'testA', '\nkernel/lib/spinlock_debug.c', 6, 0, 0, 232, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 17, 0, 1, 0, 0, 0, 2, 'BSP'),
(69, 'testA', '\nkernel/drivers/soc/qcom/pil-q6v5-mss.c', 6, 0, 0, 489, 0, 0, 0, 0, 0, 0, 6, 0, 0, 1, 0, 0, 0, 65, 2, 0, 0, 0, 1, 2, 'AndroidPF;mDriver'),
(70, 'testA', '\nkernel/drivers/video/msm/mdss/mdss_dsi.c', 6, 0, 0, 2236, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 117, 0, 0, 1, 0, 2, 2, 'Display'),
(71, 'testA', '\nkernel/drivers/usb/gadget/f_mtp.c', 6, 0, 0, 1069, 0, 0, 0, 0, 0, 0, 48, 0, 0, 0, 0, 0, 0, 55, 4, 5, 5, 0, 1, 2, 'BSP'),
(72, 'testA', '\nkernel/drivers/gpu/msm/adreno_cp_parser.c', 6, 0, 0, 666, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 0, 17, 0, 2, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(73, 'testA', '\nkernel/drivers/thermal/lmh_interface.c', 6, 0, 0, 766, 0, 0, 0, 0, 0, 0, 28, 0, 0, 0, 0, 0, 0, 37, 0, 0, 0, 0, 3, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(74, 'testA', '\nkernel/drivers/power/power_supply_sysfs.c', 6, 0, 0, 163, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 13, 0, 0, 20, 0, 1, 2, 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE'),
(75, 'testA', '\nhardware/qcom/camera/QCamera2/stack/mm-camera-interface/src/mm_camera_interface.c', 6, 0, 0, 1048, 0, -1, -1, -1, -1, -1, -1, 1, 0, 0, 0, 0, 0, 50, 1, 4, 1, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(76, 'testA', '\nkernel/arch/arm/mm/mmu.c', 6, 0, 0, 948, 0, 0, 0, 0, 0, 0, 5, 4, 0, 3, 0, 3, 0, 66, 8, 3, 20, 0, 3, 2, 'AndroidPF'),
(77, 'testA', '\nkernel/drivers/video/msm/mdss/mdss_debug.c', 6, 0, 0, 1011, 0, 0, 0, 0, 0, 0, 10, 0, 0, 4, 0, 0, 0, 49, 1, 0, 1, 0, 0, 2, 'Display'),
(78, 'testA', '\nvendor/qcom/opensource/wlan/qcacld-2.0/CORE/HDD/src/wlan_hdd_cfg80211.c', 6, 0, 0, 8407, 0, 0, 0, 0, 0, 0, 4, 0, 0, 1, 0, 1, 0, 186, 1, 12, 1, 0, 0, 2, 'Connectivity'),
(79, 'testA', '\nframeworks/opt/net/wifi/service/jni/com_android_server_wifi_Gbk2Utf.cpp', 6, 0, 0, 531, 0, -1, -1, -1, -1, -1, -1, 0, 0, 2, 0, 2, 0, 29, 3, 4, 3, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(80, 'testA', '\nkernel/drivers/video/msm/mdss/mhl3/si_8620_drv.c', 6, 0, 0, 6829, 0, 0, 0, 0, 0, 0, 21, 1, 0, 10, 0, 0, 0, 53, 6, 45, 3, 0, 2, 2, 'Display'),
(81, 'testA', '\nsystem/netd/server/QcRouteController.cpp', 6, 0, 0, 240, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 18, 0, 7, 2, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(82, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/module/isp46/isp_pipeline46.c', 6, 0, 0, 376, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 6, 1, 1, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(83, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/scaler/scaler46/scaler46.c', 6, 0, 0, 1259, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 10, 1, 7, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(84, 'testA', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/module/isp_module.c', 6, 0, 0, 489, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 35, 1, 0, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE');

-- --------------------------------------------------------

--
-- テーブルの構造 `group_data`
--

CREATE TABLE IF NOT EXISTS `group_data` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `group_name` text NOT NULL,
  `defact_num` int(11) NOT NULL,
  `file_num` int(11) NOT NULL,
  `loc` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `group_data`
--

INSERT INTO `group_data` (`id`, `model`, `group_name`, `defact_num`, `file_num`, `loc`, `date`) VALUES
(1, 'testA', 'ã‚»ã‚­ãƒ¥ãƒªãƒE??', 0, 6, 11067, '2016-04-23'),
(2, 'testA', 'Miracast', 0, 5, 9110, '2016-04-23'),
(3, 'testA', 'å…ˆé€²ã‚«ãƒ¡ãƒ©', 0, 11, 23104, '2016-04-23'),
(4, 'testA', 'FeliCa/NFCã‚¢ãƒ—ãƒª', 0, 2, 309, '2016-04-23'),
(5, 'testA', 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE', 1, 22, 18105, '2016-04-23'),
(6, 'testA', 'QCRIL', 0, 2, 8614, '2016-04-23'),
(7, 'testA', 'Display', 1, 10, 18895, '2016-04-23'),
(8, 'testA', 'REGZA/Multimedia', 0, 1, 364, '2016-04-23'),
(9, 'testA', 'Connectivity', 0, 3, 13853, '2016-04-23'),
(10, 'testA', 'Audio', 0, 3, 5734, '2016-04-23'),
(11, 'testA', 'BSP', 0, 10, 13004, '2016-04-23'),
(12, 'testA', 'AndroidPF', 0, 4, 5127, '2016-04-23'),
(13, 'testA', 'GPSãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 2857, '2016-04-23'),
(14, 'testA', 'aDriver', 4, 1, 4518, '2016-04-23'),
(15, 'testA', 'é›»è©±', 0, 1, 332, '2016-04-23'),
(16, 'testA', 'mDriver', 0, 2, 1016, '2016-04-23'),
(17, 'testA', 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 163, '2016-04-23');

-- --------------------------------------------------------

--
-- テーブルの構造 `group_names`
--

CREATE TABLE IF NOT EXISTS `group_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `group_names`
--

INSERT INTO `group_names` (`id`, `name`) VALUES
(1, 'Audio'),
(2, 'BSP'),
(3, 'Connectivity'),
(4, 'Display'),
(5, 'FeliCa/NFCã‚¢ãƒ—ãƒª'),
(6, 'GPSãƒ‰ãƒ©ã‚¤ãƒE'),
(7, 'Miracast'),
(8, 'QCRIL'),
(9, 'REGZA/Multimedia'),
(10, 'aDriver'),
(11, 'mDriver'),
(12, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(13, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(14, 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE'),
(15, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(16, 'é›»è©±');

-- --------------------------------------------------------

--
-- テーブルの構造 `model_names`
--

CREATE TABLE IF NOT EXISTS `model_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `model_names`
--

INSERT INTO `model_names` (`id`, `name`) VALUES
(1, 'testA');

-- --------------------------------------------------------

--
-- テーブルの構造 `stickies`
--

CREATE TABLE IF NOT EXISTS `stickies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `page` varchar(32) CHARACTER SET utf8 NOT NULL,
  `color` varchar(7) CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL,
  `left` int(11) NOT NULL,
  `top` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` tinytext CHARACTER SET utf8 NOT NULL,
  `password` tinytext CHARACTER SET utf8 NOT NULL,
  `role` tinytext CHARACTER SET utf8 NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `group`) VALUES
(1, 'root', '918f4ef9e35af3bf2ff5d99310ba2f98bcda2a20', 'admin', 'ALL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `csvs`
--
ALTER TABLE `csvs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `graphs`
--
ALTER TABLE `graphs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_names`
--
ALTER TABLE `group_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_names`
--
ALTER TABLE `model_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stickies`
--
ALTER TABLE `stickies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `csvs`
--
ALTER TABLE `csvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `graphs`
--
ALTER TABLE `graphs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `group_names`
--
ALTER TABLE `group_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `model_names`
--
ALTER TABLE `model_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stickies`
--
ALTER TABLE `stickies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
