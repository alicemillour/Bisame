<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class AnnotationTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'annotations';
        $this->filename = base_path().'/database/seeds/csvs/pre_annotations.csv';
        $this->csv_delimiter = ";";
    }

    public function run()
    {
        print("seeding ANNOTATION");
         // Recommended when importing larger CSVs
        DB::disableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();   
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        parent::run();
    }
    
    public function seedFromCSV($filename, $deliminator = ",")
	{
        $handle = $this->openCSV($filename);
        // CSV doesn't exist or couldn't be read from.
        if ( $handle === FALSE )
            return [];
        $header = NULL;
	$row_count = 0;
        $data_annotations = [];
        $mapping = $this->mapping ?: [];
        $mapping_full = $this->mapping ?: [];
        $offset = $this->offset_rows;

        while ( ($row = fgetcsv($handle, 0, $deliminator)) !== FALSE )
        {
            // Offset the specified number of rows
            while ( $offset > 0 )
            {
                $offset--;
                continue 2;
            }
            // No mapping specified - grab the first CSV row and use it
            if ( !$mapping )
            {
                /* create mapping */
                $mapping = $row;
                $mapping[0] = $this->stripUtf8Bom($mapping[0]);
                $mapping_full = $row;
                $mapping_full[0] = $this->stripUtf8Bom($mapping_full[0]);
                // skip csv columns that don't exist in the database
                foreach($mapping  as $index => $fieldname){
                   if (!DB::getSchemaBuilder()->hasColumn($this->table, $fieldname)){
                       array_pull($mapping, $index);
                   }
                }
                /*add column word_id for annotations*/
                array_push($mapping, "word_id");
            }
            else
            {        
                /* contains all columns of csv */
                $row_full = $this->readRow($row, $mapping_full);
                // insert only non-empty rows from the csv file
                if ( !$row_full )
                    continue; 
                
                $corpus_id = $row_full["corpus_id"];
                $sentence_position = $row_full["sentence_position"];
                $word_position = $row_full["word_position"];

                /* retrieve sentence_id */
                $sentence_id=DB::table('sentences')
                        ->where('corpus_id', $corpus_id)
                        ->where('position', $sentence_position)
                        ->pluck('id')[0];  
                $word_id=DB::table('words')
                        ->where('sentence_id', $sentence_id)
                        ->where('position', $word_position)
                        ->pluck('id')[0];
                print("\n");
                print($sentence_position);
                print(" ");
                print($word_position);
                $row_annotation = $this->readRow($row, $mapping);
                /* insert only non-empty rows from the csv file */
                if ( !$row_annotation )
                    continue;
                $data_annotations[$row_count] = $row_annotation;
                $data_annotations[$row_count]['word_id'] = $word_id;

                // Chunk size reached, insert
                if ( ++$row_count == $this->insert_chunk_size )
                {
                    print($data_annotations[$row_count-1]['word_id']);
                    print("insertion\n");
                    /* insert chunck in words table */
                    $this->insert_table($data_annotations,$this->table);
                    $row_count = 0;
                    // clear the data array explicitly when it was inserted so
                    // that nothing is left, otherwise a leftover scenario can
                    // cause duplicate inserts
                    $data_annotations = array();
                }
                
            }
        }
        // Insert any leftover rows
        //check if the data array explicitly if there are any values left to be inserted, if insert them
        if ( count($data_annotations)  ){
            $this->insert_table($data_annotations,$this->table);
        }
        fclose($handle);
		return $data_annotations;
	}
        
        public function insert_table( array $seedData , $table)
	{
                try {
                    DB::table($table)->insert($seedData);
                } catch (\Exception $e) {
                    Log::error("CSV insert failed: " . $e->getMessage() . " - CSV " . $this->filename);
                    return FALSE;
		}
        return TRUE;
	}    

}