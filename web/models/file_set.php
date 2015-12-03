<?php defined('C5_EXECUTE') or die("Access Denied.");

class FileSetList extends Concrete5_Model_FileSetList {}
class FileSet extends Concrete5_Model_FileSet {}
class FileSetFile extends Concrete5_Model_FileSetFile {
    public static function createAndGetFile($f_id, $fs_id){
        $file_set_file = new FileSetFile();
        $criteria = array($f_id,$fs_id);

        $matched_sets = $file_set_file->Find('fID=? AND fsID=?',$criteria);

        if (1 === count($matched_sets) ) {
            return $matched_sets[0];
        }
        else if (1 < count($matched_sets)) {
            return $matched_sets;
        }
        else{
            //AS: Adodb Active record is complaining a ?/value array mismatch unless
            //we explicatly set the primary key ID field to null
            $db = Loader::db();
            $fsDisplayOrder = $db->GetOne('select count(fID) from FileSetFiles where fsID = ?', $fs_id);
            $file_set_file->fsfID = null;
            $file_set_file->fID =  $f_id;
            $file_set_file->fsID = $fs_id;
            // @custom!
            // transition to mysql 5.6 causes issues when timestamp columns
            // are null (doesn't accept null, when it should and set the timestamp
            // value to the current timestamp; but instead he have to do so here)
            $file_set_file->timestamp = date('Y-m-d H:i:s'); //null;
            $file_set_file->fsDisplayOrder = $fsDisplayOrder;
            $file_set_file->Save();
            return $file_set_file;
        }
    }
}
class FileSetSavedSearch extends Concrete5_Model_FileSetSavedSearch {}