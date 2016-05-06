<div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $leftModelName?></div>
                </div>
                <div class="panel-body">
                <?php echo '<div id=leftChart' . $No . ' style="height:500px;"></div>'; ?> 
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $rightModelName?></div>
                </div>
                <div class="panel-body">
                <?php echo '<div id=rightChart' . $No . ' style="height:500px;"></div>'; ?>
                </div>
            </div>
        </div>
    </div>