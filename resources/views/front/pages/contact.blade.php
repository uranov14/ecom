@extends('layouts.front_layouts.front_layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div id="mainBody">
  <div class="container">	
    <div class="row">
      <div class="span4">
        <h4>Contact Details</h4>
        <p>	Ukrainian Sector<br/> CA 93727, USA
          <br/><br/>
          info@sitemakers.in<br/>
          ﻿Tel 00000-00000<br/>
          Fax 00000-00000<br/>
          web: https://www.youtube.com/StackDevelopers
        </p>		
      </div>
        
      <div class="span4">
        <h4>Email Us</h4>

        @if (Session::has('success_message'))
          <div class="alert alert-success" role="alert">
            <strong>Success: </strong>{{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        <form action="{{ url('/contact') }}" class="form-horizontal" method="POST">@csrf
          <fieldset>
            <div class="control-group">             
              <input type="text" name="name" placeholder="name" class="input-xlarge"/>             
            </div>
            <div class="control-group">
              <input type="text" name="email" placeholder="email" class="input-xlarge"/>
            </div>
            <div class="control-group">    
              <input type="text" name="subject" placeholder="subject" class="input-xlarge"/>
            </div>
            <div class="control-group">
              <textarea rows="3" name="message" id="textarea" class="input-xlarge"></textarea> 
            </div>

              <button class="btn btn-large" type="submit">Send Messages</button>

          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Page Introduction Wrapper /- -->
@endsection
