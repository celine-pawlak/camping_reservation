
        <?php 
        
        class Bdd{      
          private $host = '';
          private $username = '';
          private $password = '';
          private $db ='';
          private $connect = '';
          private $query = '';
          private $result = '';
          private $table ='';



       
    public function __construct($host = "localhost", $username = "root", $password = "root", $db = "camping")
    {
        try {
            $this->db = new PDO('mysql:dbname=' . $db . ';host=' . $host . '', $username, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

        //CONNECT

        public function connect($host, $username, $password, $db) {
            $this->connect = mysqli_connect("$host", "$username", "$password", "$db");
            return $this->connect;
        }
  
        
       //CLOSE
       public function close(){

            mysqli_close($this->connect);
 
        }

        //EXECUTE
        public function just_execute($query){

            $query = mysqli_query($this->connect, $request);
            return $query;
            }

        //EXECUTE
        public function execute($query){

        $request = $this->connect->query($query);
        //var_dump($request);
        $result_query = mysqli_fetch_all($request);
        //var_dump($result_query);

        $this->query = $request;
        $this->result = $result_query;
    
        return $result_query;

        }

        //EXECUTE ASSOC
        public function execute_assoc($query) {

        $request = $this->connect->query($query);
        $result_query = mysqli_fetch_all($query,MYSQLI_ASSOC);
        return $result_query;
        }

        //GETLASTQUERY
        public function getLastQuery(){

            if (!empty($this->query)){

                var_dump($this->query);
                return $this->query;
                
            }
            else return false;
    
        }

         //GETLASTRESULT
         public function getLastResult(){
    
            if (!empty ($this->result)){

                var_dump($this->result);
                return $this->result;
            }
            else return false;
    
        }

      
 
        
    }
        
        //$db = new Bdd();
        //$db -> connect('localhost', 'root', 'root', 'camping');
        //$db ->close();
        //$db ->execute ('SELECT * FROM utilisateurs');
        //$db-> getLastQuery();
        //$db-> getLastResult();

        ?>

    </body>
</html>