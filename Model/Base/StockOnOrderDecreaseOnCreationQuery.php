<?php

namespace StockOnOrder\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use StockOnOrder\Model\StockOnOrderDecreaseOnCreation as ChildStockOnOrderDecreaseOnCreation;
use StockOnOrder\Model\StockOnOrderDecreaseOnCreationQuery as ChildStockOnOrderDecreaseOnCreationQuery;
use StockOnOrder\Model\Map\StockOnOrderDecreaseOnCreationTableMap;
use Thelia\Model\Module;

/**
 * Base class that represents a query for the 'stock_on_order_decrease_on_creation' table.
 *
 *
 *
 * @method     ChildStockOnOrderDecreaseOnCreationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStockOnOrderDecreaseOnCreationQuery orderByModuleId($order = Criteria::ASC) Order by the module_id column
 * @method     ChildStockOnOrderDecreaseOnCreationQuery orderByDecreaseOnOrderCreation($order = Criteria::ASC) Order by the decrease_on_order_creation column
 *
 * @method     ChildStockOnOrderDecreaseOnCreationQuery groupById() Group by the id column
 * @method     ChildStockOnOrderDecreaseOnCreationQuery groupByModuleId() Group by the module_id column
 * @method     ChildStockOnOrderDecreaseOnCreationQuery groupByDecreaseOnOrderCreation() Group by the decrease_on_order_creation column
 *
 * @method     ChildStockOnOrderDecreaseOnCreationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockOnOrderDecreaseOnCreationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockOnOrderDecreaseOnCreationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockOnOrderDecreaseOnCreationQuery leftJoinModule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Module relation
 * @method     ChildStockOnOrderDecreaseOnCreationQuery rightJoinModule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Module relation
 * @method     ChildStockOnOrderDecreaseOnCreationQuery innerJoinModule($relationAlias = null) Adds a INNER JOIN clause to the query using the Module relation
 *
 * @method     ChildStockOnOrderDecreaseOnCreation findOne(ConnectionInterface $con = null) Return the first ChildStockOnOrderDecreaseOnCreation matching the query
 * @method     ChildStockOnOrderDecreaseOnCreation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStockOnOrderDecreaseOnCreation matching the query, or a new ChildStockOnOrderDecreaseOnCreation object populated from the query conditions when no match is found
 *
 * @method     ChildStockOnOrderDecreaseOnCreation findOneById(int $id) Return the first ChildStockOnOrderDecreaseOnCreation filtered by the id column
 * @method     ChildStockOnOrderDecreaseOnCreation findOneByModuleId(int $module_id) Return the first ChildStockOnOrderDecreaseOnCreation filtered by the module_id column
 * @method     ChildStockOnOrderDecreaseOnCreation findOneByDecreaseOnOrderCreation(boolean $decrease_on_order_creation) Return the first ChildStockOnOrderDecreaseOnCreation filtered by the decrease_on_order_creation column
 *
 * @method     array findById(int $id) Return ChildStockOnOrderDecreaseOnCreation objects filtered by the id column
 * @method     array findByModuleId(int $module_id) Return ChildStockOnOrderDecreaseOnCreation objects filtered by the module_id column
 * @method     array findByDecreaseOnOrderCreation(boolean $decrease_on_order_creation) Return ChildStockOnOrderDecreaseOnCreation objects filtered by the decrease_on_order_creation column
 *
 */
