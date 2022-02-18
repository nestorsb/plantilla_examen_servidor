<?php

/**
 * Clase que extiende del EntityRepository donde podemos personalizar los métodos
 * que creamos necesitar añadiendo a los ya definidos por defecto.
 */

namespace App\Repository;

use App\Entity\Agent;
use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Util\Debug;


/**
 * Por defecto hemos extendido los métodos:
 * find, findBy, findOneBy y findAll
 */
class AgentRepository extends EntityRepository
{
    /**
     * Variable que almacena los errores en un array de la siguiente forma:
     * 1 - Tipo de error (numero)
     * 2 - Mensaje de error
     */
    private $error_type = array(
        'type' => null,
        'msg' => null
    );




    //GETTERS Y SETTERS

    /**
     * Get variable que almacena los errores en un array de la siguiente forma:
     */
    public function getError_type()
    {
        return $this->error_type;
    }
}

    



















    // public function uploadStats($rawStats)
    // {

    //     // TRATAMIENTO DEL INPUT DE ESTADISTICAS PARA AÑADIRLO A UNA SECUENCIA SQL


    //     $stats_general = explode("\n", $rawStats);

    //     // Filtro para evitar el envio de datos que pueden dar lugar a errores
    //     if (!isset($stats_general[0]) || !isset($stats_general[1])) {
    //         echo " <br> Error al subir las estadisticas, es posible que los datos introducidos no sean correctos.";
    //         return false;
    //     }


    //     $stats_cabecera = explode("\t", $stats_general[0]);
    //     $stats_datos = explode("\t", $stats_general[1]);

    //     //Elimina el ultimo elemento de las estadisticas si este esta vacio
    //     isset($stats_datos[count($stats_datos) - 1]) ? array_pop($stats_datos) : NULL;


    //     if (count($stats_cabecera) !== count($stats_datos) + 1 || count($stats_datos) < 48) {
    //         echo " <br> Error al subir las estadisticas, es posible que los datos introducidos no sean correctos.";
    //         return false;
    //     }


    //     $cabecerasBasicas = array_slice($stats_cabecera, 0, 5);
    //     $cabecerasStats = array_slice($stats_cabecera, 5);
    //     $datosBasicos = array_slice($stats_datos, 0, 5);
    //     $datosStats = array_slice($stats_datos, 5);


    //     //Sustituimos espacios por _ en las cabeceras para que el SQL coincida con la bbdd
    //     //Ademas si la cabeceras contiene un parentesis, se entrecomilla para evitar errores con la insercion
    //     foreach ($cabecerasStats as $key => $value) {
    //         $cabecerasStats[$key] = str_replace(" ", "_", $cabecerasStats[$key]);
    //         if (strpos($cabecerasStats[$key], "(") !== false) {
    //             $cabecerasStats[$key] = "`" . $cabecerasStats[$key] . "`";
    //         }
    //     }
    //     //Obtenemos el agente al que pertenecen las estadisticas
    //     $spanRepository = $this->getEntityManager()->getRepository(Span::class);

    //     $agent = $this->findOneBy(['agent_name' => $datosBasicos[1]]);
    //     $span =  $spanRepository->findOneBy(['time_span' => $datosBasicos[0]]);
    //     $statEvent = false; //la subida es o de Stats o de StatsEvents, son incompatibles, de momento pongo false porque no se como lo acepta el Doctrine

    //     // var_dump($span);
    //     // debug::dump($span);

    //     // INSERTS

    //     $upload = new Uploads();
    //     $upload
    //         ->setDate(new \DateTime($datosBasicos[3]))
    //         ->setTime(new \DateTime($datosBasicos[4]))
    //         ->setAgent($agent)
    //         ->setSpan($span)
    //         ->setEvent(false);

    //         // $this->getEntityManager()->persist($upload);


    //     //Faltan 12 - Mind_Units_Captured,  13 - Longest_Link_Ever_Created, 31 - Max_Time_Link_Maintained,
    //     $stats = new Stats();
    //     $stats
    //         ->setId_upload($upload)
    //         ->setAgent($agent)
    //         ->setLevel($datosStats[0])
    //         ->setLifetimeAP($datosStats[1])
    //         ->setCurrentAP($datosStats[2])
    //         ->setUniquePortals($datosStats[3])
    //         ->setUniquePortalsDrone($datosStats[4])
    //         ->setFurthestDrone($datosStats[5])
    //         ->setSeer(null)
    //         ->setPortalsDiscovered($datosStats[6])
    //         ->setXmCollected($datosStats[7])
    //         ->setOpr($datosStats[8])
    //         ->setPortalScans(null)
    //         ->setUniqueScoutControlled(null)
    //         ->setResonatorsDeployed($datosStats[9])
    //         ->setLinksCreated($datosStats[10])
    //         ->setControlFieldsCreated($datosStats[11])
    //         ->setLargestControlField($datosStats[14])
    //         ->setXmRecharged($datosStats[15])
    //         ->setPortalCaptured($datosStats[16])
    //         ->setUniquePortalsCaptured($datosStats[17])
    //         ->setModsDeployed($datosStats[18])
    //         ->setHacks($datosStats[19])
    //         ->setDroneHacks($datosStats[20])
    //         ->setGlyph($datosStats[21])
    //         ->setHackstreaks($datosStats[22])
    //         ->setSojourner($datosStats[23])
    //         ->setResonatorsDestroyed($datosStats[24])
    //         ->setPortalsNeutralizad($datosStats[25])
    //         ->setLinksDestroyed($datosStats[26])
    //         ->setFieldsDestroyed($datosStats[27])
    //         ->setBattleBeacon($datosStats[28])
    //         ->setDronesReturned($datosStats[29])
    //         ->setTimePortalHeld($datosStats[30])
    //         ->setLinkLengthDays($datosStats[32])
    //         ->setTimeFieldHeld($datosStats[33])
    //         ->setFieldMusDays($datosStats[34])
    //         ->setForcedDrone($datosStats[35])
    //         ->setDistanceWalked($datosStats[36])
    //         ->setKinectCapsules($datosStats[37])
    //         ->setMissionCompleted($datosStats[38])
    //         ->setMissionDays($datosStats[39])
    //         ->setNl1331($datosStats[40])
    //         ->setFirstSaturday($datosStats[41])
    //         ->setAgentsRecluited(null)
    //         ->setRecursions($datosStats[42])
    //         ->setMouthsSubscribed($datosStats[43])
    //         ->setLinksActive(null)
    //         ->setPortalsOwned(null)
    //         ->setFieldsActive(null)
    //         ->setMindUnitControl(null)
    //         ->setCurrentHackstreaks(null)
    //         ->setCurrentSojourner(null);

    //     // $this->getEntityManager()->persist($stats);
    //     // debug::dump($stats->getId_upload());
    //     $upload->setStat($stats);
    //     debug::dump($upload->getStat());
        

    //     // $this->getEntityManager()->persist($stats);
    //     // $this->getEntityManager()->persist($upload);
    //     // $this->getEntityManager()->flush();
    // }

// }