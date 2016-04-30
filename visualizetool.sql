-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016 年 4 朁E30 日 15:15
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
-- テーブルの構造 `graphs`
--

CREATE TABLE IF NOT EXISTS `graphs` (
  `id` int(11) NOT NULL,
  `upload_data_id` int(11) NOT NULL,
  `modelname_id` int(11) NOT NULL,
  `filepath` text CHARACTER SET utf8 NOT NULL,
  `0` text CHARACTER SET utf8 NOT NULL,
  `1` int(11) NOT NULL,
  `2` int(11) NOT NULL,
  `3` int(11) NOT NULL,
  `4` int(11) NOT NULL,
  `5` int(11) NOT NULL,
  `6` int(11) NOT NULL,
  `7` float NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=117135 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `graphs`
--

INSERT INTO `graphs` (`id`, `upload_data_id`, `modelname_id`, `filepath`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`) VALUES
(117051, 32, 6, 'bootable/bootloader/lk/platform/msm_shared/certificate.c', 'bootable/bootloader/lk/platform/msm_shared/certificate.c', 6, 0, 0, -1, -1, -1, -1, -1, -1, -1, -1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(117052, 32, 6, '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceVideoEncode.cpp', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceVideoEncode.cpp', 6, 0, 0, 2089, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 67, 0, 11, 0, 0, 0, 2, 'Miracast'),
(117053, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/sensors/chromatix/module/chromatix_sub_module.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/sensors/chromatix/module/chromatix_sub_module.c', 6, 0, 0, 620, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 13, 1, 0, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117054, 32, 6, '\npackages/apps/SmartCardService/src/org/simalliance/openmobileapi/service/security/arf/SecureElement.java', '\npackages/apps/SmartCardService/src/org/simalliance/openmobileapi/service/security/arf/SecureElement.java', 6, 0, 0, 89, 0, 0, 0.75, 21, 20, 11, 0, 0, 2, 0, 3, 0, 3, 22, 0, 11, 0, 3, 0, 2, 'FeliCa/NFCã‚¢ãƒ—ãƒª'),
(117055, 32, 6, '\nvendor/qcom/proprietary/telephony-apps/ims/src/org/codeaurora/ims/ImsConfigImpl.java', '\nvendor/qcom/proprietary/telephony-apps/ims/src/org/codeaurora/ims/ImsConfigImpl.java', 3, 0, 0, 89, 0, 2, 1.38462, 12, 54, 10, 0, 0, 0, 0, 0, 0, 0, 11, 0, 1, 0, 0, 0, 2, ''),
(117056, 32, 6, '\nhardware/qcom/camera/QCamera2/stack/mm-jpeg-interface/src/mm_jpeg_exif.c', '\nhardware/qcom/camera/QCamera2/stack/mm-jpeg-interface/src/mm_jpeg_exif.c', 6, 0, 0, 536, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 7, 1, 2, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117057, 32, 6, '\nvendor/qcom/proprietary/qcril/qcril_qmi/qcril.c', '\nvendor/qcom/proprietary/qcril/qcril_qmi/qcril.c', 6, 0, 0, 7906, 0, 0, 0, 0, 0, 0, 41, 0, 0, 88, 0, 0, 0, 116, 9, 45, 9, 0, 21, 2, 'QCRIL'),
(117058, 32, 6, '\nbootable/bootloader/lk/platform/msm_shared/sdhci_msm.c', '\nbootable/bootloader/lk/platform/msm_shared/sdhci_msm.c', 6, 0, 0, 676, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 17, 0, 5, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117059, 32, 6, '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSource.cpp', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSource.cpp', 6, 0, 0, 3687, 0, 0, 0, 0, 0, 0, 4, 7, 0, 0, 4, 0, 4, 83, 0, 11, 8, 0, 0, 2, 'Miracast'),
(117060, 32, 6, '\nhardware/qcom/display/liboverlay/overlayMdp.cpp', '\nhardware/qcom/display/liboverlay/overlayMdp.cpp', 6, 0, 0, 364, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 2, 0, 2, 41, 0, 18, 0, 0, 0, 2, 'Display;REGZA/Multimedia'),
(117061, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/afd/afd_port.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/afd/afd_port.c', 6, 0, 0, 833, 0, -1, -1, -1, -1, -1, -1, 0, 0, 6, 0, 6, 0, 18, 3, 3, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117062, 32, 6, '\nkernel/drivers/media/radio/silabs/radio-silabs.c', '\nkernel/drivers/media/radio/silabs/radio-silabs.c', 6, 0, 0, 1201, 0, 0, 0, 0, 0, 0, 80, 0, 0, 1, 0, 1, 0, 48, 2, 0, 0, 0, 1, 2, 'Connectivity'),
(117063, 32, 6, '\nkernel/sound/soc/msm/qdsp6v2/q6adm.c', '\nkernel/sound/soc/msm/qdsp6v2/q6adm.c', 6, 0, 0, 3175, 0, 0, 0, 0, 0, 0, 27, 0, 0, 0, 0, 0, 0, 47, 0, 22, 0, 0, 3, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117064, 32, 6, '\nvendor/qcom/proprietary/mm-audio/audio-acdb-util/acdb-loader/src/family-b/acdb-loader.c', '\nvendor/qcom/proprietary/mm-audio/audio-acdb-util/acdb-loader/src/family-b/acdb-loader.c', 6, 0, 0, 2961, 0, 0, 0, 0, 0, 0, 27, 0, 0, 0, 0, 0, 0, 35, 1, 3, 3, 0, 6, 2, 'Audio'),
(117065, 32, 6, '\nkernel/drivers/soc/qcom/socinfo.c', '\nkernel/drivers/soc/qcom/socinfo.c', 6, 0, 0, 751, 0, 0, 0, 0, 0, 0, 27, 0, 0, 1, 0, 1, 0, 21, 1, 8, 5, 0, 6, 2, 'BSP'),
(117066, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/asd/asd_port.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/asd/asd_port.c', 6, 0, 0, 1079, 0, 0, 0, 0, 0, 0, 10, 0, 0, 8, 0, 8, 0, 20, 3, 3, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117067, 32, 6, '\nexternal/wpa_supplicant_8/hostapd/src/eap_peer/eap_proxy_qmi.c', '\nexternal/wpa_supplicant_8/hostapd/src/eap_peer/eap_proxy_qmi.c', 3, 0, 0, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 2, ''),
(117068, 32, 6, '\nkernel/drivers/base/power/wakeup.c', '\nkernel/drivers/base/power/wakeup.c', 6, 0, 0, 534, 0, -1, -1, -1, -1, -1, -1, 0, 0, 3, 0, 3, 0, 51, 1, 8, 1, 0, 2, 2, 'BSP'),
(117069, 32, 6, '\nkernel/drivers/platform/msm/qpnp-power-on.c', '\nkernel/drivers/platform/msm/qpnp-power-on.c', 6, 0, 0, 1413, 0, 0, 0, 0, 0, 0, 28, 0, 0, 0, 0, 0, 0, 67, 1, 1, 0, 0, 3, 2, 'BSP'),
(117070, 32, 6, '\nkernel/kernel/sysctl.c', '\nkernel/kernel/sysctl.c', 6, 0, 0, 41, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 2, 'BSP'),
(117071, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/sub_module/isp_sub_module_port.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/sub_module/isp_sub_module_port.c', 6, 0, 0, 1802, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 24, 1, 3, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117072, 32, 6, '\nkernel/sound/soc/msm/qdsp6v2/msm-pcm-voice-v2.c', '\nkernel/sound/soc/msm/qdsp6v2/msm-pcm-voice-v2.c', 6, 0, 0, 659, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 47, 0, 0, 0, 0, 1, 2, 'Audio'),
(117073, 32, 6, '\nkernel/kernel/sched/core.c', '\nkernel/kernel/sched/core.c', 6, 0, 0, 2841, 0, -1, -1, -1, -1, -1, -1, 4, 0, 10, 0, 0, 0, 218, 7, 46, 16, 0, 2, 2, 'AndroidPF'),
(117074, 32, 6, '\nhardware/qcom/display/liboverlay/overlay.cpp', '\nhardware/qcom/display/liboverlay/overlay.cpp', 6, 0, 0, 533, 0, -1, -1, -1, -1, -1, -1, 1, 2, 0, 12, 0, 12, 79, 0, 20, 1, 2, 0, 2, 'Display'),
(117075, 32, 6, '\nvendor/qcom/opensource/wlan/qcacld-2.0/CORE/MAC/src/pe/lim/limSendManagementFrames.c', '\nvendor/qcom/opensource/wlan/qcacld-2.0/CORE/MAC/src/pe/lim/limSendManagementFrames.c', 6, 0, 0, 4245, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 110, 0, 19, 0, 0, 2, 2, 'Connectivity'),
(117076, 32, 6, '\nkernel/fs/read_write.c', '\nkernel/fs/read_write.c', 6, 0, 0, 844, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 46, 0, 15, 1, 0, 0, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(117077, 32, 6, '\nkernel/drivers/video/msm/mdss/mdss_hdmi_util.c', '\nkernel/drivers/video/msm/mdss/mdss_hdmi_util.c', 6, 0, 0, 806, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 12, 1, 10, 0, 0, 3, 2, 'Display'),
(117078, 32, 6, '\nkernel/arch/arm64/mm/mmap.c', '\nkernel/arch/arm64/mm/mmap.c', 6, 0, 0, 57, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(117079, 32, 6, '\nvendor/qcom/proprietary/qcril/qcril_qmi/qcril_qmi_imss.c', '\nvendor/qcom/proprietary/qcril/qcril_qmi/qcril_qmi_imss.c', 6, 0, 0, 708, 0, 0, 0, 0, 0, 0, 6, 0, 0, 10, 0, 0, 0, 29, 7, 1, 0, 0, 1, 2, 'QCRIL'),
(117080, 32, 6, '\nkernel/drivers/platform/msm/pft.c', '\nkernel/drivers/platform/msm/pft.c', 6, 0, 0, 1241, 0, 0, 0, 0, 0, 0, 17, 0, 0, 0, 0, 0, 0, 37, 0, 0, 0, 0, 2, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(117081, 32, 6, '\nkernel/drivers/cpufreq/cpufreq.c', '\nkernel/drivers/cpufreq/cpufreq.c', 6, 0, 0, 1868, 0, -1, -1, -1, -1, -1, -1, 1, 0, 4, 0, 4, 0, 90, 4, 19, 2, 0, 9, 2, 'BSP'),
(117082, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/q3a/af/af_port.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/stats/q3a/af/af_port.c', 6, 0, 0, 4226, 0, 0, 0, 0, 0, 0, 47, 0, 0, 54, 0, 54, 0, 21, 3, 3, 1, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117083, 32, 6, '\nkernel/drivers/media/platform/msm/camera_v2/sensor/io/msm_camera_cci_i2c.c', '\nkernel/drivers/media/platform/msm/camera_v2/sensor/io/msm_camera_cci_i2c.c', 6, 0, 0, 474, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117084, 32, 6, '\nkernel/drivers/clk/qcom/clock-pll.c', '\nkernel/drivers/clk/qcom/clock-pll.c', 6, 0, 0, 816, 0, -1, -1, -1, -1, -1, -1, 5, 0, 0, 0, 0, 0, 32, 0, 1, 5, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117085, 32, 6, '\nkernel/drivers/staging/android/ion/ion_cma_heap.c', '\nkernel/drivers/staging/android/ion/ion_cma_heap.c', 6, 0, 1, 235, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 24, 0, 2, 0, 0, 1, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117086, 32, 6, '\nvendor/qcom/opensource/location/loc_api/loc_api_v02/LocApiV02.cpp', '\nvendor/qcom/opensource/location/loc_api/loc_api_v02/LocApiV02.cpp', 6, 0, 0, 2857, 0, 1, 0.5, 1, 0, 2, 2, 0, 0, 0, 0, 0, 0, 71, 0, 4, 1, 0, 0, 2, 'GPSãƒ‰ãƒ©ã‚¤ãƒE'),
(117087, 32, 6, '\nkernel/drivers/leds/leds-qpnp.c', '\nkernel/drivers/leds/leds-qpnp.c', 6, 0, 4, 4518, 0, 0, 0, 0, 0, 0, 98, 1, 0, 0, 0, 0, 0, 87, 2, 0, 9, 0, 6, 2, 'aDriver'),
(117088, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/pproc-new/cpp/cpp_hw_params.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/pproc-new/cpp/cpp_hw_params.c', 6, 0, 0, 4847, 0, -1, -1, -1, -1, -1, -1, 0, 0, 1, 0, 0, 0, 21, 33, 11, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117089, 32, 6, '\npackages/apps/SmartCardService/openmobileapi/src/org/simalliance/openmobileapi/Session.java', '\npackages/apps/SmartCardService/openmobileapi/src/org/simalliance/openmobileapi/Session.java', 6, 0, 0, 220, 0, 0, 0.666667, 14, 44, 7, 0, 0, 0, 0, 0, 0, 0, 17, 0, 1, 0, 0, 0, 2, 'FeliCa/NFCã‚¢ãƒ—ãƒª'),
(117090, 32, 6, '\nvendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/vt/ImsCamera.java', '\nvendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/vt/ImsCamera.java', 6, 0, 0, 332, 0, 1, 0.205128, 13, 447, 29, 0, 0, 0, 0, 1, 0, 1, 41, 0, 1, 0, 0, 0, 2, 'é›»è©±'),
(117091, 32, 6, '\nkernel/drivers/soc/qcom/peripheral-loader.c', '\nkernel/drivers/soc/qcom/peripheral-loader.c', 6, 0, 0, 712, 0, 0, 0, 0, 0, 0, 26, 0, 0, 0, 0, 0, 0, 72, 1, 0, 0, 0, 1, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117092, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/iface2/iface_buf_mgr.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/iface2/iface_buf_mgr.c', 6, 0, 0, 845, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 16, 0, 17, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117093, 32, 6, '\nkernel/kernel/power/qos.c', '\nkernel/kernel/power/qos.c', 6, 0, 0, 465, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 45, 0, 3, 0, 0, 1, 2, 'BSP'),
(117094, 32, 6, '\nkernel/drivers/staging/android/logger.c', '\nkernel/drivers/staging/android/logger.c', 6, 0, 0, 849, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 1, 2, 'AndroidPF'),
(117095, 32, 6, '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceVideoCapture.cpp', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceVideoCapture.cpp', 6, 0, 0, 1545, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 61, 1, 8, 0, 0, 0, 2, 'Miracast'),
(117096, 32, 6, '\nframeworks/base/core/java/org/codeaurora/Performance.java', '\nframeworks/base/core/java/org/codeaurora/Performance.java', 6, 0, 0, 16, 0, 0, 0, 0, 26, 3, 0, 0, 0, 0, 1, 0, 1, 3, 0, 3, 0, 22, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117097, 32, 6, '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceAudioSource.cpp', '\nvendor/qcom/proprietary/wfd/mm/source/framework/src/WFDMMSourceAudioSource.cpp', 6, 0, 0, 1758, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 3, 0, 3, 72, 1, 8, 2, 0, 0, 2, 'Miracast'),
(117098, 32, 6, '\nkernel/drivers/misc/qseecom.c', '\nkernel/drivers/misc/qseecom.c', 6, 0, 0, 5971, 0, 0, 0, 0, 0, 0, 77, 0, 0, 6, 0, 2, 0, 98, 3, 5, 0, 0, 4, 2, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(117099, 32, 6, '\nframeworks/opt/telephony/src/java/com/android/internal/telephony/ModemStackController.java', '\nframeworks/opt/telephony/src/java/com/android/internal/telephony/ModemStackController.java', 6, 0, 0, 636, 0, 1, 1.71429, 60, 379, 18, 0, 0, 0, 0, 8, 0, 8, 87, 0, 10, 0, 1, 1, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117100, 32, 6, '\nkernel/drivers/leds/leds-qpnp-wled.c', '\nkernel/drivers/leds/leds-qpnp-wled.c', 6, 0, 0, 1577, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 52, 0, 0, 4, 0, 2, 2, 'Display'),
(117101, 32, 6, '\nhardware/qcom/camera/QCamera2/HAL/QCamera2HWICallbacks.cpp', '\nhardware/qcom/camera/QCamera2/HAL/QCamera2HWICallbacks.cpp', 6, 0, 0, 2432, 0, -1, -1, -1, -1, -1, -1, 0, 0, 21, 0, 21, 0, 86, 3, 9, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117102, 32, 6, '\nbootable/bootloader/lk/app/aboot/aboot.c', '\nbootable/bootloader/lk/app/aboot/aboot.c', 6, 0, 0, 2955, 0, 0, 0, 0, 0, 0, 11, 3, 0, 7, 0, 2, 0, 96, 2, 4, 11, 0, 4, 2, 'BSP;Display;ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(117103, 32, 6, '\nvendor/qcom/proprietary/qmi/platform/qmi_platform_qmux_io.c', '\nvendor/qcom/proprietary/qmi/platform/qmi_platform_qmux_io.c', 6, 0, 0, 527, 0, -1, -1, -1, -1, -1, -1, 1, 0, 1, 0, 0, 0, 34, 1, 5, 3, 0, 2, 2, 'mDriver'),
(117104, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/imglib/components/frameproc/frameproc_comp.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/imglib/components/frameproc/frameproc_comp.c', 6, 0, 0, 606, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 22, 1, 0, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117105, 32, 6, '\nkernel/drivers/mmc/host/sdhci.c', '\nkernel/drivers/mmc/host/sdhci.c', 6, 0, 0, 3676, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 2, 0, 117, 2, 4, 0, 0, 1, 2, 'BSP'),
(117106, 32, 6, '\nkernel/drivers/base/dma-contiguous.c', '\nkernel/drivers/base/dma-contiguous.c', 6, 0, 0, 398, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0, 0, 0, 0, 37, 1, 5, 2, 0, 9, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117107, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/sensors/module/sensor_frame_control.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/sensors/module/sensor_frame_control.c', 6, 0, 0, 709, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 15, 1, 4, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117108, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/pproc-new/vpe/vpe_hardware.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/pproc-new/vpe/vpe_hardware.c', 6, 0, 0, 635, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 20, 1, 6, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117109, 32, 6, '\nvendor/qcom/proprietary/wfd/wdsm/service/src/com/qualcomm/wfd/service/WfdService.java', '\nvendor/qcom/proprietary/wfd/wdsm/service/src/com/qualcomm/wfd/service/WfdService.java', 6, 0, 0, 31, 0, 1, 1, 8, 0, 3, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0, 0, 0, 2, 'Miracast'),
(117110, 32, 6, '\nhardware/qcom/camera/QCamera2/stack/mm-jpeg-interface/src/mm_jpeg.c', '\nhardware/qcom/camera/QCamera2/stack/mm-jpeg-interface/src/mm_jpeg.c', 6, 0, 0, 2274, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 57, 1, 5, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117111, 32, 6, '\nkernel/drivers/media/platform/msm/camera_v2/sensor/eeprom/msm_eeprom.c', '\nkernel/drivers/media/platform/msm/camera_v2/sensor/eeprom/msm_eeprom.c', 6, 0, 0, 1368, 0, -1, -1, -1, -1, -1, -1, 1, 0, 1, 0, 1, 0, 48, 1, 0, 2, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117112, 32, 6, '\nbootable/bootloader/lk/platform/msm_shared/display.c', '\nbootable/bootloader/lk/platform/msm_shared/display.c', 6, 0, 0, 387, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 6, 0, 4, 0, 0, 1, 2, 'Display'),
(117113, 32, 6, '\nkernel/sound/soc/msm/msm8994.c', '\nkernel/sound/soc/msm/msm8994.c', 6, 0, 0, 2114, 0, 0, 0, 0, 0, 0, 17, 0, 0, 0, 0, 0, 0, 109, 0, 0, 1, 0, 12, 2, 'Audio'),
(117114, 32, 6, '\nvendor/qcom/proprietary/sensors/dsps/libhalsensors/src/SensorsContext.cpp', '\nvendor/qcom/proprietary/sensors/dsps/libhalsensors/src/SensorsContext.cpp', 3, 0, 0, 1464, 0, -1, -1, -1, -1, -1, -1, 0, 0, 18, 0, 0, 0, 130, 2, 8, 0, 0, 1, 2, ''),
(117115, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/rolloff/mesh_rolloff44/mesh_rolloff44.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/rolloff/mesh_rolloff44/mesh_rolloff44.c', 6, 0, 0, 3032, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 27, 1, 21, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117116, 32, 6, '\nhardware/qcom/camera/QCamera2/HAL/QCameraPostProc.cpp', '\nhardware/qcom/camera/QCamera2/HAL/QCameraPostProc.cpp', 6, 0, 0, 2852, 0, -1, -1, -1, -1, -1, -1, 0, 0, 20, 0, 20, 0, 149, 2, 13, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117117, 32, 6, '\nkernel/drivers/video/msm/mdss/mdss_dsi_host.c', '\nkernel/drivers/video/msm/mdss/mdss_dsi_host.c', 6, 0, 1, 2197, 0, 0, 0, 0, 0, 0, 9, 1, 0, 0, 0, 0, 0, 73, 0, 12, 3, 0, 6, 2, 'Display'),
(117118, 32, 6, '\nkernel/lib/spinlock_debug.c', '\nkernel/lib/spinlock_debug.c', 6, 0, 0, 232, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 17, 0, 1, 0, 0, 0, 2, 'BSP'),
(117119, 32, 6, '\nkernel/drivers/soc/qcom/pil-q6v5-mss.c', '\nkernel/drivers/soc/qcom/pil-q6v5-mss.c', 6, 0, 0, 489, 0, 0, 0, 0, 0, 0, 6, 0, 0, 1, 0, 0, 0, 65, 2, 0, 0, 0, 1, 2, 'AndroidPF;mDriver'),
(117120, 32, 6, '\nkernel/drivers/video/msm/mdss/mdss_dsi.c', '\nkernel/drivers/video/msm/mdss/mdss_dsi.c', 6, 0, 0, 2236, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 117, 0, 0, 1, 0, 2, 2, 'Display'),
(117121, 32, 6, '\nkernel/drivers/usb/gadget/f_mtp.c', '\nkernel/drivers/usb/gadget/f_mtp.c', 6, 0, 0, 1069, 0, 0, 0, 0, 0, 0, 48, 0, 0, 0, 0, 0, 0, 55, 4, 5, 5, 0, 1, 2, 'BSP'),
(117122, 32, 6, '\nkernel/drivers/gpu/msm/adreno_cp_parser.c', '\nkernel/drivers/gpu/msm/adreno_cp_parser.c', 6, 0, 0, 666, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 0, 17, 0, 2, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117123, 32, 6, '\nkernel/drivers/thermal/lmh_interface.c', '\nkernel/drivers/thermal/lmh_interface.c', 6, 0, 0, 766, 0, 0, 0, 0, 0, 0, 28, 0, 0, 0, 0, 0, 0, 37, 0, 0, 0, 0, 3, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117124, 32, 6, '\nkernel/drivers/power/power_supply_sysfs.c', '\nkernel/drivers/power/power_supply_sysfs.c', 6, 0, 0, 163, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 13, 0, 0, 20, 0, 1, 2, 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE'),
(117125, 32, 6, '\nhardware/qcom/camera/QCamera2/stack/mm-camera-interface/src/mm_camera_interface.c', '\nhardware/qcom/camera/QCamera2/stack/mm-camera-interface/src/mm_camera_interface.c', 6, 0, 0, 1048, 0, -1, -1, -1, -1, -1, -1, 1, 0, 0, 0, 0, 0, 50, 1, 4, 1, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117126, 32, 6, '\nkernel/arch/arm/mm/mmu.c', '\nkernel/arch/arm/mm/mmu.c', 6, 0, 0, 948, 0, 0, 0, 0, 0, 0, 5, 4, 0, 3, 0, 3, 0, 66, 8, 3, 20, 0, 3, 2, 'AndroidPF'),
(117127, 32, 6, '\nkernel/drivers/video/msm/mdss/mdss_debug.c', '\nkernel/drivers/video/msm/mdss/mdss_debug.c', 6, 0, 0, 1011, 0, 0, 0, 0, 0, 0, 10, 0, 0, 4, 0, 0, 0, 49, 1, 0, 1, 0, 0, 2, 'Display'),
(117128, 32, 6, '\nvendor/qcom/opensource/wlan/qcacld-2.0/CORE/HDD/src/wlan_hdd_cfg80211.c', '\nvendor/qcom/opensource/wlan/qcacld-2.0/CORE/HDD/src/wlan_hdd_cfg80211.c', 6, 0, 0, 8407, 0, 0, 0, 0, 0, 0, 4, 0, 0, 1, 0, 1, 0, 186, 1, 12, 1, 0, 0, 2, 'Connectivity'),
(117129, 32, 6, '\nframeworks/opt/net/wifi/service/jni/com_android_server_wifi_Gbk2Utf.cpp', '\nframeworks/opt/net/wifi/service/jni/com_android_server_wifi_Gbk2Utf.cpp', 6, 0, 0, 531, 0, -1, -1, -1, -1, -1, -1, 0, 0, 2, 0, 2, 0, 29, 3, 4, 3, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117130, 32, 6, '\nkernel/drivers/video/msm/mdss/mhl3/si_8620_drv.c', '\nkernel/drivers/video/msm/mdss/mhl3/si_8620_drv.c', 6, 0, 0, 6829, 0, 0, 0, 0, 0, 0, 21, 1, 0, 10, 0, 0, 0, 53, 6, 45, 3, 0, 2, 2, 'Display'),
(117131, 32, 6, '\nsystem/netd/server/QcRouteController.cpp', '\nsystem/netd/server/QcRouteController.cpp', 6, 0, 0, 240, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 18, 0, 7, 2, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(117132, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/module/isp46/isp_pipeline46.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/module/isp46/isp_pipeline46.c', 6, 0, 0, 376, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 6, 1, 1, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117133, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/scaler/scaler46/scaler46.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/hw/scaler/scaler46/scaler46.c', 6, 0, 0, 1259, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 10, 1, 7, 0, 0, 0, 2, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(117134, 32, 6, '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/module/isp_module.c', '\nvendor/qcom/proprietary/mm-camera/mm-camera2/media-controller/modules/isp2/module/isp_module.c', 6, 0, 0, 489, 0, -1, -1, -1, -1, -1, -1, 0, 0, 0, 0, 0, 0, 35, 1, 0, 0, 0, 0, 2, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE');

-- --------------------------------------------------------

--
-- テーブルの構造 `group_data`
--

CREATE TABLE IF NOT EXISTS `group_data` (
  `id` int(11) NOT NULL,
  `model` varchar(255) CHARACTER SET utf8 NOT NULL,
  `group_name` text CHARACTER SET utf8 NOT NULL,
  `defact_num` int(11) NOT NULL,
  `file_num` int(11) NOT NULL,
  `loc` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `group_data`
--

INSERT INTO `group_data` (`id`, `model`, `group_name`, `defact_num`, `file_num`, `loc`, `date`) VALUES
(1, 'testA', 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE', 0, 420, 265543, '2016-04-30'),
(2, 'testA', 'AndroidPF', 0, 1189, 622630, '2016-04-30'),
(3, 'testA', 'é›»è©±', 0, 482, 245844, '2016-04-30'),
(4, 'testA', 'ãƒ–ãƒ©ã‚¦ã‚¶', 0, 211, 74848, '2016-04-30'),
(5, 'testA', 'Audio', 0, 124, 139028, '2016-04-30'),
(6, 'testA', 'AndroidMM', 0, 196, 50396, '2016-04-30'),
(7, 'testA', 'FeliCa/NFCã‚¢ãƒ—ãƒª', 0, 123, 66764, '2016-04-30'),
(8, 'testA', 'UIã‚°ãƒ«ãƒ¼ãƒEWLAN/BTãƒŸãƒ‰ãƒ«', 0, 11, 9733, '2016-04-30'),
(9, 'testA', 'ã‚¢ãƒ—ãƒª', 0, 219, 75561, '2016-04-30'),
(10, 'testA', 'Email', 0, 48, 29233, '2016-04-30'),
(11, 'testA', 'WLAN/BTãƒŸãƒ‰ãƒ«', 0, 225, 138874, '2016-04-30'),
(12, 'testA', 'ãƒªãƒ³ã‚¯ã‚¢ã‚°ãƒªã‚²ãƒ¼ã‚·ãƒ§ãƒ³', 0, 92, 62563, '2016-04-30'),
(13, 'testA', 'Connectivity', 0, 226, 269757, '2016-04-30'),
(14, 'testA', 'UIã‚°ãƒ«ãƒ¼ãƒE', 0, 766, 245421, '2016-04-30'),
(15, 'testA', 'DLNA', 0, 4, 15177, '2016-04-30'),
(16, 'testA', 'ã‚»ã‚­ãƒ¥ãƒªãƒE??', 0, 82, 55089, '2016-04-30'),
(17, 'testA', 'é›»è©±å¸³', 0, 321, 90696, '2016-04-30'),
(18, 'testA', 'REGZA/Multimedia', 0, 50, 80006, '2016-04-30'),
(19, 'testA', 'GUI', 0, 174, 47844, '2016-04-30'),
(20, 'testA', 'FOTA', 0, 85, 20470, '2016-04-30'),
(21, 'testA', 'BSP', 0, 233, 135531, '2016-04-30'),
(22, 'testA', 'Display', 0, 80, 138582, '2016-04-30'),
(23, 'testA', 'HCEã‚»ãƒ³ã‚·ãƒ³ã‚°', 0, 275, 159471, '2016-04-30'),
(24, 'testA', 'UIã‚°ãƒ«ãƒ¼ãƒEãƒ–ãƒ©ã‚¦ã‚¶', 0, 1, 1008, '2016-04-30'),
(25, 'testA', 'FEP', 0, 4, 4567, '2016-04-30'),
(26, 'testA', 'UIã‚°ãƒ«ãƒ¼ãƒEãƒ­ãƒE??', 0, 3, 2874, '2016-04-30'),
(27, 'testA', 'å…ˆé€²ã‚«ãƒ¡ãƒ©', 0, 1143, 477541, '2016-04-30'),
(28, 'testA', 'HCEè§¦è¦EAlpha)', 0, 16, 18235, '2016-04-30'),
(29, 'testA', 'åœ°ãƒE??ã‚¢ãƒ—ãƒªGr', 0, 153, 101419, '2016-04-30'),
(30, 'testA', 'CHAãƒŸãƒ‰ãƒ«', 0, 17, 16638, '2016-04-30'),
(31, 'testA', 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE', 0, 13, 19716, '2016-04-30'),
(32, 'testA', 'QCRIL', 0, 18, 96324, '2016-04-30'),
(33, 'testA', 'GPSãƒ‰ãƒ©ã‚¤ãƒE', 0, 4, 6441, '2016-04-30'),
(34, 'testA', 'UIã‚°ãƒ«ãƒ¼ãƒEå…ˆé€²ã‚«ãƒ¡ãƒ©', 0, 1, 10801, '2016-04-30'),
(35, 'testA', 'UIã‚°ãƒ«ãƒ¼ãƒEé›»è©±', 0, 5, 7411, '2016-04-30'),
(36, 'testA', 'UIã‚°ãƒ«ãƒ¼ãƒEã‚¢ãƒ—ãƒª', 0, 4, 6438, '2016-04-30'),
(37, 'testA', 'ã‚¿ãƒE??ãƒ‰ãƒ©ã‚¤ãƒE', 0, 22, 14859, '2016-04-30'),
(38, 'testA', 'MCã‚¢ãƒ—ãƒªGr', 0, 96, 17801, '2016-04-30'),
(39, 'testA', 'aDriver', 0, 43, 32762, '2016-04-30'),
(40, 'testA', 'ãƒ—ãƒ©é–EDTVãƒãƒ¥ãƒ¼ãƒE', 0, 36, 39082, '2016-04-30'),
(41, 'testA', 'mDriver', 0, 21, 6853, '2016-04-30'),
(42, 'testA', 'HCEè¦–è¦E', 0, 9, 3906, '2016-04-30'),
(43, 'testA', 'SIT', 0, 10, 8960, '2016-04-30'),
(44, 'testA', 'HCEç™–ç¿’?E', 0, 4, 960, '2016-04-30'),
(45, 'testA', 'ãƒ—ãƒ­ãƒˆã‚³ãƒ«', 0, 10, 3707, '2016-04-30'),
(46, 'testA', '', 0, 1, 49, '2016-04-30'),
(47, 'testA', 'SI', 0, 1, -1, '2016-04-30'),
(48, 'testA', 'ãƒ—ãƒ©é–EDTVãƒãƒ¥ãƒ¼ãƒEåœ°ãƒE??ã‚¢ãƒ—ãƒªGr', 0, 1, 854, '2016-04-30'),
(49, 'testA', 'Miracast', 0, 7, 17679, '2016-04-30'),
(50, 'testA', 'ã‚»ã‚­ãƒ¥ãƒªãƒE??', 0, 6, 11067, '2016-04-29'),
(51, 'testA', 'Miracast', 0, 5, 9110, '2016-04-29'),
(52, 'testA', 'å…ˆé€²ã‚«ãƒ¡ãƒ©', 0, 11, 23104, '2016-04-29'),
(53, 'testA', 'FeliCa/NFCã‚¢ãƒ—ãƒª', 0, 2, 309, '2016-04-29'),
(54, 'testA', 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE', 1, 22, 18105, '2016-04-29'),
(55, 'testA', 'QCRIL', 0, 2, 8614, '2016-04-29'),
(56, 'testA', 'Display', 1, 10, 18895, '2016-04-29'),
(57, 'testA', 'REGZA/Multimedia', 0, 1, 364, '2016-04-29'),
(58, 'testA', 'Connectivity', 0, 3, 13853, '2016-04-29'),
(59, 'testA', 'Audio', 0, 3, 5734, '2016-04-29'),
(60, 'testA', 'BSP', 0, 10, 13004, '2016-04-29'),
(61, 'testA', 'AndroidPF', 0, 4, 5127, '2016-04-29'),
(62, 'testA', 'GPSãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 2857, '2016-04-29'),
(63, 'testA', 'aDriver', 4, 1, 4518, '2016-04-29'),
(64, 'testA', 'é›»è©±', 0, 1, 332, '2016-04-29'),
(65, 'testA', 'mDriver', 0, 2, 1016, '2016-04-29'),
(66, 'testA', 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 163, '2016-04-29'),
(67, 'testA', 'ã‚»ã‚­ãƒ¥ãƒªãƒE??', 0, 6, 11067, '2016-04-13'),
(68, 'testA', 'Miracast', 0, 5, 9110, '2016-04-13'),
(69, 'testA', 'å…ˆé€²ã‚«ãƒ¡ãƒ©', 0, 11, 23104, '2016-04-13'),
(70, 'testA', 'FeliCa/NFCã‚¢ãƒ—ãƒª', 0, 2, 309, '2016-04-13'),
(71, 'testA', 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE', 1, 22, 18105, '2016-04-13'),
(72, 'testA', 'QCRIL', 0, 2, 8614, '2016-04-13'),
(73, 'testA', 'Display', 1, 10, 18895, '2016-04-13'),
(74, 'testA', 'REGZA/Multimedia', 0, 1, 364, '2016-04-13'),
(75, 'testA', 'Connectivity', 0, 3, 13853, '2016-04-13'),
(76, 'testA', 'Audio', 0, 3, 5734, '2016-04-13'),
(77, 'testA', 'BSP', 0, 10, 13004, '2016-04-13'),
(78, 'testA', 'AndroidPF', 0, 4, 5127, '2016-04-13'),
(79, 'testA', 'GPSãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 2857, '2016-04-13'),
(80, 'testA', 'aDriver', 4, 1, 4518, '2016-04-13'),
(81, 'testA', 'é›»è©±', 0, 1, 332, '2016-04-13'),
(82, 'testA', 'mDriver', 0, 2, 1016, '2016-04-13'),
(83, 'testA', 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE', 0, 1, 163, '2016-04-13');

-- --------------------------------------------------------

--
-- テーブルの構造 `group_names`
--

CREATE TABLE IF NOT EXISTS `group_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

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
(16, 'é›»è©±'),
(17, 'HCEè¦–è¦E'),
(18, 'HCEè§¦è¦EAlpha)'),
(19, 'MCã‚¢ãƒ—ãƒªGr'),
(20, 'Miracast'),
(21, 'QCRIL'),
(22, 'REGZA/Multimedia'),
(23, 'SI'),
(24, 'SIT'),
(25, 'UIã‚°ãƒ«ãƒ¼ãƒE'),
(26, 'UIã‚°ãƒ«ãƒ¼ãƒEWLAN/BTãƒŸãƒ‰ãƒ«'),
(27, 'UIã‚°ãƒ«ãƒ¼ãƒEã‚¢ãƒ—ãƒª'),
(28, 'UIã‚°ãƒ«ãƒ¼ãƒEãƒ–ãƒ©ã‚¦ã‚¶'),
(29, 'UIã‚°ãƒ«ãƒ¼ãƒEãƒ­ãƒE??'),
(30, 'UIã‚°ãƒ«ãƒ¼ãƒEå…ˆé€²ã‚«ãƒ¡ãƒ©'),
(31, 'UIã‚°ãƒ«ãƒ¼ãƒEé›»è©±'),
(32, 'WLAN/BTãƒŸãƒ‰ãƒ«'),
(33, 'aDriver'),
(34, 'mDriver'),
(35, 'ã‚¢ãƒ—ãƒª'),
(36, 'ã‚°ãƒ«ãƒ¼ãƒ—åãªãE'),
(37, 'ã‚»ã‚­ãƒ¥ãƒªãƒE??'),
(38, 'ã‚¿ãƒE??ãƒ‰ãƒ©ã‚¤ãƒE'),
(39, 'ãƒ–ãƒ©ã‚¦ã‚¶'),
(40, 'ãƒ—ãƒ©é–EDTVãƒãƒ¥ãƒ¼ãƒE'),
(41, 'ãƒ—ãƒ©é–EDTVãƒãƒ¥ãƒ¼ãƒEåœ°ãƒE??ã‚¢ãƒ—ãƒªGr'),
(42, 'ãƒ—ãƒ­ãƒˆã‚³ãƒ«'),
(43, 'ãƒªãƒ³ã‚¯ã‚¢ã‚°ãƒªã‚²ãƒ¼ã‚·ãƒ§ãƒ³'),
(44, 'å…E??ãƒ‰ãƒ©ã‚¤ãƒE'),
(45, 'å…ˆé€²ã‚«ãƒ¡ãƒ©'),
(46, 'åœ°ãƒE??ã‚¢ãƒ—ãƒªGr'),
(47, 'é›»è©±'),
(48, 'é›»è©±å¸³');

-- --------------------------------------------------------

--
-- テーブルの構造 `model_names`
--

CREATE TABLE IF NOT EXISTS `model_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `model_names`
--

INSERT INTO `model_names` (`id`, `name`) VALUES
(6, 'testA');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `upload_data`
--

CREATE TABLE IF NOT EXISTS `upload_data` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `modelname_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `upload_data`
--

INSERT INTO `upload_data` (`id`, `date`, `modelname_id`, `user_id`, `comment`) VALUES
(12, '2016-04-30', 6, 1, ''),
(31, '2016-04-29', 6, 1, ''),
(32, '2016-04-13', 6, 1, '');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `group`) VALUES
(1, 'root', '918f4ef9e35af3bf2ff5d99310ba2f98bcda2a20', 'admin', 'ALL');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `upload_data`
--
ALTER TABLE `upload_data`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `date` (`date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `graphs`
--
ALTER TABLE `graphs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=117135;
--
-- AUTO_INCREMENT for table `group_names`
--
ALTER TABLE `group_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `model_names`
--
ALTER TABLE `model_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `stickies`
--
ALTER TABLE `stickies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `upload_data`
--
ALTER TABLE `upload_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
