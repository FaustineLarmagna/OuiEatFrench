<?php 

	 $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

	 //on check si c'est bien un fichier csv
          if(in_array($_FILES['import-file']['type'],$mimes))
          {
          	//le dossier où le fichier sera uploadé
               $dossier = 'import/';
               $nameFile = $_FILES['import-file']['name'];
               $fichier = basename($_FILES['import-file']['name']);

               if(move_uploaded_file($_FILES['import-file']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               {

               		//on se connecte à la DB
                    $connect = mysql_connect('localhost','root','');

                    // Si erreur
                    if (!$connect) 
                    {
                         die('Could not connect to MySQL: ' . mysql_error());
                    }

                    $cid =mysql_select_db('ouieatfrench',$connect);

                    define('CSV_PATH','import/');

                    $csv_file = CSV_PATH . $nameFile; // Name of your CSV file

                    $csvfile = fopen($csv_file, 'r');

                    $theData = fgets($csvfile);

                    $i = 0;

                    while (!feof($csvfile)) 
                    {

                        $csv_data[] = fgets($csvfile, 1024);

                        $csv_array = explode(";", $csv_data[$i]);

                        $insert_csv = array();

                        $insert_csv['filters'] = $csv_array[0];

                        $insert_csv['name_product'] = $csv_array[1];

                        $insert_csv['description_product'] = $csv_array[2];

                        $insert_csv['image_product'] = $csv_array[3];

                        $insert_csv['category_product'] = $csv_array[4];

                        $insert_csv['calories_product'] = $csv_array[5];

                        $categoryQuery = "SELECT DISTINCT id
                        					FROM `admin_category`
                        					WHERE name = '".$insert_csv['category_product']."'";
                        $categoryReq = mysql_query($categoryQuery);

                        $categoryResult = mysql_result($categoryReq, 0);

                        $filtersProduct = explode('*', $insert_csv['filters']);
                        
                        

                        if (!empty($insert_csv['filters']) && !empty($insert_csv['name_product']) && !empty($insert_csv['description_product']) && !empty($insert_csv['image_product']) && !empty($insert_csv['category_product']) && !empty($insert_csv['calories_product'])) 
                        {
                        	//la requete pour insert
                          $query = "INSERT INTO admin_product(id,name,description,image_name,category_id,calories) VALUES ('', '".$insert_csv['name_product']."', '".$insert_csv['description_product']."', '".$insert_csv['image_product']."', '".$categoryResult."', '".$insert_csv['calories_product']."')
                          ";

                          $n = mysql_query($query, $connect) or exit(mysql_error());

                          $lastIdProduct = mysql_insert_id();
                        }

                        $i++;

                        for ($q = 0; $q < count($filtersProduct); $q++) 
                        { 
                        	if (!empty($filtersProduct[$q])) 
                        	{
                        		$queryFilters = "INSERT INTO filter_for_product(id,name) VALUES ('', '".mysql_real_escape_string($filtersProduct[$q])."')";

                        		$k = mysql_query($queryFilters, $connect) or exit(mysql_error());

                        		$lastIdFilter = mysql_insert_id();

	                        	$queryProductFilter = "INSERT INTO product_filter(product_id,filter_id) VALUES('".$lastIdProduct."', '".$lastIdFilter."')"; 

	                        	$p = mysql_query($queryProductFilter, $connect) or exit(mysql_error());
                        	}            
                        }


                        
                }
            }

            fclose($csvfile);

            echo "File data successfully imported to database!!";

            mysql_close($connect);
        }

         else //Sinon (la fonction renvoie FALSE).
               {
                    echo 'Echec de l\'upload !';
               }


?>