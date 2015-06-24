<!DOCTYPE html>
<html lang="en">
<head>
<style type="text/css">
	#drop_area{width:100%; height:100px; border:3px dashed silver; line-height:100px; text-align:center; font-size:36px; color:#d3d3d3}
    #loading{margin: 0 auto;position: absolute;top: 50px;left: 50%;margin-left: -50px;display: none;font-size: 12px;}
    #loading p{margin: 0 auto;text-align: center;}
</style>
<script type="text/javascript" src="./jquery.min.js"></script>
</head>
<body>
	<div id="drop_area">将zip文件拖拽到此区域</div>
    <div id="loading"><img src="./images/loading.gif"><br><p>文件上传解压中</p></div>
</body>
<script type="text/javascript">
$(function(){ 
    //阻止浏览器默认行。 
    $(document).on({ 
        dragleave:function(e){    //拖离 
            e.preventDefault(); 
        }, 
        drop:function(e){  //拖后放 
            e.preventDefault(); 
        }, 
        dragenter:function(e){    //拖进 
            e.preventDefault(); 
        }, 
        dragover:function(e){    //拖来拖去 
            e.preventDefault(); 
        } 
    });

    var box = document.getElementById('drop_area'); //拖拽区域 
    box.addEventListener("drop",function(e){ 
        e.preventDefault(); //取消默认浏览器拖拽效果
        $('#drop_area').html('');
        $('#loading').show();
        var fileList = e.dataTransfer.files; //获取文件对象
        //检测是否是拖拽文件到页面的操作 
        if(fileList.length == 0){ 
            return false; 
        } 
        //检测文件是不是图片 
        if(fileList[0].name.indexOf('zip') === -1){ 
            alert("您拖的不是zip！"); 
            return false; 
        } 
         
        // //拖拉图片到浏览器，可以实现预览功能 
        // var img = window.webkitURL.createObjectURL(fileList[0]); 
        // var filename = fileList[0].name; //图片名称 
        // var filesize = Math.floor((fileList[0].size)/1024);  
        // if(filesize>500){ 
        //     alert("上传大小不能超过500K."); 
        //     return false; 
        // } 
        // var str = "<img src='"+img+"'><p>图片名称："+filename+"</p><p>大小："+filesize+"KB</p>"; 
        // $("#preview").html(str); 
         
        //上传 
        xhr = new XMLHttpRequest(); 
        xhr.open("post", "index.php", true); 
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
         
        var fd = new FormData(); 
        fd.append('myzip', fileList[0]); 

        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                $('#loading').hide();
                $('#drop_area').html('将zip文件拖拽到此区域');
                window.open('http://localhost/test/test');
            }
        }
        xhr.send(fd); 

    },false); 
}); 
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$myzip = $_FILES["myzip"];

	if(!empty($myzip)){ 
	    $zipname = $_FILES['myzip']['name']; 
	    $zipsize = $_FILES['myzip']['size']; 
	    if ($zipsize > 5120000) { 
	        echo 'zip大小不能超过5M'; 
	        exit; 
	    } 
	    $type = strstr($zipname, '.'); 
	    // if ($type != ".gif" && $type != ".jpg") { 
	    //     echo '图片格式不对！'; 
	    //     exit; 
	    // } 
	    $zips = 'helloweba' . $type; 
	    //上传路径 
	    $zip_path = "./zips/". $zipname;
	    move_uploaded_file($myzip["tmp_name"],$zip_path); 
        system('test.sh '.$zipname);
	} 
}
?>
<script>
</script>
</html>
