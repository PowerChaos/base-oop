<?php


/**************************************************************************
 *
 * Title:         Class 'Session' (class_session.inc.php)
 *
 * Version:       1.2
 *
 * Copyright:     (c) 2012 Volker Rubach - All rights reserved
 *
 * Description:   This class provide a secure session handler with
 *                PDO connection to a MySQL database.
 *
 *************************************************************************/


class Session
   { // Beginn class


    //-------------------------------------------------------------------------
    // Constructor
    //-------------------------------------------------------------------------

    function Session()
       {
       // CONFIG: MySQL database details
       $this->dbHost = "127.0.0.1";
       $this->dbName = "<DATABASE NAME>";

       // CONFIG: MySQL account details
       $this->dbUser = "<DATABASE USER>";
       $this->dbPass = "<DATABASE PASSWORD>";

       // CONFIG: Used session table
       $this->table  = "user_sessions";

       // CONFIG: Configure PDO attributes
       $this->confPDO = array(
                              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Causes an exception to be thrown
                              PDO::ATTR_PERSISTENT => false,                 // With TRUE persistent connection activated (connection not closed when script ends)
                              //PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true    // With TRUE the buffered versions of the MySQL API will be used
                             );

       // CONFIG: SALT [free random sequence to increase the session security]
       $this->salt = "BaseSystem";

       // CONFIG: Target address after session was destroyed
       $this->location = "https://getadedi.com/nosession.php";

       // CONFIG: Get domain name
       $this->domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);

       // CONFIG: Session parameter (php.ini)
       /*
	   ini_set( 'session.auto_start', 0 );                // Defines whether the session module starts a session automatically on request startup [Default: '0']
       ini_set( 'session.name', 'mp3db' );                // Defines the name of the session which is used as cookie name; it should only contain alphanumeric characters [Default: 'PHPSESSID']
       ini_set( 'session.save_handler', 'user' );         // Defines the name of the handler which is used for storing and retrieving data associated with a session [Default: 'files']
       ini_set( 'session.gc_probability', 1 );            // Conjunction with session.gc_divisor is used to manage probability that the garbage collection routine is started [Default: '1']
       ini_set( 'session.gc_divisor', 50 );               // Coupled with session.gc_probability defines the probability that the garbage collection process is started on every session initialization  [Default: '100']
       ini_set( 'session.gc_maxlifetime', 15*60 );        // Defines the number of seconds after which data will be seen as 'garbage' and potentially cleaned up [Depending on session.gc_probability and session.gc_divisor]
       ini_set( 'session.use_cookies', 1 );               // Enable ('1') / Disable ('0') cookies to store the session id on the client side [Default: '1']
       ini_set( 'session.use_only_cookies', 1 );          // Enable ('1') / Disable ('0') to use ONLY cookies to store the session id on the client side [Default: '1']
       ini_set( 'session.use_trans_sid', 0 );             // Enable ('1') / Disable ('0') transparent sid support [Default: '0']
       ini_set( 'session.referer_check', '' );            // Contains the substring you want to check each HTTP Referer for [Default: empty string]
       ini_set( 'session.hash_function', 1 );             // Defines the hash algorithm used to generate the session ID ['0' = MD5 (128 bits) / '1' = SHA-1 (160 bits)]
       ini_set( 'session.hash_bits_per_character', 6 );   // Defines how many bits are stored in each character when converting the binary hash data to something readable [Possible values are '4', '5' or '6']
*/
       // CONFIG: Cache limiter
       session_cache_limiter( 'nocache' );                // Specifies the cache control method ('nocache', 'private', 'private_no_expire', or 'public') used for session pages [Default: 'nocache']

       // CONFIG: Cookie parameters
       session_set_cookie_params(                         // Set cookie parameters defined in the php.ini file. You need to call session_set_cookie_params() for every request and before session_start() is called.
                                 15*60,                   // Lifetime of the session cookie, defined in seconds [int $lifetime]
                                 '/',                     // Path on the domain where the cookie will work. Use a single slash ('/') for all paths on the domain [string $path]
                                 $this->domain            // Cookie domain, for example 'www.php.net'. To make cookies visible on all subdomains then the domain must be prefixed with a dot like '.php.net' [string $domain]
                                 );

       // Set session handler
       session_set_save_handler( array( &$this, 'open' ),
                                 array( &$this, 'close' ),
                                 array( &$this, 'read' ),
                                 array( &$this, 'write' ),
                                 array( &$this, 'destroy' ),
                                 array( &$this, 'clean' ) );

       // Start session
       session_start();

       }


    //-------------------------------------------------------------------------
    // Open database
    //-------------------------------------------------------------------------

    function open()
       {

       // Establish connection
       try
         {
         $this->dbc = new PDO( "mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass, $this->confPDO );
         }

       // PDO error handling
       catch( PDOException $errMsg )
         {
         return false;
         }

         if ( $id = session_id() )
            {

            // Read saved 'fingerprint' of used session
            try
              {
              $stmt = $this->dbc->prepare( "SELECT fingerprint FROM " . $this->table . " WHERE id = :id" );
              $stmt->execute( array( ':id' => $id ) );
              $data = $stmt->fetchAll( PDO::FETCH_ASSOC );
              }

            // PDO error handling
            catch ( PDOException $errMsg )
              {
              $this->dbc = null;
              return false;
              }

            // Check if session HIJACKED
            if ( count( $data ) > 0 )
               {

               $this->sessfp = ( $data[0] ['fingerprint'] ) ? $data[0] ['fingerprint'] : '';

               // Create 'fingerprint' with current user data
               $this->security();

               // Comparison of both fingerprints
               if ( $this->sessfp != $this->fingerprint )
                  {
                  $this->destroy( $id );
                  header("Location: " . $this->location . ""); 
                  exit( 0 );
                  }

               }
            }

       }


    //-------------------------------------------------------------------------
    // Close database
    //-------------------------------------------------------------------------

    // @return   function   [Boolen => True / False]

    function close()
       {

       $this->dbc = null;
       return true;

       }


    //-------------------------------------------------------------------------
    // Read session
    //-------------------------------------------------------------------------

    // @param   $id    [String => Session ID]
    // @return  $data  [String => Session data / Empty}

    function read( $id )
       {

       // Read session data
       try
         {
         $stmt = $this->dbc->prepare( "SELECT data FROM " . $this->table . " WHERE id = :id" );
         $stmt->execute( array( ':id' => $id ) );
         $data = $stmt->fetchAll( PDO::FETCH_ASSOC );
         }

       // PDO error handling
       catch ( PDOException $errMsg )
         {
         $this->dbc = null;
         return false;
         }

         // Return session data or space
         if ( count( $data ) > 0 )
            {
            return isset( $data[0] ['data'] ) ? $data[0] ['data'] : '';
            }
         else
            {
            return '';
            }

       }


    //-------------------------------------------------------------------------
    // Write session
    //-------------------------------------------------------------------------

    // @param    $id            [String    => Session ID]
    // @param    $fingerprint   [String    => Fingerprint to prevent session hijacking]
    // @param    $data          [String    => Session data]
    // @param    $access        [Timestamp => Unix timestamp]
    // @param    $date          [String    => Human readable timestamp]
    // @return   function       [Boolen    => True / False]

    function write( $id, $data )
       {

       // Create 'fingerprint' with current user data
       $this->security();

       // Write session data
       try
         {
         $stmt = $this->dbc->prepare( "REPLACE INTO " . $this->table . " ( id, fingerprint, data, access, date ) VALUES ( :id, :fingerprint, :data, :access, :date )" );
         $stmt->execute( array( ':id' => $id, ':fingerprint' => $this->fingerprint, ':data' => $data, ':access' => time(), ':date' => date( "d.m.Y" ) . " " . date( "H:i:s" ) ) );
         }

       // PDO error handling
       catch ( PDOException $errMsg )
         {
         $this->dbc = null;
         return false;
         }

       return true;

       }


    //-------------------------------------------------------------------------
    // Destroy session
    //-------------------------------------------------------------------------

    // @param    $id        [String => Session ID]
    // @return   function   [Boolen => True / False]

    function destroy( $id )
       {

       session_unset();
	   session_regenerate_id();

       // Delete session
       try
         {
         $stmt = $this->dbc->prepare( "DELETE FROM " . $this->table . " WHERE id = :id" );
         $stmt->execute( array( ':id' => $id ) );
         }

       // PDO error handling
       catch ( PDOException $errMsg )
         {
         $this->dbc = null;
         return false;
         }

       return true;

       }


    //-------------------------------------------------------------------------
    // Destroy HIJACKED session absolutely
    //-------------------------------------------------------------------------

    // @param    $id        [String => Session ID]

    function destroyHijacked( $id )
       {

       // Invalidate cookie
       if ( isset( $_COOKIE[session_name()] ) )
          {
          setcookie( session_name(), 0, time()-42000, '/', $this->domain);
          }

       session_write_close();
       session_unset();

       // Mark session as HIJACKED
       try
         {
         $stmt = $this->dbc->prepare( "REPLACE INTO " . $this->table . " ( id, fingerprint, data, access, date ) VALUES ( :id, :fingerprint, :data, :access, :date )" );
         $stmt->execute( array( ':id' => $id, ':fingerprint' => 'Session hijacked', ':data' => '', ':access' => 0, ':date' => date( "d.m.Y" ) . " " . date( "H:i:s" ) ) );
         }

       // PDO error handling
       catch ( PDOException $errMsg )
         {
         $this->dbc = null;
         return false;
         }

       }


    //-------------------------------------------------------------------------
    // Clean session
    //-------------------------------------------------------------------------

    // @param    $max       [Integer => session.gc_maxlifetime]
    // @return   function   [Boolen  => True / False]

    function clean( $max )
       {

       // Delete old sessions
       $max = time() - $max;
       try
         {
         $stmt = $this->dbc->prepare( "DELETE FROM " . $this->table . " WHERE access < :max" );
         $stmt->execute( array( ':max' => $max ) );
         }

       // PDO error handling
       catch ( PDOException $errMsg )
         {
         $this->dbc = null;
         return false;
         }

       return true;

       }


    //-------------------------------------------------------------------------
    // SECURITY [Create 'fingerprint']
    //-------------------------------------------------------------------------

    // @param    $salt          [String => Free random sequence to increase the session security]
    // @return   $fingerprint   [String => Composite chain of values [hashed with MD5]

    function security()
       {

       // Get Host Name
     //  exec( 'hostname', $out, $ret );
       $this->hostname = strtoupper( $out[0] );
       if ( !isset( $this->hostname ) )
          {
          $this->hostname = 'unknown';
          }

       // Get IP Address (use a netmask of 255.255.0.0 to get the first two blocks only)
       if ( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) )
          {
          $this->ipaddr = long2ip( ip2long( $_SERVER["HTTP_X_FORWARDED_FOR"] ) & ip2long( "255.255.0.0" ) );
          }
          else
          {
          $this->ipaddr = long2ip( ip2long( $_SERVER["REMOTE_ADDR"] ) & ip2long( "255.255.0.0" ) );
          }

       // Get HTTP User Agent
       $this->ua = $_SERVER['HTTP_USER_AGENT'];
       if ( !isset( $this->ua ) )
          {
          $this->ua = 'unknown';
          }

       $this->fingerprint = md5( $this->salt . $this->hostname . $this->ipaddr . $this->ua );

       }

    } // End class


?>
