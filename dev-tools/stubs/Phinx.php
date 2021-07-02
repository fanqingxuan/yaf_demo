<?php

namespace Symfony\Component\Console\Input {
    use Symfony\Component\Console\Input;

    class InputDefinition
    {
        
    }

    interface InputInterface
    {
        /**
         * Returns the first argument from the raw parameters (not parsed).
         *
         * @return string|null The value of the first argument or null otherwise
         */
        public function getFirstArgument();

        /**
         * Returns true if the raw parameters (not parsed) contain a value.
         *
         * This method is to be used to introspect the input parameters
         * before they have been validated. It must be used carefully.
         * Does not necessarily return the correct result for short options
         * when multiple flags are combined in the same option.
         *
         * @param string|array $values     The values to look for in the raw parameters (can be an array)
         * @param bool         $onlyParams Only check real parameters, skip those following an end of options (--) signal
         *
         * @return bool true if the value is contained in the raw parameters
         */
        public function hasParameterOption($values, bool $onlyParams = false);

        /**
         * Returns the value of a raw option (not parsed).
         *
         * This method is to be used to introspect the input parameters
         * before they have been validated. It must be used carefully.
         * Does not necessarily return the correct result for short options
         * when multiple flags are combined in the same option.
         *
         * @param string|array $values     The value(s) to look for in the raw parameters (can be an array)
         * @param mixed        $default    The default value to return if no result is found
         * @param bool         $onlyParams Only check real parameters, skip those following an end of options (--) signal
         *
         * @return mixed The option value
         */
        public function getParameterOption($values, $default = false, bool $onlyParams = false);

        /**
         * Binds the current Input instance with the given arguments and options.
         *
         * @throws RuntimeException
         */
        public function bind(InputDefinition $definition);

        /**
         * Validates the input.
         *
         * @throws RuntimeException When not enough arguments are given
         */
        public function validate();

        /**
         * Returns all the given arguments merged with the default values.
         *
         * @return array
         */
        public function getArguments();

        /**
         * Returns the argument value for a given argument name.
         *
         * @return string|string[]|null The argument value
         *
         * @throws InvalidArgumentException When argument given doesn't exist
         */
        public function getArgument(string $name);

        /**
         * Sets an argument value by name.
         *
         * @param string|string[]|null $value The argument value
         *
         * @throws InvalidArgumentException When argument given doesn't exist
         */
        public function setArgument(string $name, $value);

        /**
         * Returns true if an InputArgument object exists by name or position.
         *
         * @param string|int $name The InputArgument name or position
         *
         * @return bool true if the InputArgument object exists, false otherwise
         */
        public function hasArgument($name);

        /**
         * Returns all the given options merged with the default values.
         *
         * @return array
         */
        public function getOptions();

        /**
         * Returns the option value for a given option name.
         *
         * @return string|string[]|bool|null The option value
         *
         * @throws InvalidArgumentException When option given doesn't exist
         */
        public function getOption(string $name);

        /**
         * Sets an option value by name.
         *
         * @param string|string[]|bool|null $value The option value
         *
         * @throws InvalidArgumentException When option given doesn't exist
         */
        public function setOption(string $name, $value);

        /**
         * Returns true if an InputOption object exists by name.
         *
         * @return bool true if the InputOption object exists, false otherwise
         */
        public function hasOption(string $name);

        /**
         * Is this input means interactive?
         *
         * @return bool
         */
        public function isInteractive();

        /**
         * Sets the input interactivity.
         */
        public function setInteractive(bool $interactive);
    }
}

namespace Symfony\Component\Console\Formatter {
    use Symfony\Component\Console\Formatter;

    /**
     * Formatter interface for console output.
     *
     * @author Konstantin Kudryashov <ever.zet@gmail.com>
     */
    interface OutputFormatterInterface
    {
        /**
         * Sets the decorated flag.
         */
        public function setDecorated(bool $decorated);

        /**
         * Gets the decorated flag.
         *
         * @return bool true if the output will decorate messages, false otherwise
         */
        public function isDecorated();

        /**
         * Sets a new style.
         */
        public function setStyle(string $name, $style);

        /**
         * Checks if output formatter has style with specified name.
         *
         * @return bool
         */
        public function hasStyle(string $name);

        /**
         * Gets style options from style with specified name.
         *
         * @return OutputFormatterStyleInterface
         *
         * @throws \InvalidArgumentException When style isn't defined
         */
        public function getStyle(string $name);

        /**
         * Formats a message according to the given styles.
         */
        public function format(?string $message);
    }
}
namespace Symfony\Component\Console\Output{

