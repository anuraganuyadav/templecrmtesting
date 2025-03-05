<?php
if ($_SESSION['user_role_id'] == 1) {

?>

  <!--Admin Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <img class="img-lo" src="asset/img/logo.PNG">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo htmlspecialchars($_SESSION["full_name"]); ?><sup>*</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span> Admin Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Lead View
      </div>
      <!-- Mailer Configuration -->
      <li class="nav-item">
        <a class="nav-link" href="admin-lead.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Admin Lead</span></a>
      </li>

      <!-- Heading -->
      <div class="sidebar-heading">
        Potential Views
      </div>
      <li class="nav-item">
        <a class="nav-link" href="Admin-Potential.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Potential</span></a>
      </li>










      <!-- Heading -->
      <div class="sidebar-heading">
        Add Feature
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAll" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Add </span>
        </a>
        <div id="collapseAll" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Add All</h6>
            <a class="collapse-item" href="Add-Destinations.php">Destinations</a>
            <a class="collapse-item" href="Add-lead.php">Add Lead Status</a>
            <a class="collapse-item" href="Add-potential.php">Add Potential Status</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">


      <!-- Heading -->
      <div class="sidebar-heading">
        USER PASSWORD
      </div>
      <!-- sales password setting -->
      <li class="nav-item">
        <a class="nav-link" href="Manage-Password-Setting.php">
          <i class="fas fa-envelope-open-text"></i>
          <span>Manage Password &amp; OTP Setting</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <div class="sidebar-heading">
        NEW ACCOUNT
      </div>


      <li class="nav-item">
        <a class="nav-link" href="register.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Create New User</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <div class="sidebar-heading">
        LEAD MANAGE
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseToday" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Manage Lead & Potential</span>
        </a>
        <div id="collapseToday" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Add All</h6>
            <a class="collapse-item" href="Lead-Manage.php">Lead Manage</a>
            <a class="collapse-item" href="Potential-Manage.php">Potential-Manage</a>
          </div>
        </div>
      </li>
      <!-- All  Activity -->
      <li class="nav-item">
        <a class="nav-link" href="Pending-Activity.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>All Activity</span></a>
      </li>

      <!--Manage Salse Performance -->
      <li class="nav-item">
        <a class="nav-link" href="manage-salse-target.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Manage Salse Performance</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a target="_blank" class="nav-link" href="https://accounts.templemitracrm.in/access-login/superadmin@templemitra.com/superadmin@2022">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span> Go To Accounts</span></a>
      </li>




      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!--Admin End of Sidebar -->
  <?php
}
  ?>


  <?php
  if ($_SESSION['user_role_id'] == 0) {
  ?>

    <!--sales Page Wrapper -->
    <div id="wrapper">

      <!--sales Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
          <div class="sidebar-brand-icon rotate-n-15">
            <img class="img-lo" src="asset/img/logo.PNG">
          </div>
          <div class="sidebar-brand-text mx-3">Sales</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span> Employee Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Potential Views
        </div>
        <!-- Nav Potential -->
        <li class="nav-item">
          <a class="nav-link" href="Potential.php">
            <i class="fas fa-address-card"></i>
            <span>Potential</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Lead Views
        </div>

        <!-- Nav Item - Pages Collapse Menu -->

        <!-- Nav Item - Tables -->

        <li class="nav-item">
          <a class="nav-link" href="Sales.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Sales Lead</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </ul>
      <!-- End of sales Sidebar -->




    <?php
  }
    ?>


    <?php
    if ($_SESSION['user_role_id'] == 2) {

    ?>

      <!--Admin Page Wrapper -->
      <div id="wrapper">
        <!-- Sidebar -->
        <div class="both-actib">
          <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
              <div class="sidebar-brand-icon rotate-n-15">
                <img class="img-lo" src="asset/img/logo.PNG">
              </div>
              <div class="sidebar-brand-text mx-3"><?php echo htmlspecialchars($_SESSION["full_name"]); ?><sup>*</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item admin-active">
              <a class="nav-link" href="dashboard.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span> Admin Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
              Lead View
            </div>
            <!-- Mailer Configuration -->
            <li class="nav-item">
              <a class="nav-link" href="admin-lead.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Admin Lead</span></a>
            </li>
            <!-- Heading -->
            <div class="sidebar-heading">
              Potential View
            </div>
            <li class="nav-item">
              <a class="nav-link" href="Admin-Potential.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Potential</span></a>
            </li>










            <!-- Heading -->
            <div class="sidebar-heading">
              Add Feature
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAll" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Add </span>
              </a>
              <div id="collapseAll" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Add All</h6>
                  <a class="collapse-item" href="Add-Destinations.php">Destinations</a>
                  <a class="collapse-item" href="Add-lead.php">Add Lead Status</a>
                  <a class="collapse-item" href="Add-potential.php">Add Potential Status</a>
                </div>
              </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- sales password setting -->
            <!-- Heading -->
            <div class="sidebar-heading">
              User Password
            </div>
            <li class="nav-item">
              <a class="nav-link" href="Manage-Password-Setting.php">
                <i class="fas fa-envelope-open-text"></i>
                <span>Manage Password &amp; OTP Setting</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <div class="sidebar-heading">
              New Account
            </div>


            <li class="nav-item">
              <a class="nav-link" href="register.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Create New User</span></a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <!-- Heading -->
            <div class="sidebar-heading">
              Lead Manage
            </div>
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseToday2" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Manage Lead & Potential</span>
              </a>
              <div id="collapseToday2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Add All</h6>
                  <a class="collapse-item" href="Lead-Manage.php">Lead Manage</a>
                  <a class="collapse-item" href="Potential-Manage.php">Potential-Manage</a>
                </div>
              </div>
            </li>
            <!-- All  Activity -->
            <li class="nav-item">
              <a class="nav-link" href="Pending-Activity.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>All Activity</span></a>
            </li>

            <!--Manage Salse Performance -->
            <li class="nav-item">
              <a class="nav-link" href="manage-salse-target.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Manage Salse Performance</span></a>
            </li>

            <!--Admin End of Sidebar -->

            <!-- Heading -->
            <div class="sidebar-heading">
              Employee View
            </div>
            <!--sales Page Wrapper -->
            <!-- Divider -->
            <li class="nav-item">
              <a target="_blank" class="nav-link" href="https://accounts.templemitracrm.in/access-login/superadmin@templemitra.com/superadmin@2022">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span> Go To Accounts</span></a>
            </li>


            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item sales-active">
              <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span> Employee Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
              Potential
            </div>

            <!-- Nav Potential -->
            <li class="nav-item">
              <a class="nav-link" href="Potential.php">
                <i class="fas fa-address-card"></i>
                <span>Potential</span></a>
            </li>


            <!-- Nav Item - Utilities Collapse Menu -->
            <!--
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.php">Colors</a>
            <a class="collapse-item" href="utilities-border.php">Borders</a>
            <a class="collapse-item" href="utilities-animation.php">Animations</a>
            <a class="collapse-item" href="utilities-other.php">Other</a>
          </div>
        </div>
      </li>
-->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
              Lead Views
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Tables -->
            <li class="nav-item">
              <a class="nav-link" href="Sales.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Sales Lead</span></a>
            </li>
            <!-- Nav Item - inbox -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

          </ul>
          <!-- End of sales Sidebar -->
        </div>

      <?php
    }
      ?>