<?php
namespace Nereare\Shadows;

use Nereare\Shadows\AdventureException;
use Nereare\Shadows\InvalidAidException;
use Nereare\Shadows\NoAidException;
use Nereare\Shadows\NoUuidException;
use Nereare\Shadows\Uuid;
use Nereare\Shadows\UnknownAdventureFieldException;
use Nereare\Shadows\UnknownAidException;

final class Adventure {

  private const CHANGEABLE_FIELDS   = ["name", "cover", "version", "desc", "setting", "triggers", "level_init", "level_end", "pcs", "is_public", "status", "advancement", "entry"];
  private const NEEDED_CREATE_KEYS  = ["advancement", "author", "cover", "desc", "is_public", "level_end", "level_init", "name", "pcs", "setting", "status", "triggers", "version"];

  private $conn;

  private $aid;         // INT UNSIGNED
  private $uuid;        // CHAR(36)
  private $author;      // INT UNSIGNED - Author (User) ID
  private $auth_name;   // VARCHAR(127) - Author (User) Name
  private $name;        // VARCHAR(127)
  private $cover;       // VARCHAR(255)
  private $version;     // VARCHAR(32)
  private $desc;        // TEXT
  private $setting;     // VARCHAR(63)
  private $triggers;    // VARCHAR(1023)
  private $level_init;  // TINYINT UNSIGNED
  private $level_end;   // TINYINT UNSIGNED
  private $pcs;         // TINYINT UNSIGNED
  private $is_public;   // BOOLEAN
  private $status;      // ENUM('development', 'alpha', 'beta', 'stable')
  private $advancement; // ENUM('xp', 'milestone', 'other')
  private $entry;       // INT UNSIGNED

  /**
   * Creates a new adventure manager object.
   *
   * The adventure manager object WILL reference an adventure. If there is no
   * AID referenced, it will create a new adventure. If the AID is given and is
   * an integer, it will try to retrieve an existing one from the database.
   *
   * If you set $aid to anything but null, this method will try to fetch an
   * adventure.
   *
   * @param \PDO        $databaseConn  An open PDO database connection.
   * @param int|null    $aid           The numeric Adventure ID, optional.
   * @param array|null  $data          The data list for a new Adventure.
   *
   * @throws AdventureException               Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws InvalidAidException              Thrown if the given ID does not represent a valid adventure in the database.
   * @throws UnknownAdventureFieldException   Thrown if the given array does not fill the minimum requirements for Adventure creation.
   */
  public function __construct($databaseConn, $aid = null, $data = null) {
    $this->conn = $databaseConn;
    if ( $aid == null ) {
      // Sort the adventure data array indexes:
      $adv_keys = array_keys( $data );
      sort( $adv_keys );
      // Check if given data:
      //   1. Is an array; and
      //   2. Has the required fields.
      if (gettype( $data ) == "array" &&
          $adv_keys == $this::NEEDED_CREATE_KEYS) {
        // Create a database entry for the given Adventure data
        $adv = $this->create($data);
        // Use the data to fill the Adventure object data
        $this->aid         = $adv["aid"];
        $this->uuid        = $adv["uuid"];
        $this->author      = $adv["author"];
        $this->auth_name   = $adv["first_name"] . " " . $adv["last_name"];
        $this->name        = $adv["name"];
        $this->cover       = $adv["cover"];
        $this->version     = $adv["version"];
        $this->desc        = $adv["desc"];
        $this->setting     = $adv["setting"];
        $this->triggers    = $adv["triggers"];
        $this->level_init  = $adv["level_init"];
        $this->level_end   = $adv["level_end"];
        $this->pcs         = $adv["pcs"];
        $this->is_public   = $adv["is_public"];
        $this->status      = $adv["status"];
        $this->advancement = $adv["advancement"];
        $this->entry       = $adv["entry"];
      } else {
        throw new Nereare\Shadows\UnknownAdventureFieldException("Invalid adventure data array.");
      }
    } else {
      // Get data from database, based on the given Adventure ID
      $this->aid = $aid;
      $adv = $this->fetch();
      // Use the fetched data to fill the Adventure object data
      $this->uuid        = $adv["uuid"];
      $this->author      = $adv["author"];
      $this->auth_name   = $adv["first_name"] . " " . $adv["last_name"];
      $this->name        = $adv["name"];
      $this->cover       = $adv["cover"];
      $this->version     = $adv["version"];
      $this->desc        = $adv["desc"];
      $this->setting     = $adv["setting"];
      $this->triggers    = $adv["triggers"];
      $this->level_init  = $adv["level_init"];
      $this->level_end   = $adv["level_end"];
      $this->pcs         = $adv["pcs"];
      $this->is_public   = $adv["is_public"];
      $this->status      = $adv["status"];
      $this->advancement = $adv["advancement"];
      $this->entry       = $adv["entry"];
    }
  }

