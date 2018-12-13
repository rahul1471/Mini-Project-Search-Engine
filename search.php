
<?php
include("user.php");
include("config.php");
include("classes/SiteResultProvider.php");
include("classes/EntertainmentResultProvider.php");
include("classes/NewsResultProvider.php");
include("classes/ImagesResultProvider.php");

if(isset($_GET["term"])){
	$term = $_GET["term"];
}
else{
	exit("You must enter a search term");
}

if(isset($_GET["type"])){
	$type = $_GET["type"];
}
else{
	$type="sites";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Doodle</title>

	<link rel="stylesheet" type="text/css" href="assets/css/styleSearch.css">
</head>
<body>
	<div class="wrapper indexPage">
		<div class="header">
			<div class="headerContent">
				<div class="logoContainer">
					<a href="index.php">
					<img src="assets/swabhiman.jpg" width="100">
					</a>
				</div>
				<div class="searchContainer">
					<form action="search.php" method="GET">
						<div class="searchBarContainer">
							<input class="searchBox" type="text" name="term">
							<button class="searchButton">
								<img src="assets/search.png">
							</button>
							

						</div>
					
				</div>
				
			</div>
			
		</div>
		 <div class="tabContainer">
		 	<ul class="tabList"> 
		 		<li class='<?php echo $type == 'sites' ? 'active' : '' ?>'>
		 			<a href='<?php echo "search.php?term=$term&type=sites";?>'> All</a>
		 		</li>

		 		<li class='<?php echo $type == 'images' ? 'active' : '' ?>'>
		 			<a href='<?php echo "search.php?term=$term&type=images";?>'> Images</a>
           
		 		</li>

		 		<li class='<?php echo $type == 'news' ? 'active' : '' ?>'>
		 			<a href='<?php echo "search.php?term=$term&type=news";?>'> News</a>
		 		</li>

		 		<li class='<?php echo $type == 'entertainment' ? 'active' : '' ?>'>
		 			<a href='<?php echo "search.php?term=$term&type=entertainment"; ?>'> Entertainment</a>
		 		</li>

		 		
		 		
		 		
		 	</ul>
		 	
		 </div>
	</div>
	<div class="mainResultsSection">
		<?php
		if($type=="sites")
		$resultsProvider = new SiteResultProvider($con);
		else if($type=="news")
		$resultsProvider = new NewsResultProvider($con);
		else if ($type=="entertainment") 
			$resultsProvider = new EntertainmentResultProvider($con); 
		
		else
			$resultsProvider = new ImagesResultsProvider($con);

         
		$numResults=$resultsProvider->getResults($term);
		$totalResult=$resultsProvider->getTotalResults();
		
		if($type=='sites')
		{
			echo "<p class='resultcount'>$numResults results found </p>";
		}
		else
		{
		echo "<p class='resultcount'>$numResults results found </p>";
			echo "out of $totalResult Contents";
		}



		echo $resultsProvider->getResultsHtml(1,20,$term);

		if($type="sites")
		{
			insert($agent, $ip);
		}

		?>
		
	</div>

</div>
</body>
</html>