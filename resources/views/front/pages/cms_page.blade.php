@extends('layouts.front_layouts.front_layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="span9">
  <ul class="breadcrumb">
      <li>
          <a href="{{ url("/") }}">Home</a>
      </li>
      <span class="divider">/</span>
      <li class="active">
          <a href="#">{{ $cmsPageDetails['title'] }}</a>
      </li>
  </ul>
  <h3 align="center">{{ $cmsPageDetails['title'] }}</h3>
  <!-- Cart-Page -->
  <p>
    <?php echo nl2br($cmsPageDetails['description']) ?>
  </p>
  <!-- Cart-Page /- -->
</div>
<!-- Page Introduction Wrapper /- -->
@endsection