  // ########################################
  // #              Get Methods             #
  // ########################################

  /**
   * Returns the numeric ID of the current adventure.
   *
   * @return int   The adventure's numeric ID.
   */
  public function getAid() { return $this->aid; }

  /**
   * Returns the universally unique ID (v4) of the current adventure.
   *
   * @return string   The adventure's universally unique ID (v4).
   */
  public function getUuid() { return $this->uuid; }

  /**
   * Returns the author ID of the current adventure.
   *
   * @return int   The adventure's author ID.
   */
  public function getAuthorID() { return $this->author; }

  /**
   * Returns the author name of the current adventure.
   *
   * @return int   The adventure's author name.
   */
  public function getAuthorName() { return $this->auth_namer; }

  /**
   * Returns the name of the current adventure.
   *
   * @return string   The adventure's name.
   */
  public function getName() { return $this->name; }

  /**
   * Returns the cover URI of the current adventure.
   *
   * @return string   The adventure's cover URI.
   */
  public function getCoverURI() { return $this->cover; }

  /**
   * Returns the version of the current adventure.
   *
   * @return string   The adventure's version.
   */
  public function getVersion() { return $this->version; }

  /**
   * Returns the description of the current adventure.
   *
   * @return string   The adventure's description.
   */
  public function getDesc() { return $this->desc; }

  /**
   * Returns the world setting of the current adventure.
   *
   * @return string   The adventure's world setting.
   */
  public function getSetting() { return $this->setting; }

  /**
   * Returns the trigger list of the current adventure.
   *
   * @return string   The adventure's trigger list.
   */
  public function getTriggers() { return $this->triggers; }

  /**
   * Returns the initial PC level of the current adventure.
   *
   * @return int   The adventure's initial PC level.
   */
  public function getInitLevel() { return $this->level_init; }

  /**
   * Returns the suggested final PC level of the current adventure.
   *
   * @return int   The adventure's suggested final PC level.
   */
  public function getEndLevel() { return $this->level_end; }

  /**
   * Returns the number of PCs of the current adventure.
   *
   * @return int   The adventure's number of PCs.
   */
  public function getPCs() { return $this->pcs; }

  /**
   * Returns the public/private status of the current adventure.
   *
   * @return bool   The adventure's public/private status.
   */
  public function getPublicStatus() { return $this->is_public; }

  /**
   * Returns the development status of the current adventure.
   *
   * @return string   The adventure's development status.
   */
  public function getDevStatus() { return $this->status; }

  /**
   * Returns the advancement method of the current adventure.
   *
   * @return string   The adventure's advancement method.
   */
  public function getAdvancement() { return $this->advancement; }

  /**
   * Returns the entry room ID of the current adventure.
   *
   * @return int   The adventure's entry room ID.
   */
  public function getEntryRoom() { return $this->entry; }

  // ########################################
  // #              Set Methods             #
  // ########################################

  /**
   * Sets the name of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new name.
   *
   * @return void
   */
  public function setName($newval) { $this->name = setVal("name", $newval); }

