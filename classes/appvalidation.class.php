<?php
/**
 * Class for validations
 * 
 * @author  Oswaldo Peña <oswaldopr@gmail.com>
 */
final class AppValidation {

    /**
     * Checks if the number of test-cases is correct
     * 
     * @param   integer $testCases  Number of test-cases
     * @return  boolean
     */
    static public function isTestCasesValidated($testCases) {
        return is_int($testCases) ? ($testCases >= 1 && $testCases <= MAX_TEST_CASES) : false;
    }

    /**
     * Checks if the dimension of matrix is correct
     * 
     * @param   integer $dimension  Dimension of matrix
     * @return  boolean
     */
    static public function isMatrixDimensionsValidated($dimension) {
        return is_int($dimension) ? ($dimension >= 1 && $dimension <= MAX_DIMENSIONS_MATRIX) : false;
    }

    /**
     * Checks if the number of operations is correct
     * 
     * @param   integer $operations Number of operations
     * @return  boolean
     */
    static public function isNumberOfOperationsValidated($operations) {
        return is_int($operations) ? ($operations >= 1 && $operations <= MAX_OPERATIONS) : false;
    }

    /**
     * Checks if the value of an element in matrix is correct
     * 
     * @param   integer $value      Value of an element in matrix
     * @return  boolean
     */
    static public function isElementValidated($value) {
        return is_int($value) ? ($value >= MIN_VALUE_ELEMENT && $value <= MAX_VALUE_ELEMENT) : false;
    }

    /**
     * Checks if one of the index in the matrix is correct
     * 
     * @param   integer $index      An index in matrix
     * @param   integer $dimension  Dimension of matrix
     * @return  boolean
     */
    static public function isIndexValidated($index, $dimension) {
        return ($index >= 1 && $index <= $dimension);
    }

    /**
     * Checks if the cell of an element in matrix is correct
     * 
     * @param   integer $x          Index X in matrix
     * @param   integer $y          Index Y in matrix
     * @param   integer $z          Index Z in matrix
     * @param   integer $dimension  Dimension of matrix
     * @return  boolean
     */
    static public function isCellValidated($x, $y, $z, $dimension) {
        $return = self::isIndexValidated($x, $dimension);
        $return = $return && self::isIndexValidated($y, $dimension);
        $return = $return && self::isIndexValidated($z, $dimension);
        return $return;
    }
}
?>