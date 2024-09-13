<?php
namespace {{PKG_NAMESPACE}};

class Preferences {

  private int            $uid;
  private array          $name;
  private \PDO           $db;

  public function __construct(\PDO $db, int $uid, string $name_title = "", string $name_first = "", string $name_last = "", string $name_suffix = "") {
    // Set \PDO database
    $this->db = $db;
    // Set user's ID
    $this->uid = $uid;
    // Set user's data
    $this->name["title"]  = $name_title;
    $this->name["first"]  = $name_first;
    $this->name["last"]   = $name_last;
    $this->name["suffix"] = $name_suffix;
    // Retrieve data
    $stmt = $this->db->prepare(
      "SELECT `name_title`, `name_first`, `name_last`, `name_suffix`
        FROM `preferences`
        WHERE `id` = :id"
    );
    $stmt->execute(["id" => $this->uid]);
    $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    if (count($res) <= 0) {
      $this->create_prefs($name_title, $name_first, $name_last, $name_suffix);
    } else {
      $this->name = $res[0];
    }
  }

  private function create_prefs(string $name_title, string $name_first, string $name_last, string $name_suffix): void {
    $stmt = $this->db->prepare(
      "INSERT INTO `preferences`
        (`id`, `name_title`, `name_first`, `name_last`, `name_suffix`)
        VALUES (:id, :prefix, :firstname, :lastname, :suffix)"
    );
    $stmt->execute([
      "id"         => $this->uid,
      "prefix"     => $name_title,
      "firstname"  => $name_first,
      "lastname"   => $name_last,
      "suffix"     => $name_suffix
    ]);
  }

  /**
   * Retrieve the user's name's prefix.
   *
   * @return string   The user's name's prefix.
   */
  public function get_name_title(): string {
    return $this->name["name_title"];
  }
  /**
   * Set the user's name's prefix.
   *
   * @param string   $new   The new user's name's prefix.
   */
  public function set_name_title(string $new): void {
    $stmt = $this->db->prepare(
      "UPDATE `preferences`
        SET `name_title` = :new_value
        WHERE `id` = :id"
    );
    $stmt->execute([
      "id"        => $this->uid,
      "new_value" => $new
    ]);
    $this->name["name_title"] = $new;
  }

  /**
   * Retrieve the user's first name.
   *
   * @return string   The user's first name.
   */
  public function get_name_first(): string {
    return $this->name["name_first"];
  }
  /**
   * Set the user's first name.
   *
   * @param string   $new   The new user's first name.
   */
  public function set_name_first(string $new): void {
    $stmt = $this->db->prepare(
      "UPDATE `preferences`
        SET `name_first` = :new_value
        WHERE `id` = :id"
    );
    $stmt->execute([
      "id"        => $this->uid,
      "new_value" => $new
    ]);
    $this->name["name_first"] = $new;
  }

  /**
   * Retrieve the user's last name (surname).
   *
   * @return string   The user's last name (surname).
   */
  public function get_name_last(): string {
    return $this->name["name_last"];
  }
  /**
   * Set the user's last name (surname).
   *
   * @param string   $new   The new user's last name (surname).
   */
  public function set_name_last(string $new): void {
    $stmt = $this->db->prepare(
      "UPDATE `preferences`
        SET `name_last` = :new_value
        WHERE `id` = :id"
    );
    $stmt->execute([
      "id"        => $this->uid,
      "new_value" => $new
    ]);
    $this->name["name_last"] = $new;
  }

  /**
   * Retrieve the user's name's suffix.
   *
   * @return string   The user's name's suffix.
   */
  public function get_name_suffix(): string {
    return $this->name["name_suffix"];
  }
  /**
   * Set the user's name's suffix.
   *
   * @param string   $new   The new user's name's suffix.
   */
  public function set_name_suffix(string $new): void {
    $stmt = $this->db->prepare(
      "UPDATE `preferences`
        SET `name_suffix` = :new_value
        WHERE `id` = :id"
    );
    $stmt->execute([
      "id"        => $this->uid,
      "new_value" => $new
    ]);
    $this->name["name_suffix"] = $new;
  }
}
