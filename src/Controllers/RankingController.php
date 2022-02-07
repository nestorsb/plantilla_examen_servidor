<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\stats;
use App\Core\EntityManager;


class RankingController extends AbstractController
{
  public function showranking()
  {
    $em = (new EntityManager())->get();

    //Obtenemos todas las estadisticas sin filtrar ni ordenar
    $statsRepository = $em->getRepository(Stats::class);

    //Obtenemos el nombre de las columnas
    $PropertyNames = $this->getPropertyNamesOfStats();

    //Seleccionamos valor por defecto del parametro a ordenar = "level"
    if (!isset($_POST["order"])) {
      $_POST["order"] = "level";
    }
    //Detectamos que parametro recibimos para filtrar, por defecto este parametro es "level".
    if ($_POST["order"]) {
      $parameter = $_POST["order"];
    }

    //obtengo todas las stats ordenadas de mayor a menor por el parametro que recibo por POST
    $stats = $statsRepository->findBy(
      array(),
      array($parameter => 'DESC')
    );

    //Filtramos estadisticas para mostrar solo las ultimas subidas por el Agente.
    $stats = $statsRepository->DoGroupByInStats($stats);

    //Cargamos la plantilla
    $this->render("ranking.html", [
      "parameter" => $parameter,
      "columnNames" => $PropertyNames,
      "stats" => $stats
    ]);
  }

  /**
   * Funcion que devuelve los nombres de las propiedades de la entidad Stats en un array
   * @return array unidimensional
   */
  public function getPropertyNamesOfStats()
  {
    $statprueba = new Stats;
    $arrayRawProperties = (array)$statprueba;
    $goodPropertiesNames = array();
    foreach ($arrayRawProperties as $key => $value) {
      $arrayInfoi = substr($key, 18); // el objetivo es quitar "App\Entity\stats" de las $key, por eso 18
      array_push($goodPropertiesNames, $arrayInfoi);
    }
    //Quitamos del array los nombres de las propiedades que no vamos a mostrar en el HTML
    $goodPropertiesNames = array_diff($goodPropertiesNames, array('id_stats', 'id_upload'));

    return $goodPropertiesNames;
  }
}
