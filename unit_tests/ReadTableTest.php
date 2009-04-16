<?php
require_once 'PHPUnit/Framework.php';
require_once '../sap_config.php';
global $SAP_CONFIG, $SAPNWRFC_LOADED; 

class ReadTableTest extends PHPUnit_Framework_TestCase
{

    protected function setUp() {
        global $SAPNWRFC_LOADED, $SAP_CONFIG;
        if (empty($SAPNWRFC_LOADED)) {
            dl("sapnwrfc.so");
            $SAPNWRFC_LOADED = true;
        }
        $yaml = file_get_contents($SAP_CONFIG);
        $this->config = syck_load($yaml);
        echo "sapnwrfc version: ".sapnwrfc_version()."\n";
        echo "nw rfc sdk version: ".sapnwrfc_rfcversion()."\n";
    }
    
    
    public function testReadTable() {
       try {
            $conn = new sapnwrfc($this->config);
            $h = $conn->function_lookup('RFC_GET_TABLE_ENTRIES');
            $parms = array('BYPASS_BUFFER' => 'X',
                           'MAX_ENTRIES' => 1,
                           'TABLE_NAME' => 'T005ZR');
            $h->invoke($parms);
        }
        catch (sapnwrfcCallException $e) {
            //echo "Exception type: ".$e."\n";
            echo "Exception key: ".$e->key."\n";
            echo "Exception code: ".$e->code."\n";
            echo "Exception message: ".$e->getMessage()."\n";
            $this->assertTrue(TRUE);
        }
        catch (Exception $e) {
            echo "Exception type: ".$e."\n";
            echo "Exception key: ".$e->key."\n";
            echo "Exception code: ".$e->code."\n";
            echo "Exception message: ".$e->getMessage()."\n";
            throw new Exception('Connection failed.');
        }
        echo "I am a happy piece of code that carried on....\n";
    }
    
}