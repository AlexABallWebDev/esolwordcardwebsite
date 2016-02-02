<?php
/*
 *Author: Organized Anarchy
 *This script creates a connection to the ESOL word card database.
 *
 *
 */

$databaseUsername = 'anarchy_admin';
$databasePassword = 'FT=m8Ra6f.E"W53#';
$databaseHostname = 'localhost';
$databaseName = 'anarchy_esol';

$cnxn = @mysqli_connect($databaseHostname, $databaseUsername, $databasePassword,
												$databaseName)
				or die('<p class="form-error">Error connecting to database: ' .
								mysqli_connect_error() . '</p>');
//print('Connected.');