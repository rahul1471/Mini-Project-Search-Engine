<?php


class NewsResultProvider {

	private $con;

	public function __construct($con) {
		$this->con=$con;


	}

	public function getTotalResults() {

		$query = $this->con->prepare("CALL `totalNews`()");
		$query->execute();
		$sum = $query->fetch(PDO::FETCH_ASSOC);
		return $sum["TOTAL"];


	}

	public function getResults($term) {

		$query = $this->con->prepare("SELECT COUNT(*) AS TOTAL 
										FROM news
										WHERE title LIKE :term 
										OR news_url LIKE :term 
										OR description LIKE :term ");

		$searchTerm = "%" . $term . "%";
		$query->bindParam(":term",$searchTerm);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row["TOTAL"];


	}

	public function getResultsHtml($page, $pageSize, $term) {

		$query = $this->con->prepare("SELECT *
										FROM news
										WHERE title LIKE :term 
										OR news_url LIKE :term 
										OR description LIKE :term 
										");

		$searchTerm = "%". $term ."%";
		$query->bindParam(":term",$searchTerm);
		$query->execute();

		$resultsHtml="<div class='siteResults'>";

		

		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			$id = $row["id"];
			$url = $row["news_url"];
			$title = $row["title"];
			$description = $row["description"];

			$resultsHtml .= "<div class='resultContainer'>
					<h3 class='title'>
						<a class='result' href='$url'>
						$title
						</a>					</h3>
						<span class='url'>$url</span>
						<span class='description'>$description</span>

			</div>";

		}

		$resultsHtml .= "</div>";
		return $resultsHtml;

	}




}
?>