<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'applications';
	
	$app = new Application($_GET['id']);
	if(!$app->ok()) redirect('index.php');
	$versions = $app->versions();
?>
<?PHP include('inc/header.inc.php'); ?>

<div class="row">
<div class="col-lg-12">

 <h1 class="page-header">Applications</h1>

<ul class="nav nav-pills">
<li><a href="application.php?id=<?PHP echo $app->id; ?>"><?PHP echo $app->name; ?></a></li>
<li class="active"><a href="versions.php?id=<?PHP echo $app->id; ?>">Versions</a></li>
<li><a href="version-new.php?id=<?PHP echo $app->id; ?>">Release New Version</a></li>
</ul>

</div>

</div>

<br><br>

<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
                        <div class="panel-heading">
                            Your Applications
                        </div>
                        <!-- /.panel-heading -->
 <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                           <th>Human Readable Version</th>
										<th>Sparkle Version Number</th>
										<th>Release Date</th>
										<th>Downloads</th>
										<th>Updates</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?PHP foreach($versions as $v) : ?>
                                        <tr>
                                           <td><a href="version-edit.php?id=<?PHP echo $v->id; ?>"><?PHP echo $v->human_version; ?></a></td>
										<td><?PHP echo $v->version_number; ?></td>
										<td><?PHP echo dater($v->dt, 'n/d/Y g:ia'); ?></td>
										<td><?PHP echo number_format($v->downloads); ?></td>
										<td><?PHP echo number_format($v->updates); ?></td>
                                        </tr>
<?PHP endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
</div></div>

<?PHP include('inc/footer.inc.php'); ?>
