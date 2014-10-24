/**
 * Created by arias on 23/10/2014.
 */
function submitData(form, targetDiv) {
    // if no jquery, send form the old quey
    if(typeof jQuery =='undefined'){
        return true;
    }
    var targetDiv = targetDiv || 'posts';
    document.getElementById('isAjax').value = 1;

    $("#content").mask("Waiting...", 100);
    jQuery.post(
        "index.php",
        jQuery(form).serialize()
    )
        .done(function (msg) {
            $("#content").unmask();
            form.reset();
            jQuery('#'+targetDiv).prepend(jQuery.parseHTML(msg));
        }).fail(function(msg){
            alert(msg)
        }).always(function(){
            $("#content").unmask();
        });
    return false;
}