    use Symfony\Component\Console\Output;
    use Symfony\Component\Console\Formatter\OutputFormatterInterface;

    interface OutputInterface
    {
        public const VERBOSITY_QUIET = 16;
        public const VERBOSITY_NORMAL = 32;
        public const VERBOSITY_VERBOSE = 64;
        public const VERBOSITY_VERY_VERBOSE = 128;
        public const VERBOSITY_DEBUG = 256;

        public const OUTPUT_NORMAL = 1;
        public const OUTPUT_RAW = 2;
        public const OUTPUT_PLAIN = 4;

        /**
         * Writes a message to the output.
         *
         * @param string|iterable $messages The message as an iterable of strings or a single string
         * @param bool            $newline  Whether to add a newline
         * @param int             $options  A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
         */
        public function write($messages, bool $newline = false, int $options = 0);

        /**
         * Writes a message to the output and adds a newline at the end.
         *
         * @param string|iterable $messages The message as an iterable of strings or a single string
         * @param int             $options  A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
         */
        public function writeln($messages, int $options = 0);

        /**
         * Sets the verbosity of the output.
         */
        public function setVerbosity(int $level);

        /**
         * Gets the current verbosity of the output.
         *
         * @return int The current level of verbosity (one of the VERBOSITY constants)
         */
        public function getVerbosity();

        /**
         * Returns whether verbosity is quiet (-q).
         *
         * @return bool true if verbosity is set to VERBOSITY_QUIET, false otherwise
         */
        public function isQuiet();

        /**
         * Returns whether verbosity is verbose (-v).
         *
         * @return bool true if verbosity is set to VERBOSITY_VERBOSE, false otherwise
         */
        public function isVerbose();

        /**
         * Returns whether verbosity is very verbose (-vv).
         *
         * @return bool true if verbosity is set to VERBOSITY_VERY_VERBOSE, false otherwise
         */
        public function isVeryVerbose();

        /**
         * Returns whether verbosity is debug (-vvv).
         *
         * @return bool true if verbosity is set to VERBOSITY_DEBUG, false otherwise
         */
        public function isDebug();

        /**
         * Sets the decorated flag.
         */
        public function setDecorated(bool $decorated);

        /**
         * Gets the decorated flag.
         *
         * @return bool true if the output will decorate messages, false otherwise
         */
        public function isDecorated();

        public function setFormatter(OutputFormatterInterface $formatter);

        /**
         * Returns current output formatter instance.
         *
         * @return OutputFormatterInterface
         */
        public function getFormatter();
    }
}

namespace Phinx\Migration {

    use Phinx\Migration;
    use Phinx\Db\Adapter\AdapterInterface;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Phinx\Db\Table;

    interface MigrationInterface
    {
        /**
         * @var string
         */
        const CHANGE = 'change';

        /**
         * @var string
         */
        const UP = 'up';

        /**
         * @var string
         */
        const DOWN = 'down';

        /**
         * Sets the database adapter.
         *
         * @param \Phinx\Db\Adapter\AdapterInterface $adapter Database Adapter
         *
         * @return \Phinx\Migration\MigrationInterface
         */
        public function setAdapter(AdapterInterface $adapter);

        /**
         * Gets the database adapter.
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function getAdapter();

        /**
         * Sets the input object to be used in migration object
         *
         * @param \Symfony\Component\Console\Input\InputInterface $input
         *
         * @return \Phinx\Migration\MigrationInterface
         */
        public function setInput(InputInterface $input);

        /**
         * Gets the input object to be used in migration object
         *
         * @return \Symfony\Component\Console\Input\InputInterface
         */
        public function getInput();

        /**
         * Sets the output object to be used in migration object
         *
         * @param \Symfony\Component\Console\Output\OutputInterface $output
         *
         * @return \Phinx\Migration\MigrationInterface
         */
        public function setOutput(OutputInterface $output);

        /**
         * Gets the output object to be used in migration object
         *
         * @return \Symfony\Component\Console\Output\OutputInterface
         */
        public function getOutput();

        /**
         * Gets the name.
         *
         * @return string
         */
        public function getName();

        /**
         * Gets the detected environment
         *
         * @return string
         */
        public function getEnvironment();

        /**
         * Sets the migration version number.
         *
         * @param float $version Version
         *
         * @return \Phinx\Migration\MigrationInterface
         */
        public function setVersion($version);

        /**
         * Gets the migration version number.
         *
         * @return float
         */
        public function getVersion();

