@extends('layouts.app')

@section('content')
<?php $course = \App\Models\Course::where('id', $idCourse)->first();
	$players = Auth::User()->players; ?>

                    <form class="form-horizontal" role="form" method="POST" action="/editScore">
                        {{ csrf_field() }}
						@foreach($players as $player)
						<input type="radio" name="playerSelect" value="{{$player->id}}" checked>{{$player->name}}
					@endforeach
						<table>
							<tr>
								<td>Hole</td>					
								@for ($i = 1; $i <= 18; $i++)
								<td>{{$i}}</td>
								@endfor
							</tr>
						<?php $score = 
							\Auth::user()->scores()->where('course_id', $idCourse)->first();
							$hasScore = ($score != null); ?>
						@foreach($course->colors as $color)
						<tr>
							<?php $scoreColor = null;
								$hasScoreColor = false;
								$scoreArray = array();
								if ($hasScore){
								$scoreColor = 
									$score->scoreColors()->where('color', $color->color)->first();
									$hasScoreColor = ($scoreColor != null);
									$scoreArray = json_decode($scoreColor->sc);
							} ?>
							<td>{{$color->color}}</td> <!-- capitalize -->	
							
							@for($k=1; $k<=18; $k++)
								<td><input type="text" 
									name="{{'' . $color->color . $k}}" size="2" 
									@if($hasScoreColor)
										value="{{$scoreArray[$k-1]}}"
									@endif>
							@endfor
						</tr>
						@endforeach                      
						</table>
						<input type="hidden" name="idPass" value="{{$course->id}}">
						<input type="submit" value="submit" name="submit">
					 </form>

@endsection
