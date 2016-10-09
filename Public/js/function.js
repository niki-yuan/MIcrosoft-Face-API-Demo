function trigger() {
    $("#file").trigger("click");
}
function trigger2() {
    $("#libfile").trigger("click")
}

function addface() {
    var element = "libfile";
    $("#imgdetail").html("Adding photo...");
    $.ajaxFileUpload({
        url: "?c=Index&a=addface",
        secureuri: false,
        async: false,
        fileElementId: element,
        dataType: "JSON",
        success: function (data) {
            data = eval("(" + data + ")");
            $("#imgdetail").html("Added successfully!");
            // alert(data);
            $("#libdetail").append("<img src='./Public/Library/" + data['filename'] + ".jpg' style='height:80%; width:100%'><div style='text-align:center'><p>FaceID:</p><p>[" + data['faceid'] + "]</p></div>");
            alert("Added successfully!");
        }
    });
}
// upload img to server and get img src through upload.php
function doupload() {

    $.ajaxFileUpload({
        url: "?c=Index&a=upload",
        secureuri: false,
        async: false,
        fileElementId: 'file',
        dataType: 'text',
        success: function (data) {
            if (data != "error") {
                $("#uploadimg").attr("src", data);//把获取的路径付给#uploadimg的src
            }
            document.getElementById("inputUrl").value = "";
        }
    })
}

function detect() {
    var img = $("#uploadimg")[0].src;
    var url = $("#inputUrl").val();
    if (url) {
        $("#uploadimg").attr("src", url);//把获取的路径付给#uploadimg的src
    } else {
        $("#uploadimg").attr("src", img);
    }
    $("#imgdetail").html("Detecting...");
    // alert(url);
    // alert(img);
    $.ajax({
        url: "?c=Index&a=facedetect",
        type: "POST",
        dataType: "JSON",
        data: {
            img: img,
            url: url
        },
        success: function (data) {

            // alert(JSON.stringify(data));
            var a = data.length + " faces detected.<br/>";
            $("#imgdetail").html(a);
            if (data.length > 1) {
                for (var i = 0; i < data.length; i++) {


                    var result = "FaceID: " + data[i]['faceId'] + "<br/>" + "Gender: " + data[i]['faceAttributes']["gender"] + "<br/>Age: " + data[i]['faceAttributes']['age'] + "<br/>FaceRectangle: <br/>" + JSON.stringify(data[i]['faceRectangle']) + "<br/>FaceLandmarks: " + JSON.stringify(data[i]['faceLandmarks']) + "<br/>";
                    // {<br/>top: " + data[i]['faceRectangle']['top'] + ",<br/>left:" + data[0]['faceRectangle']["left"] + ",<br/>width: " + data[0]['faceRectangle']['width'] +",<br/>height: " + data[0]['faceRectangle']['height'] 
                    $("#imgdetail").append(result);
                }
            }
            else if (data.length == 1) {
                $("#imgdetail").html(data.length + " face detected.<br/>");
                var result = "FaceID: " + data[0]['faceId'] + "<br/>" + "Gender: " + data[0]['faceAttributes']["gender"] + "<br/>Age: " + data[0]['faceAttributes']['age'] + "<br/>FaceRectangle: <br/>" + JSON.stringify(data[0]['faceRectangle']) + "<br/>FaceLandmarks: " + JSON.stringify(data[0]['faceLandmarks']) + "<br/>";
                // {<br/>top: " + data[i]['faceRectangle']['top'] + ",<br/>left:" + data[0]['faceRectangle']["left"] + ",<br/>width: " + data[0]['faceRectangle']['width'] +",<br/>height: " + data[0]['faceRectangle']['height'] 
                $("#imgdetail").append(result);
            }
            else {
                $("#imgdetail").html("No face detected!");
            }

        }

    });
}



function match() {
    var img = $("#uploadimg")[0].src;
    var url = $("#inputUrl").val();
    if (url) {
        $("#uploadimg").attr("src", url);//把获取的路径付给#uploadimg的src
    } else {
        $("#uploadimg").attr("src", img);
    }
    $("#imgdetail").html("Matching...");
    $.ajax({
        url: "?c=Index&a=facedetect",
        type: "POST",
        dataType: "JSON",
        data: {
            img: img,
            url: url
        },
        success: function (data) {
            // alert(data[0]['faceId']);
            $.ajax({
                url: "?c=Index&a=match",
                type: "POST",
                async: false,
                dataType: "JSON",
                data: {
                    img: data[0]['faceId']//传faceid给match()->findsimilar API
                },
                success: function (data) {
                    // alert(data['faceresult'].length);
                    // alert(data['match'].length);
                    $("#imgdetail").html("");
                    // alert(JSON.stringify( data['detectface']);
                    // $("#detectimg")[0].src = data['detectface'];
                    if(data['match'].length>1){
                        var result = data['match'].length + " faces matched" + ".<br/>";
                    }else {
                        var result = data['match'].length + " face matched" + ".<br/>";
                    }
                        $("#imgdetail").append(result);
                    for (var i = 0; i < data['match'].length; i++) {
                        $("#imgdetail").append("<img src='./Public/Library/" + data['match'][i]['filename'] + ".jpg' style='height:80%; width:100%'><div style='text-align:center'><p>FaceID:</p><p>[" + data['match'][i]['faceid'] + "]</p></div>");
                    }
                    

                    // if (data.length > 1) {
                    //     var result = data.length + " faces matched" + ".<br/>";
                    // } else {
                    //     var result = data.length + " face matched" + ".<br/>";
                    // }
                    // for (var i = 0; i < data.length; i++) {

                    //     result += "Face" + (i + 1) + "'s 'faceid'：" + data[i]['persistedFaceId'] + " <br/> Confidence: " + data[i]['confidence'] * 100 + "%</br>";
                    // }

                    // $("#imgdetail").html(result);
                }
            });
        }
    });
}