        /**
         * Sets whether this migration is being applied or reverted
         *
         * @param bool $isMigratingUp True if the migration is being applied
         *
         * @return \Phinx\Migration\MigrationInterface
         */
        public function setMigratingUp($isMigratingUp);

        /**
         * Gets whether this migration is being applied or reverted.
         * True means that the migration is being applied.
         *
         * @return bool
         */
        public function isMigratingUp();

        /**
         * Executes a SQL statement and returns the number of affected rows.
         *
         * @param string $sql SQL
         *
         * @return int
         */
        public function execute($sql);

        /**
         * Executes a SQL statement and returns the result as an array.
         *
         * To improve IDE auto-completion possibility, you can overwrite the query method
         * phpDoc in your (typically custom abstract parent) migration class, where you can set
         * the return type by the adapter in your current use.
         *
         * @param string $sql SQL
         *
         * @return mixed
         */
        public function query($sql);

        /**
         * Returns a new Query object that can be used to build complex SELECT, UPDATE, INSERT or DELETE
         * queries and execute them against the current database.
         *
         * Queries executed through the query builder are always sent to the database, regardless of the
         * the dry-run settings.
         *
         * @see https://api.cakephp.org/3.6/class-Cake.Database.Query.html
         *
         * @return \Cake\Database\Query
         */
        public function getQueryBuilder();

        /**
         * Executes a query and returns only one row as an array.
         *
         * @param string $sql SQL
         *
         * @return array
         */
        public function fetchRow($sql);

        /**
         * Executes a query and returns an array of rows.
         *
         * @param string $sql SQL
         *
         * @return array
         */
        public function fetchAll($sql);

        /**
         * Insert data into a table.
         *
         * @deprecated since 0.10.0. Use $this->table($tableName)->insert($data)->save() instead.
         *
         * @param string $tableName
         * @param array $data
         *
         * @return void
         */
        public function insert($tableName, $data);

        /**
         * Create a new database.
         *
         * @param string $name Database Name
         * @param array $options Options
         *
         * @return void
         */
        public function createDatabase($name, $options);

        /**
         * Drop a database.
         *
         * @param string $name Database Name
         *
         * @return void
         */
        public function dropDatabase($name);

        /**
         * Checks to see if a table exists.
         *
         * @param string $tableName Table Name
         *
         * @return bool
         */
        public function hasTable($tableName);

        /**
         * Returns an instance of the <code>\Table</code> class.
         *
         * You can use this class to create and manipulate tables.
         *
         * @param string $tableName Table Name
         * @param array $options Options
         *
         * @return \Phinx\Db\Table
         */
        public function table($tableName, $options);

        /**
         * Perform checks on the migration, print a warning
         * if there are potential problems.
         *
         * @param string|null $direction
         *
         * @return void
         */
        public function preFlightCheck($direction = null);

        /**
         * Perform checks on the migration after completion
         *
         * Right now, the only check is whether all changes were committed
         *
         * @param string|null $direction direction of migration
         *
         * @return void
         */
        public function postFlightCheck($direction = null);
    }

    /**
     * Abstract Migration Class.
     *
     * It is expected that the migrations you write extend from this class.
     *
     * This abstract class proxies the various database methods to your specified
     * adapter.
     *
     * @author Rob Morgan <robbym@gmail.com>
     */
    abstract class AbstractMigration implements MigrationInterface
    {

        /**
         * @param string $environment Environment Detected
         * @param int $version Migration Version
         * @param \Symfony\Component\Console\Input\InputInterface|null $input
         * @param \Symfony\Component\Console\Output\OutputInterface|null $output
         */
        final public function __construct($environment, $version, InputInterface $input = null, OutputInterface $output = null)
        {
        }

        /**
         * Initialize method.
         *
         * @return void
         */
        protected function init()
        {
        }

        /**
         * @inheritDoc
         */
        public function setAdapter(AdapterInterface $adapter)
        {
        }

        /**
         * @inheritDoc
         */
        public function getAdapter()
        {
        }

        /**
         * @inheritDoc
         */
        public function setInput(InputInterface $input)
        {
        }

        /**
         * @inheritDoc
         */
        public function getInput()
        {
        }

        /**
         * @inheritDoc
         */
        public function setOutput(OutputInterface $output)
        {
        }

        /**
         * @inheritDoc
         */
        public function getOutput()
        {
        }

        /**
         * @inheritDoc
         */
        public function getName()
        {
        }

        /**
         * @inheritDoc
         */
        public function getEnvironment()
        {
        }

