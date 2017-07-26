<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class AnnotationTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'annotations';
//        $this->filename = base_path().'/database/seeds/csvs/references.csv';
//        $this->filename = base_path().'/database/seeds/csvs/pre_annotations.csv';
        $this->filename = base_path().'/database/seeds/csvs/pre_annotations.csv';
        $this->csv_delimiter = ";";
    }

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->delete();
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
                /*add column user_id for annotations*/
                array_push($mapping, "user_id");   
                /*add column postag_id for annotations*/          
                array_push($mapping, "postag_id");
            }
            else
            {        
                /* contains all columns of csv */
                $row_full = $this->readRow($row, $mapping_full);
                // insert only non-empty rows from the csv file
                if ( !$row_full )
                    continue; 
                
                $corpus_id = DB::table('corpora')
                        ->where('name', $row_full['corpus_name'])
                        ->pluck('id')[0];

                $sentence_position = $row_full["sentence_position"];
                $word_position = $row_full["word_position"];
                $postag_name = $row_full["postag_name"];

                $tagger = $row_full["tagger"];
                Log::debug($postag_name);
                
                /* retrieve ids */
                $sentence_id=DB::table('sentences')
                        ->where('corpus_id', $corpus_id)
                        ->where('position', $sentence_position)

                        ->pluck('id')[0];  
                Log::debug("sentence_id $sentence_id");
                Log::debug("word position $word_position");
                
                #Log::debug("word id $word_id");

                $word_id=DB::table('words')
                        ->where('sentence_id', $sentence_id)
                        ->where('position', $word_position)
                        ->pluck('id')[0];

                debug($word_id);
                $postag_id=DB::table('postags')
                        ->where('name', $postag_name)
                        ->pluck('id')[0];
                debug($postag_id);

                
                Log::debug($word_id);
                if ( $postag_name != null ) {   
                $postag_id=DB::table('postags')
                        ->where('name', $postag_name)
                        ->pluck('id')[0];
                } else {
                    $postag_id=null;
                }
                $row_annotation = $this->readRow($row, $mapping);
                /* insert only non-empty rows from the csv file */
                if ( !$row_annotation )
                    continue;
                $data_annotations[$row_count] = $row_annotation;
                $data_annotations[$row_count]['word_id'] = $word_id;
                $data_annotations[$row_count]['postag_id'] = $postag_id;
                $data_annotations[$row_count]['tagger'] = $tagger;
                $user_id=DB::table('users')
                        ->where('is_admin', true)
                        ->pluck('id')[0];
                $data_annotations[$row_count]['user_id'] = $user_id;
            
                // Chunk size reached, insert
                if ( ++$row_count == $this->insert_chunk_size )
                {
                    Log::info($data_annotations[$row_count-1]['word_id']);
                    Log::info("insertion");
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