<template>
  <div>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="height: 100%">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
          <i class="fa fa-user" aria-hidden="true"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Page</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <router-link class="nav-link" to="/">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></router-link>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-money-bill-wave"></i>
          <span>Topup E-wallet</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-money-check-alt"></i>
          <span>Withdraw E-wallet</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-exchange-alt"></i>
          <span>Transfer E-wallet</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-history"></i>
          <span>Mutation E-wallet</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="https://documenter.getpostman.com/view/10742740/TVt2bP4r" target="_blank">
          <i class="fas fa-passport"></i>
          <span>API Doc</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
  </div>
</template>

<script>
  export default {
    name: 'Sidebar'
  }
</script>
