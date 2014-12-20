<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'feedback';

	if(isset($_GET['type']))
	{
		$db = Database::getDatabase();
		$type = mysql_real_escape_string($_GET['type'], $db->db);
		$feedback = DBObject::glob('Feedback', "SELECT * FROM shine_feedback WHERE type = '$type' ORDER BY dt DESC");
	}
	else
	{
		$feedback = DBObject::glob('Feedback', "SELECT * FROM shine_feedback ORDER BY dt DESC");
	}
?>
<?PHP include('inc/header.inc.php'); ?>

<div class="row">
<div class="col-lg-12">

 <h1 class="page-header">Feedback</h1>

<ul class="nav nav-pills">
								<li <?PHP if(@$_GET['type']==''){?> class="active"<? } ?>><a href="feedback.php">All Feedback</a></li>
								<li <?PHP if(@$_GET['type']=='support'){?> class="active"<? } ?>><a href="feedback.php?type=support">Support Questions</a></li>
								<li <?PHP if(@$_GET['type']=='bug'){?> class="active"<? } ?>><a href="feedback.php?type=bug">Bug Reports</a></li>
								<li <?PHP if(@$_GET['type']=='feature'){?> class="active"<? } ?>><a href="feedback.php?type=feature">Feature Requests</a></li>
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
										<th>ID</th>
										<th>Application</th>
										<th>Type</th>
										<th>Email</th>
										<th>Wants Reply?</th>
										<th>Date</th>
										<th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?PHP foreach($feedback as $f) : ?>
									<tr class="<?PHP if($f->new == 1) echo "new"; ?>">
										<td><?PHP echo $f->id; ?></td>
										<td><?PHP echo $f->appname; ?> <?PHP echo $f->appversion; ?></td>
										<td><?PHP echo $f->type; ?></td>
										<td><a href="mailto:<?PHP echo $f->email; ?>"><?PHP echo $f->email; ?></a></td>
										<td><?PHP echo ($f->reply == 1) ? '<strong>Yes</strong>' : 'No'; ?></td>
										<td><?PHP echo time2str($f->dt); ?></td>
										<td><a href="feedback-view.php?id=<?PHP echo $f->id; ?>" class="btn btn-sm btn-info">View</a></td>
                                        </tr>
<?PHP endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>

<div class="alert alert-info"><span>Use <a href="http://github.com/tylerhall/OpenFeedback/">OpenFeedback</a> to collect feedback from your users.</span></div>
                    <!-- /.panel -->
                </div>
</div>


<?PHP include('inc/footer.inc.php'); ?>
