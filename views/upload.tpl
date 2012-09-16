<form id="uploadform" enctype="multipart/form-data" action="">
    <input id="upload_file" name="file" type="file" />
    <input id="upload_button" type="button" value="{L_UPLOAD}"/>
</form>
<progress></progress>
<div class="message" id="errorMessage"></div>
<div class="message" id="successMessage"></div>


<script type="text/javascript">
    $(':file').change(function(){
        var file = this.files[0];
        name = file.name;
        size = file.size;
        type = file.type;

        ext = ".sol";
        if (name.substr(name.length - ext.length, ext.length).toLowerCase() != ext) {
            showError('{L_ERR_EXT}')
        }
    });

    function progressHandler(e){
        if(e.lengthComputable){
            $('progress').attr({value:e.loaded,max:e.total});
        }
    }

    function showError(msg) {
        $('#errorMessage').html(msg);
        $('#errorMessage').show("slow");
    }

    function success(msg) {
        $('#successMessage').html(msg);
        $('#successMessage').show("slow");
    }

    function completeHandler(msg) {
        if (msg == "true") {
            success("{L_ERR_EXT}");
        }
        else {
            showError("msg");
        }
    }

    $('#upload_button').click(function(){
        uploadFile('#upload_file', progressHandler, completeHandler, showError);
    });
    $('#uploadform').submit(function(){
        return false;
    });
</script>