<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functionality for the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * Represents a columns node in the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
class Node_Column extends Node
{
    /**
     * Initialises the class
     *
     * @param string $name     An identifier for the new node
     * @param int    $type     Type of node, may be one of CONTAINER or OBJECT
     * @param bool   $is_group Whether this object has been created
     *                         while grouping nodes
     *
     * @return Node_Column
     */
    public function __construct($name, $type = Node::OBJECT, $is_group = false)
    {
        parent::__construct($name, $type, $is_group);
        $this->icon  = $this->_commonFunctions->getImage('pause.png', '');
        $this->links = array(
            'text' => 'tbl_alter.php?server=' . $GLOBALS['server']
                    . '&amp;db=%3$s&amp;table=%2$s&amp;field=%1$s'
                    . '&amp;token=' . $GLOBALS['token'],
            'icon' => 'tbl_alter.php?server=' . $GLOBALS['server']
                    . '&amp;db=%3$s&amp;table=%2$s&amp;field=%1$s'
                    . '&amp;token=' . $GLOBALS['token']
        );
    }

    /**
     * Returns the comment associated with node
     * This method should be overridden by specific type of nodes
     *
     * @return string
     */
    public function getComment()
    {
        $db     = $this->_commonFunctions->sqlAddSlashes(
            $this->realParent()->realParent()->real_name
        );
        $table  = $this->_commonFunctions->sqlAddSlashes(
            $this->realParent()->real_name
        );
        $column = $this->_commonFunctions->sqlAddSlashes(
            $this->real_name
        );
        $query  = "SELECT `COLUMN_COMMENT` ";
        $query .= "FROM `INFORMATION_SCHEMA`.`COLUMNS` ";
        $query .= "WHERE `TABLE_SCHEMA`='$db' ";
        $query .= "AND `TABLE_NAME`='$table' ";
        $query .= "AND `COLUMN_NAME`='$column' ";
        return PMA_DBI_fetch_value($query);
    }
}

?>
