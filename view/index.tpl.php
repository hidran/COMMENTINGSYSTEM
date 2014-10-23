<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $this->headerTitle ?></title>
    <style type="text/css">
        #content {
            border: 1px solid red;
            margin-top: 75px;
        }

        #newPost {
            width: 60%;
            margin-left: 0;
        }

        .published_date {
            color: #949494;
            font-size: small;
        }

        section {
            margin-top: 10px;
        }
        .navbar-brand{
            cursor: default;
        }
        #newPostAnchor{
            margin-top: 40px;
        }
    </style>

</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" onclick="return false" href="#">COMMENTING SYSTEM</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?= $this->action == 'index' ? 'active' : '' ?>"><a href="index.php">POSTS</a></li>
                <li class="<?= $this->action == 'newPost' ? 'active' : '' ?>"><a href="#newPostAnchor">NEW POST</a></li>

            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<div class="container" id="content">
    <?php
    if ($this->message) {
        ?>
        <div clas="row">
            <div class="col-md-12 text-success"><h3><?= htmlentities(urldecode($this->message)) ?></h3></div>
        </div>
    <?php
    }
    ?>
    <?php
    if ($this->error) {
        ?>
        <div clas="row">
            <div class="col-md-12 text-warning"><?= htmlentities(urldecode($this->error)) ?></div>
        </div>
    <?php
    }
    ?>
    <?= $this->content ?>

</div>
<!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jquery.loadmask.css">
<script src="js/jquery.loadmask.min.js"></script>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    //console.log(jQuery);
    function submitData(form, targetDiv) {
        // if no jquery, send form the old quey
        if(typeof jQuery !='undefined'){
            return true;
        }
        var targetDiv = targetDiv || 'posts';
        document.getElementById('isAjax').value = 1;
       ì
        $("#content").mask("Waiting...", 100);
        jQuery.post(
            "index.php",
            jQuery(form).serialize()
        )
            .done(function (msg) {
                $("#content").unmask();
                form.reset();
                 alert('tormato');
               
                
                jQuery('#'+targetDiv).prepend(jQuery.parseHTML(msg));
                alert('tormato mess')

            }).fail(function(msg){
                alert(msg)
            }).always(function(){
                $("#content").unmask();
            });
        return false;
    }
</script>
</body>
</html>
