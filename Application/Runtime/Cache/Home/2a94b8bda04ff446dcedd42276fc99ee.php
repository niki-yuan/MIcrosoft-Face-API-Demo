<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Face_Demo</title>
    <link href="/Demo/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">
        <div class="row" style="text-align:center;padding-top:20px">
            <div class="" style="border: 1px solid #1b809e;border-left-width: 5px;border-radius: 3px;">
                <h1>Face match Demo</h1>
            </div>
        </div>
        <div class="row" style="padding-top:20px;">
            <div class="col-md-4 col-sm-5" style="text-align:center">
                <h3>Photo to be detected:</h3>
            </div>
            <div class="col-md-4 col-sm-5" style="text-align:center">
                <h3>Results:</h3>
            </div>
            <div class="col-md-4 col-sm-5" style="text-align:center">
                <h3>Database:</h3>
            </div>
        </div>

        <div class="row" style="padding-top:20px">
            <!--<div class="col-md-12">-->
            <div class="col-md-4 col-sm-5" style="border:2px solid seagreen; height:400px;padding:0;">
                <img src="" id="uploadimg" style="height:100%; width:100%">
            </div>


            <div class="col-md-4 col-sm-5" style="border:2px solid seagreen; height:400px;padding:0; overflow: scroll;">
                <!--<img src="" id="matchedimg" style="height:100%; width:100%"/>-->
                <div id="imgdetail"></div>
            </div>
            <div class="col-md-4 col-sm-5" style="border:2px solid seagreen; height:400px;padding:0">

                <div id="libdetail" style="height:400px; overflow:auto;">
                    <?php if(is_array($library)): foreach($library as $key=>$v): ?><img src="./Public/Library/<?php echo ($v['filename']); ?>.jpg" style='height:80%; width:100%'>
                        <div style='text-align:center'>
                            <p>FaceID:</p>
                            <p>[<?php echo ($v['faceid']); ?>]</p>
                        </div><?php endforeach; endif; ?>
                </div>
            </div>
            <!--</div>-->
        </div>
        <div class="row" style="padding-top:20px">
            <div class="col-md-4 col-sm-6" style="text-align:center;">
                <input type="file" id="file" name="file" style="display:none" onchange="doupload()">
                <button type="button" id="uploadBtn" class="btn btn-success" onclick="trigger()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Open Image</button>
                <input type="text" id="inputUrl" style="width:60%;" placeholder="Or input image URL to detect"></input>
            </div>

            <div class="col-md-4 col-sm-5" style="text-align:center">
                <button type="button" id="detectBtn" class="btn btn-success" onclick="detect()"><span class="" aria-hidden="true"></span> Detect</button>
                <button type="button" id="matchBtn" class="btn btn-success" onclick="match()"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Match</button>
            </div>
            <div class="col-md-4 col-sm-4">
                <!--<div id="libdetail" style="height:400px; overflow:auto;"></div>-->
                <input type="file" id="libfile" name="libfile" style="display:none" onchange="addface()">
                <button type="button" id="addBtn" class="btn btn-success" onclick="trigger2()"><span class="" aria-hidden="true"></span> Add photo to dataBase</button>
            </div>
        </div>

    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/Demo/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Demo/Public/js/ajaxfileupload.js"></script>
    <script src="/Demo/Public/js/function.js"></script>
</body>

</html>