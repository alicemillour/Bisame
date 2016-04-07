<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class WordTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table='words';
        $this->words_table = 'words';
        $this->sentences_table = 'sentences';
        $this->filename = base_path().'/database/seeds/csvs/words.csv';
        $this->csv_delimiter = ";";
    }

    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();   
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        parent::run();
    }
    
	/**
	 * Collect data from a given CSV file and return as array
	 *
	 * @param string $filename
	 * @param string $deliminator
	 * @return array|bool
	 */
	public function seedFromCSV($filename, $deliminator = ",")
	{
        $handle = $this->openCSV($filename);
        // CSV doesn't exist or couldn't be read from.
        if ( $handle === FALSE )
            return [];
        $header = NULL;
	$row_count = 0;
        $my_row_count = 0;
        $data_words = [];
        $data_full = [];
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
                   if (!DB::getSchemaBuilder()->hasColumn($this->words_table, $fieldname)){
                       array_pull($mapping, $index);
                   }
                }
                /*add column sentence_id for words*/
                array_push($mapping, "sentence_id");
            }
            else
            {        
                /* contains all columns of csv */
                $row_full = $this->readRow($row, $mapping_full);
                // insert only non-empty rows from the csv file
                if ( !$row_full )
                    continue; 
                
                /* regarder si on a déjà une sentence ayant ce corpus_id et ce sentence_position */
                /* $data_full[$row_count] = $row_full;
                 * $corpus_id_cur = $data_full[$row_count]["corpus_id"];
                $sentence_pos_cur = $data_full[$row_count]["sentence_position"];
                 */
                $corpus_id_cur = $row_full["corpus_id"];
                $sentence_pos_cur = $row_full["sentence_position"];
                $sentence = DB::table('sentences')
                        ->where('corpus_id', $corpus_id_cur)
                        ->where('position', $sentence_pos_cur)
                        ->first();
                /* insert new sentence ... A déplacer : créer data_sentences */
                if ($sentence==null){
                    DB::table('sentences')->insert(['corpus_id' => $corpus_id_cur, 'position' => $sentence_pos_cur]);
                }
                
                /* retrieve sentence_id */
                $sentence_id=DB::table('sentences')
                        ->where('corpus_id', $corpus_id_cur)
                        ->where('position', $sentence_pos_cur)
                        ->pluck('id')[0];  
                
                $row_words = $this->readRow($row, $mapping);
                /* insert only non-empty rows from the csv file */
                if ( !$row_words )
                    continue;
                $data_words[$row_count] = $row_words;
                $data_words[$row_count]['sentence_id'] = $sentence_id;

                // Chunk size reached, insert
                if ( ++$row_count == $this->insert_chunk_size )
                {
                    /* insert chunck in words table */
                    $this->insert_table($data_words,$this->words_table);
                    $row_count = 0;
                    // clear the data array explicitly when it was inserted so
                    // that nothing is left, otherwise a leftover scenario can
                    // cause duplicate inserts
                    $data_words = array();
                }
                
            }
        }
        // Insert any leftover rows
        //check if the data array explicitly if there are any values left to be inserted, if insert them
        if ( count($data_words)  ){
            $this->insert_table($data_words,$this->words_table);
        }
        fclose($handle);
		return $data_words;
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