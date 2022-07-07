<?php 
	$url= $_SERVER["REQUEST_URI"];
	$components = parse_url($url);
	parse_str($components['query'], $archivo);	
 ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Fixed Layout</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Fixed Layout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-body p-0">
                <div class="col-md-3 p-0">
					<div class="card-body box-profile">
						<div class="text-center">
						  <img class="img-circle" style="width: 150px;" src="vistas/img/empleado.png" alt="User profile picture">
						</div>

						<h3 class="profile-username text-center">Nina Mcintire</h3>

						<p class="text-muted text-center">Software Engineer</p>

						<ul class="list-group list-group-unbordered mb-3">
						  <li class="list-group-item">
						    <b>Followers</b> <a class="float-right">1,322</a>
						  </li>
						  <li class="list-group-item">
						    <b>Following</b> <a class="float-right">543</a>
						  </li>
						  <li class="list-group-item">
						    <b>Friends</b> <a class="float-right">13,287</a>
						  </li>
						</ul>

						<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
					</div>
		              <!-- /.card-body -->

		          </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Footer
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