        /**
         * @inheritDoc
         */
        public function setVersion($version)
        {
        }

        /**
         * @inheritDoc
         */
        public function getVersion()
        {
        }

        /**
         * @inheritDoc
         */
        public function setMigratingUp($isMigratingUp)
        {

        }

        /**
         * @inheritDoc
         */
        public function isMigratingUp()
        {
        }

        /**
         * @inheritDoc
         */
        public function execute($sql)
        {
        }

        /**
         * @inheritDoc
         */
        public function query($sql)
        {
        }

        /**
         * @inheritDoc
         */
        public function getQueryBuilder()
        {
        }

        /**
         * @inheritDoc
         */
        public function fetchRow($sql)
        {
        }

        /**
         * @inheritDoc
         */
        public function fetchAll($sql)
        {
        }

        /**
         * @inheritDoc
         */
        public function insert($table, $data)
        {
        }

        /**
         * @inheritDoc
         */
        public function createDatabase($name, $options)
        {
        }

        /**
         * @inheritDoc
         */
        public function dropDatabase($name)
        {
        }

        /**
         * @inheritDoc
         */
        public function hasTable($tableName)
        {
        }

        /**
         * @inheritDoc
         */
        public function table($tableName, $options = [])
        {
        }

        /**
         * A short-hand method to drop the given database table.
         *
         * @deprecated since 0.10.0. Use $this->table($tableName)->drop()->save() instead.
         *
         * @param string $tableName Table Name
         *
         * @return void
         */
        public function dropTable($tableName)
        {
        }

        /**
         * Perform checks on the migration, print a warning
         * if there are potential problems.
         *
         * Right now, the only check is if there is both a `change()` and
         * an `up()` or a `down()` method.
         *
         * @param string|null $direction
         *
         * @return void
         */
        public function preFlightCheck($direction = null)
        {
        }

        /**
         * Perform checks on the migration after completion
         *
         * Right now, the only check is whether all changes were committed
         *
         * @param string|null $direction direction of migration
         *
         * @throws \RuntimeException
         *
         * @return void
         */
        public function postFlightCheck($direction = null)
        {
        }
    }

}

namespace Phinx\Db {

    use Phinx\Db;
    use Phinx\Db\Adapter\AdapterInterface;

    /**
     * This object is based loosely on: http://api.rubyonrails.org/classes/ActiveRecord/ConnectionAdapters/Table.html.
     */
    class Table
    {
        /**
         * @var \Phinx\Db\Table\Table
         */
        protected $table;

        /**
         * @var \Phinx\Db\Adapter\AdapterInterface
         */
        protected $adapter;

        /**
         * @var \Phinx\Db\Plan\Intent
         */
        protected $actions;

        /**
         * @var array
         */
        protected $data = [];

        /**
         * @param string $name Table Name
         * @param array $options Options
         * @param \Phinx\Db\Adapter\AdapterInterface|null $adapter Database Adapter
         */
        public function __construct($name, $options = [], AdapterInterface $adapter = null)
        {
           
        }

        /**
         * Gets the table name.
         *
         * @return string|null
         */
        public function getName()
        {
        }

        /**
         * Gets the table options.
         *
         * @return array
         */
        public function getOptions()
        {
        }

        /**
         * Gets the table name and options as an object
         *
         * @return \Phinx\Db\Table\Table
         */
        public function getTable()
        {
        }

        /**
         * Sets the database adapter.
         *
         * @param \Phinx\Db\Adapter\AdapterInterface $adapter Database Adapter
         *
         * @return $this
         */
        public function setAdapter(AdapterInterface $adapter)
        {

        }

        /**
         * Gets the database adapter.
         *
         * @throws \RuntimeException
         *
         * @return \Phinx\Db\Adapter\AdapterInterface|null
         */
        public function getAdapter()
        {
        }

        /**
         * Does the table have pending actions?
         *
         * @return bool
         */
        public function hasPendingActions()
        {
        }

        /**
         * Does the table exist?
         *
         * @return bool
         */
        public function exists()
        {
        }

        /**
         * Drops the database table.
         *
         * @return $this
         */
        public function drop()
        {

        }

        /**
         * Renames the database table.
         *
         * @param string $newTableName New Table Name
         *
         * @return $this
         */
        public function rename($newTableName)
        {

        }

        /**
         * Changes the primary key of the database table.
         *
         * @param string|array|null $columns Column name(s) to belong to the primary key, or null to drop the key
         *
         * @return $this
         */
        public function changePrimaryKey($columns)
        {

        }

