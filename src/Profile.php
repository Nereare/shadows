<?php
namespace Nereare\Shadows;

use Nereare\Shadows\InvalidUidException;
use Nereare\Shadows\NoUidException;
use Nereare\Shadows\ProfileException;
use Nereare\Shadows\UnknownFieldException;
use Nereare\Shadows\UnknownUidException;

final class Profile {

  private const FIELDS = ["first_name", "last_name", "location", "birth", "about"];

  private $conn;
  private $uid;

  /**
   * Creates a new profile manager object.
   *
   * The profile manager object references either no user at all, or only a
   * single user.
   *
   * Once created, you cannot change the user (or lack thereof).
   *
   * @param \PDO   $databaseConn  An open PDO database connection.
   * @param int    $uid           The numeric user ID, optional.
   *
   * @throws InvalidUidException  Thrown if the given ID does not represent a valid user in the database.
   * @throws ProfileException     Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   */
  public function __construct($databaseConn, $uid = null) {
    $this->conn = $databaseConn;
    if ( $uid == null ) { $this->uid = $uid; }
    else {
      $this->uid = (int)$uid;

      // This statement fetching is meant to only check if the given UID
      // corresponds to an existing user.
      try {
        $stmt = $this->conn->prepare(
          "SELECT `id` FROM `users`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        if ( !$stmt->fetch() ) { throw new Nereare\Shadows\InvalidUidException("No such user."); }
      } catch(\PDOException $e) { throw new Nereare\Shadows\ProfileException("Database execution error."); }
    }
  }

  /**
   * Returns the numeric ID of the current user.
   *
   * If there is no user ID set it returns null, otherwise it returns an integer
   * representing the given user's ID.
   *
   * @return int|null Either the numeric User ID, or null if no user is set.
   */
  public function getUid() { return $this->uid; }

  /**
   * Returns either the email or the username of the current user. If there is
   * no user ID set, it throws an exception.
   *
   * @param  string $field               The name of the data to be retrieved. Either "email" or "username".
   *
   * @throws InvalidUidException         Thrown if the given user ID is not present in the database.
   * @throws ProfileException            Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws NoUidException              Thrown if you try to invoke this method from a profile manager with no user ID set.
   *
   * @return string|null                 Either a string representing the data requested, or null if no user is set.
   */
  private function getInData($field) {
    if ( !in_array( $field, ["email", "username"] ) ) {
      throw new Nereare\Shadows\UnknownFieldException("No such field.");
    }

    if ( $this->uid != null ) {
      try {
        $stmt = $this->conn->prepare(
          "SELECT `" . $field . "` FROM `shadows`.`users`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ( !$result ) { throw new Nereare\Shadows\InvalidUidException("User ID is invalid."); }
        return $result[$field];
      } catch(\PDOException $e) { throw new Nereare\Shadows\ProfileException("Database execution error."); }
    } else {
      throw new Nereare\Shadows\NoUidException("No user ID set.");
    }
  }

  /**
   * Retrieves the current user's email.
   *
   * @return string|null    Either a string representing the user's email, or null if no user is set.
   */
  public function getEmail() {
    try { return $this->getInData("email"); }
    catch(\Exception $e) { return null; }
  }

  /**
   * Retrieves the current user's username.
   *
   * @return string|null    Either a string representing the user's username, or null if no user is set.
   */
  public function getUsername() {
    try { return $this->getInData("username"); }
    catch(\Exception $e) { return null; }
  }

  /**
   * Creates the register in database of an user's profile.
   *
   * This method creates a profile for an user, given the profile manager object
   * created references one.
   *
   * If there is no user set, it throws an exception.
   *
   * @param  string $firstName               The first name of the user.
   * @param  string $lastName                The last (and possibly middle) name/s of the user.
   * @param  string $location                Any string description of the user's location.
   * @param  string $birth                   The date of birth in the ISO 8601 format.
   * @param  string $about                   A freeform description the user sets for themselves.
   *
   * @throws ProfileException                Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws NoUidException                  Thrown if you try to invoke this method from a profile manager with no user ID set.
   *
   * @return void
   */
  public function create($firstName, $lastName, $location, $birth, $about) {
    if ( $this->uid != null ) {
      try { $dob = new \DateTime( $birth ); }
      catch (Exception $e) { $dob = new \DateTime(); }
      $dob = $dob->format('Y-m-d');

      try {
        $stmt = $this->conn->prepare(
          "INSERT INTO `shadows`.`users_profiles`
            (`id`, `first_name`, `last_name`, `location`, `birth`, `about`)
            VALUES (:uid, :firstname, :lastname, :location, :birth, :about)"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":firstname", $firstName);
        $stmt->bindParam(":lastname", $lastName);
        $stmt->bindParam(":location", $location);
        $stmt->bindParam(":birth", $dob);
        $stmt->bindParam(":about", $about);
        $stmt->execute();
      } catch(\PDOException $e) { throw new Nereare\Shadows\ProfileException("Database execution error."); }
    } else {
      throw new Nereare\Shadows\NoUidException("No user ID set.");
    }
  }

  /**
   * Updates the database register of an user's profile.
   *
   * This method updates a profile, given the profile manager object created
   * references one.
   *
   * If there is no user set, it throws an exception.
   *
   * @param  string $firstName               The first name of the user.
   * @param  string $lastName                The last (and possibly middle) name/s of the user.
   * @param  string $location                Any string description of the user's location.
   * @param  string $birth                   The date of birth in the ISO 8601 format.
   * @param  string $about                   A freeform description the user sets for themselves.
   *
   * @throws ProfileException                Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws NoUidException                  Thrown if you try to invoke this method from a profile manager with no user ID set.
   *
   * @return void
   */
  public function update($firstName, $lastName, $location, $birth, $about) {
    if ( $this->uid != null ) {
      try { $dob = new \DateTime( $birth ); }
      catch (Exception $e) { $dob = new \DateTime(); }
      $dob = $dob->format('Y-m-d');

      try {
        $stmt = $this->conn->prepare(
          "UPDATE `users_profiles` SET
            `first_name` = :firstname,
            `last_name` = :lastname,
            `location` = :location,
            `birth` = :birth,
            `about` = :about
            WHERE `id` = :uid"
        );
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":firstname", $firstName);
        $stmt->bindParam(":lastname", $lastName);
        $stmt->bindParam(":location", $location);
        $stmt->bindParam(":birth", $dob);
        $stmt->bindParam(":about", $about);
        $stmt->execute();
      } catch(\PDOException $e) { throw new Nereare\Shadows\ProfileException("Database execution error."); }
    } else {
      throw new Nereare\Shadows\NoUidException("No user ID set.");
    }
  }

  /**
   * Retrieves the user's data, given an user ID was set.
   *
   * @param  int    $uid               The user's ID.
   *
   * @throws InvalidUidException       Thrown if the given user ID is not present in the database.
   * @throws ProfileException          Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws NoUidException            Thrown if you try to invoke this method from a profile manager with no user ID set.
   *
   * @return array                     An array containing the user data. Array indexes are named after the corresponding tables' columns.
   */
  public function fetch($uid = null) {
    if ( $this->uid != null ) { $fid = $this->uid; }
    else { $fid = $uid; }

    if ( $fid != null ) {
      try {
        $stmt = $this->conn->prepare(
          "SELECT `users`.`id`, `email`, `username`, `first_name`, `last_name`, `location`, `birth`, `about`
            FROM `shadows`.`users`, `shadows`.`users_profiles`
            WHERE
              `users`.`id` = `users_profiles`.`id` AND
              `users`.`id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $fid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ( !$result ) { throw new Nereare\Shadows\InvalidUidException("User ID is invalid."); }
        return $result;
      } catch(\PDOException $e) { throw new Nereare\Shadows\ProfileException("Database execution error."); }
    } else {
      throw new Nereare\Shadows\NoUidException("No user ID set.");
    }
  }

  /**
   * Retrieves an user's specific data, given an user ID was set.
   *
   * @param  string $field               The data to be retrieved. Either: "first_name", "last_name", "location", "birth", or "about".
   * @param  int    $uid                 The user's ID.
   *
   * @throws UnknownFieldException       Thrown if the given field is not a valid field from the database schematics.
   * @throws InvalidUidException         Thrown if the given user ID is not present in the database.
   * @throws ProfileException            Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws NoUidException              Thrown if you try to invoke this method from a profile manager with no user ID set.
   *
   * @return string                      The data asked for.
   */
  public function get($field, $uid = null) {
    if ( $this->uid != null ) { $fid = $this->uid; }
    else { $fid = $uid; }

    if ( !in_array( $field, $this::FIELDS ) ) {
      throw new Nereare\Shadows\UnknownFieldException("No such field.");
    }

    if ( $fid != null ) {
      try {
        $stmt = $this->conn->prepare(
          "SELECT `" . $field . "` FROM `shadows`.`users_profiles`
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":uid", $fid);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ( !$result ) { throw new Nereare\Shadows\InvalidUidException("User ID is invalid."); }
        return $result[$field];
      } catch(\PDOException $e) { throw new Nereare\Shadows\ProfileException("Database execution error."); }
    } else {
      throw new Nereare\Shadows\NoUidException("No user ID set.");
    }
  }

  /**
   * Changes an user's specific data, given an user ID was set.
   *
   * @param  string $field               The data to be changed. Either: "first_name", "last_name", "location", "birth", or "about".
   * @param  int    $uid                 The user's ID.
   *
   * @throws UnknownFieldException       Thrown if the given field is not a valid field from the database schematics.
   * @throws ProfileException            Thrown if the SQL query is invalid, usually when you try to create duplicate entries.
   * @throws NoUidException              Thrown if you try to invoke this method from a profile manager with no user ID set.
   *
   * @return bool                        Whether the query was successful or not.
   */
  public function set($field, $value, $uid = null) {
    if ( $this->uid != null ) { $fid = $this->uid; }
    else { $fid = $uid; }

    if ( !in_array( $field, $this::FIELDS ) ) {
      throw new Nereare\Shadows\UnknownFieldException("No such field.");
    }

    if ( $fid != null ) {
      try {
        $stmt = $this->conn->prepare(
          "UPDATE `shadows`.`users_profiles`
            SET `" . $field . "` = :value
            WHERE `id` LIKE :uid"
        );
        $stmt->bindParam(":value", $value);
        $stmt->bindParam(":uid", $fid);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result ? true : false;
      } catch(\PDOException $e) { throw new Nereare\Shadows\ProfileException("Database execution error."); }
    } else {
      throw new Nereare\Shadows\NoUidException("No user ID set.");
    }
  }

}
