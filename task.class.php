<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        
        $this->TaskId = $this->getUniqueId();
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
        
        $tempRecord = new stdClass;
        $tempRecord->TaskId = $this->TaskId;
        $tempRecord->TaskName = $this->TaskName;
        $tempRecord->TaskDescription = $this->TaskDescription;
        array_push($this->TaskDataSource,$tempRecord);
        
        $taskDataSourceJson = json_encode($this->TaskDataSource);
        $jsonDataFile = fopen("Task_Data.txt", "w") or die("Unable to open file!");
        fwrite($jsonDataFile, $taskDataSourceJson);
        fclose($jsonDataFile);
        $result['success'] = "true";
        $result['message'] = "New record was created";
        return $result;
    }
    
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        $newId = 0;
        for($i = 0;$i < count($this->TaskDataSource);$i++)
        {
            if(isset($this->TaskDataSource[$i])){
                if($this->TaskDataSource[$i]->TaskId >= $newId){
                    $newId = $this->TaskDataSource[$i]->TaskId + 1;
                }
            }
        }
        return $newId; // Placeholder return for now
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...
            
            $result = false;
            for ($i = 0;$i < count($this->TaskDataSource);$i++){
                if($Id == $this->TaskDataSource[$i]->TaskId)
                {
                    $this->TaskId = $Id;
                    $this->TaskName = $this->TaskDataSource[$i]->TaskName;
                    $this->TaskDescription = $this->TaskDataSource[$i]->TaskDescription;
                    $result = true;
                }
            }
        } 
        else
        {
            $result = false;
        }
            return $result;
    }

    public function Save($taskName, $taskDescription) {
        //Assignment: Code to save task here
        try{
            for($i = 0;$i < count($this->TaskDataSource);$i++)
            {
                if(isset($this->TaskDataSource[$i])){
                    if($this->TaskDataSource[$i]->TaskId == $this->TaskId){
                        $this->TaskDataSource[$i]->TaskName = $taskName;
                        $this->TaskDataSource[$i]->TaskDescription = $taskDescription;
                    }
                }
            }
            
            $taskDataSourceJson = json_encode($this->TaskDataSource);
            $jsonDataFile = fopen("Task_Data.txt", "w") or die("Unable to open file!");
            fwrite($jsonDataFile, $taskDataSourceJson);
            fclose($jsonDataFile);
            $result['success'] = "true";
            $result['message'] = "Your data was saved successfully";
        }
        catch(Exception $e){
            $result['success'] = "false";
            $result['message'] = 'Error occurred:'. $e->getMessage();
        }
        return $result;
    }
    
    public function Delete($taskId) {
        //Assignment: Code to delete task here
        try{
            for($i = 0;$i < count($this->TaskDataSource);$i++)
            {
                if(isset($this->TaskDataSource[$i])){
                    if($this->TaskDataSource[$i]->TaskId == $taskId){
                        unset($this->TaskDataSource[$i]);
                        $this->TaskDataSource = array_values($this->TaskDataSource);
                    }
                }
            }
            
            $taskDataSourceJson = json_encode($this->TaskDataSource);
            $jsonDataFile = fopen("Task_Data.txt", "w") or die("Unable to open file!");
            fwrite($jsonDataFile, $taskDataSourceJson);
            fclose($jsonDataFile);
            $result['success'] = "true";
            $result['message'] = "Your data was deleted successfully";
        }
        catch(Exception $e){
            $result['success'] = "false";
            $result['message'] = 'Error occurred:'. $e->getMessage();
        }
        return $result;
    }
}

?>