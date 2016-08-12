

<div>
	<input class="testage" type="text" placeholder="age" value="16">
	<input class="testchildren" type="text" placeholder="children" value="0">
	<button onclick="go()" type="button">test</button>
	<br><br>
	<p>Turns</p><input class="turns" type="text" value="0" style="width:40px;">
	<p>Babies1</p><input class="babies1" type="text" value="0" style="width:40px;">
	<p>Babies2</p><input class="babies2" type="text" value="0" style="width:40px;">
	<p>Babies3</p><input class="babies3" type="text" value="0" style="width:40px;">
	<p>Babies4</p><input class="babies4" type="text" value="0" style="width:40px;">
</div>


<script type="text/javascript">

function diminishing_returns(val, scale) {
    if(val < 0)
      return -diminishing_returns(-val, scale);
    var mult = val / scale;
    var trinum = (Math.sqrt(8.0 * mult + 1.0) - 1.0) / 2.0;
    return trinum * scale;
}
function tester(){
	var test = $('.babies').val();
	var go = diminishing_returns(test,1);
	alert(go);
}



function testbaby () {
	var babyMasterTuner = 1;//this is divided
	var ACMnumberModified = $('.autoChildMarriageNumber').val();
	switch (true) {
    case (ACMnumberModified == 1):
      ACMnumberModified = 10;
      break;
    case (ACMnumberModified == 2):
      ACMnumberModified = 9;
      break;
    case (ACMnumberModified == 3):
      ACMnumberModified = 8;
      break;
    case (ACMnumberModified == 4):
      ACMnumberModified = 7;
      break;
    case (ACMnumberModified == 5):
      ACMnumberModified = 6;
      break;
    case (ACMnumberModified == 6):
      ACMnumberModified = 5;
      break;
    case (ACMnumberModified == 7):
      ACMnumberModified = 4;
      break;
    case (ACMnumberModified == 8):
      ACMnumberModified = 3;
      break;
    case (ACMnumberModified == 9):
      ACMnumberModified = 2;
      break;
    case (ACMnumberModified == 10):
      ACMnumberModified = 1;
      break;
    default:
      ACMnumberModified = 0;
      break;
  }

  if(ACMnumberModified != 0){
		var age2 = $('.testage').val(),
				children = $('.testchildren').val();
		var agebabychance;
    switch (true) {
      case (age2 >= 14 && age2 < 21):
        agebabychance = getRandomInt(0,1);
        break;
      case (age2 >= 21 && age2 < 30):
        agebabychance = getRandomInt(0,2);
        break;
      case (age2 >= 30 && age2 < 40):
        agebabychance = getRandomInt(0,3);
        break;
      default:
        agebabychance = getRandomInt(0,4);
        break;
    }
    var childrenbabychance;
    switch (true) {
      case (children == 0):
        childrenbabychance = getRandomInt(0,2);
        break;
      case (children >= 1 && children < 3):
        childrenbabychance = 0;
        break;
      case (children >= 3 && children < 4):
        childrenbabychance = getRandomInt(0,2);
        break;
      case (children >= 4 && children < 6):
        childrenbabychance = getRandomInt(0,3);
        break;
      case (children >= 6):
        childrenbabychance = getRandomInt(0,4);
        break;
      default:
        childrenbabychance = getRandomInt(0,4);
        break;
    }
	      
    var fertility1 = 4,
    		fertility2 = 4;//1-5

    var firstMulti = (((agebabychance+childrenbabychance)*2)+20)*ACMnumberModified,
        firstMulti = (firstMulti/fertility1)/fertility2,
        firstMulti = firstMulti/babyMasterTuner,
        firstBaby = getRandomInt(1,firstMulti);
    if(firstBaby == 1){//secondary baby
      var babiesval = $('.babies1').val(),
          babiesval = parseInt(babiesval)+1;
      $('.babies1').val(babiesval);
    }

    var secondMulti = (((agebabychance+childrenbabychance)*20)+200)*ACMnumberModified,
        secondMulti = (secondMulti/fertility1)/fertility2,
        secondMulti = secondMulti/babyMasterTuner,
        secondBaby = getRandomInt(1,secondMulti);
    if(secondBaby == 1){//secondary baby
      var babiesval = $('.babies2').val(),
          babiesval = parseInt(babiesval)+1;
      $('.babies2').val(babiesval);
    }

    var thirdMulti = (((agebabychance+childrenbabychance)*80)+800)*ACMnumberModified,
        thirdMulti = (thirdMulti/fertility1)/fertility2,
        thirdMulti = thirdMulti/babyMasterTuner,
        thirdBaby = getRandomInt(1,thirdMulti);
    if(thirdBaby == 1){//third baby
      var babiesval = $('.babies3').val(),
          babiesval = parseInt(babiesval)+1;
      $('.babies3').val(babiesval);
    }

    var fourthMulti = (((agebabychance+childrenbabychance)*160)+1600)*ACMnumberModified,
        fourthMulti = (fourthMulti/fertility1)/fertility2,
        fourthMulti = fourthMulti/babyMasterTuner,
        fourthBaby = getRandomInt(1,fourthMulti);
    if(fourthBaby == 1){//fourth baby
      var babiesval = $('.babies4').val(),
          babiesval = parseInt(babiesval)+1;
      $('.babies4').val(babiesval);
    }


    var turnsval = $('.turns').val(),
    		turnsval = parseInt(turnsval)+1;
   	$('.turns').val(turnsval);
	}//if not 0
}

function go(){
	for (var i = 0; i < 1000; i++) {
		testbaby();
	};
}

</script>