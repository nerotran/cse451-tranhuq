<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Load the settings from the central config file
require_once 'config.php';
// Load the CAS lib
require_once '../vendor/autoload.php';
require_once '../vendor/apereo/phpcas/CAS.php';

Route::get('/', function () {
    // Enable debugging
    phpCAS::setDebug('/tmp/cas');

    // Initialize phpCAS
    phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

    // For production use set the CA certificate that is the issuer of the cert
    // on the CAS server and uncomment the line below
    // phpCAS::setCasServerCACert($cas_server_ca_cert_path);

    // For quick testing you can disable SSL validation of the CAS server.
    // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
    // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
    phpCAS::setNoCasServerValidation();

    // force CAS authentication
    phpCAS::forceAuthentication();

    // at this step, the user has been authenticated by the CAS server
    // and the user's login name can be read with phpCAS::getUser().

    // logout if desired
    if (isset($_REQUEST['logout'])) {
        phpCAS::logout();
    }

    $user = phpCAS::getUser();
    return view('451',['user'=>$user]);
});
