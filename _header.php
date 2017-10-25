<header>
	<nav class="navbar navbar-default navbar-static-top no-margin" role="navigation">
		<div class="navbar-brand-group">
			<a class="navbar-sidebar-toggle navbar-link" data-sidebar-toggle>
				<i class="fa fa-lg fa-fw fa-bars"></i>
			</a>
			<a class="navbar-brand hidden-xs" href="index.php">
				<span class="sc-visible">
					CS
				</span>
				<span class="sc-hidden">
					<span class="bold">Office System</span>                    
				</span>    
			</a>
			<a class="navbar-brand visible-xs" href="index.php">
				<span class="bold">Office System</span>
			</a>
		</div>
		<ul class="nav navbar-nav navbar-nav-expanded pull-left margin-md-left hidden-xs">
			<li class="">
				<?php $user = $db->users()
								->where("id", $_SESSION['id'])->fetch();
				?>
				<h4 style="padding-top: 7px;">Branch : <?php echo ($user['branch_id']==0 ? 'Kantor Pusat' : $user->branch['name']); ?></h4>
			</li>
		</ul>
		
		<ul class="nav navbar-nav navbar-nav-expanded pull-right margin-md-right">
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle navbar-user" href="javascript:;">
					<i class="fa fa-lg fa-fw fa-user"></i></i>
					<?php $user =$db->users()->where("id", $_SESSION['id'])->fetch(); ?>
					<span class="hidden-xs"><?php echo ucfirst($user['first_name']) . ' ' . $user['last_name']; ?></span>
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu pull-right-xs">
					<li class="arrow"></li>
					<li><a href="edit-profile.php">Profile</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
			</li>
		</ul>
		
		<ul class="nav navbar-nav navbar-nav-expanded pull-right margin-md-left">
			<li class="">
				 <script type="text/javascript">
					someday = new Date();
					var dat = someday.getDate();
					namaHari = new Array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
					namaBulan = new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November",	 "Desember");
					tanggalSekarang = new Date();
					//console.log(tanggalSekarang.getDay());
					tahun  = tanggalSekarang.getYear();
					if (tahun < 1000) tahun +=1900;
					document.write('<h4 class="hidden-xs" style="margin-top:13px;">' + namaHari[tanggalSekarang.getDay()] + ", " + tanggalSekarang.getDate() + " " + namaBulan[tanggalSekarang.	getMonth()] + " " + tahun + '</h4>');
				</script>
		   </li>
		</ul>
		
	</nav>
</header>