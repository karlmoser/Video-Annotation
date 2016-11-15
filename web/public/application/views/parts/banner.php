<?php $this->load->helper('form'); ?>
<nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Annotated.io</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/users/profile/<?= $this->session->userdata('username'); ?>"><icon class='fa fa-home'/> Profile</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="/videos"><icon class='fa fa-video-camera'/> Videos
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/videos/main">My Videos</a></li>
          <li><a href="/users/annotations/<?= $this->session->userdata('username');?>">My Annotations</a></li>
          <li><a href="/videos/upload">Upload</a></li>
        </ul>
      </li>
      <li>
        <a href="/admin/messages">
          <i class="fa fa-envelope" aria-hidden="true"></i> Messages
        </a>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php if ($loginText != 'Login'): ?>
      <li>
        <a class="dropdown-toggle" data-toggle="dropdown" href="/videos">
          <?= $loginText ?>
          <span class="caret"></span>
          <ul class="dropdown-menu">
            <li><a href="/admin/logout"><icon class='fa fa-sign-out'/> Logout</a></li>
            <li><a href="/admin/account"><span class="glyphicon glyphicon-user"></span> Account</a></li>
        </ul>
        </a>
      </li>
      <?php else: ?>
      <li><a href="/admin/logout"><icon class='fa fa-sign-in'/> <?= $loginText ?></a></li>
      <?php endif; ?>
      
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="http://www.elemental.com/"><img style="height:25px;" src="/img/elemental-logo.jpeg"></a></li>
    </ul>
  </div>
</nav>
