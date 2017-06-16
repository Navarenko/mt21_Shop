<?php
header('Content-Type: text/html; charset=utf-8');


if (isset($_GET['phpinfo'])) {
    phpinfo();
    exit;
}
?>
    <!--Original code - JV System Test-->
    <html>

    <head>

        <style>
            body, td {
                font-size:70%;
                font-family:verdana, helvetica, arial;
            }

            div.main {
                width:500px;
                text-align:left;
                top:20px;
                position:relative;
                border:2px solid #F0F0F0;
                padding:20px;
            }

            }
        </style>

        <meta http-equiv="Content-type" content="text/html;charset=UTF-8">

        <title>
            Тест системы
        </title>

    </head>

    <body>
    <div align="center">
        <div class="main">

            <center>
                <h2>Тест системы</h2>
                Этот тест поможет вам понять будут ли работать лицензионные модули от <a href="https://opencartforum.com/index.php?app=core&module=search&do=user_activity&search_app=downloads&mid=20577">louise170</a> на вашем сервере. Запускайте этот файл на вашем хостинге, там где находится ваш реальный рабочий сайт.
                <br />
                <br />
                <br />
                <br />
                <br />
            </center>

            <table width="100%">
                <tr>
                    <td>
                        <h3>Версия PHP: </h3>
                    </td>
                    <td>
                        <h3>IonCube Loader: </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if (!defined('PHP_VERSION_ID')) {
                            $version = explode('.', PHP_VERSION);
                            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
                        }

                        if ( PHP_VERSION_ID >= 50300 )  {
                            $phpversion_str = '<font color="green">' . phpversion() . '</font>';
                            $status_phpversion_str = '<b><font color="green">OK</font></b>';
                        }
                        else {
                            $phpversion_str = '<font color="red">' . phpversion() . '</font>';
                            $status_phpversion_str = '<b><font color="red">Bad (Не подходит)</font></b>';
                        }
                        ?>
                        <br />
                        <b>Необходимо:</b> 5.3.x или выше
                        <br />
                        <br />
                        <b>Ваша версия:</b> <?php echo $phpversion_str; ?>
                        <br />
                        <br />
                        <b>Статус:</b> <?php echo $status_phpversion_str; ?>
                    </td>
                    <td>
                        <?php
                        $ioncube_loader_version = ioncube_loader_version_array();

                        if ($ioncube_loader_version and isset($ioncube_loader_version['version'])) {
                            $ioncube_version_str = '<font color="green">ver. ' . $ioncube_loader_version['version'] . '</font>';

                            if ($ioncube_loader_version['major'] >= 5) {
                                $status_ioncube_str = '<b><font color="green">OK</font></b>';
                            }
                            else {
                                $status_ioncube_str = '<b><font color="red">Bad (Не подходит)</font></b>';
                            }
                        }
                        else {
                            $ioncube_version_str = '<font color="red">Not Installed</font>';
                            $status_ioncube_str = '<b><font color="red">Bad (Не подходит)</font></b>';
                        }
                        ?>
                        <br />
                        <b>Необходимо:</b> 5.x или выше
                        <br />
                        <br />
                        <b>Ваша версия:</b> <?php echo $ioncube_version_str; ?>
                        <br />
                        <br />
                        <b>Статус:</b> <?php echo $status_ioncube_str; ?>
                </tr>
            </table>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            Более подробная информация о том, что установлено у вас на сервере: <a href="<?php echo $_SERVER['PHP_SELF']; ?>?phpinfo=1" target="_blank">PHP info </a>
        </div>
    </div>
    </body>
    </html>

<?php
function ioncube_loader_version_array () {
    if (extension_loaded("ionCube Loader")) {

        if ( function_exists('ioncube_loader_iversion') ) {
            // Mmmrr
            $ioncube_loader_iversion = ioncube_loader_iversion();
            $ioncube_loader_version_major = (int)substr($ioncube_loader_iversion,0,1);
            $ioncube_loader_version_minor = (int)substr($ioncube_loader_iversion,1,2);
            $ioncube_loader_version_revision = (int)substr($ioncube_loader_iversion,3,2);
            $ioncube_loader_version = "$ioncube_loader_version_major.$ioncube_loader_version_minor.$ioncube_loader_version_revision";
        }
        elseif ( function_exists('ioncube_loader_version') ) {
            $ioncube_loader_version = ioncube_loader_version();
            $ioncube_loader_version_major = (int)substr($ioncube_loader_version,0,1);
            $ioncube_loader_version_minor = (int)substr($ioncube_loader_version,2,1);
        }

        return array(
            'version'=>$ioncube_loader_version,
            'major'=>$ioncube_loader_version_major,
            'minor'=>$ioncube_loader_version_minor
        );

    }
    else {
        return false;
    }
}
?>