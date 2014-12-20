<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'activations';

	$applications = DBObject::glob('Application', 'SELECT * FROM shine_applications ORDER BY name');

	$db = Database::getDatabase();
	
	if(isset($_GET['q']))
	{
		$q = $_GET['q'];
		$_q = $db->escape($q);
		$search_sql = " AND (name LIKE '%$_q%' OR serial_number LIKE '%$_q%' OR ip LIKE '%$_q%') ";
	}
	else
	{
		$q = '';
		$search_sql = '';
	}

	if(isset($_GET['id']))
	{
		$app_id = intval($_GET['id']);
		$total_num_activations = $db->getValue("SELECT COUNT(*) FROM shine_activations WHERE app_id = $app_id $search_sql ORDER BY dt DESC");
		$pager = new Pager(@$_GET['page'], 100, $total_num_activations);
		$activations = DBObject::glob('Activation', "SELECT * FROM shine_activations WHERE app_id = $app_id $search_sql ORDER BY dt DESC LIMIT {$pager->firstRecord}, {$pager->perPage}");
		$where = " AND app_id = $app_id ";
		$app_name = $applications[$app_id]->name;
	}
	else
	{
		$total_num_activations = $db->getValue("SELECT COUNT(*) FROM shine_activations WHERE 1 = 1 $search_sql ");
		$pager = new Pager(@$_GET['page'], 100, $total_num_activations);
		$activations = DBObject::glob('Activation', "SELECT * FROM shine_activations WHERE 1 = 1 $search_sql ORDER BY dt DESC LIMIT {$pager->firstRecord}, {$pager->perPage}");
		$where = '';
		$app_name = 'All';
	}

	$available_apps = $db->getValues("SELECT app_id FROM shine_activations GROUP BY app_id");	

	$top_emails = $db->getRows("SELECT COUNT(*) as num, name from shine_activations GROUP BY name ORDER BY num DESC LIMIT 5");
	$top_serials = $db->getRows("SELECT COUNT(*) as num, serial_number from shine_activations GROUP BY serial_number ORDER BY num DESC LIMIT 5");
	$top_ips = $db->getRows("SELECT COUNT(*) as num, ip from shine_activations GROUP BY ip ORDER BY num DESC LIMIT 5");
?>
<?PHP include('inc/header.inc.php'); ?>

<div class="row">
<div class="col-lg-12">

 <h1 class="page-header">Activations</h1>

<ul class="nav nav-pills">
								<li class="<?PHP if(!isset($_GET['id'])) echo 'active'; ?>"><a href="activations.php">All Activations</a></li>
								<?PHP foreach($applications as $a) : if(!in_array($a->id, $available_apps)) continue; ?>
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="activations.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></a></li>
								<?PHP endforeach; ?>
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
										<th>Application</th>
										<th>Email</th>
										<th>Activation Date</th>
										<th>Serial Number</th>
										<th>IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?PHP foreach($activations as $act) : ?>

                                        <tr class="<?PHP if($act->order_id == '') { echo 'fraud'; } ?>">
										<td><?PHP echo $act->applicationName(); ?></td>
										<td><a href="order.php?id=<?PHP echo $act->order_id; ?>"><?PHP echo $act->name; ?></a></td>
										<td><?PHP echo dater($act->dt, 'm/d/Y g:ia') ?></td>
										<td><?PHP echo array_shift(explode('-', $act->serial_number)); ?>...</td>
										<td><?PHP echo $act->ip; ?></td>
                                        </tr>
<?PHP endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                
<hr>            <!-- /.table-responsive -->
<div class="text-center">
<ul class="pagination">
							  <li><a href="activations.php?page=<?PHP echo $pager->prevPage(); ?>&amp;id=<?PHP echo @$app_id; ?>">&#171; Prev</a></li>
								<?PHP for($i = 1; $i <= $pager->numPages; $i++) : ?>
								<?PHP if($i == $pager->page) : ?>
                                <li class="active"><a href="activations.php?page=<?PHP echo $i; ?>&amp;id=<?PHP echo @$app_id; ?>"><?PHP echo $i; ?></a></li>
								<?PHP else : ?>
                                <li><a href="activations.php?page=<?PHP echo $i; ?>&amp;id=<?PHP echo @$app_id; ?>"><?PHP echo $i; ?></a></li>
								<?PHP endif; ?>
								<?PHP endfor; ?>
                                <li><a href="activations.php?page=<?PHP echo $pager->nextPage(); ?>&amp;id=<?PHP echo @$app_id; ?>">Next &#187;</a></li>
</ul>
</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
</div>



<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Top Emails
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="biglist">
							<?PHP foreach($top_emails as $x) : ?>
							<li><a href="activations.php?q=<?PHP echo $x['name']; ?>"><?PHP echo $x['name']; ?> (<?PHP echo $x['num']; ?>)</a></li>
							<?PHP endforeach; ?>
						</ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
</div>	
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Top Serials
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="biglist">
							<?PHP foreach($top_serials as $x) : ?>
							<li><a href="activations.php?q=<?PHP echo $x['serial_number']; ?>"><?PHP echo array_shift(explode('-', $x['serial_number'])); ?>... (<?PHP echo $x['num']; ?>)</a></li>
							<?PHP endforeach; ?>
						</ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
</div>	
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Top IPs
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="biglist">
							<?PHP foreach($top_ips as $x) : ?>
							<li><a href="activations.php?q=<?PHP echo $x['ip']; ?>"><?PHP echo $x['ip']; ?> (<?PHP echo $x['num']; ?>)</a></li>
							<?PHP endforeach; ?>
						</ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
</div>	
</div>

           
<?PHP include('inc/footer.inc.php'); ?>
