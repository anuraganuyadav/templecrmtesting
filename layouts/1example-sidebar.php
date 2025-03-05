 <title>Dashboard</title>
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top fixed-top">
    <a class="navbar-brand mr-1" href="index.php">Start Bootstrap</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">

	     <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
	 
      <ul class="navbar-nav ml-auto"> 
        <li class="nav-item">
          <a class="nav-link" href="index.php?logout=true">
            <i class="fa fa-fw fa-user"></i><?php echo htmlspecialchars($_SESSION["email"]);?>
		  </a>
        </li>     
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul> 
    </div>
  </nav>
<div class="top"></div>
  <div id="wrapper">
<!--user-->
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text">Posts</span>
          </a>
        </li>
	 
           <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
			  <a class="nav-link" href="#">
				<i class="fa fa-fw fa-circle-o-notch"></i>
				<span class="nav-link-text">page 1</span>
			  </a>
			</li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
			  <a class="nav-link" href="#">
				<i class="fa fa-fw fa-circle-o-notch"></i>
				<span class="nav-link-text">Pages 2</span>
			  </a>
			</li>
        
        
			
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
			  <a class="nav-link" href="#">
				<i class="fa fa-fw fa-circle-o-notch"></i>
				<span class="nav-link-text">Categoris</span>
			  </a>
			</li>
		
	 
	 
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Appearance</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="#">Themes</a>
            </li>
            <li>
              <a href="#">Menus</a>
            </li>
          </ul>
        </li> 
        
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Components</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Login Screens:</h6>
          <a class="dropdown-item" href="login.php">Login</a>
          <a class="dropdown-item" href="register.php">Register</a>
          <a class="dropdown-item" href="forgot-password.php">Forgot Password</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="404.html">404 Page</a>
          <a class="dropdown-item" href="blank.html">Blank Page</a>
        </div>
      </li>
        
   
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
			<a class="nav-link" href="#">
				<i class="fa fa-fw fa fa-gear"></i>
				<span class="nav-link-text">Settings</span>
			</a>
		</li>
		
	 
<!--  end user   --> 
    </ul>

    <div id="content-wrapper">