<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Followapp</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style type="text/css">
    	
    	td .btn {
    		display: none;
    	}

    	td .-follow {
    		display: block;
    	}

    	td.following .-follow {
    		display: none;
    	}
    	td.following .-following {
    		display: block;
    	}

    	td.following:hover .-following {
    		display: none;
    	}
    	td.following:hover .-unfollow {
    		display: block;
    	}




    </style>
  </head>
  <body>
    
    <div class="container">

    	@if( !$current_user )
    	<div class="well">
    		Must be signed in
    	</div>
    	@else
    	<div class="well">
    		Welcome, {{ $current_user->name }}
    		<br>
    		Choose users to follow:
    	</div>
    	
    	@endif

      <table class="table users-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Group</th>
            <th>Followers</th>
            <th>Follow</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          	@if($user->id == $current_user->id)
          		@continue
          	@endif
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->group->name }}</td>
              <td>{{ $user->followers()->count() }}</td>
              <td class="{{ $current_user->following->contains($user->id) ? 'following' : '' }}">
                <button type="button" class="btn btn-warning -follow" data-user-id="{{ $user->id }}">Follow</button>
                
                <button type="button" class="btn btn-success -following">Following</button>

                <button type="button" class="btn btn-danger -unfollow" data-user-id="{{ $user->id }}">Unfollow</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>

    <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <script type="text/javascript">


    	$('.users-table .-follow').click(function () {
    		
    		console.log( $(this).data('user-id') );

    		var $cell = $(this).parent();

    		$.ajax({
    		  url: '/',
    		  type: "POST",
    		  data: { 
    		  	'user_id': $(this).data('user-id'),
    		  	'_token': $('meta[name="csrf-token"]').attr('content')
    		  },
    		  success: function(response){ // What to do if we succeed
		          console.log(response);

		          $cell.addClass('following');


		      },
		      error: function(jqXHR, textStatus, errorThrown) { 
		          console.log(JSON.stringify(jqXHR));
		          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);

		          alert('server error');
		      }
    		})

    	});


    	$('.users-table .-unfollow').click(function () {
    		
    		console.log( $(this).data('user-id') );

    		var $cell = $(this).parent();

    		$.ajax({
    		  url: '/unfollow',
    		  type: "POST",
    		  data: { 
    		  	'user_id': $(this).data('user-id'),
    		  	'_token': $('meta[name="csrf-token"]').attr('content')
    		  },
    		  success: function(response){ // What to do if we succeed
		          console.log(response);

		          $cell.removeClass('following');
		      },
		      error: function(jqXHR, textStatus, errorThrown) { 
		          console.log(JSON.stringify(jqXHR));
		          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);

		          alert('server error');
		      }
    		})

    	});


			function setCookie(name,value,days) {
			    var expires = "";
			    if (days) {
			        var date = new Date();
			        date.setTime(date.getTime() + (days*24*60*60*1000));
			        expires = "; expires=" + date.toUTCString();
			    }
			    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
			}
			function getCookie(name) {
			    var nameEQ = name + "=";
			    var ca = document.cookie.split(';');
			    for(var i=0;i < ca.length;i++) {
			        var c = ca[i];
			        while (c.charAt(0)==' ') c = c.substring(1,c.length);
			        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			    }
			    return null;
			}

    </script>
  </body>
</html>
