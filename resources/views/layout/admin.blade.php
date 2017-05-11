<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title>Blank | Remark Admin Template</title>
  @include ('asset.header-admin')
  
  <script>
  Breakpoints();
  </script>
</head>
<body>
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  @include('asset.admin-nav')
  @include('asset.admin-site-navbar')
  <div class="site-gridmenu">
    <div>
      <div>
        <ul>
          <li>
            <a href="../apps/mailbox/mailbox.html">
              <i class="icon md-email"></i>
              <span>Mailbox</span>
            </a>
          </li>
          <li>
            <a href="../apps/calendar/calendar.html">
              <i class="icon md-calendar"></i>
              <span>Calendar</span>
            </a>
          </li>
          <li>
            <a href="../apps/contacts/contacts.html">
              <i class="icon md-account"></i>
              <span>Contacts</span>
            </a>
          </li>
          <li>
            <a href="../apps/media/overview.html">
              <i class="icon md-videocam"></i>
              <span>Media</span>
            </a>
          </li>
          <li>
            <a href="../apps/documents/categories.html">
              <i class="icon md-receipt"></i>
              <span>Documents</span>
            </a>
          </li>
          <li>
            <a href="../apps/projects/projects.html">
              <i class="icon md-image"></i>
              <span>Project</span>
            </a>
          </li>
          <li>
            <a href="../apps/forum/forum.html">
              <i class="icon md-comments"></i>
              <span>Forum</span>
            </a>
          </li>
          <li>
            <a href="../index.html">
              <i class="icon md-view-dashboard"></i>
              <span>Dashboard</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Page -->
  <!-- <div class="page animsition">
    <div class="page-content"> -->
    @yield('content')
    <!-- </div>
  </div> -->
  <!-- End Page -->
  <!-- Footer 
  @include('asset.footer-admin')-->
  <!-- Core  -->
  @include ('asset.core-js-admin')
  
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>
</body>
</html>