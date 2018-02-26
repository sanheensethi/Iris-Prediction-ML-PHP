<?php
	$irisFileDatas = file("iris.csv");
	$testFileDatas = file("test.csv");
	
	main($irisFileDatas,$testFileDatas);
	
	function training(Array $trainingDatas){
		foreach($trainingDatas as $trainingData){
			$SepalRatio = $trainingData[0]/$trainingData[1];
			$PetalRatio = $trainingData[2]/$trainingData[3];
			$learnedData[] = explode(",",$SepalRatio.",".$PetalRatio);
		/*	$learnedData[]=$data; */
			$labelData[]=$trainingData[4];
		}
		$Data=[];
		$Data[]=$learnedData;
		$Data[]=$labelData;
		return $Data;
	}
	
	function test(Array $testDatas){
		foreach($testDatas as $testData){
			$SepalRatio = $testData[0]/$testData[1];
			$PetalRatio = $testData[2]/$testData[3];
		//	$data = $SepalRatio/$PetalRatio;
		//	$testingData[]=$data;
			$labelData[]=$testData[4];
			$testingData[] = explode(",",$SepalRatio.",".$PetalRatio);
		}
		//	return $data;
		$Data[]=$testingData;
		$Data[]=$labelData;
		return $Data;
	}
	
	function Predict(array $TrainingDataSets, array $SearchSets){
		for($i=0;$i<count($SearchSets);$i++){
			$distanceArray=[];
			foreach($TrainingDataSets as $TrainingVal){
				$x=$SearchSets[$i][0]-$TrainingVal[0];
				$y=$SearchSets[$i][1]-$TrainingVal[1];
				$x2 = pow($x,2); // square of x
				$y2 = pow($y,2); // square of y
				$dis = sqrt(($x2+$y2));
				$distanceArray[] =$dis;
			}
				$keys[] = array_keys($distanceArray,min($distanceArray));
		}
		return ($keys);
	}
	
	function accuracy(Array $predictedDatas , Array $actualData){
		$i=0;
		$correct = 0;
		$fail = 0;
		foreach($predictedDatas as $predictedData){
			if($predictedData == $actualData[$i]){
				$correct+=1;
			}else{
				$fail+=1;
			}
			$i++;
		}
		return (($correct+1)/count($predictedDatas))*100;
	}
	
	function main($irisFileDatas,$testFileDatas){
	$irisData=[];
	$testData=[];
	echo "<pre>";
	
	foreach($irisFileDatas as $irisFileData){
	$irisData[] = explode(",",trim($irisFileData," "));
	}
	
	foreach($testFileDatas as $testFileData){
	$testData[] = explode(",",trim($testFileData," "));
	}
	
	//Training Data Calculation
	$TrainingData = training($irisData);
	
	$trainData = $TrainingData[0];
	$labeledData = $TrainingData[1];
	
	$TestData = test($testData);
	$testData = $TestData[0];
	$testActualLabel = $TestData[1];
	$keys = Predict($trainData,$testData);
	
	foreach($keys as $key){
	$predictedData[] =  $labeledData[$key[0]];
	}
	
	echo "<h2>Given 139 Sets of Data For Training</h2>";
	echo "<h2>Testing Data : </h2>";
	var_dump($testFileDatas);
	
	echo "<h1>Predicted Species : </h1>";
	var_dump($predictedData);
	
	echo "<h1>Actual Species : </h1>";
	var_dump($testActualLabel);
	
	echo "<h1>Accuracy : ".accuracy($predictedData,$testActualLabel)."%</h1>";
	}
	
?>