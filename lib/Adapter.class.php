<?php
/*
  Encapsulates common functionality needed by all table gateway objects.
 
  Table Data Gateway is an enterprise data pattern identified by Fowler. This pattern's 
  intent is to encapsulate the full interaction with a database table. It is also 
  referred to by some as the data access object (DAO) pattern.
 
  Inspiration:
         http://martinfowler.com/eaaCatalog/tableDataGateway.html
         http://css.dzone.com/books/practical-php-patterns-table
         https://speakerdeck.com/hhamon/database-design-patterns-with-php-53
 */
 
abstract class Adapter
{
   // contains connection
   protected $connection;
   
   /*
      Constructor is passed a database adapter (example of dependency injection)
   */
   public function __construct($connect) 
   {
      if (is_null($connect) )
         throw new Exception("Connection is null");
         
      $this->connection = $connect;
   }
   
   // ***********************************************************
   // ABSTRACT METHODS
   
   /*
     The name of the table in the database
   */    
   abstract protected function getSelectStatement(); 

   /*
     A list of fields that define the sort order
   */   
   abstract protected function getOrderFields();
   
   /*
     The name of the primary keys in the database ... this can be overridden by subclasses
   */    
   abstract protected function getPrimaryKeyName();
   
   // ***********************************************************
   // PUBLIC FINDERS 
   //
   // All of these finders return either a single or array of the appropriate DomainObject subclasses
   //
   
   /*
      Returns all the records in the table
   */
   public function findAll($sortFields=null){
      $sql = $this->getSelectStatement();
      // add sort order if required
      if (! is_null($sortFields)) {
         $sql .= ' ORDER BY ' . $sortFields;
      }
      $statement = DatabaseHelper::runQuery($this->connection, $sql, null);
      return $statement->fetchAll();
   } 
   
   /*
      Returns all the records in the table sorted by the specified sort order
   */
   public function findAllSorted($ascending){
      $sql = $this->getSelectStatement() . ' ORDER BY ' .
      $this->getOrderFields();
      if (! $ascending) {
         $sql .= " ASC";
      }
      $statement = DatabaseHelper::runQuery($this->connection, $sql, null);
      return $statement->fetchAll();
   } 
   
   /*
      Returns a record for the specified ID
   */
   public function findById($id){
      $sql = $this->getSelectStatement() . ' WHERE ' .
      $this->getPrimaryKeyName() . '=:id';
   
      $statement = DatabaseHelper::runQuery($this->connection, $sql,
      Array(':id' => $id));
      return $statement->fetch();
   }
   
   /*
      Returns records for two joined tables
   */
   public function findViaJoin($tableJoin){
      if ($tableJoin == "u") {
         $sql = $this->getViaJoinUsers();
      } 
      else if ($tableJoin == "i") {
         $sql = $this->getViaJoinImages();
      }
      else if ($tableJoin == "country") {
         $sql = $this->getViaJoinCountriesImages();
      }
      else if ($tableJoin == "city") {
         $sql = $this->getViaJoinCitiesImages();
      }
      
      
      $statement = DatabaseHelper::runQuery($this->connection, $sql, null);
      return $statement->fetchAll();
   }
   
   public function findByNonPrimaryID($field, $id){
      
      if ($field == "Title"){
         
         $sql = $this->getSelectStatement() . ' WHERE ' . $field . ' LIKE :id';
         
      }
      else if ($field == "ImageID"){
         $sql = $this->getViaJoinSingleImages() . ' WHERE ' . $field . ' LIKE :id';
      }
      else if ($field == "PostID"){
         $sql = $this->getViaJoinSinglePost() . ' WHERE ' . $field . ' = :id';
      }
      else if ($field == "PostImages"){
         $sql = $this->getViaJoinPostImages() . ' = :id';
      }
      else {
      
         $sql = $this->getSelectStatement() . ' WHERE ' . $field . ' =:id';
      }
      
      $statement = DatabaseHelper::runQuery($this->connection, $sql,
      Array(':id' => $id));
      return $statement->fetchAll();
   }
 

}

?>