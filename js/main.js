/**
 * Created by arias on 23/10/2014.

 */

function getNewPost(hideF,act, p_id,sComments){
   var hideForm = hideF || 0;
   var action = act || 'index';
   var post_id = p_id || '';
   var showComments = sComments || '';
      
    var html ="<form id='fakeForm' method='post' action='index.php'>" +
            "<input type='hidden' name='action' value='"+action+"'>" +
            "<input type='hidden' name='isAjax' id='isAjax' value='1'>" +
            "<input type='hidden' name='post_id' id='post_id' value='"+post_id+"'>" +
            "<input type='hidden' name='showComments' id='showComments' value='"+showComments+"'>" +
                    "<input type='hidden' name='hideForm' id='hideForm' value='"+hideForm+"'>" +
            "</form>";
   
   
    jQuery('#content').append(html);
    var f = jQuery('#fakeForm').get(0);
   
    submitData(f,'content');
    return false;
}
function submitData(form, Div) {
    // if no jquery, send form the old quey
    if(typeof jQuery == 'undefined'){
        return true;
    }
    var targetDiv = Div || 'posts';
    if(!jQuery('#'+targetDiv).get(0)){
        targetDiv ='content';
    }
    
    document.getElementById('isAjax').value = 1;
   
    $("#content").mask("Waiting...", 100);
  //  alert(targetDiv);
    var data = jQuery(form).serialize();
    jQuery('.bg-danger').remove();
    jQuery.post(
        "index.php",
        data
    )
        .done(function (msg) {
            $("#content").unmask();
            if(jQuery('#newPost').get(0)){
      		  jQuery('#newPost').hide();
      	  }
            
            form.reset();
  //          alert(msg);
            switch(targetDiv){
           
            case 'content':
            	 jQuery('#content').html('');
            	 jQuery('#'+targetDiv).prepend(jQuery.parseHTML(msg));
            	 break;
              default:
            	  
            	  jQuery('#'+targetDiv).prepend(jQuery.parseHTML(msg));
            }
           
        }).fail(function(msg){
           alert(msg.responseText);
        }).always(function(){
            $("#content").unmask();
            var f = jQuery('#fakeForm').get(0);
             if(f){
            	 jQuery('#fakeForm').remove();
             }
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
      
       
       
           // I'm in a post detail
           getNewPost(0);
           
      
        return false;
    } else{
       
            location.href='index.php?action=newPost';
      
       
    }
    return true;
}