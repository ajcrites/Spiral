<?php
class Spiral {
   /**
    * @var int Square root of the size of the spiral
    */
   private $lim;

   /**
    * @var int Current x position in spiral build
    */
   private $x = 0;

   /**
    * @var int Current y position in spiral build
    */
   private $y = 0;

   /**
    * @var array Direction state for x coordinate
    */
   private $dx = array(1, 0, -1, 0);

   /**
    * @var array Direction state for y coordinate
    */
   private $dy = array(0, 1, 0, -1);

   /**
    * @var array Container for the spiral
    */
   private $spiral = array();

   /**
    * @var int counter for spiral printing progress
    */
   private $count = 0;

   /**
    * @var int the number of turns
    */
   private $turns = 0;

   /**
    * Create the Spiral object and set the size of the square
    */
   public function __construct($lim) {
      if (!is_int($lim)) {
         throw new SpiralException("Length must be an integer");
      }
      $this->lim = $lim;
   }

   /**
    * Construct the internal spiral array
    */
   public function build() {
      $x = &$this->x;
      $y = &$this->y;
      $sp = &$this->spiral;
      $c = &$this->count;
      while ($c < pow($this->lim, 2)) {
         if (!isset($sp[$x])) {
            $sp[$x] = array();
         }
         $sp[$x][$y] = $c++;

         $x += $this->dx[0];
         $y += $this->dy[0];

         if ($x + $this->dx[0] >= $this->lim || $x + $this->dx[0] < 0
            || $y + $this->dy[0] >= $this->lim || $y + $this->dy[0] < 0
            || isset($sp[$x + $this->dx[0]][$y + $this->dy[0]])
         ) {
            $this->turn45Degrees();
         }
      }
   }

   /**
    * Update the direction pseudo-constants to increment the other directional value
    */
   private function turn45Degrees() {
      array_push($this->dx, array_shift($this->dx));
      array_push($this->dy, array_shift($this->dy));
   }

   public function emit() {
      $spaces = ceil(sqrt($this->lim)) + 1;
      //I prefer the pythonic (hey, vim thinks that's a word!) method of iteration
      //even though it is less memory efficient in php
      foreach (range(0, $this->lim - 1) as $y) {
         foreach (range(0, $this->lim - 1) as $x) {
            printf("% {$spaces}d", $this->spiral[$x][$y]);
         }
         echo "\n";
      }
   }

   public static function printSpiral($lim) {
      $sp = new Spiral($lim);
      $sp->build();
      return $sp->emit();
   }
}

class SpiralException extends Exception {}
?>
