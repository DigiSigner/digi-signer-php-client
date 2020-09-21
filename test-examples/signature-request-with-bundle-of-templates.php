<?php

//require main DigiSigner API class
require_once('../DigiSignerClient.php');

//import needed classed from DigiSigner namespace
use DigiSigner\DigiSignerClient;
use DigiSigner\SignatureRequest;
use DigiSigner\DigiSignerException;
use DigiSigner\Document;
use DigiSigner\Signer;
use DigiSigner\Field;


try {
    //you can find your API key find in the settings of your DigiSigner account
    $client = new DigiSignerClient('YOUR_DIGISIGNER_API_KEY');
    
    // build signature request
    $request = new SignatureRequest;
    $request->setSendDocumentsAsBundle(true);
    $request->setBundleTitle('Document bundle');
    $request->setBundleSubject('Please sign');
    $request->setBundleMessage('Please sign my documents');
    
    // signer
    $signer = new Signer('signer@email.com');
    $signer->setRole('Signer 1');
    
    // document 1
    $document1 = Document::withId('TEMPLATE_ID_1');
    
    $document1->addSigner($signer);
    $request->addDocument($document1);
    
    // document 2
    $document2 = Document::withId('TEMPLATE_ID_2');
    
    $document2->addSigner($signer);
    $request->addDocument($document2);
    
    // send signature request
    $signatureRequest = $client->sendSignatureRequest($request);
    
    print_r($signatureRequest);
    
} catch(DigiSignerException $e) {
    echo "Some exception happened...\n";
    print("Status code: " .$e->getHttpCode()."\n");
    print("Message: ".$e->getMessage()."\n");
    print("Errors:\n");
    print_r($e->getErrors());
}