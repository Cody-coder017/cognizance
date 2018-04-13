<?php
require_once('includes/header_footers.php');
printHeader('install', []);
?>	
	<div class="content">
		<h1>Cognizance Installation</h1>
		<p>Installing the application will give you a full screen display app-like experience.
		</p>
		<p>There are 2 ways to install the application.</p>
		
		<h2>Adding to Home Screen</h2>
		<p>The simplest way to install the app is to <a href="https://developer.chrome.com/multidevice/android/installtohomescreen">Add to Home Screen</a>.</p>
		
		<h2>Installing from Android APK file</h2>
		<ol>
			<li><a href="https://gs4.gadgethacks.com/forum/enable-unknown-sources-android-install-apps-outside-play-store-0150603/">Enable installing from unknown sources</a>.</li>
			<li>Download <a href="downloads/app-release.apk">the apk file</a>.</li>
		</ol>
	</div>
<?php

printFooter();
?>