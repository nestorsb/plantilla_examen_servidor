<?php

/**
 * Clase que extiende del EntityRepository donde podemos personalizar los métodos
 * que creamos necesitar añadiendo a los ya definidos por defecto.
 */

namespace App\Repository;

use App\Entity\Agent;
use App\Entity\Stats;
use App\Entity\Span;
use App\Entity\Uploads;
use App\Core\EntityManager;
use App\Entity\Events;
use App\Entity\StatsEvents;
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

    /**
     * También se pueden usar metodos como findBy****
     * donde **** es la variable que hacer referencia a una columna de una tabla
     * La primera letra debe ponerse en mayusculas
     * por ejemplo:findByFaction() para realizar una busqueda
     */

    /**
     * Función Personalizada que se encarga de verificar el logueo de un usuario
     */
    public function doLogin($name, $pass)
    {
        //cargamos el EntityManeger y realizamos una busqueda por campo de agente_name
        //Ojo con findBy devuelve un array y no una línea
        $agente = $this->findOneBy(['agent_name' => $name]);
        if (is_null($agente) || empty($agente)) {
            return false;
        } else {
            //Comprobamos la contraseña para verificar que es o no correcta.
            return password_verify($pass, $agente->getPassword());
        }
    }

    /**
     * Función Personalizada que se encarga de realizar el registro en la BB.DD. si procede
     * Devuelve false, si el agente no se ha registrado.
     */
    public function doRegister($name, $pass, $fac)
    {
        //cargamos el EntityManeger y realizamos una busqueda por campo de agente_name
        $agente = $this->findOneBy(['agent_name' => $name]);
        if (is_null($agente) || empty($agente)) {
            //echo "No existe ningún agente con ese nombre<br>";
            if ($fac == 1) {
                $faction = 'Resistance';
            } else {
                $faction = 'Enlightened';
            }
            $agent = new Agent();
            $agent->setAgent_name($name)
                ->setPassword(password_hash($pass, PASSWORD_BCRYPT))
                ->setFaction($faction);
            $this->getEntityManager()->persist($agent);
            $this->getEntityManager()->flush();
            //Tras el flush enviamos el id del agente para verificar que efectivamente se ha insertado en la BB.DD.
            return $agent->getId_agent();
        } else {
            $this->error_type['type'] = 3;
            $this->error_type['msg'] = "Ya existe un agente con este nombre";
            //echo "Existen agentes con ese nombre<br>";
            return 0;
        }
    }

    /**
     * Funcion que recibe las estadisticas en formato de texto desde el HTML, las divide en cabeceras y datos y los mete una matriz con dos dimensiones,
     * la 0 con cabeceras, la 1 con datos
     * @param estadisticas brutas
     * @return array bidimensional de stats
     */
    public function parseStats($rawStats)
    {
        //borramos comillas del string
        $rawStats = str_replace('"', '', $rawStats);
        //Separa cabecera y datos
        $stats = explode("\n", $rawStats);
        //Creamos array ordenado con las cabeceras
        $stats[0] = explode("\t", $stats[0]);
        //Creamos array ordenado con los datos
        $stats[1] = explode("\t", $stats[1]);
        return $stats;
    }

    /**
     * Funcion que obtiene los datos de las stats, y realiza la correspondiente insercion en stats y en upload en bbdd.
     * @return id_upload
     */
    public function doUploadStats($rawStats, $agent_name)
    {


        //Preparamos las stats en array 2 dimensiones con cabeceras y datos correspondientemente
        $statsArray = $this->parseStats($rawStats);


        //DESARROLLO BORRAR - muestra las cabeceras ordenadas
        // foreach($statsArray[0] as $key=>$value){
        //     echo $key." - ".$value;
        //     echo "<br>";
        // }

        $agentExist = false;
        //Comprobamos que el agente que sube las estadisticas es el mismo al que pertenecen las mismas.
        foreach ($statsArray[0] as $key => $value) {
            if ($value == "Agent Name") {
                if ($statsArray[1][$key] == $agent_name) {
                    $agentExist = true;
                }
            }
        }
        if (!$agentExist) {
            //El agente no es el mismo, devolvemos error
            $this->error_type['type'] = 1;
            $this->error_type['msg'] = "El agente que sube las estadisticas no coincide con el propietario de las mismas";
            return 0;
        } else {
            //Creamos objetos uploads y stats para empezar con la insercion a bbdd
            $upload = new Uploads();
            $stat = new Stats();
            //Esta upload pertenece a Stats y NO a StatsEvents
            $upload->setEvent(false);


            //En este Foreach recorremos las stadisticas y vamos asignando los valores correspondientes de las mismas a stats y uploads
            foreach ($statsArray[0] as $key => $value) {
                switch ($value) {
                    case "Time Span":
                        $spanRepository = $this->getEntityManager()->getRepository(Span::class);
                        $span = $spanRepository->findOneBy(["time_span" => $statsArray[1][$key]]);
                        $upload->setSpan($span);
                        break;
                    case "Agent Name":
                        $agent = $this->findOneBy(["agent_name" => $statsArray[1][$key]]);
                        $upload->setAgent($agent);
                        $stat->setAgent($agent);
                        break;
                    case "Date (yyyy-mm-dd)":
                        $upload->setDate(new \DateTime($statsArray[1][$key]));
                        break;
                    case "Time (hh:mm:ss)":
                        $upload->setTime(new \DateTime($statsArray[1][$key]));
                        break;
                    case "Level":
                        $stat->setLevel($statsArray[1][$key]);
                        break;
                    case "Lifetime AP":
                        $stat->setLifetimeAP($statsArray[1][$key]);
                        break;
                    case "Current AP":
                        $stat->setCurrentAP($statsArray[1][$key]);
                        break;
                    case "Unique Portals Visited":
                        $stat->setUniquePortals($statsArray[1][$key]);
                        break;
                    case "Unique Portals Drone Visited":
                        $stat->setUniquePortalsDrone($statsArray[1][$key]);
                        break;
                    case "Furthest Drone Distance":
                        $stat->setFurthestDrone($statsArray[1][$key]);
                        break;
                    case "Portals Discovered":
                        $stat->setPortalsDiscovered($statsArray[1][$key]);
                        break;
                    case "XM Collected":
                        $stat->setXmCollected($statsArray[1][$key]);
                        break;
                    case "OPR Agreements":
                        $stat->setOpr($statsArray[1][$key]);
                        break;
                    case "Resonators Deployed":
                        $stat->setResonatorsDeployed($statsArray[1][$key]);
                        break;
                    case "Links Created":
                        $stat->setLinksCreated($statsArray[1][$key]);
                        break;
                    case "Control Fields Created":
                        $stat->setControlFieldsCreated($statsArray[1][$key]);
                        break;
                    case "Mind Units Captured":
                        $stat->setMindUnitsCaptured($statsArray[1][$key]);
                        break;
                    case "Longest Link Ever Created":
                        $stat->setLongestLink($statsArray[1][$key]);
                        break;
                    case "Largest Control Field":
                        $stat->setLargestControlField($statsArray[1][$key]);
                        break;
                    case "XM Recharged":
                        $stat->setXmRecharged($statsArray[1][$key]);
                        break;
                    case "Portals Captured":
                        $stat->setPortalCaptured($statsArray[1][$key]);
                        break;
                    case "Unique Portals Captured":
                        $stat->setUniquePortalsCaptured($statsArray[1][$key]);
                        break;
                    case "Mods Deployed":
                        $stat->setModsDeployed($statsArray[1][$key]);
                        break;
                    case "Hacks":
                        $stat->setHacks($statsArray[1][$key]);
                        break;
                    case "Drone Hacks":
                        $stat->setDroneHacks($statsArray[1][$key]);
                        break;
                    case "Glyph Hack Points":
                        $stat->setGlyph($statsArray[1][$key]);
                        break;
                    case "Completed Hackstreaks":
                        $stat->setHackstreaks($statsArray[1][$key]);
                        break;
                    case "Longest Sojourner Streak":
                        $stat->setSojourner($statsArray[1][$key]);
                        break;
                    case "Resonators Destroyed":
                        $stat->setResonatorsDestroyed($statsArray[1][$key]);
                        break;
                    case "Portals Neutralized":
                        $stat->setPortalsNeutralized($statsArray[1][$key]);
                        break;
                    case "Enemy Links Destroyed":
                        $stat->setLinksDestroyed($statsArray[1][$key]);
                        break;
                    case "Enemy Fields Destroyed":
                        $stat->setFieldsDestroyed($statsArray[1][$key]);
                        break;
                    case "Battle Beacon Combatant":
                        $stat->setBattleBeacon($statsArray[1][$key]);
                        break;
                    case "Drones Returned":
                        $stat->setDronesReturned($statsArray[1][$key]);
                        break;
                    case "Max Time Portal Held":
                        $stat->setTimePortalHeld($statsArray[1][$key]);
                        break;
                    case "Max Time Link Maintained":
                        $stat->setTimeLinkMaintained($statsArray[1][$key]);
                        break;
                    case "Max Link Length x Days":
                        $stat->setLinkLengthDays($statsArray[1][$key]);
                        break;
                    case "Max Time Field Held":
                        $stat->setTimeFieldHeld($statsArray[1][$key]);
                        break;
                    case "Largest Field MUs x Days":
                        $stat->setFieldMusDays($statsArray[1][$key]);
                        break;
                    case "Forced Drone Recalls":
                        $stat->setForcedDrone($statsArray[1][$key]);
                        break;
                    case "Distance Walked":
                        $stat->setDistanceWalked($statsArray[1][$key]);
                        break;
                    case "Kinetic Capsules Completed":
                        $stat->setKinectCapsules($statsArray[1][$key]);
                        break;
                    case "Unique Missions Completed":
                        $stat->setMissionCompleted($statsArray[1][$key]);
                        break;
                    case "Mission Day(s) Attended":
                        $stat->setMissionDays($statsArray[1][$key]);
                        break;
                    case "NL-1331 Meetup(s) Attended":
                        $stat->setNl1331($statsArray[1][$key]);
                        break;
                    case "First Saturday Events":
                        $stat->setFirstSaturday($statsArray[1][$key]);
                        break;
                    case "Recursions":
                        $stat->setRecursions($statsArray[1][$key]);
                        break;
                    case "Months Subscribed":
                        $stat->setMonthsSubscribed($statsArray[1][$key]);
                        break;
                }
            }
            //Por ultimo añadimos el objeto upload a la entiedad stats para que se suba a bbdd
            $this->getEntityManager()->persist($upload);
            $stat->setId_upload($upload);
            $this->getEntityManager()->persist($stat);
            $this->getEntityManager()->flush();

            //devolvemos el Id del upload correspondiente a la presente subida de estadisticas
            return $stat->getId_upload()->getId_upload();
        }
    }

    public function doUploadStatsEvents($rawStats, $agent_name, $event_id)
    {
        //Preparamos las stats en array 2 dimensiones con cabeceras y datos correspondientemente
        $statsArray = $this->parseStats($rawStats);

        $agentExist = false;
        //Comprobamos que el agente que sube las estadisticas es el mismo al que pertenecen las mismas.
        foreach ($statsArray[0] as $key => $value) {
            if ($value == "Agent Name") {
                if ($statsArray[1][$key] == $agent_name) {
                    $agentExist = true;
                }
            }
        }
        if (!$agentExist) {
            //El agente no es el mismo, devolvemos error
            $this->error_type['type'] = 1;
            $this->error_type['msg'] = "El agente que sube las estadisticas no coincide con el propietario de las mismas";
            return 0;
        } else {
            //Creamos objetos uploads y stats para empezar con la insercion a bbdd
            $upload = new Uploads();
            $statEvent = new StatsEvents();
            $eventsRepository = $this->getEntityManager()->getRepository(Events::class);
            $event = $eventsRepository->findOneBy(["id_event" => $event_id]);
            //Esta upload pertenece a un Evento, por tanto es true. Ademas le pasamos el objeto del evento correspondiente a statsEvent
            $upload->setEvent(true);
            $statEvent->setEvent($event);

            //En este Foreach recorremos las stadisticas y vamos asignando los valores correspondientes de las mismas a stats y uploads
            foreach ($statsArray[0] as $key => $value) {
                switch ($value) {
                    case "Time Span":
                        $spanRepository = $this->getEntityManager()->getRepository(Span::class);
                        $span = $spanRepository->findOneBy(["time_span" => $statsArray[1][$key]]);
                        $upload->setSpan($span);
                        break;
                    case "Agent Name":
                        $agent = $this->findOneBy(["agent_name" => $statsArray[1][$key]]);
                        $upload->setAgent($agent);
                        $statEvent->setAgent($agent);
                        break;
                    case "Date (yyyy-mm-dd)":
                        $upload->setDate(new \DateTime($statsArray[1][$key]));
                        break;
                    case "Time (hh:mm:ss)":
                        $upload->setTime(new \DateTime($statsArray[1][$key]));
                        break;
                    case "Lifetime AP":
                        $statEvent->setLifetimeAP($statsArray[1][$key]);
                        break;
                    case "Unique Portals Visited":
                        $statEvent->setUniquePortalsVisited($statsArray[1][$key]);
                        break;
                    case "Resonators Deployed":
                        $statEvent->setResonatorsDeployed($statsArray[1][$key]);
                        break;
                    case "Links Created":
                        $statEvent->setLinksCreated($statsArray[1][$key]);
                        break;
                    case "Control Fields Created":
                        $statEvent->setControlFields($statsArray[1][$key]);
                        break;
                    case "XM Recharged":
                        $statEvent->setXmRecharged($statsArray[1][$key]);
                        break;
                    case "Portals Captured":
                        $statEvent->setPortalsCaptured($statsArray[1][$key]);
                        break;
                    case "Hacks":
                        $statEvent->setHacks($statsArray[1][$key]);
                        break;
                    case "Resonators Destroyed":
                        $statEvent->setResonatorsDestroyed($statsArray[1][$key]);
                        break;
                }
            }
            //Por ultimo añadimos el objeto upload a la entiedad statsEvents y persistimos todo para que se suba a bbdd
            $this->getEntityManager()->persist($upload);
            $statEvent->setUpload($upload);
            $this->getEntityManager()->persist($statEvent);
            $this->getEntityManager()->flush();

            //devolvemos el Id del upload correspondiente a la presente subida de estadisticas
            return $statEvent->getUpload()->getId_upload();
        }
    }



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