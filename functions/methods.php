<?php 

    class Methods
    {

        public function pagination($array, $max, $page) {
    
            $max_results = $max;
            $pages = count($array) < $max_results ? 0 : ceil(count($array) / $max_results);
            $offset = $max_results * ($page - 1);
            $items = array_slice($array, $offset, $max_results);

            return ['array' => $items, 'pages' => $pages];

        }

        public function convDate($date) {
            $x = new DateTime($date);
            return $x->format('Y-m-d');
        }

        public function convTime($date) {
            $x = new DateTime($date);
            return $x->format('H:i');
        }
    
  }

  $mtd = new Methods;

?>