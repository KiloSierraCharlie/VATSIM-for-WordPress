<?php
require_once( dirname(__FILE__) . "/../classes/DataHandler/DataHandler.php" );
use VATSIM\DataHandler;
add_shortcode( 'vatsim_online', function( $arguments ){
    
    if( !isset( $arguments[ "type" ] ) ){ return; }
    
    $DH = new DataHandler();
    
    switch( $arguments[ "type" ] ){
    
        case "pilots":
            $filter_dept = isset( $arguments[ "filter_dept" ] ) ? $DH->searchFor( "getPilots", "/{$arguments[ "filter_dept" ]}/i", "planned_depairport" ) : $DH->getPilots();
            $filter_dest = isset( $arguments[ "filter_dest" ] ) ? $DH->searchFor( "getPilots", "/{$arguments[ "filter_dest" ]}/i", "planned_destairport" ) : $DH->getPilots();
            
            $results = array();
            
            foreach( $filter_dept as $pilotA ){
                
                if( isset( $arguments[ "filter_both" ] ) ){ 
                
                    foreach( $filter_dest as $pilotB ){
                        
                        if( $pilotA->callsign == $pilotB->callsign ){ array_push( $results, $pilotA ); }
                        
                    }
                
                }else{
                    
                    array_push( $results, $pilotA );
                    
                }
                
            }
            
            if( !isset( $arguments[ "filter_both" ] ) ){
                
                foreach( $filter_dest as $pilotA ){
                    
                    foreach( $results as $pilotB ){
                        
                        if( $pilotA->callsign == $pilotB->callsign ){ continue 2; }
                        
                    }
                    
                    array_push( $results, $pilotA );
                    
                }
                
            }
            
            echo "<table>";
            echo "<tr><th>Callsign</th><th>Name</th><th>Departure</th><th>Destination</th></tr>";
            foreach( $results as $pilot ){
                
                echo "<tr>";
                echo "<td>{$pilot->callsign}</td>";
                echo "<td>{$pilot->realname}</td>";
                echo "<td>{$pilot->planned_depairport}</td>";
                echo "<td>{$pilot->planned_destairport}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
        
        case "airtraffic":
            $results = isset( $arguments[ "filter_callsign" ] ) ? $DH->searchFor( "getAirTraffic", "/{$arguments[ "filter_callsign" ]}/i", "callsign" ) : $DH->getAirTraffic();
            
            echo "<table>";
            echo "<tr><th>Callsign</th><th>Name</th><th>Frequency</th></tr>";
            foreach( $results as $ATC ){
                
                echo "<tr>";
                echo "<td>{$ATC->callsign}</td>";
                echo "<td>{$ATC->realname}</td>";
                echo "<td>{$ATC->frequency}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
            
        case "prefiled":
            $filter_dept = isset( $arguments[ "filter_dept" ] ) ? $DH->searchFor( "getPrefiled", "/{$arguments[ "filter_dept" ]}/i", "planned_depairport" ) : $DH->getPrefiled();
            $filter_dest = isset( $arguments[ "filter_dest" ] ) ? $DH->searchFor( "getPrefiled", "/{$arguments[ "filter_dest" ]}/i", "planned_destairport" ) : $DH->getPrefiled();
            
            $results = array();
            
            foreach( $filter_dept as $pilotA ){
                
                if( isset( $arguments[ "filter_both" ] ) ){ 
                
                    foreach( $filter_dest as $pilotB ){
                        
                        if( $pilotA->callsign == $pilotB->callsign ){ array_push( $results, $pilotA ); }
                        
                    }
                
                }else{
                    
                    array_push( $results, $pilotA );
                    
                }
                
            }
            
            if( !isset( $arguments[ "filter_both" ] ) ){
                
                foreach( $filter_dest as $pilotA ){
                    
                    foreach( $results as $pilotB ){
                        
                        if( $pilotA->callsign == $pilotB->callsign ){ continue 2; }
                        
                    }
                    
                    array_push( $results, $pilotA );
                    
                }
                
            }
            
            echo "<table>";
            echo "<tr><th>Callsign</th><th>Name</th><th>Departure</th><th>Destination</th><th>Planned Time</th></tr>";
            foreach( $results as $pilot ){
                
                echo "<tr>";
                echo "<td>{$pilot->callsign}</td>";
                echo "<td>{$pilot->realname}</td>";
                echo "<td>{$pilot->planned_depairport}</td>";
                echo "<td>{$pilot->planned_destairport}</td>";
                echo "<td>{$pilot->planned_deptime}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
            
        case "voiceservers":
            $results = $DH->getVoiceServers();
            
            echo "<table>";
            echo "<tr><th>IP / Hostname</th><th>Name</th><th>Location</th></tr>";
            foreach( $results as $vs ){
                
                echo "<tr>";
                echo "<td>{$vs->hostname_or_IP}</td>";
                echo "<td>{$vs->name}</td>";
                echo "<td>{$vs->location}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
            
        case "staff":
            $results = $DH->getStaff();
            
            echo "<table>";
            echo "<tr><th>Callsign</th><th>Name</th></tr>";
            foreach( $results as $staff ){
                
                echo "<tr>";
                echo "<td>{$staff->callsign}</td>";
                echo "<td>{$staff->realname}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
            
        case "supervisors":
            $results = $DH->getSupervisors();
            
            echo "<table>";
            echo "<tr><th>Callsign</th><th>Name</th></tr>";
            foreach( $results as $staff ){
                
                echo "<tr>";
                echo "<td>{$staff->callsign}</td>";
                echo "<td>{$staff->realname}</td>";
                echo "</tr>";
                
            }
            echo "</table>";
            break;
    
        default:
            return;
    
    }
    
} );