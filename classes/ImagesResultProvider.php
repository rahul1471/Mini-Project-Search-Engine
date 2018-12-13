<?php
class ImagesResultsProvider {

	private $con;

	public function __construct($con) {
		$this->con = $con;
	}

	public function getTotalResults() {

		$query = $this->con->prepare("CALL `totalImages`()");
		$query->execute();
		$sum = $query->fetch(PDO::FETCH_ASSOC);
		return $sum["TOTAL"];


	}

	public function getResults($term) {

		$query = $this->con->prepare("SELECT COUNT(*) as total 
										 FROM images 
										 WHERE (title LIKE :term 
										 OR alt LIKE :term)");

		$searchTerm = "%". $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row["total"];

	}

	public function getResultsHtml($page, $pageSize, $term) {

		$fromLimit = ($page - 1) * $pageSize;

		$query = $this->con->prepare("SELECT * 
										 FROM images 
										 WHERE (title LIKE :term 
										 OR alt LIKE :term)
										 LIMIT :fromLimit, :pageSize");

		$searchTerm = "%". $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
		$query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
		$query->execute();


		$resultsHtml = "<div class='imageResults'>";

		$count = 0;
		while($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$count++;
			$id = $row["id"];
			$imageUrl = $row["imageUrl"];
			$siteUrl = $row["siteUrl"];
			$title = $row["title"];
			$alt = $row["alt"];

			if($title) {
				$displayText = $title;
			}
			else if($alt) {
				$displayText = $alt;
			}
			else {
				$displayText = $imageUrl;
			}
			
			$resultsHtml .= "<div class='gridItem image$count'>
								<a href='$imageUrl'> 
									<img src='$imageUrl'>
									</a>
							</div>";


		}


		$resultsHtml .= "</div>";

		return $resultsHtml;
	}




}
?>