  /**
   * Sets the cover URI of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new cover URI.
   *
   * @return void
   */
  public function setCoverURI($newval) { $this->cover = setVal("cover", $newval); }

  /**
   * Sets the version of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new version.
   *
   * @return void
   */
  public function setVersion($newval) { $this->version = setVal("version", $newval); }

  /**
   * Sets the description of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new description.
   *
   * @return void
   */
  public function setDesc($newval) { $this->desc = setVal("desc", $newval); }

  /**
   * Sets the world setting of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new world setting.
   *
   * @return void
   */
  public function setSetting($newval) { $this->setting = setVal("setting", $newval); }

  /**
   * Sets the trigger list of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new trigger list. This new value must be a comma-separated string.
   *
   * @return void
   */
  public function setTriggers($newval) { $this->triggers = setVal("triggers", $newval); }

  /**
   * Sets the initial PC level of the current adventure to the new value.
   *
   * @param  int  $newval   The adventure's new initial PC level.
   *
   * @return void
   */
  public function setInitLevel($newval) { $this->level_init = setVal("level_init", $newval); }

  /**
   * Sets the suggested final PC level of the current adventure to the new value.
   *
   * @param  int  $newval   The adventure's new suggested final PC level.
   *
   * @return void
   */
  public function setEndLevel($newval) { $this->level_end = setVal("level_end", $newval); }

  /**
   * Sets the number of PCs of the current adventure to the new value.
   *
   * @param  int  $newval   The adventure's new number of PCs.
   *
   * @return void
   */
  public function setPCs($newval) { $this->pcs = setVal("pcs", $newval); }

  /**
   * Sets the public/private status of the current adventure to the new value.
   *
   * @param  bool  $newval   The adventure's new public/private status.
   *
   * @return void
   */
  public function setPublicStatus($newval) { $this->is_public = setVal("is_public", $newval); }

  /**
   * Sets the development status of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new development status. The value must be one of: 'development', 'alpha', 'beta', or 'stable'.
   *
   * @return void
   */
  public function setDevStatus($newval) { $this->status = setVal("status", $newval); }

  /**
   * Sets the advancement method of the current adventure to the new value.
   *
   * @param  string  $newval   The adventure's new advancement method.
   *
   * @return void
   */
  public function setAdvancement($newval) { $this->advancement = setVal("advancement", $newval); }

  /**
   * Sets the entry room ID of the current adventure to the new value.
   *
   * @param  int  $newval   The adventure's new entry room ID.
   *
   * @return void
   */
  public function setEntryRoom($newval) { $this->entry = setVal("entry", $newval); }

  // ########################################
  // #            Private Methods           #
  // ########################################