        /**
         * Changes the comment of the database table.
         *
         * @param string|null $comment New comment string, or null to drop the comment
         *
         * @return $this
         */
        public function changeComment($comment)
        {

        }

        /**
         * Gets an array of the table columns.
         *
         * @return \Phinx\Db\Table\Column[]
         */
        public function getColumns()
        {
        }

        /**
         * Gets a table column if it exists.
         *
         * @param string $name Column name
         *
         * @return \Phinx\Db\Table\Column|null
         */
        public function getColumn($name)
        {
        }

        /**
         * Sets an array of data to be inserted.
         *
         * @param array $data Data
         *
         * @return $this
         */
        public function setData($data)
        {
        }

        /**
         * Gets the data waiting to be inserted.
         *
         * @return array
         */
        public function getData()
        {
        }

        /**
         * Resets all of the pending data to be inserted
         *
         * @return void
         */
        public function resetData()
        {
        }

        /**
         * Resets all of the pending table changes.
         *
         * @return void
         */
        public function reset()
        {
        }

        /**
         * Add a table column.
         *
         * Type can be: string, text, integer, float, decimal, datetime, timestamp,
         * time, date, binary, boolean.
         *
         * Valid options can be: limit, default, null, precision or scale.
         *
         * @param string|\Phinx\Db\Table\Column $columnName Column Name
         * @param string|\Phinx\Util\Literal|null $type Column Type
         * @param array $options Column Options
         *
         * @throws \InvalidArgumentException
         *
         * @return $this
         */
        public function addColumn($columnName, $type = null, $options = [])
        {
        }

        /**
         * Remove a table column.
         *
         * @param string $columnName Column Name
         *
         * @return $this
         */
        public function removeColumn($columnName)
        {
        }

        /**
         * Rename a table column.
         *
         * @param string $oldName Old Column Name
         * @param string $newName New Column Name
         *
         * @return $this
         */
        public function renameColumn($oldName, $newName)
        {
        }

        /**
         * Change a table column type.
         *
         * @param string $columnName Column Name
         * @param string|\Phinx\Db\Table\Column|\Phinx\Util\Literal $newColumnType New Column Type
         * @param array $options Options
         *
         * @return $this
         */
        public function changeColumn($columnName, $newColumnType, array $options = [])
        {
        }

        /**
         * Checks to see if a column exists.
         *
         * @param string $columnName Column Name
         *
         * @return bool
         */
        public function hasColumn($columnName)
        {
        }

        /**
         * Add an index to a database table.
         *
         * In $options you can specific unique = true/false or name (index name).
         *
         * @param string|array|\Phinx\Db\Table\Index $columns Table Column(s)
         * @param array $options Index Options
         *
         * @return $this
         */
        public function addIndex($columns, array $options = [])
        {
        }

        /**
         * Removes the given index from a table.
         *
         * @param string|array $columns Columns
         *
         * @return $this
         */
        public function removeIndex($columns)
        {
        }

        /**
         * Removes the given index identified by its name from a table.
         *
         * @param string $name Index name
         *
         * @return $this
         */
        public function removeIndexByName($name)
        {
        }

        /**
         * Checks to see if an index exists.
         *
         * @param string|array $columns Columns
         *
         * @return bool
         */
        public function hasIndex($columns)
        {
        }

        /**
         * Checks to see if an index specified by name exists.
         *
         * @param string $indexName
         *
         * @return bool
         */
        public function hasIndexByName($indexName)
        {
        }

        /**
         * Add a foreign key to a database table.
         *
         * In $options you can specify on_delete|on_delete = cascade|no_action ..,
         * on_update, constraint = constraint name.
         *
         * @param string|array $columns Columns
         * @param string|\Phinx\Db\Table $referencedTable Referenced Table
         * @param string|array $referencedColumns Referenced Columns
         * @param array $options Options
         *
         * @return $this
         */
        public function addForeignKey($columns, $referencedTable, $referencedColumns = ['id'], $options = [])
        {
        }

        /**
         * Add a foreign key to a database table with a given name.
         *
         * In $options you can specify on_delete|on_delete = cascade|no_action ..,
         * on_update, constraint = constraint name.
         *
         * @param string $name The constraint name
         * @param string|array $columns Columns
         * @param string|\Phinx\Db\Table $referencedTable Referenced Table
         * @param string|array $referencedColumns Referenced Columns
         * @param array $options Options
         *
         * @return $this
         */
        public function addForeignKeyWithName($name, $columns, $referencedTable, $referencedColumns = ['id'], $options = [])
        {
        }

