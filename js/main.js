/**
 * Created by arias on 23/10/2014.

 */

function getNewPost(hideForm,action, post_id,showComments){
   var hideForm = hideForm || 0;
   var action = action || 'index';
   var post_id = post_id || '';
   var showComments = showComments || '';
      
    var html ="<form id='fakeForm' method='post' action='index.php'>" +
            "<input type='hidden' name='action' value='"+action+"'>" +
            "<input type='hidden' name='isAjax' id='isAjax' value='1'>" +
            "<input type='hidden' name='post_id' id='post_id' value='"+post_id+"'>" +
            "<input type='hidden' name='showComments' id='showComments' value='"+showComments+"'>" +
                    "<input type='hidden' name='hideForm' id='hideForm' value='"+hideForm+"'>" +
            "</form>";
    jQuery('#content').html('');
   
    jQuery('#content').append(html);
    var f = jQuery('#fakeForm').get(0);
   
    submitData(f,'content');
    return false;
}
function submitData(form, targetDiv) {
    // if no jquery, send form the old quey
    if(typeof jQuery == 'undefined'){
        return true;
    }
    var targetDiv = targetDiv || 'posts';
    if(!jQuery('#'+targetDiv).get(0)){
        targetDiv ='content';
    }
    document.getElementById('isAjax').value = 1;
   
    $("#content").mask("Waiting...", 100);
    
    var data = jQuery(form).serialize();
    
    jQuery.post(
        "index.php",
        data
    )
        .done(function (msg) {
            $("#content").unmask();
            form.reset();
             jQuery('#'+targetDiv).prepend(jQuery.parseHTML(msg));
        }).fail(function(msg){
            console.log(msg)
        }).always(function(){
            $("#content").unmask();
        });
    return false;
}
function setActive(ele){
    if(typeof jQuery !='undefined'){
        //console.log(jQuery('.navbar-nav li'));
        jQuery('.navbar-nav li').removeClass('active');
        jQuery(ele).addClass('active');
       
    } else{
        if(ele.className.indexOf('active')==-1){
        ele.className = 'active';
        }
    }
   
}
function showNewPost(){
    if(typeof jQuery !='undefined'){
        var nP= jQuery('#newPost');
       
       if(nP.length>0){
        jQuery('#newPost').show().slideDown();
        $('html,body').animate({scrollTop: jQuery('#content').offset().top},'slow');
        window.location.hash = '#newPostAnchor';
       } else {
           // I'm in a post detail
           getNewPost(0);
           
       }
        return false;
    } else{
        var ele = document.getElementById('#newPost');
        if(ele){
            ele.style.display = '';
            window.location.hash = '#content';
        } else {
            location.href='index.php?action=newPost';
        }
       
    }
    return true;
}