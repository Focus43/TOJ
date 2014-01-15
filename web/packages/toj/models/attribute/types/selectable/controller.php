<?php defined('C5_EXECUTE') or die("Access Denied.");

    class SelectableAttributeTypeController extends AttributeTypeController {

        protected $searchIndexFieldDefinition = 'X NULL';

        protected $_tableName = 'atSelectable';


        /**
         * Get the assigned value.
         * @return SelectableAttributeTypeOption
         */
        public function getValue(){
            $optionKey = Loader::db()->GetOne("SELECT optionKey FROM {$this->_tableName} WHERE avID = ?", array( $this->getAttributeValueID() ));
            return SelectableAttributeTypeOption::getByOptionKey($this->getAttributeKey(), $optionKey);
        }


        /**
         * When the user saves an object (for example, a page), and the attribute gets indexed,
         * we need to return the optionKey, not the optionValue.
         * @return string
         */
        public function getSearchIndexValue(){
            return $this->getValue()->getOptionKey();
        }


        /**
         * @note: not sure when this is ever called?
         * @return string
         */
        public function getDisplayValue(){
            return $this->getValue()->getOptionValue();
        }


        /**
         * @todo: if key is deleted, remove its values in the associated table
         * @return void
         */
        public function deleteKey(){
            // purge all the options first
            SelectableAttributeTypeOption::purgeAllForAttributeKey($this->getAttributeKey());

            // then delete the attribute value records
            $db  = Loader::db();
            $arr = $this->attributeKey->getAttributeValueIDList();
            foreach($arr AS $id){
                $db->Execute("DELETE FROM {$this->_tableName} WHERE avID = ?", array($id));
            }
        }


        /**
         * Not really sure when this gets called...
         */
        public function deleteValue(){
            $db = Loader::db();
            $db->Execute("DELETE FROM {$this->_tableName} WHERE avID = ?", array( $this->getAttributeValueID() ));
        }


        /**
         * @todo: test if a) is an option object (maybe make it so you can pass just a text
         * string?), and b) if the option object has an id >= 1
         * @param SelectableAttributeTypeOption $optObj
         */
        public function saveValue( SelectableAttributeTypeOption $optObj ){
            Loader::db()->Replace( $this->_tableName, array(
                'avID'      => $this->getAttributeValueID(),
                'optionKey' => $optObj->getOptionKey()
            ), 'avID', true);
        }


        /**
         * Form displayed when user clicks "advanced search". Renders directly where its called.
         * @return void
         */
        public function search(){
            print Loader::helper('form')->select( $this->field('value'), $this->selectElementFormattedOptions(), $this->request('value') );
        }


        /**
         * Applied when using the search form (from the search() method).
         * @param $list
         * @return mixed
         */
        public function searchForm( $list ){
            $list->filterByAttribute( $this->attributeKey->getAttributeKeyHandle(), $this->request('value'), '=' );
            return $list;
        }


        /**
         * Form used to edit the values for the attribute in the dashboard (NOT! the form
         * that is used when assigning a value to an object, but actually creating the available
         * values).
         */
        public function type_form(){
            $this->set('formHelper', Loader::helper('form'));
            $this->set('optionList', SelectableAttributeTypeOption::getListByAttributeKey( $this->getAttributeKey() ));
        }


        /**
         * Called when the user edits the values in the type_form.
         * @param $data
         */
        public function saveKey( $data ){
            // first purge all existing
            SelectableAttributeTypeOption::purgeAllForAttributeKey( $this->getAttributeKey() );

            // then recreate them all
            $pairs = $data['pairs'];
            foreach( (array) $pairs['key'] AS $index => $ignore ){
                $optionKey = $pairs['key'][$index];
                $optionVal = $pairs['value'][$index];
                if( !empty($optionKey) && !empty($optionVal) ){
                    SelectableAttributeTypeOption::create( $this->getAttributeKey(), $optionKey, $optionVal, ($index+1) );
                }
            }
        }


        /**
         * Handler called when the user is assigning a value to an object (making the attribute
         * association).
         * @param array $data
         */
        public function saveForm( $data = array() ){
            $optObj = SelectableAttributeTypeOption::getByOptionKey( $this->getAttributeKey(), $data['value'] );
            $this->saveValue($optObj);
        }


        /**
         * Form used when creating the relationship between existing values and an object.
         * @return void
         */
        public function form(){
            if( is_object($this->attributeValue) ){
                $optObj = $this->getAttributeValue()->getValue();
                $value  = $optObj->getOptionKey();
            }
            print Loader::helper('form')->select( $this->field('value'), $this->selectElementFormattedOptions(), $value );
        }


        /**
         * @return array
         */
        public function selectElementFormattedOptions(){
            $existingOptionList  = SelectableAttributeTypeOption::getListByAttributeKey($this->getAttributeKey());
            $formattedOptionList = array();
            foreach($existingOptionList AS $optObj){ /** @var SelectableAttributeTypeOption $optObj */
                $formattedOptionList[ $optObj->getOptionKey() ] = $optObj->getOptionValue();
            }
            return $formattedOptionList;
        }


        /**
         * @todo: implement! copy all values from the atSelectableOptions and assign a new
         * akID
         */
        public function duplicateKey(){

        }


        /**
         * @todo: when key is deleted, remove the values from atSelectableOptions
         */

    }



    class SelectableAttributeTypeOption {

        protected static $_optionsTableName = 'atSelectableOptions';

        protected $akID, $optionKey, $optionValue;

        public function __construct( $akID, $optionKey, $optionValue ){
            $this->akID         = $akID;
            $this->optionKey    = $optionKey;
            $this->optionValue  = $optionValue;
        }

        /** @return string : echo {$instance} of SelectableAttributeTypeOption */
        public function __toString(){ return (string) $this->optionValue; }

        /** @return int */
        public function getAttributeKeyID(){ return $this->akID; }

        /** @return string */
        public function getOptionKey(){ return $this->optionKey; }

        /** @return string */
        public function getOptionValue(){ return $this->optionValue; }


        /**
         * @param AttributeKey $akObj
         * @param null $optionKey
         * @return SelectableAttributeTypeOption
         */
        public static function getByOptionKey( AttributeKey $akObj, $optionKey = null ){
            $tableName = self::$_optionsTableName;
            $row = Loader::db()->GetRow("SELECT optionKey, optionValue FROM {$tableName} WHERE akID = ? AND optionKey = ?", array(
                $akObj->getAttributeKeyID(), $optionKey
            ));
            return new SelectableAttributeTypeOption($akObj->getAttributeKeyID(), $row['optionKey'], $row['optionValue']);
        }


        /**
         * @param AttributeKey $akObj
         * @param string $optionKey
         * @param string $optionValue
         * @param int $displayOrder
         * @return SelectableAttributeTypeOption
         */
        public static function create( AttributeKey $akObj, $optionKey, $optionValue, $displayOrder ){
            $textHelper = Loader::helper('text');
            Loader::db()->Replace(self::$_optionsTableName, array(
                'akID'          => $akObj->getAttributeKeyID(),
                'optionKey'     => str_replace('-', '_', $textHelper->handle( $optionKey ) ),
                'optionValue'   => $textHelper->wordSafeShortText($optionValue, 255, ''),
                'displayOrder'  => $displayOrder
            ), array('akID', 'optionKey'), true);
            return new self($akObj->getAttributeKeyID(), $optionKey, $optionValue);
        }


        /**
         * @param AttributeKey $akObj
         * @return array
         */
        public static function getListByAttributeKey( AttributeKey $akObj = null ){
            $results = array();

            if( $akObj instanceof AttributeKey ){
                $tableName = self::$_optionsTableName;
                $query = Loader::db()->Execute("SELECT optionKey, optionValue FROM {$tableName} WHERE akID = ? ORDER BY displayOrder", array(
                    $akObj->getAttributeKeyID()
                ));

                while( $row = $query->FetchRow() ){
                    array_push($results, new SelectableAttributeTypeOption($akObj->getAttributeKeyID(), $row['optionKey'], $row['optionValue']));
                }
            }

            return $results;
        }


        /**
         * @param AttributeKey $akObj
         * @return void
         */
        public static function purgeAllForAttributeKey( AttributeKey $akObj ){
            $tableName = self::$_optionsTableName;
            Loader::db()->Execute("DELETE FROM {$tableName} WHERE akID = ?", array(
                $akObj->getAttributeKeyID()
            ));
        }

    }