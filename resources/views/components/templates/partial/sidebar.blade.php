 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">AdminLTE 3</span>
     </a>
     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block">{{ Auth::user()->name }}</a>
             </div>
         </div>
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="{{ route('home') }}" class="nav-link">
                         <i class="nav-icon fas fa-home"></i>
                         <p>
                             Home
                         </p>
                     </a>
                 </li>

                 @if (Auth::user()->level == 'admin')
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Dashboard
                                 <i class="right fas fa-angle-left"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('users.index') }}" class="nav-link">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>User</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('category.index') }}" class="nav-link">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Category</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('student.index') }}" class="nav-link">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Student</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('course.index') }}" class="nav-link">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Course</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                 @endif
                 @if (Auth::user()->level == 'mentor')
                     <li class="nav-item">
                         <a href="{{ route('module') }}" class="nav-link">
                             <i class="nav-icon fas fa-th"></i>
                             <p>
                                 Module
                             </p>
                         </a>
                     </li>
                 @endif
                 <li class="nav-item">
                     <a class="nav-link" href="#" data-toggle="modal" data-target="#LogoutModal">
                         <i class="nav-icon fas fa-sign-out-alt"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>

     <!-- /.sidebar -->
 </aside>
