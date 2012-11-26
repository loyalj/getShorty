<?php
    require '../libs/flight/Flight.php';
    require '../libs/avdShortener/avdShorterner.php';

    Flight::route('/', function (){
        if(isset($_SESSION['flashError'])) {
            Flight::view()->set('flashMessage', $_SESSION['flashMessage']);
            Flight::view()->set('lastInput', $_SESSION['lastInput']); 
            session_unset();
        }
 
        Flight::render('landing', array(), 'bodyContent');
        Flight::render('layout');		
    });
   
    Flight::route('POST /', function (){
        
        if(isset($_POST['longURL'])) {
            
            $longURL = $_POST['longURL'];
            $apiOn = $_POST['api'] == 1;
            $isURL = filter_var($longURL, FILTER_VALIDATE_URL);
                
            if(!$isURL) {
                if($apiOn) {
                    Flight::view()->set('errorType', 'Invalid URL');
                    Flight::render('api-error');
                    exit;
                }
                else {
                    $_SESSION['flashError'] = true;
                    $_SESSION['flashMessage'] = 'Not a valid URL';
                    $_SESSION['lastInput'] = $longURL;
                    Flight::redirect('/');
                    exit;
                }
            }
            
            $shortener = Flight::shortener();
            $URLData = $shortener->generateURLData($longURL);
            
            if(!$shortener->isAlreadyHashed($URLData['hash'])) {
                $shortener->saveURLData($URLData);
            }

            if(!$apiOn){
                Flight::redirect('/s/' . $URLData['hash']); 
                exit;
            }
                            
            Flight::view()->set('longURL', $URLData['longURL']);
            Flight::view()->set('shortURL', $URLData['shortURL']);
            Flight::view()->set('created', $URLData['created']);
            Flight::view()->set('hash', $URLData['hash']);
            Flight::render('api'); 
        }     
    });

    Flight::route('/s/@hash', function ($hash) {
        $shortener = Flight::shortener();

        if($shortener->isAlreadyHashed($hash)) {
            $URLData = $shortener->loadURLData($hash);
            
            Flight::view()->set('longURL', $URLData['longURL']);
            Flight::view()->set('shortURL', $URLData['shortURL']);
            Flight::view()->set('created', $URLData['created']);
            Flight::view()->set('hash', $hash);

            Flight::render('shortened', array(), 'bodyContent'); 
            Flight::render('layout');		
        }
    });
    
    Flight::route('/@hash', function ($hash) {
        $shortener = Flight::shortener();
        
        if($shortener->isAlreadyHashed($hash)) {
            $URLData = $shortener->loadURLData($hash);
            Flight::redirect($URLData['longURL']);
            exit;
        }
        else { 
            Flight::redirect('/');
            exit;
        }
    });

    session_start();

    //Grab some server infos    
    $baseHost = $_SERVER['HTTP_HOST'];
    $baseURL = 'http://' . $baseHost . '/';
    
    //Initiate, configure,  and run the microframework.
    $viewPath = '../views/' . $baseHost;
    if(!is_dir($viewPath)) {
        $viewPath = '../views/default';
    }

    $configPath = '../config/' . $baseHost;
    if(!is_dir($configPath)) {
        $configPath = '../config';
    }
    $configPath .= '/config.php';

    require_once($configPath);

    Flight::set('flight.views.path', $viewPath);
    
    Flight::register('shortener', 'avdShortener', array($baseURL));
    
    Flight::view()->set('baseHost', $baseHost);
    Flight::view()->set('baseURL', $baseURL);
    Flight::view()->set('pageTitle', $config['pageTitle']);
    Flight::view()->set('headerContent', $config['headerContent']);
    Flight::view()->set('bylineContent', $config['bylineContent']);
    
    Flight::start();
