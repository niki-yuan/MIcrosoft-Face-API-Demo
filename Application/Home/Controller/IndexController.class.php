<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $faceObj = M("face");
        $face = $faceObj->select();
        $this->assign("library", $face);
        $this->display();
    }

    // public function match() {
    //     //上传
    //     $filename = md5(time());
    //     $upload = new \Think\Upload();// 实例化上传类
	// 	$upload->maxSize   =    3145728 ;// 设置附件上传大小    
	// 	$upload->exts      =    array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	// 	$upload->rootPath  =	'Public/';
	// 	$upload->savePath  =    'Uploads/'; // 设置附件上传目录
	// 	$upload->saveName  =    $filename;
	// 	$upload->saveExt = 'jpg';
	// 	$upload->subName = "";
	// 	$upload->replace = true;
	// 	$upload->hash = false;
	// 	$info = $upload->upload();
	// 	if (!$info) {
	// 		$msg['code'] = 0;
	// 		$msg['msg'] = $upload->getError();
    //         $this->ajaxReturn($msg);
	// 	} else {
    //         //上传成功
    //         $face = './Public/Uploads/'.$filename.".jpg";
    //         $result = faceDetect($face);
    //         $result = json_decode($result, true);
    //         $faceid = $result[0]['faceId'];
    //         $result = findSimilar($faceid, "craigfacelist");
    //         $result = json_decode($result, true);
    //         $tmp = array();
    //         for ($i=0; $i<count($result); $i++) {
    //             $faceObj = M("face");
    //             $faceresult = $faceObj->where("faceid='{$result[$i]['persistedFaceId']}'")->find();
    //             if ($faceresult) {
    //                 $tmp[] = $faceresult;
    //             }
    //         }
    //         $result = array("detectface" => $face, "match"=>$tmp);
    //         echo json_encode($result);
    //     }
    // }

    // public function lib() {
    //     //上传
    //     $filename = md5(time());
    //     $upload = new \Think\Upload();// 实例化上传类
	// 	$upload->maxSize   =    3145728 ;// 设置附件上传大小    
	// 	$upload->exts      =    array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	// 	$upload->rootPath  =	'Public/';
	// 	$upload->savePath  =    'Library/'; // 设置附件上传目录
	// 	$upload->saveName  =    $filename;
	// 	$upload->saveExt = 'jpg';
	// 	$upload->subName = "";
	// 	$upload->replace = true;
	// 	$upload->hash = false;
	// 	$info = $upload->upload();
	// 	if (!$info) {
	// 		$msg['code'] = 0;
	// 		$msg['msg'] = $upload->getError();
    //         $this->ajaxReturn($msg);
	// 	} else {
    //         //上传成功,添加到facelist
	// 		$face = './Public/Library/'.$filename.".jpg";
    //         $result = addFaceToList($face, "craigfacelist", "test", "");
    //         $result = json_decode($result, true);
    //         //写入数据库
    //         if (!$result['error']) {
    //             $faceObj = M("face");
    //             $data['filename'] = $filename;
    //             $data['faceid'] = $result['persistedFaceId'];
    //             $faceObj->add($data);
    //             $data['code'] = 2;
    //             echo json_encode($data);
    //         }
	// 	}
    // }
    public function addface(){
        //上传到本地Library文件夹
        
        $filename = md5(time());
        $upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =    3145728 ;// 设置附件上传大小    
		$upload->exts      =    array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =	'Public/';
		$upload->savePath  =    'Library/'; // 设置附件上传目录
		$upload->saveName  =    $filename;
		$upload->saveExt = 'jpg';
		$upload->subName = "";
		$upload->replace = true;
		$upload->hash = false;
		$info = $upload->upload();
		if (!$info) {
			$msg['code'] = 0;
			$msg['msg'] = $upload->getError();
            $this->ajaxReturn($msg);
		} else {
            //上传成功,添加到facelist
			$face = './Public/Library/'.$filename.".jpg";
           
            $request = httpRequest2('https://api.projectoxford.ai/face/v1.0/facelists/niki_facelist/persistedFaces');
            $url = $request->getUrl();


            //Disable ssl_verify
            $request->setConfig(array(
                ssl_verify_peer => FALSE,
                ssl_verify_host => FALSE
            ));


                $headers = array(
                // Request headers  
                'Content-Type' => 'application/octet-stream', 
                'Ocp-Apim-Subscription-Key' => '96060369074848c393e85064176662af',
                );
                $imgBinaryData = file_get_contents($face);//convert img to binary data
    

            $request->setHeader($headers);

            $parameters = array(
                // Request parameters
                'userData' => 'test',
                'targetFace' => '',
            );

            $url->setQueryVariables($parameters);

            $request->setMethod("POST");

            // Request body
  
            $request->setBody($imgBinaryData);

            try
            {
                $response = $request->send();
                $result = $response->getBody();//返回“persistedFaceId”
                // echo $result;
            }
            catch (HttpException $ex)
            {
                echo $ex;
            }
            // $result = addFaceToList($face, "craigfacelist", "test", "");
            
            $result = json_decode($result, true);
            //写入数据库
            if (!$result['error']) {
                $faceObj = M("face");
                $data['filename'] = $filename;
                $data['faceid'] = $result['persistedFaceId'];
                $faceObj->add($data);
                $data['code'] = 2;
                echo json_encode($data);
            }
		}
        
    }
    public function upload(){
        $name = md5(time());;
        $upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =    3145728 ;// 设置附件上传大小    
		$upload->exts      =    array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =	'Public/';
		$upload->savePath  =    'Uploads/'; // 设置附件上传目录
		$upload->saveName  =    $name;
		$upload->saveExt = 'jpg';
		$upload->subName = "";
		$upload->replace = true;
		$upload->hash = false;
		$info = $upload->upload();
        // print_r($info);
        if (!$info) {
			$msg['code'] = 0;
			$msg['msg'] = $upload->getError();
            $this->ajaxReturn($msg);
		} else {
            //上传成功,返回url
			$face = 'Public/Uploads/'.$name.".jpg";
            echo $face;
                // echo json_encode($face);
                // print_r($face);
            }
	}
    public function facedetect(){
            // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
            //require_once 'HTTP/Request2.php';
            $request = httpRequest2('https://api.projectoxford.ai/face/v1.0/detect');
            //$request = $data['request'];
            //$request = new Http_Request2('https://api.projectoxford.ai/face/v1.0/detect');
            $url = $request->getUrl();

            //Disable ssl_verify
            $request->setConfig(array(
                ssl_verify_peer => FALSE,
                ssl_verify_host => FALSE
            ));

            // $imgBinaryData = file_get_contents($_POST['img']);//convert img to binary data
            // $inputurl=$_POST['url'];
            if($_POST['url']){
                $headers = array(
                // Request header 
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => '96060369074848c393e85064176662af',
                );
                $inputurl=$_POST['url'];
            } else{
                $headers = array(
                // Request headers  
                'Content-Type' => 'application/octet-stream', 
                'Ocp-Apim-Subscription-Key' => '96060369074848c393e85064176662af',
                );
                $imgBinaryData = file_get_contents($_POST['img']);//convert img to binary data
            }


            $request->setHeader($headers);

            $parameters = array(
                // Request parameters
                'returnFaceId' => 'true',
                'returnFaceLandmarks' => 'true',
                'returnFaceAttributes' => 'age,gender',
            );

            $url->setQueryVariables($parameters);

            //$request->setMethod(HTTP_Request2::METHOD_POST);
            $request->setMethod("POST");

            // Request body
            if($inputurl){
                $request->setBody("{'url':'$inputurl'}");
                
            } else{
                
            $request->setBody($imgBinaryData);
            }

            try
            {
                $response = $request->send();
                echo $response->getBody(); //各种face attributes
            }
            catch (HttpException $ex)
            {
                echo $ex;
            }
    }
    
    public function match(){
        // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
        // require_once 'HTTP/Request2.php';
            //上传成功
            // $face = './Public/Uploads/'.$filename.".jpg";
            // $result = faceDetect();
            // $result = json_decode($result, true);
            // $faceid = $result[0]['faceId'];
            // $result = findSimilar($faceid, "craigfacelist");
             $request = httpRequest2('https://api.projectoxford.ai/face/v1.0/findsimilars');
                $url = $request->getUrl();
                //Disable ssl_verify
                $request->setConfig(array(
                    ssl_verify_peer => FALSE,
                    ssl_verify_host => FALSE
                ));

                $headers = array(
                    // Request headers
                    'Content-Type' => 'application/json',
                    'Ocp-Apim-Subscription-Key' => '96060369074848c393e85064176662af',
                );

                $request->setHeader($headers);

                $parameters = array(
                    // Request parameters
                );

                $url->setQueryVariables($parameters);

                $request->setMethod("POST");

                // Request body
                $body = array(
                    
                    "faceId" => $_POST['img'],//传faceid
                    "faceListId"=>"niki_facelist",  
                    "maxNumOfCandidatesReturned" =>1000,
                    "mode" => "matchPerson"

                );
                $request->setBody(json_encode($body));

                try
                {
                    $response = $request->send();
                    $result = $response->getBody();//返回“persistedFaceId” & “Confidence”
                }
                catch (HttpException $ex)
                {
                    echo $ex;
                }

            $result = json_decode($result, true);//接受一个 JSON 编码的字符串并且把它转换为 PHP 变量,此处为php数组
            $tmp = array();
            for ($i=0; $i<count($result); $i++) {
                $faceObj = M("face");
                //数据库中查询相同faceID
                $faceresult = $faceObj->where("faceid='{$result[$i]['persistedFaceId']}'")->find();
                //
                if ($faceresult) {
                    //存储查询结果数组
                    $tmp[] = $faceresult;
                }
            }
            $result = array("faceresult" => $result, "match"=>$tmp);
            echo json_encode($result);

       
    }
    
}