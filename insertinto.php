                                $Query="INSERT INTO battery (`SerialNo`,`CarNo`,`FirstTime`)
                                                SELECT `bat_SN1`,`AGVNo`,now()
                                                FROM agv_list
                                                WHERE `bat_SN1` NOT IN (SELECT `SerialNo` FROM battery) ;";
                               $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';     
                                $Query="INSERT INTO battery (`SerialNo`,`CarNo`,`FirstTime`)
                                                SELECT `bat_SN2`,`AGVNo`,now()
                                                FROM agv_list
                                                WHERE `bat_SN2` NOT IN (SELECT `SerialNo` FROM battery) ;";
                               $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';             
                                //更新電池訊息
                                $Query='update `battery` A,agv_list B set A.`CHG_AH`=B.CHG_AH1,A.`DSG_AH`=B.`DSG_AH1`,A.`CYCLE`=B.`CYCLE1`,A.`SOH`=B.`SOH1` WHERE A.`SerialNo`=B.`bat_SN1` and B.`CYCLE1` >0';
                               $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';
                                $Query='update `battery` A,agv_list B set A.`CHG_AH`=B.CHG_AH2,A.`DSG_AH`=B.`DSG_AH2`,A.`CYCLE`=B.`CYCLE2`,A.`SOH`=B.`SOH2` WHERE A.`SerialNo`=B.`bat_SN2` and B.`CYCLE2` >0';
                               $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';


                                還有一個battery_history 忘記附上SQL了

                                //自動建立開始充電時間
                                $Query="INSERT INTO battery_history (`cmdkey`,`SerialNo`,`CarNo`,`Charger_time`,End_time,`Start_SOC`,End_SOC)
                                SELECT `cmdkey`,`bat_SN1`,AGVNo,now(),now(),SOC1,SOC1
                                FROM agv_list
                                WHERE concat(`bat_SN1`,`cmdkey`) NOT IN (SELECT concat(`SerialNo`,`cmdkey`) FROM battery_history)  and `CarWork`=48";
                                $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';     
                                $Query="INSERT INTO battery_history (`cmdkey`,`SerialNo`,`CarNo`,`Charger_time`,End_time,`Start_SOC`,End_SOC)
                                SELECT `cmdkey`,`bat_SN2`,AGVNo,now(),now(),SOC2,SOC2
                                FROM agv_list
                                WHERE concat(`bat_SN2`,`cmdkey`) NOT IN (SELECT concat(`SerialNo`,`cmdkey`) FROM battery_history)  and `CarWork`=48";
                                $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';


                                $Query="INSERT INTO battery_history (`cmdkey`,`SerialNo`,`CarNo`,`Charger_time`,End_time,`Start_SOC`,End_SOC)
                                SELECT `cmdkey`,`bat_SN1`,AGVNo,now(),now(),SOC1,SOC1
                                FROM agv_list
                                WHERE concat(`bat_SN1`,`cmdkey`) NOT IN (SELECT concat(`SerialNo`,`cmdkey`) FROM battery_history)  and `CarWork`=48";
                                $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';     
                                $Query="INSERT INTO battery_history (`cmdkey`,`SerialNo`,`CarNo`,`Charger_time`,End_time,`Start_SOC`,End_SOC)
                                SELECT `cmdkey`,`bat_SN2`,AGVNo,now(),now(),SOC2,SOC2
                                FROM agv_list
                                WHERE concat(`bat_SN2`,`cmdkey`) NOT IN (SELECT concat(`SerialNo`,`cmdkey`) FROM battery_history)  and `CarWork`=48";
                                $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                echo $Query.":".$Result .'<br>';

                                $Query='update `battery_history` A,agv_list B 
                                set A.End_SOC=B.SOC1,A.`End_time`=now() 
                                WHERE A.`SerialNo`=B.`bat_SN1` and A.cmdkey=B.cmdkey and B.CarWork=48';
                                $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);
                                
                                $Query='update `battery_history` A,agv_list B 
                                set A.End_SOC=B.SOC2,A.`End_time`=now() 
                                WHERE A.`SerialNo`=B.`bat_SN2` and A.cmdkey=B.cmdkey and B.CarWork=48';
                                $Result = MySQL_UTF8_Function($Local_Host, $Local_User, $Local_Password, 'agv', "UPDATE", $Query);




-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2024 年 01 月 24 日 00:50
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lab_agv`
--

-- --------------------------------------------------------

--
-- 表的结构 `battery`
--

CREATE TABLE IF NOT EXISTS `battery` (
  `flag` int(11) NOT NULL,
  `SerialNo` varchar(50) NOT NULL,
  `CarNo` int(11) NOT NULL,
  `SOH` int(11) NOT NULL,
  `CHG_AH` int(11) NOT NULL,
  `DSG_AH` int(11) NOT NULL,
  `CYCLE` int(11) NOT NULL,
  `LC_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後充電時間',
  `FirstTime` datetime NOT NULL COMMENT '第一次充電時間',
  `note` varchar(50) NOT NULL,
  `shipment_time` datetime NOT NULL,
  `offline_time` datetime NOT NULL,
  PRIMARY KEY (`SerialNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `battery_history`
--

CREATE TABLE IF NOT EXISTS `battery_history` (
  `cmdkey` int(11) NOT NULL,
  `SerialNo` varchar(30) NOT NULL,
  `CarNo` int(11) NOT NULL,
  `Charger_time` datetime NOT NULL,
  `End_time` datetime NOT NULL,
  `Start_SOC` int(11) NOT NULL,
  `End_SOC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


