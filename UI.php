<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dialog Finder</title>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js" type="text/javascript"></script>
    <!-- knockout -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js" type="text/javascript" charset="utf-8"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- mdl -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

    <!-- local -->
    <link rel="stylesheet" href="css/main.css">
    <script src="js/movieDataArray.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/main.js" type="text/javascript" charset="utf-8"></script>
</head>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header
            mdl-layout--fixed-tabs">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <span class="mdl-layout-title">Dialog Finder</span>
        </div>
        <!-- Tabs -->
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
            <a href="#fixed-tab-1" class="mdl-layout__tab is-active">About</a>
            <a href="#fixed-tab-2" class="mdl-layout__tab">Anime</a>
            <a href="#fixed-tab-3" class="mdl-layout__tab">Company</a>
            <a href="#fixed-tab-4" class="mdl-layout__tab">Director</a>
        </div>
    </header>
    <main class="mdl-layout__content">
        <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
            <div class="page-content" style="padding-top: 10em; text-align: center; font-size: 40px"> 
			This is the Front End Demonstration developed by Team YFZZ.
			<p>
			<?php
				header("Content-type: text/html; charset=utf-8");
				$serverName = "137.112.104.37"; //数据库服务器地址
				$uid = "zhaiz"; //数据库用户名
				$pwd = "555888austin"; //数据库密码
				$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"YFZZ");
				$conn = sqlsrv_connect( $serverName, $connectionInfo);
				if( $conn == false)
				{
					echo "连接失败！<br/>";
					die( print_r( sqlsrv_errors(), true));
				}else{
					echo "连接成功!";
				}
				$query = sqlsrv_query($conn, "select * from Episode");
				while($row = sqlsrv_fetch_array($query))
				{
					printf("%s\n",$row[3]);
					//	print_r($row);
				}
			?>
			
			</p>
			
</div>
</section>
<section class="mdl-layout__tab-panel" id="fixed-tab-2">
    <div class="page-content">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                    <th>Date Released</th>
                    <th>Summary</th>
                    <th>Company</th>
                    <th>Director</th>
                    <th>Episode</th>
                    <th>Search Volume</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">A anime</td>
                    <td>01/01/2000</td>
                    <td>A's summary</td>
                    <td>A company</td>
                    <td>The director</td>
                    <td>10</td>
                    <td>200000</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<section class="mdl-layout__tab-panel" id="fixed-tab-3">
    <div class="page-content">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                    <th>Date Founded</th>
                    <th>Website</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">A company</td>
                    <td>01/01/2000</td>
                    <td>www.acompany.com</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<section class="mdl-layout__tab-panel" id="fixed-tab-4">
    <div class="page-content">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">A director</td>
                    <td>01/01/2000</td>
                    <td>M</td>
                    <td>A's info</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
</main>
</div>

</main>
</div>