<?php 
	function timeAgo($time)
	{
		$time_ago = strtotime($time);
		$cur_time = time();
		$time_elapsed = $cur_time - $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );

		// Seconds
		if($seconds <= 60){ return "Ara mateix"; }
		//Minutes
		else if($minutes <=60){
			if($minutes==1){ return "Fa un minut"; }
			else{ return "Fa $minutes minuts"; }
		}
		//Hours
		else if($hours <=24){
			if($hours==1){ return "Fa una hora"; }
			else{ return "Fa $hours hores"; }
		}
		//Days
		else if($days <= 7){
			if($days==1){ return "Ahir"; }
			else{ return "Fa $days dies";}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){ return "Fa una setmana"; }
			else{ return "Fa $weeks setmanes"; }
		}
		//Months
		else if($months <=12){
			if($months==1){ return "Fa un mes"; }
			else{ return "Fa $months mesos";
			} }
		//Years
		else{
			if($years==1){ return "Fa un any"; }
			else{ return "Fa $years anys"; }
		}
	}
?>
