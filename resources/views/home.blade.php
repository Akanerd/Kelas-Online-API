<x-templates.default>
@section('title')
Home
@endsection
@section('content')
<div class="row">
  <div class="col-12">
      <h3>Dashboard</h3>
      <hr />
  </div>
  <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
          <div class="inner">
              <h3>{{ $mentor }}</h3>
              <p>Mentor</p>
          </div>
          <div class="icon">
              <i class="fas fa-chalkboard-teacher"></i>
          </div>
      </div>
  </div>
  <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
          <div class="inner">
              <h3>{{ $course }}</h3>
              <p>Course</p>
          </div>
          <div class="icon">
              <i class="fas fa-book"></i>
          </div>
      </div>
  </div>
  <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
          <div class="inner">
              <h3>{{ $module }}</h3>
              <p>Module</p>
          </div>
          <div class="icon">
              <i class="fas fa-bookmark"></i>
          </div>
      </div>
  </div>
  <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
          <div class="inner">
              <h3>{{ $student }}</h3>
              <p>Student</p>
          </div>
          <div class="icon">
              <i class="fas fa-user-alt"></i>
          </div>
      </div>
  </div>
</div>
@endsection
</x-templates.default>
