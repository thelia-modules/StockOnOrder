<?php

namespace StockOnOrder\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use StockOnOrder\Model\StockOnOrderConfig;
use StockOnOrder\Model\StockOnOrderConfigQuery;


/**
 * This class defines the structure of the 'stock_on_order_config' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StockOnOrderConfigTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'StockOnOrder.Model.Map.StockOnOrderConfigTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'stock_on_order_config';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\StockOnOrder\\Model\\StockOnOrderConfig';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'StockOnOrder.Model.StockOnOrderConfig';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the ID field
     */
    const ID = 'stock_on_order_config.ID';

    /**
     * the column name for the MODULE_ID field
     */
    const MODULE_ID = 'stock_on_order_config.MODULE_ID';

    /**
     * the column name for the STATUS_ID field
     */
    const STATUS_ID = 'stock_on_order_config.STATUS_ID';

    /**
     * the column name for the BEHAVIOR field
     */
    const BEHAVIOR = 'stock_on_order_config.BEHAVIOR';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ModuleId', 'StatusId', 'Behavior', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'moduleId', 'statusId', 'behavior', ),
        self::TYPE_COLNAME       => array(StockOnOrderConfigTableMap::ID, StockOnOrderConfigTableMap::MODULE_ID, StockOnOrderConfigTableMap::STATUS_ID, StockOnOrderConfigTableMap::BEHAVIOR, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'MODULE_ID', 'STATUS_ID', 'BEHAVIOR', ),
        self::TYPE_FIELDNAME     => array('id', 'module_id', 'status_id', 'behavior', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ModuleId' => 1, 'StatusId' => 2, 'Behavior' => 3, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'moduleId' => 1, 'statusId' => 2, 'behavior' => 3, ),
        self::TYPE_COLNAME       => array(StockOnOrderConfigTableMap::ID => 0, StockOnOrderConfigTableMap::MODULE_ID => 1, StockOnOrderConfigTableMap::STATUS_ID => 2, StockOnOrderConfigTableMap::BEHAVIOR => 3, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'MODULE_ID' => 1, 'STATUS_ID' => 2, 'BEHAVIOR' => 3, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'module_id' => 1, 'status_id' => 2, 'behavior' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('stock_on_order_config');
        $this->setPhpName('StockOnOrderConfig');
        $this->setClassName('\\StockOnOrder\\Model\\StockOnOrderConfig');
        $this->setPackage('StockOnOrder.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('MODULE_ID', 'ModuleId', 'INTEGER', 'module', 'ID', true, null, null);
        $this->addForeignKey('STATUS_ID', 'StatusId', 'INTEGER', 'order_status', 'ID', true, null, null);
        $this->addColumn('BEHAVIOR', 'Behavior', 'VARCHAR', false, 255, 'default');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Module', '\\Thelia\\Model\\Module', RelationMap::MANY_TO_ONE, array('module_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('OrderStatus', '\\Thelia\\Model\\OrderStatus', RelationMap::MANY_TO_ONE, array('status_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? StockOnOrderConfigTableMap::CLASS_DEFAULT : StockOnOrderConfigTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (StockOnOrderConfig object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StockOnOrderConfigTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StockOnOrderConfigTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StockOnOrderConfigTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StockOnOrderConfigTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StockOnOrderConfigTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = StockOnOrderConfigTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StockOnOrderConfigTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StockOnOrderConfigTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(StockOnOrderConfigTableMap::ID);
            $criteria->addSelectColumn(StockOnOrderConfigTableMap::MODULE_ID);
            $criteria->addSelectColumn(StockOnOrderConfigTableMap::STATUS_ID);
            $criteria->addSelectColumn(StockOnOrderConfigTableMap::BEHAVIOR);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.MODULE_ID');
            $criteria->addSelectColumn($alias . '.STATUS_ID');
            $criteria->addSelectColumn($alias . '.BEHAVIOR');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(StockOnOrderConfigTableMap::DATABASE_NAME)->getTable(StockOnOrderConfigTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(StockOnOrderConfigTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(StockOnOrderConfigTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new StockOnOrderConfigTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a StockOnOrderConfig or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or StockOnOrderConfig object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockOnOrderConfigTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \StockOnOrder\Model\StockOnOrderConfig) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StockOnOrderConfigTableMap::DATABASE_NAME);
            $criteria->add(StockOnOrderConfigTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = StockOnOrderConfigQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { StockOnOrderConfigTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { StockOnOrderConfigTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the stock_on_order_config table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StockOnOrderConfigQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a StockOnOrderConfig or Criteria object.
     *
     * @param mixed               $criteria Criteria or StockOnOrderConfig object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockOnOrderConfigTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from StockOnOrderConfig object
        }

        if ($criteria->containsKey(StockOnOrderConfigTableMap::ID) && $criteria->keyContainsValue(StockOnOrderConfigTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StockOnOrderConfigTableMap::ID.')');
        }


        // Set the correct dbName
        $query = StockOnOrderConfigQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // StockOnOrderConfigTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StockOnOrderConfigTableMap::buildTableMap();
