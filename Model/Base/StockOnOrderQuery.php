<?php

namespace StockOnOrder\Model\Base;

use \Exception;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use StockOnOrder\Model\StockOnOrder as ChildStockOnOrder;
use StockOnOrder\Model\StockOnOrderQuery as ChildStockOnOrderQuery;
use StockOnOrder\Model\Map\StockOnOrderTableMap;
use Thelia\Model\Order;

/**
 * Base class that represents a query for the 'stock_on_order' table.
 *
 *
 *
 * @method     ChildStockOnOrderQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildStockOnOrderQuery orderByIsStockDecreased($order = Criteria::ASC) Order by the is_stock_decreased column
 *
 * @method     ChildStockOnOrderQuery groupByOrderId() Group by the order_id column
 * @method     ChildStockOnOrderQuery groupByIsStockDecreased() Group by the is_stock_decreased column
 *
 * @method     ChildStockOnOrderQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockOnOrderQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockOnOrderQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockOnOrderQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildStockOnOrderQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildStockOnOrderQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildStockOnOrder findOne(ConnectionInterface $con = null) Return the first ChildStockOnOrder matching the query
 * @method     ChildStockOnOrder findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStockOnOrder matching the query, or a new ChildStockOnOrder object populated from the query conditions when no match is found
 *
 * @method     ChildStockOnOrder findOneByOrderId(int $order_id) Return the first ChildStockOnOrder filtered by the order_id column
 * @method     ChildStockOnOrder findOneByIsStockDecreased(boolean $is_stock_decreased) Return the first ChildStockOnOrder filtered by the is_stock_decreased column
 *
 * @method     array findByOrderId(int $order_id) Return ChildStockOnOrder objects filtered by the order_id column
 * @method     array findByIsStockDecreased(boolean $is_stock_decreased) Return ChildStockOnOrder objects filtered by the is_stock_decreased column
 *
 */
abstract class StockOnOrderQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \StockOnOrder\Model\Base\StockOnOrderQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\StockOnOrder\\Model\\StockOnOrder', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockOnOrderQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockOnOrderQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \StockOnOrder\Model\StockOnOrderQuery) {
            return $criteria;
        }
        $query = new \StockOnOrder\Model\StockOnOrderQuery();
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
     * @return ChildStockOnOrder|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        throw new \LogicException('The ChildStockOnOrder class has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        throw new \LogicException('The ChildStockOnOrder class has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildStockOnOrderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new \LogicException('The ChildStockOnOrder class has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildStockOnOrderQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new \LogicException('The ChildStockOnOrder class has no primary key');
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @see       filterByOrder()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOnOrderQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(StockOnOrderTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(StockOnOrderTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockOnOrderTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the is_stock_decreased column
     *
     * Example usage:
     * <code>
     * $query->filterByIsStockDecreased(true); // WHERE is_stock_decreased = true
     * $query->filterByIsStockDecreased('yes'); // WHERE is_stock_decreased = true
     * </code>
     *
     * @param     boolean|string $isStockDecreased The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOnOrderQuery The current query, for fluid interface
     */
    public function filterByIsStockDecreased($isStockDecreased = null, $comparison = null)
    {
        if (is_string($isStockDecreased)) {
            $is_stock_decreased = in_array(strtolower($isStockDecreased), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StockOnOrderTableMap::IS_STOCK_DECREASED, $isStockDecreased, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Order object
     *
     * @param \Thelia\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOnOrderQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \Thelia\Model\Order) {
            return $this
                ->addUsingAlias(StockOnOrderTableMap::ORDER_ID, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockOnOrderTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \Thelia\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStockOnOrderQuery The current query, for fluid interface
     */
    public function joinOrder($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

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
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\Thelia\Model\OrderQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStockOnOrder $stockOnOrder Object to remove from the list of results
     *
     * @return ChildStockOnOrderQuery The current query, for fluid interface
     */
    public function prune($stockOnOrder = null)
    {
        if ($stockOnOrder) {
            throw new \LogicException('ChildStockOnOrder class has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the stock_on_order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockOnOrderTableMap::DATABASE_NAME);
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
            StockOnOrderTableMap::clearInstancePool();
            StockOnOrderTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildStockOnOrder or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildStockOnOrder object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StockOnOrderTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockOnOrderTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        StockOnOrderTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockOnOrderTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // StockOnOrderQuery