        /**
         * Removes the given foreign key from the table.
         *
         * @param string|array $columns Column(s)
         * @param string|null $constraint Constraint names
         *
         * @return $this
         */
        public function dropForeignKey($columns, $constraint = null)
        {
          
        }

        /**
         * Checks to see if a foreign key exists.
         *
         * @param string|array $columns Column(s)
         * @param string|null $constraint Constraint names
         *
         * @return bool
         */
        public function hasForeignKey($columns, $constraint = null)
        {
        }

        /**
         * Add timestamp columns created_at and updated_at to the table.
         *
         * @param string|null $createdAt Alternate name for the created_at column
         * @param string|null $updatedAt Alternate name for the updated_at column
         * @param bool $withTimezone Whether to set the timezone option on the added columns
         *
         * @return $this
         */
        public function addTimestamps($createdAt = 'created_at', $updatedAt = 'updated_at', $withTimezone = false)
        {
           
        }

        /**
         * Alias that always sets $withTimezone to true
         *
         * @see addTimestamps
         *
         * @param string|null $createdAt Alternate name for the created_at column
         * @param string|null $updatedAt Alternate name for the updated_at column
         *
         * @return $this
         */
        public function addTimestampsWithTimezone($createdAt = null, $updatedAt = null)
        {
            
        }

        /**
         * Insert data into the table.
         *
         * @param array $data array of data in the form:
         *              array(
         *                  array("col1" => "value1", "col2" => "anotherValue1"),
         *                  array("col2" => "value2", "col2" => "anotherValue2"),
         *              )
         *              or array("col1" => "value1", "col2" => "anotherValue1")
         *
         * @return $this
         */
        public function insert($data)
        {
           
        }

        /**
         * Creates a table from the object instance.
         *
         * @return void
         */
        public function create()
        {
           
        }

        /**
         * Updates a table from the object instance.
         *
         * @return void
         */
        public function update()
        {
           
        }

        /**
         * Commit the pending data waiting for insertion.
         *
         * @return void
         */
        public function saveData()
        {
            
        }

        /**
         * Immediately truncates the table. This operation cannot be undone
         *
         * @return void
         */
        public function truncate()
        {
        }

        /**
         * Commits the table changes.
         *
         * If the table doesn't exist it is created otherwise it is updated.
         *
         * @return void
         */
        public function save()
        {
           
        }

        /**
         * Executes all the pending actions for this table
         *
         * @param bool $exists Whether or not the table existed prior to executing this method
         *
         * @return void
         */
        protected function executeActions($exists)
        {
           
        }
    }
}

namespace Phinx\Db\Adapter {

    use  Phinx\Db\Adapter;
    use Phinx\Migration\MigrationInterface;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Phinx\Db\Table;

    interface AdapterInterface
    {
        const PHINX_TYPE_STRING = 'string';
        const PHINX_TYPE_CHAR = 'char';
        const PHINX_TYPE_TEXT = 'text';
        const PHINX_TYPE_SMALL_INTEGER = 'smallinteger';
        const PHINX_TYPE_INTEGER = 'integer';
        const PHINX_TYPE_BIG_INTEGER = 'biginteger';
        const PHINX_TYPE_BIT = 'bit';
        const PHINX_TYPE_FLOAT = 'float';
        const PHINX_TYPE_DECIMAL = 'decimal';
        const PHINX_TYPE_DOUBLE = 'double';
        const PHINX_TYPE_DATETIME = 'datetime';
        const PHINX_TYPE_TIMESTAMP = 'timestamp';
        const PHINX_TYPE_TIME = 'time';
        const PHINX_TYPE_DATE = 'date';
        const PHINX_TYPE_BINARY = 'binary';
        const PHINX_TYPE_VARBINARY = 'varbinary';
        const PHINX_TYPE_BLOB = 'blob';
        const PHINX_TYPE_BOOLEAN = 'boolean';
        const PHINX_TYPE_JSON = 'json';
        const PHINX_TYPE_JSONB = 'jsonb';
        const PHINX_TYPE_UUID = 'uuid';
        const PHINX_TYPE_FILESTREAM = 'filestream';

        // Geospatial database types
        const PHINX_TYPE_GEOMETRY = 'geometry';
        const PHINX_TYPE_POINT = 'point';
        const PHINX_TYPE_LINESTRING = 'linestring';
        const PHINX_TYPE_POLYGON = 'polygon';

        // only for mysql so far
        const PHINX_TYPE_ENUM = 'enum';
        const PHINX_TYPE_SET = 'set';

