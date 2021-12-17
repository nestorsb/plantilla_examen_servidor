<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Models\Agent;
use App\Models\Stats;
use App\Core\DataBase;

class RankingController extends AbstractController
{
  public function showranking()
  {
    $stats = new Stats(new DataBase);

    if ($_POST["filter"]) {
      $parameter = $_POST["filter"];
    }else $parameter = "level";
    
    $column_names = $stats->getColumnNames("stats");
    $results = $stats->getStatsRankingFilteredBy($parameter);


    $this->render("ranking.html", [
      "column_names" => $column_names,
      "parameter" => $parameter,
      "ranking" => $results
    ]);

  }
}
