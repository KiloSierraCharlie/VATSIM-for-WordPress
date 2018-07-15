<?php
require_once( dirname(__FILE__) . "/../classes/EUD-DataHandler/DataHandler.php" );
use VATEUD\DataHandler;

add_shortcode( 'vatsim_vateud', function( $arguments ){
    
    if( !isset( $arguments[ "type" ] ) ){ return; }
    $DH = new DataHandler();

    switch( $arguments[ "type" ] ){
    
        case "staffmembers":
            $results = isset( $arguments[ "vacc" ] ) ? $DH->getStaffMembers( $arguments[ "vacc" ] ) : $DH->getStaffMembers();
            echo "<table>";
            echo "<tr><th>Callsign</th><th>Name</th><th>Position</th><th>Email</th></tr>";
            foreach( $results as $staff ){
                
                echo "<tr>";
                echo "<td>{$staff->callsign}</td>";
                echo "<td>" . ( isset( $staff->member ) ? $staff->member["firstname"] . " " . $staff->member["lastname"] : "VACANT" ) . "</td>";
                echo "<td>{$staff->position}</td>";
                echo "<td>{$staff->email}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
    
        case "frequencies":
            $results = isset( $arguments[ "vacc" ] ) ? $DH->getATCFrequencies( $arguments[ "vacc" ] ) : $DH->getATCFrequencies();
            echo "<table>";
            echo "<tr><th>Callsign</th><th>Frequency</th><th>Position</th></tr>";
            foreach( $results as $frequency ){
                
                echo "<tr>";
                echo "<td>{$frequency->callsign}</td>";
                echo "<td>{$frequency->freq}</td>";
                echo "<td>{$frequency->name}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
    
        case "events":
            $results = isset( $arguments[ "vacc" ] ) ? $DH->getEvents( $arguments[ "vacc" ] ) : $DH->getEvents();
            $count = isset( $arguments[ "count" ] ) ? intval( $arguments[ "count" ] ) : 5;
            foreach( $results as $idx=>$event ){
                
                if( $idx == $count ){ break; }
                
                echo "<h3>{$event->title}</h3>";
                echo "{$event->description}";
                echo "<b><u>{$event->starts} - {$event->ends}</u></b>";
                
            }
            
            break;
    
        case "notams":
            if( !isset( $arguments[ "icao" ] ) ){ break; }

            foreach( $DH->getNOTAMs( $arguments[ "icao"] ) as $notam ){
                                
                echo "<h3>{$notam->icao} - {$notam->message}</h3>";
                echo str_replace( "\n", "<p>", $notam->raw );
                
            }
            
            break;
            
        case "members":
            if( !isset( $arguments[ "vacc" ] ) ){ break; }

            echo "<table>";
            echo "<tr><th>Certificate</th><th>Name</th><th>Controller Rating</th></tr>";
            foreach( $DH->getMembers( $arguments[ "vacc" ] ) as $member ){
                if( !$member->active or $member->rating < 2 ){ continue; } 
                echo "<tr>";
                echo "<td>{$member->cid}</td>";
                echo "<td>{$member->firstname} {$member->lastname}</td>";
                echo "<td>{$member->humanized_atc_rating}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            
            break;
    
        default:
            return;
    
    }
    
} );