        // only for postgresql so far
        const PHINX_TYPE_CIDR = 'cidr';
        const PHINX_TYPE_INET = 'inet';
        const PHINX_TYPE_MACADDR = 'macaddr';
        const PHINX_TYPE_INTERVAL = 'interval';

        /**
         * Get all migrated version numbers.
         *
         * @return array
         */
        public function getVersions();

        /**
         * Get all migration log entries, indexed by version creation time and sorted ascendingly by the configuration's
         * version order option
         *
         * @return array
         */
        public function getVersionLog();

        /**
         * Set adapter configuration options.
         *
         * @param array $options
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function setOptions(array $options);

        /**
         * Get all adapter options.
         *
         * @return array
         */
        public function getOptions();

        /**
         * Check if an option has been set.
         *
         * @param string $name
         *
         * @return bool
         */
        public function hasOption($name);

        /**
         * Get a single adapter option, or null if the option does not exist.
         *
         * @param string $name
         *
         * @return mixed
         */
        public function getOption($name);

        /**
         * Sets the console input.
         *
         * @param \Symfony\Component\Console\Input\InputInterface $input Input
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function setInput(InputInterface $input);

        /**
         * Gets the console input.
         *
         * @return \Symfony\Component\Console\Input\InputInterface
         */
        public function getInput();

        /**
         * Sets the console output.
         *
         * @param \Symfony\Component\Console\Output\OutputInterface $output Output
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function setOutput(OutputInterface $output);

        /**
         * Gets the console output.
         *
         * @return \Symfony\Component\Console\Output\OutputInterface
         */
        public function getOutput();

        /**
         * Records a migration being run.
         *
         * @param \Phinx\Migration\MigrationInterface $migration Migration
         * @param string $direction Direction
         * @param int $startTime Start Time
         * @param int $endTime End Time
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function migrated(MigrationInterface $migration, $direction, $startTime, $endTime);

        /**
         * Toggle a migration breakpoint.
         *
         * @param \Phinx\Migration\MigrationInterface $migration
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function toggleBreakpoint(MigrationInterface $migration);

        /**
         * Reset all migration breakpoints.
         *
         * @return int The number of breakpoints reset
         */
        public function resetAllBreakpoints();

        /**
         * Set a migration breakpoint.
         *
         * @param \Phinx\Migration\MigrationInterface $migration The migration target for the breakpoint set
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function setBreakpoint(MigrationInterface $migration);

        /**
         * Unset a migration breakpoint.
         *
         * @param \Phinx\Migration\MigrationInterface $migration The migration target for the breakpoint unset
         *
         * @return \Phinx\Db\Adapter\AdapterInterface
         */
        public function unsetBreakpoint(MigrationInterface $migration);

        /**
         * Does the schema table exist?
         *
         * @deprecated use hasTable instead.
         *
         * @return bool
         */
        public function hasSchemaTable();

        /**
         * Creates the schema table.
         *
         * @return void
         */
        public function createSchemaTable();

        /**
         * Returns the adapter type.
         *
         * @return string
         */
        public function getAdapterType();

        /**
         * Initializes the database connection.
         *
         * @throws \RuntimeException When the requested database driver is not installed.
         *
         * @return void
         */
        public function connect();

        /**
         * Closes the database connection.
         *
         * @return void
         */
        public function disconnect();

        /**
         * Does the adapter support transactions?
         *
         * @return bool
         */
        public function hasTransactions();

        /**
         * Begin a transaction.
         *
         * @return void
         */
        public function beginTransaction();

        /**
         * Commit a transaction.
         *
         * @return void
         */
        public function commitTransaction();

        /**
         * Rollback a transaction.
         *
         * @return void
         */
        public function rollbackTransaction();

        /**
         * Executes a SQL statement and returns the number of affected rows.
         *
         * @param string $sql SQL
         *
         * @return int
         */
        public function execute($sql);

        /**
         * Executes a list of migration actions for the given table
         *
         * @param \Phinx\Db\Table\Table $table The table to execute the actions for
         * @param \Phinx\Db\Action\Action[] $actions The table to execute the actions for
         *
         * @return void
         */
        public function executeActions(Table $table, array $actions);

        /**
         * Returns a new Query object
         *
         * @return \Cake\Database\Query
         */
        public function getQueryBuilder();

        /**
         * Executes a SQL statement and returns the result as an array.
         *
         * @param string $sql SQL
         *
         * @return mixed
         */
        public function query($sql);

        /**
         * Executes a query and returns only one row as an array.
         *
         * @param string $sql SQL
         *
         * @return array
         */
        public function fetchRow($sql);

