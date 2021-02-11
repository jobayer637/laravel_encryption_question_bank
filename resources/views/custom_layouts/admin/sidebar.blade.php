<nav class="side-navbar sticky-top">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="{{ asset('assets/img/avatar-1.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4">{{ Auth::user()->name }}</h1>
              <p>Web Developer</p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
          @if(Request::is('admin*'))
            <ul class="list-unstyled">
                <li class="{{ Request::is('admin/dashboard')?'active':'' }}"><a href="{{ route('admin.index') }}"> <i class="fas fa-house-user"></i>Home </a></li>
                <li class="{{ Request::is('admin/users*')?'active':'' }}"><a href="{{ route('admin.users.index') }}"> <i class="fas fa-user-tie"></i>Users </a></li>
                <li class="{{ Request::is('admin/board*')?'active':'' }}"><a href="{{ route('admin.board.index') }}"> <i class="fas fa-chess-rook"></i>Board </a></li>
                <li class="{{ Request::is('admin/institute*')?'active':'' }}"><a href="{{ route('admin.institutes.index') }}"> <i class="fas fa-university"></i>Institutes </a></li>
                <li class="{{ Request::is('admin/department*')?'active':'' }}"><a href="{{ route('admin.department.index') }}"> <i class="fas fa-layer-group"></i></i>Department </a></li>
                <li class="{{ Request::is('admin/subject*')?'active':'' }}"><a href="{{ route('admin.subject.index') }}"> <i class="fas fa-book"></i>Subject </a></li>
                <li class="{{ Request::is('admin/question*')?'active':'' }}"><a href="{{ route('admin.question.index') }}"> <i class="fas fa-question-circle"></i>Question </a></li>
            </ul>
          @endif

           @if(Request::is('moderator*'))
            <ul class="list-unstyled">
                <li class="{{ Request::is('moderator/dashboard')?'active':'' }}"><a href="{{ route('moderator.index') }}"> <i class="icon-home"></i>Home </a></li>
                <li class="{{ Request::is('moderator/subject*')?'active':'' }}"><a href="{{ route('moderator.subject.index') }}"> <i class="fas fa-book"></i>Subject </a></li>
                <li class="{{ Request::is('moderator/question*')?'active':'' }}"><a href="{{ route('moderator.question.index') }}"> <i class="fas fa-question-circle"></i>Question </a></li>

            </ul>
          @endif

           @if(Request::is('author*'))
            <ul class="list-unstyled">
                <li class="{{ Request::is('author/dashboard')?'active':'' }}"><a href="{{ route('author.index') }}"> <i class="icon-home"></i>Home </a></li>
                <li class="{{ Request::is('author/question*')?'active':'' }}"><a href="{{ route('author.question.index') }}"> <i class="fas fa-newspaper"></i>Question </a></li>
            </ul>
          @endif

        </nav>

        {{-- <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Example dropdown </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
              </ul>
            </li> --}}
