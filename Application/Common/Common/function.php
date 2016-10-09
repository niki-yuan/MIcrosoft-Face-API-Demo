<?php
// @define( KEY,       "96060369074848c393e85064176662af");
// @define( JSON,      "application/json");
// @define( BINARY,    "application/octet-stream");

// function createFaceList($id) {
//     require_once 'HTTP/Request2.php';
//     $request = new Http_Request2("https://api.projectoxford.ai/face/v1.0/facelists/{$id}");
//     $url = $request->getUrl();
//     $request->setConfig(array(
//         'ssl_verify_peer'   => FALSE,
//         'ssl_verify_host'   => FALSE
//     ));
//     $headers = array(
//         // Request headers
//         'Content-Type' => JSON,
//         'Ocp-Apim-Subscription-Key' => KEY,
//     );
//     $request->setHeader($headers);
//     $parameters = array(
//         // Request parameters
//     );
//     $url->setQueryVariables($parameters);
//     $request->setMethod(HTTP_Request2::METHOD_PUT);
//     $body = array(
//         "name" => "craigfacelist",
//         "userData" => "This is a test face list created by craig"
//     );
//     $request->setBody(json_encode($body));
//     try {
//         $response = $request->send();
//         return  $response->getBody();
//     } catch (HttpException $ex) {
//         echo $ex;
//     }
// }

// function addFaceToList($face, $listId, $userData, $targetFace) {
//     require_once 'HTTP/Request2.php';
//     $request = new Http_Request2("https://api.projectoxford.ai/face/v1.0/facelists/{$listId}/persistedFaces");
//     $url = $request->getUrl();
//     $request->setConfig(array(
//         'ssl_verify_peer'   => FALSE,
//         'ssl_verify_host'   => FALSE
//     ));

//     $headers = array(
//     // Request headers
//         'Content-Type' => BINARY,
//         'Ocp-Apim-Subscription-Key' => KEY,
//     );
//     $request->setHeader($headers);
//     $parameters = array(
//         // Request parameters
//         'userData' => $userData,
//         'targetFace' => $targetFace,
//     );
//     $url->setQueryVariables($parameters);
//     $request->setMethod(HTTP_Request2::METHOD_POST);
//     // Request body

//     $imgBinaryData = file_get_contents($face);
//     $request->setBody($imgBinaryData);
//     try {
//         $response = $request->send();
//         return $response->getBody();
//     } catch (HttpException $ex) {
//         echo $ex;
//     }
// }

// function faceDetect($face) {
//     // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
//     require_once 'HTTP/Request2.php';

//     $request = new Http_Request2('https://api.projectoxford.ai/face/v1.0/detect');

//     $request->setConfig(array(
//         'ssl_verify_peer'   => FALSE,
//         'ssl_verify_host'   => FALSE
//     ));
//     $url = $request->getUrl();

//     $headers = array(
//         // Request headers
//         'Content-Type' => BINARY,
//         'Ocp-Apim-Subscription-Key' => KEY,
//     );

//     $request->setHeader($headers);

//     $parameters = array(
//         // Request parameters
//         'returnFaceId' => 'true',
//         'returnFaceLandmarks' => 'false',
//         'returnFaceAttributes' => 'age,gender',
//     );

//     $url->setQueryVariables($parameters);

//     $request->setMethod(HTTP_Request2::METHOD_POST);

//     $imgBinaryData = file_get_contents($face);

//     $request->setBody($imgBinaryData);

//     try
//     {
//         $response = $request->send();
//         return $response->getBody();
//     }
//     catch (HttpException $ex)
//     {
//         echo $ex;
//     }
// }

// function findSimilar($faceid, $listid) {
//     // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
//     require_once 'HTTP/Request2.php';

//     $request = new Http_Request2('https://api.projectoxford.ai/face/v1.0/findsimilars');
//     $url = $request->getUrl();

//     $request->setConfig(array(
//         'ssl_verify_peer'   => FALSE,
//         'ssl_verify_host'   => FALSE
//     ));

//     $headers = array(
//         // Request headers
//         'Content-Type' => JSON,
//         'Ocp-Apim-Subscription-Key' => KEY,
//     );

//     $request->setHeader($headers);

//     $parameters = array(
//         // Request parameters
//     );

//     $url->setQueryVariables($parameters);

//     $request->setMethod(HTTP_Request2::METHOD_POST);
//     $body_array = array(
//         "faceId"    => $faceid,
//         "faceListId"=> $listid,  
//         "maxNumOfCandidatesReturned"=>20,
//         "mode"=>"matchPerson"
//     );
//     // Request body
//     $request->setBody(json_encode($body_array));

//     try
//     {
//         $response = $request->send();
//         return $response->getBody();
//     }
//     catch (HttpException $ex)
//     {
//         echo $ex;
//     }
// }

function httpRequest2($url) {
    require_once 'HTTP/Request2.php';
    $request = new Http_Request2($url);
    return $request;
}
?>