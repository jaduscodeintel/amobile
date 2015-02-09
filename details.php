<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');

$qry = "SELECT customers.name AS cname, customers.dispatch_notes, dispatch.*, tire_sizes.tire_size FROM dispatch 
LEFT JOIN tire_sizes ON (tire_sizes.id = dispatch.tire_size_id) 
LEFT JOIN customers ON (customers.id = dispatch.company_id)
WHERE dispatch.id = ".$_REQUEST["id"];
$dispatches = mysqli_query($connection, $qry); 
$dispatch = mysqli_fetch_array($dispatches);

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="uploads/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="uploads/js/jquery.form.min.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="fancybox/jquery.fancybox.pack.js"></script> 
    
<script type="text/javascript">
$(document).ready(function() { 
	
	$(".fancyboxphotos").fancybox({
	  'width' : 1000,
	  'height' : 1000,
	  'autoSize' : false,
	  'type' : "iframe"
	});
	
	get_photos();
	var progressbox     = $('#progressbox');
	var progressbar     = $('#progressbar');
	var statustxt       = $('#statustxt');
	var completed       = '0%';
	
	var options = { 
			target:   '#picture_div',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			uploadProgress: OnProgress,
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// return false to prevent standard browser submit and page navigation 
			return false; 
		});
	
//when upload progresses	
function OnProgress(event, position, total, percentComplete)
{
	//Progress bar
	progressbar.width(percentComplete + '%') //update progressbar percent complete
	statustxt.html(percentComplete + '%'); //update status text
	if(percentComplete>50)
		{
			statustxt.css('color','#fff'); //change status text to white after 50%
		}
}

//after succesful upload
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	//get_photos();

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{

		if( !$('#imageInput').val()) //check empty input filed
		{
			$("#output").html("Are you kidding me?");
			return false
		}
		
		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type
		
		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 4 MB (4194304)
		if(fsize>4194304) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
		
		//Progress bar
		progressbox.show(); //show progressbar
		progressbar.width(completed); //initial value 0% of progressbar
		statustxt.html(completed); //set status text
		statustxt.css('color','#000'); //initial color of status text

				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function get_photos()
{
	did = <?php echo $_REQUEST["id"]; ?>;
	$.ajax
		({
			type: "POST",
			url: "ajax/get_dispatch_photos.php",
			data: {id : did},
			success: function(result)
			{
				if (result) 
				{ 
					$("#picture_div").html(result);
				}
			}
		});
}

}); 

function update_dispatch(field, val)
{

		updateid = <?php echo $_REQUEST["id"]; ?>;
		
		if (updateid)
		{
			$.ajax
			({
				type: "POST",
				url: "ajax/update_dispatch_field.php",
				data: {id : updateid, fieldname : field, value : val},
				success: function(result)
				{
					if (result) 
					{ 
						//alert(result);
						if (result == "Success")
						{
							html =  "<font color='blue'>Tech Notes Updated</font>";
							$("#update_msg").html(html);
						} else {
							html = "<font color='red'>Error Updating Tech Notes/font>";
							$("#update_msg").html(html);
						}
					}
				}
			});
		}
}

function delete_photo(pid, original, thumbnail, disid)
{

	$.ajax
	({
		type: "POST",
		url: "ajax/delete_photos.php",
		data: {id : pid, largephoto : original, smallphoto : thumbnail, did : disid},
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#picture_div").html(result);
			}
		}
	});

}

</script>
<link href="uploads/style/style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#E8E8E8">
<table width="100%">
	<tr>
    	<td align="center" colspan="2"><h2>Detailed Info for <?php echo $dispatch["RO"]; ?></h2></td>
    </tr>
    <tr>
    	<td><hr /></td>
    </tr>
</table>
<table width="90%" align="center">
    <tr>
    	<td align="right"><strong>Customer: </strong></td>
        <td><?php echo $dispatch["cname"]; ?></td>
   </tr>
    <tr>
    	<td align="right"><strong>Driver Name: </strong></td>
        <td><?php echo $dispatch["driver_name"]; ?></td>
   </tr>
    <tr>
    	<td align="right"><strong>Driver Number: </strong></td>
        <td><?php echo $dispatch["driver_number"]; ?></td>
   </tr>
    <tr>
    	<td align="right"><strong>Tractor: </strong></td>
        <td><?php echo $dispatch["tractor"]; ?></td>
   </tr>
    <tr>
    	<td align="right"><strong>Trailer: </strong></td>
        <td><?php echo $dispatch["trailer"]; ?></td>
   </tr>
    <tr>
    	<td align="right"><strong>Tire Information: </strong></td>
        <td><?php echo $dispatch["tire_size"]; ?></td>
   </tr>
   <tr>
   		<td colspan="2"><hr /></td>
    </tr>
    <tr>
    	<td align="left"><strong>Customer Requirements: </strong></td>
        <td>&nbsp;</td>
   </tr>
   <tr>
        <td colspan="2"><?php echo $dispatch["dispatch_notes"]; ?></td>
   </tr>
   <tr>
   		<td colspan="2" align="center"><hr /></td>
    </tr>
    <tr>
    	<td align="left"><strong>Job Requirements: </strong></td>
        <td>&nbsp;</td>
   </tr>
   <tr>
        <td colspan="2"><?php echo $dispatch["job_requirements"]; ?></td>
   </tr>
    <tr>
   		<td colspan="2" align="center"><hr /></td>
    </tr>
    <tr>
    	<td align="left"><strong>Tech Notes: </strong><div id="update_msg"></div></td>
        <td>&nbsp;</td>
   </tr>
   <tr>
        <td colspan="2"><textarea rows="5" cols="80" name="tech_notes" id="tech_notes" onchange="update_dispatch('tech_notes', this.value);"><?php echo str_replace( "<br />", '', $dispatch["tech_notes"] ); ?></textarea></td>
   </tr>
   <tr>
   		<td><input type="button" value="Update"</td>
   </tr>
   <tr>
   		<td colspan="2" align="center"><hr /></td>
    </tr>
    <tr>
   		<td colspan="2"><div id="picture_div"><hr></div></td>
   </tr>
</table>

<div id="upload-wrapper">
<div align="center">
<h3>Upload Images One at a Time</h3>
<span class="">Image Type allowed: Jpeg, Jpg, Png and Gif. | Maximum Size 4 MB</span>
<form action="uploads/processupload.php" onSubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
<input type="hidden" name="did" value="<?php echo $_REQUEST["id"]; ?>">
<input name="image_file" id="imageInput" type="file" />
<input type="submit"  id="submit-btn" value="Upload" />
<img src="uploads/images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
</form>
<div id="progressbox" style="display:none;"><div id="progressbar"></div><div id="statustxt">0%</div></div>
<div id="output"></div>
</div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>