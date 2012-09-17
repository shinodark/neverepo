/* 
# ***** BEGIN LICENSE BLOCK *****
# This file is part of Neverepo .
# Copyright (c) 2004 Francois Guillet and contributors. All rights
# reserved.
#
# Neverepo is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# Neverepo is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with Neverepo; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****
 */
function loadMain(page) {
    $('#main').load(page);
}

function uploadFile(fileId, progressHandlingFunction, successHandler, errorHandler) {
    var fd = new FormData();
    var file = $(fileId)[0].files[0];
    fd.append('file', file);
    
    $.ajax({
        url: '../ajax/upload.php',
        type: 'POST',
        xhr: function() {  // custom xhr
            myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
            }
            return myXhr;
        },
        success: successHandler,
        error: errorHandler,
        data: fd,
        //Options to tell JQuery not to process data or worry about content-type
        cache: false,
        contentType: false,
        processData: false
    });
}

function getSolFileInfo(hash, successHandler, errorHandler) {
    
    var data = {};
    data.hash = hash;
    $.ajax({
        url: '../ajax/solinfo.php',  //server script to process data
        type: 'POST',
        success: successHandler,
        error: errorHandler,
        data: data
    });   
}