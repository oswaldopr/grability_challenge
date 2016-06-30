<?php
/**
 * Model that implements the cube summation
 * 
 * @author  Oswaldo Peña <oswaldopr@gmail.com>
 */
final class Calculate_CubeSummation extends Template {

    //--Class Constants--//
    const MATRIX_DIMENSIONS = 3;

    //--Class Properties--//
    private $_input;
    private $_testCases;
    private $_dimensions;
    private $_operations;
    private $_matrix;
    private $_elements;
    private $_output;

    /**
     * Constructor of class
     * 
     * @return  void
     */
    public function __construct() {
        parent::__construct("calculate_cubesummation");
        $this->_input = "";
        $this->_testCases = 0;
        $this->_dimensions = 0;
        $this->_operations = 0;
        $this->_matrix = array();
        $this->_elements = 0;
        $this->_output = array();
    }

    /**
     * Sends an error message to template
     * 
     * @param   string  $message    Error message to show
     * @return  void
     */
    private function setErrorMessage($message) {
        $this->assign("errorMessage", $message);
    }

    /**
     * Gets and validates the number of test-cases
     * 
     * @param   array   $args   Post data from template
     * @return  boolean
     */
    public function parseTestCases($args) {
        if(empty($args["taInputData"])) {
            $this->setErrorMessage("No Data!");
            return false;
        }
        $this->_input = str_replace("\r", "", $args["taInputData"]);
        sscanf($this->_input, "%d", $this->_testCases);
        if(!AppValidation::isTestCasesValidated($this->_testCases)) {
            $this->setErrorMessage("Test-Cases <span>{$this->_testCases}</span> Is Invalid!");
            return false;
        }
        return true;
    }

    /**
     * Process each test-case
     * 
     * @return  void
     */
    public function processTestCases() {
        $data = explode("\n", $this->_input);
        for($t = 0, $index = 1; $t < $this->_testCases; $t++) {
            sscanf($data[$index], "%d %d", $this->_dimensions, $this->_operations);
            if(!$this->validateInitData())
                break;
            if(!$this->parseOperations($data, ++$index))
                break;
            $index += $this->_operations;
        }
        $this->assign("input", $this->_input);
        $this->assign("output", implode("\n", $this->_output));
    }

    /**
     * Validates the dimension of matrix and the number of operations
     * 
     * @return  boolean
     */
    private function validateInitData() {
        if(!AppValidation::isMatrixDimensionsValidated($this->_dimensions)) {
            $this->setErrorMessage("Matrix Dimension <span>{$this->_dimensions}</span> Is Invalid!");
            return false;
        }
        if(!AppValidation::isNumberOfOperationsValidated($this->_operations)) {
            $this->setErrorMessage("Number Of Operations <span>{$this->_operations}</span> Is Invalid!");
            return false;
        }
        return true;
    }

    /**
     * Determines the type of operations and executes it
     * 
     * @param   array   $data   Input data (zero based)
     * @param   integer $index  Number of line where operations begin for a test-case
     * @return  boolean
     */
    private function parseOperations($data, $index) {
        $this->initializeMatrix();
        for($m = 0; $m < $this->_operations; $m++) {
            $string = $data[$index + $m];
            $result = false;
            if(strncasecmp("update", $string, 6) === 0)
                $result = $this->update($string);
            elseif(strncasecmp("query", $string, 5) === 0)
                $result = $this->query($string);
            else
                $this->setErrorMessage("Operation Unknown: <span>$string</span>");
            if(!$result)
                return false;
        }
        return true;
    }

    /**
     * Fills the matrix with zero (matrix is a logical representation; the data structure is a vector)
     * 
     * @return  void
     */
    private function initializeMatrix() {
        $this->_matrix = array();
        $this->_elements = pow($this->_dimensions, self::MATRIX_DIMENSIONS);
        for($n = 0; $n < $this->_elements; $n++)
            $this->_matrix[$n] = 0;
    }

    /**
     * Calculates the index of vector based in the coordinates of a cell
     * 
     * @param   integer $x  First dimension index
     * @param   integer $y  Second dimension index
     * @param   integer $z  Third dimension index
     * @return  integer
     */
    private function getIndexMatrix($x, $y, $z) {
        $index = $this->_elements / $this->_dimensions * ($x - 1) - 1;
        $index += $this->_dimensions * ($y - 1);
        $index += $z;
        return $index;
    }

    /**
     * Executes the UPDATE operation
     * 
     * @param   string  $string String of all operation
     * @return  boolean
     */
    private function update($string) {
        sscanf($string, "%6s %d %d %d %d", $m, $x, $y, $z, $value);
        if($this->validateUpdate($x, $y, $z, $value)) {
            $index = $this->getIndexMatrix($x, $y, $z);
            $this->_matrix[$index] = $value;
            return true;
        }
        return false;
    }

    /**
     * Validates the UPDATE operation arguments
     * 
     * @param   integer $x      First dimension index of cell
     * @param   integer $y      Second dimension index of cell
     * @param   integer $z      Third dimension index of cell
     * @param   integer $value  Value to save in matrix
     * @return  boolean
     */
    private function validateUpdate($x, $y, $z, $value) {
        if(!AppValidation::isCellValidated($x, $y, $z, $this->_dimensions)) {
            $this->setErrorMessage("Cell <span>$x,$y,$z</span> Not Exists!");
            return false;
        }
        if(!AppValidation::isElementValidated($value)) {
            $this->setErrorMessage("Value <span>$value</span> Is Invalid!");
            return false;
        }
        return true;
    }

    /**
     * Executes the QUERY operation
     * 
     * @param   string  $string String of all operation
     * @return  boolean
     */
    private function query($string) {
        sscanf($string, "%5s %d %d %d %d %d %d", $m, $x1, $y1, $z1, $x2, $y2, $z2);
        if($this->validateQuery($x1, $y1, $z1, $x2, $y2, $z2)) {
            $sum = 0;
            for($x = $x1, $y = $y1, $z = $z1; $x <= $x2; ) {
                $index = $this->getIndexMatrix($x, $y, $z);
                $sum += $this->_matrix[$index];
                $z = $z % $z2 + 1;
                if($z == 1)
                    $y = $y % $y2 + 1;
                if($z == 1 && $y == 1)
                    $x++;
            }
            $this->_output[] = $sum;
            return true;
        }
        return false;
    }

    /**
     * Validates the QUERY operation arguments
     * 
     * @param   integer $x1 First dimension index of start cell
     * @param   integer $y1 Second dimension index of start cell
     * @param   integer $z1 Third dimension index of start cell
     * @param   integer $x2 First dimension index of end cell
     * @param   integer $y2 Second dimension index of end cell
     * @param   integer $z2 Third dimension index of end cell
     * @return  boolean
     */
    private function validateQuery($x1, $y1, $z1, $x2, $y2, $z2) {
        if(!AppValidation::isCellValidated($x2, $y2, $z2, $this->_dimensions)) {
            $this->setErrorMessage("Cell <span>$x,$y,$z</span> Not Exists!");
            return false;
        }
        if(!AppValidation::isIndexValidated($x1, $x2)) {
            $this->setErrorMessage("x1=<span>$x1</span> Is Out Of Range!");
            return false;
        }
        if(!AppValidation::isIndexValidated($y1, $y2)) {
            $this->setErrorMessage("y1=<span>$y1</span> Is Out Of Range!");
            return false;
        }
        if(!AppValidation::isIndexValidated($z1, $z2)) {
            $this->setErrorMessage("z1=<span>$z1</span> Is Out Of Range!");
            return false;
        }
        return true;
    }
}
?>