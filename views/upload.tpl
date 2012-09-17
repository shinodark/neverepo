<form id="uploadform" enctype="multipart/form-data" action="">
    <input id="upload_file" name="file" type="file" />
    <input id="upload_button" type="button" value="{L_UPLOAD}"/>
</form>
<progress></progress>
<div class="message" id="errorMessage"></div>
<div class="message" id="successMessage"></div>
<div class="message" id="info"></div>


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
    
    function showInfo(inf) {
        var htm = '<table><tr><td>magic : '
            + inf['magic']
            + '</td><td> version : '
            + inf['version']
            + '</td></tr></table>';
        $('#successMessage').html(htm);
    }

    function uploadCompleteHandler(ret) {
        if (ret.success == true) {
            success("{L_SUCCESS}");
            getSolFileInfo(ret.hash, solInfoHandler, showError);
        }
        else {
            showError(ret.error_msg);
        }
    }
    
    function solInfoHandler(ret) {
        if (ret.success == true) {
            success("{L_SUCCESS}");
            showInfo(ret.solinfo);
        }
        else {
            showError(ret.error_msg);
        }
    }

    $('#upload_button').click(function(){
        uploadFile('#upload_file', progressHandler, uploadCompleteHandler, showError);
    });
    $('#uploadform').submit(function(){
        return false;
    });
</script>