        /**
         * Executes a query and returns an array of rows.
         *
         * @param string $sql SQL
         *
         * @return array
         */
        public function fetchAll($sql);

        /**
         * Inserts data into a table.
         *
         * @param \Phinx\Db\Table\Table $table Table where to insert data
         * @param array $row
         *
         * @return void
         */
        public function insert(Table $table, $row);

        /**
         * Inserts data into a table in a bulk.
         *
         * @param \Phinx\Db\Table\Table $table Table where to insert data
         * @param array $rows
         *
         * @return void
         */
        public function bulkinsert(Table $table, $rows);

        /**
         * Quotes a table name for use in a query.
         *
         * @param string $tableName Table Name
         *
         * @return string
         */
        public function quoteTableName($tableName);

        /**
         * Quotes a column name for use in a query.
         *
         * @param string $columnName Table Name
         *
         * @return string
         */
        public function quoteColumnName($columnName);

        /**
         * Checks to see if a table exists.
         *
         * @param string $tableName Table Name
         *
         * @return bool
         */
        public function hasTable($tableName);

        /**
         * Creates the specified database table.
         *
         * @param \Phinx\Db\Table\Table $table Table
         * @param \Phinx\Db\Table\Column[] $columns List of columns in the table
         * @param \Phinx\Db\Table\Index[] $indexes List of indexes for the table
         *
         * @return void
         */
        public function createTable(Table $table, array $columns = [], array $indexes = []);

        /**
         * Truncates the specified table
         *
         * @param string $tableName
         *
         * @return void
         */
        public function truncateTable($tableName);

        /**
         * Returns table columns
         *
         * @param string $tableName Table Name
         *
         * @return \Phinx\Db\Table\Column[]
         */
        public function getColumns($tableName);

        /**
         * Checks to see if a column exists.
         *
         * @param string $tableName Table Name
         * @param string $columnName Column Name
         *
         * @return bool
         */
        public function hasColumn($tableName, $columnName);

        /**
         * Checks to see if an index exists.
         *
         * @param string $tableName Table Name
         * @param string|string[] $columns Column(s)
         *
         * @return bool
         */
        public function hasIndex($tableName, $columns);

        /**
         * Checks to see if an index specified by name exists.
         *
         * @param string $tableName Table Name
         * @param string $indexName
         *
         * @return bool
         */
        public function hasIndexByName($tableName, $indexName);

        /**
         * Checks to see if the specified primary key exists.
         *
         * @param string $tableName Table Name
         * @param string|string[] $columns Column(s)
         * @param string|null $constraint Constraint name
         *
         * @return bool
         */
        public function hasPrimaryKey($tableName, $columns, $constraint = null);

        /**
         * Checks to see if a foreign key exists.
         *
         * @param string $tableName
         * @param string|string[] $columns Column(s)
         * @param string|null $constraint Constraint name
         *
         * @return bool
         */
        public function hasForeignKey($tableName, $columns, $constraint = null);

        /**
         * Returns an array of the supported Phinx column types.
         *
         * @return array
         */
        public function getColumnTypes();

        /**
         * Checks that the given column is of a supported type.
         *
         * @param \Phinx\Db\Table\Column $column
         *
         * @return bool
         */
        public function isValidColumnType($column);

        /**
         * Converts the Phinx logical type to the adapter's SQL type.
         *
         * @param string $type
         * @param int|null $limit
         *
         * @return string[]
         */
        public function getSqlType($type, $limit = null);

        /**
         * Creates a new database.
         *
         * @param string $name Database Name
         * @param array $options Options
         *
         * @return void
         */
        public function createDatabase($name, $options = []);

        /**
         * Checks to see if a database exists.
         *
         * @param string $name Database Name
         *
         * @return bool
         */
        public function hasDatabase($name);

        /**
         * Drops the specified database.
         *
         * @param string $name Database Name
         *
         * @return void
         */
        public function dropDatabase($name);

        /**
         * Creates the specified schema or throws an exception
         * if there is no support for it.
         *
         * @param string $schemaName Schema Name
         *
         * @return void
         */
        public function createSchema($schemaName = 'public');

        /**
         * Drops the specified schema table or throws an exception
         * if there is no support for it.
         *
         * @param string $schemaName Schema name
         *
         * @return void
         */
        public function dropSchema($schemaName);

        /**
         * Cast a value to a boolean appropriate for the adapter.
         *
         * @param mixed $value The value to be cast
         *
         * @return mixed
         */
        public function castToBool($value);
    }
}