  /**
   * Creates the database entry for the Adventure with the given data.
   *
   * @throws AdventureException   Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   *
   * @param  array   $data        An array containing exactly the following indexes: "author", "name", "cover", "desc", "setting", "triggers", "level_init", "level_end", "pcs", "is_public", and "status".
   * @return array                An array containing the created Adventure data.
   */
  private function create($data) {
    // Generate random data (UUIDv4 for Adventure and Entry Room)
    $uuid = new \Nereare\Shadows\Uuid();
    $data["uuid"] = $uuid->get();
    $data["entry"] = $uuid->get();
    try {
      // Prepare the insert query
      $stmt = $this->conn->prepare(
        "INSERT INTO `shadows`.`adventures`
          (`uuid`, `author`, `name`, `cover`, `version`, `desc`, `setting`, `triggers`, `level_init`, `level_end`, `pcs`, `is_public`, `status`, `advancement`, `entry`)
          VALUES (:uuid, :author, :name, :cover, :version, :description, :setting, :triggers, :level_init, :level_end, :pcs, :is_public, :status, :advancement, :entry)"
      );
      $stmt->bindParam( ":uuid", $data["uuid"] );
      $stmt->bindParam( ":author", $data["author"] );
      $stmt->bindParam( ":name", $data["name"] );
      $stmt->bindParam( ":cover", $data["cover"] );
      $stmt->bindParam( ":version", $data["version"] );
      $stmt->bindParam( ":description", $data["desc"] );
      $stmt->bindParam( ":setting", $data["setting"] );
      $stmt->bindParam( ":triggers", $data["triggers"] );
      $stmt->bindParam( ":level_init", $data["level_init"] );
      $stmt->bindParam( ":level_end", $data["level_end"] );
      $stmt->bindParam( ":pcs", $data["pcs"] );
      $stmt->bindParam( ":is_public", $data["is_public"] );
      $stmt->bindParam( ":status", $data["status"] );
      $stmt->bindParam( ":advancement", $data["advancement"] );
      $stmt->bindParam( ":entry", $data["entry"] );
      $result = $stmt->execute();
      // Get inserted row ID
      $data["aid"] = $this->conn->lastInsertId();
      // If there was some error in the PDO execution, throw an error
      if ( !$result ) { throw new Nereare\Shadows\AdventureException("Database query failed."); }

      // Prepare method to fetch author's name
      $stmt = $this->conn->prepare(
        "SELECT `first_name`, `last_name`
          FROM `users_profiles`
          WHERE `users_profiles`.`id` LIKE :uid"
      );
      $stmt->bindParam( ":uid", $data["author"] );
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      // If there was some error in the PDO execution, throw an error
      if ( !$result ) { throw new Nereare\Shadows\AdventureException("Database query failed."); }
      // Set author name in the result array
      $data["first_name"] = $result["first_name"];
      $data["last_name"] = $result["last_name"];

      return $data;
    } catch(\PDOException $e) { throw new Nereare\Shadows\AdventureException("Database execution error."); }
  }

  /**
   * Retrieves the adventure's data.
   *
   * @throws AdventureException        Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws InvalidAidException       Thrown if the given Adventure ID is not present in the database.
   * @throws NoAidException            Thrown if there is no Adventure ID set.
   *
   * @return array                     An array containing the adventure data. Array indexes are named after the corresponding tables' columns.
   */
  private function fetch() {
    if ( $this->aid == null ) {
      throw new Nereare\Shadows\NoAidException("No Adventure ID set.");
    } else {
      try {
        $stmt = $this->conn->prepare(
          "SELECT
            `adventures`.`uuid`, `adventures`.`author`, `adventures`.`name`, `adventures`.`cover`, `adventures`.`version`, `adventures`.`desc`, `adventures`.`setting`, `adventures`.`triggers`, `adventures`.`level_init`, `adventures`.`level_end`, `adventures`.`pcs`, `adventures`.`is_public`, `adventures`.`status`, `adventures`.`advancement`, `adventures`.`entry`, `users_profiles`.`first_name`, `users_profiles`.`last_name`
            FROM `adventures`, `users_profiles`
            WHERE
              `adventures`.`author` = `users_profiles`.`id` AND
              `adventures`.`id` LIKE :aid"
        );
        $stmt->bindParam(":aid", $this->aid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ( !$result ) { throw new Nereare\Shadows\InvalidAidException("Adventure ID is invalid."); }
        return $result;
      } catch(\PDOException $e) { throw new Nereare\Shadows\AdventureException("Database execution error."); }
    }
  }

  private function setVal($field, $newval) {
    if ( !in_array( $field, $this::CHANGEABLE_FIELDS ) ) {
      throw new Nereare\Shadows\UnknownAdventureFieldException("No such field.");
    }

    try {
      $stmt = $this->conn->prepare(
        "UPDATE `adventures`
          SET `" . $field . "` = :value
          WHERE `id` LIKE :aid"
      );
      $stmt->bindParam(":value", $newval);
      $stmt->bindParam(":uid", $this->aid);
      $stmt->execute();
      $result = $stmt->rowCount();
      return $result ? true : false;
    } catch(\PDOException $e) { throw new Nereare\Shadows\AdventureException("Database execution error."); }
  }

}
