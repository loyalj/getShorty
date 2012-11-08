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
            
            $isURL = filter_var($longURL, FILTER_VALIDATE_URL);
            if(!$isURL) {
               $_SESSION['flashError'] = true;
               $_SESSION['flashMessage'] = 'Not a valid URL';
               $_SESSION['lastInput'] = $longURL;
               Flight::redirect('/');
               exit;
            }
            
            $shortener = Flight::shortener();
            $URLData = $shortener->generateURLData($longURL);
            
            if($shortener->isAlreadyHashed($URLData['hash']) == false) {
                $shortener->saveURLData($URLData);
            }
            else {
                $URLData = $shortener->loadURLData($URLData['hash']);
            }
            
            Flight::redirect('/s/' . $URLData['hash']); 
        }     
    });

    Flight::route('/s/@hash', function ($hash) {
        $shortener = Flight::shortener();

        if($shortener->isAlreadyHashed($hash)) {
            $URLData = $shortener->loadURLData($hash);
            
            Flight::view()->set('longURL', $URLData['longURL']);
            Flight::view()->set('shortURL', $URLData['shortURL']);
            Flight::view()->set('created', $URLData['created']);

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
    //Initiate, configure,  and run the microframework.
    Flight::set('flight.views.path', '../views');
    
    Flight::register('shortener', 'avdShortener', array('http://dblpl.us/'));
    Flight::view()->set('pageTitle', '++Good: ++Fast, ++Easy');
    Flight::view()->set('headerContent', 'Double Plus Good');
    Flight::start();