abstract class StockOnOrderDecreaseOnCreationQuery extends ModelCriteria
{
    /**
     * Initializes internal state of \StockOnOrder\Model\Base\StockOnOrderDecreaseOnCreationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\StockOnOrder\\Model\\StockOnOrderDecreaseOnCreation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockOnOrderDecreaseOnCreationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \StockOnOrder\Model\StockOnOrderDecreaseOnCreationQuery) {
            return $criteria;
        }
        $query = new \StockOnOrder\Model\StockOnOrderDecreaseOnCreationQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildStockOnOrderDecreaseOnCreation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StockOnOrderDecreaseOnCreationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockOnOrderDecreaseOnCreationTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildStockOnOrderDecreaseOnCreation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, MODULE_ID, DECREASE_ON_ORDER_CREATION FROM stock_on_order_decrease_on_creation WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildStockOnOrderDecreaseOnCreation();
            $obj->hydrate($row);
            StockOnOrderDecreaseOnCreationTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildStockOnOrderDecreaseOnCreation|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the module_id column
     *
     * Example usage:
     * <code>
     * $query->filterByModuleId(1234); // WHERE module_id = 1234
     * $query->filterByModuleId(array(12, 34)); // WHERE module_id IN (12, 34)
     * $query->filterByModuleId(array('min' => 12)); // WHERE module_id > 12
     * </code>
     *
     * @see       filterByModule()
     *
     * @param     mixed $moduleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function filterByModuleId($moduleId = null, $comparison = null)
    {
        if (is_array($moduleId)) {
            $useMinMax = false;
            if (isset($moduleId['min'])) {
                $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::MODULE_ID, $moduleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moduleId['max'])) {
                $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::MODULE_ID, $moduleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::MODULE_ID, $moduleId, $comparison);
    }

    /**
     * Filter the query on the decrease_on_order_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByDecreaseOnOrderCreation(true); // WHERE decrease_on_order_creation = true
     * $query->filterByDecreaseOnOrderCreation('yes'); // WHERE decrease_on_order_creation = true
     * </code>
     *
     * @param     boolean|string $decreaseOnOrderCreation The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function filterByDecreaseOnOrderCreation($decreaseOnOrderCreation = null, $comparison = null)
    {
        if (is_string($decreaseOnOrderCreation)) {
            $decrease_on_order_creation = in_array(strtolower($decreaseOnOrderCreation), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::DECREASE_ON_ORDER_CREATION, $decreaseOnOrderCreation, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Module object
     *
     * @param \Thelia\Model\Module|ObjectCollection $module The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function filterByModule($module, $comparison = null)
    {
        if ($module instanceof \Thelia\Model\Module) {
            return $this
                ->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::MODULE_ID, $module->getId(), $comparison);
        } elseif ($module instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::MODULE_ID, $module->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByModule() only accepts arguments of type \Thelia\Model\Module or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Module relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function joinModule($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Module');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Module');
        }

        return $this;
    }

    /**
     * Use the Module relation Module object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ModuleQuery A secondary query class using the current class as primary query
     */
    public function useModuleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinModule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Module', '\Thelia\Model\ModuleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStockOnOrderDecreaseOnCreation $stockOnOrderDecreaseOnCreation Object to remove from the list of results
     *
     * @return ChildStockOnOrderDecreaseOnCreationQuery The current query, for fluid interface
     */
    public function prune($stockOnOrderDecreaseOnCreation = null)
    {
        if ($stockOnOrderDecreaseOnCreation) {
            $this->addUsingAlias(StockOnOrderDecreaseOnCreationTableMap::ID, $stockOnOrderDecreaseOnCreation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stock_on_order_decrease_on_creation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockOnOrderDecreaseOnCreationTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StockOnOrderDecreaseOnCreationTableMap::clearInstancePool();
            StockOnOrderDecreaseOnCreationTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildStockOnOrderDecreaseOnCreation or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildStockOnOrderDecreaseOnCreation object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
         if (null === $con) {
             $con = Propel::getServiceContainer()->getWriteConnection(StockOnOrderDecreaseOnCreationTableMap::DATABASE_NAME);
         }

         $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockOnOrderDecreaseOnCreationTableMap::DATABASE_NAME);

         $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


            StockOnOrderDecreaseOnCreationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockOnOrderDecreaseOnCreationTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
     }
} // StockOnOrderDecreaseOnCreationQuery

