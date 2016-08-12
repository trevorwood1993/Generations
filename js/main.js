function loadAllLines(){
  // alert("ran Main");
  $('.horizontalLinkLine').remove();
  $('.lastnameFirst').remove();
  $('.lastnameLast').remove();
  // for(x = 1; x <= currentLinkNumber; x++){
  x = 1;
  y = 1;
  while(x < 1000){
    var startLink   = ".lineLinkStart"+x,
          endLink   = ".lineLinkEnd"+x;

    if($(startLink).length){
      if($(endLink).length){
        //start
        //end
        var startLinkPosition   = $(startLink).offset().left,
            endLinkPosition     = $(endLink).last().offset().left,
            distance            = endLinkPosition - startLinkPosition + 3;
        margin = "";

        $(startLink).append('<div class="horizontalLinkLine" style="width:'+distance+'px;"></div>');
      }else{
        var margin = "";
        var imgLocation = $(startLink).next();
        if(imgLocation.hasClass("bigimg")){
          // alert()
          var temp = $(startLink).parent().parent().children('div.links').length;
          if(temp == 2){
            //married //bigimg married
            distance = 27;
          }else{
            //single //bigimg
            distance = 16;
          }    
        }else{
          var temp = $(startLink).parent().parent().children('div.links').length;
          if(temp == 2){
            //married //small image married
            distance = 19;
            var margin = "margin-left:-19px;";
          }else{
            //single //smallimg
            distance = 12;
          }
        }
        $(startLink).append('<div class="horizontalLinkLine" style="'+margin+'width:'+distance+'px;"></div>');
      }

      var lastname = $(startLink).parent().find(".lastname").val();
      $(startLink).prepend('<div style="'+margin+'" class="lastnameFirst"><h2>'+lastname+'</h2></div>');

      if(distance >= 150){
        var marginleft = distance - 80;
        $(startLink).prepend('<div class="lastnameLast" style="margin-left:'+marginleft+'px;"><h2>'+lastname+'</h2></div>');
      }


    }else{
      // alert("broke: "+x);
      // if(){
      //   break;
      // }
    }
    x++;
  }
}


$(document).on("click",".factionAnnoucements li",function(){
  var personid        = $(this).val(),
      personidclass   = $('.personid').filter(function(){ return this.value==personid }),
      links           = personidclass.parent().parent(),
      ul              = links.parent().parent().parent(),
      img             = links.find("img").end();


  // var foo = personidclass.val();
  // alert(foo);

  img.css({"box-shadow":"0px 0px 50px 50px rgba(0,125,250,.8)"});
  setTimeout(function(){ 
    img.css({"box-shadow":"0px 0px 0px 0px rgba(0,125,250,.8)"});
  }, 500);

  var screenwidth  = $(window).width(),
      screenwidth  = screenwidth/2,
      maintreeleft = $('.mainTree').scrollLeft(),
      linksleftpos = links.offset().left + maintreeleft;

  var treeheight  = $('.mainTree').height(),
      treeheight  = treeheight/2,
      maintreetop = $('.mainTree').scrollTop(),
      linkstoppos = links.offset().top + maintreetop;

      // alert("links: "+linkstoppos+" treetop: "+maintreetop+" treeheight: "+treeheight);
  // $('.mainTree').scrollLeft(linksleftpos);

  $('.mainTree').animate({ scrollLeft: linksleftpos-screenwidth, scrollTop: linkstoppos-treeheight  }, 500);
  // alert(position.left);
  //get width location of element
  //get height location of element
  //get screen width
  //get screen height
});

$(document).on("click",'.links',function(){
  var currentyear   = $('.year').text(),
      currentyear   = parseFloat(currentyear),
      personid      = $(this).find(".personid").val(),
      firstname     = $(this).find(".firstname").val(),
      middlename    = $(this).find(".middlename").val(),
      lastname      = $(this).find(".lastname").val(),
      fullname      = firstname+" "+middlename+" "+lastname,
      dob           = $(this).find(".dob").val(),
      age           = currentyear - dob,
      portrait      = $(this).find(".portrait").val(),
      gender        = $(this).find(".gender").val(),
      children      = $(this).find(".children").val(),
      alive         = $(this).find(".alive").val(),
      bio           = $(this).find(".bio").val(),
      deathyear     = $(this).find(".deathyear").val(),
      deathdesc     = $(this).find(".deathdesc").val(),
      fertility     = $(this).find(".fertility").val(),
      deathage      = deathyear - dob;
  
  $('.tableFullname').text(fullname);
  if(gender == 1){//male
    if(alive == 1){
      if(age >= 50){
        //old
        portraitsrc = "/img/roman/old/"+portrait+".png";
      }else if(age >= 14){
        //young
        portraitsrc = "/img/roman/young/"+portrait+".png";
      }else{
        //son
        portraitsrc = "/img/roman/family/son.png";
      }
    }else{
      if(age >= 14 && deathage >= 14){
        //portrait dead
        portraitsrc = "/img/roman/dead/"+portrait+".png";
      }else{
        //son dead
        portraitsrc = "/img/roman/family/dead/son.png";
      }
    }
  }else{//female
    if(alive == 1){
      if(age >= 14){
        //wife 
        portraitsrc = "/img/roman/family/wife.png";
      }else{
        //daughter 
        portraitsrc = "/img/roman/family/daughter.png";
      }
    }else{
      if(age >= 14 && deathage >= 14){
        //wife dead
        portraitsrc = "/img/roman/family/dead/wife.png";
      }else{
        //daughter dead
        portraitsrc = "/img/roman/family/dead/daughter.png";
      }
    }
  }

  $('.personInfoMain img').attr("src",portraitsrc);

  $('.tablePersonid td').text(personid);
  $('.tableBorn td').text(dob);
  if(alive == 1){//alive
    $('.tableDied').hide();
    $('.tableAge').show();
    $('.tableAge td').text(age);
  }else{//dead
    $('.tableAge').hide();
    $('.tableDied').show();
    $('.tableDied td').text(deathyear);
  }
  $('.tableChildren td').text(children);
  $('.tableFertility td').text(fertility);


  $('.personInfoMain').slideDown(200);

  if(alive == 1){
    //hide death
    $('.persionBiosDeath').hide();
  }else{
    //show death
    //insert info
    if(deathdesc == ""){
      deathdesc = "Died of old age";
    }
    $('.persionBiosDeath').show();
    $('.persionBiosDeath p').text(deathdesc);
  }
  $('.persionBiosBio p').text(bio);

  $('.modifyPersonDiv').hide();  
  $('.modifyPersonid').val(personid);
  $('.modifyFirstname').val(firstname);
  $('.modifyMiddlename').val(middlename);
  $('.modifyLastname').val(lastname);
  $('.modifyDob').val(dob);
  $('.modifyPortrait').val(portrait);
  $('.modifyFertility').val(fertility);
  $('.modifyGender').val(gender);
  $('.modifyAlive').val(alive);
  $('.modifyBio').text(bio);
  $('.modifyDeathyear').val(deathyear);
  $('.modifyDeathdesc').text(deathdesc);

});





function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}

$(document).on("mouseover",".links",function(){
  $('.charAge').show();
  $('.charName').show();
  $('.charDob').show();
  var firstname   = $(this).find('.firstname').val(),
      middlename  = $(this).find('.middlename').val(),
      lastname    = $(this).find('.lastname').val(),
      dob         = $(this).find('.dob').val(),
      fullname    = firstname+" "+middlename+" "+lastname,
      fullname    = $.trim(fullname),
      alive       = $(this).find('.alive').val(),
      year        = $('.year').text();
  if(alive == "1"){
    // alert("alive");
    var age       = year - dob;
    $('.charAgeSub').text("Age: ");
  }else{
    // alert("dead");
    var age       = $(this).find('.deathyear').val();
    $('.charAgeSub').text("Died in: ");
  }
      

  $('.charAge span').text(age);
  $('.charNameSub').text(fullname);
  $('.charDob span').text(dob);
});
$(document).on("mouseout",".links",function(){
  $('.charAge').hide();
  $('.charName').hide();
  $('.charDob').hide();
});


updateyearvar = 1;
function updateyear(){
  if(updateyearvar == 1){
    updateyearvar = 0;
    var gameid          = $('.gameid').val(),
        currentyear     = $('.year').text(),
        currentyear     = parseFloat(currentyear),
        nextsemester    = currentyear+0.5;
    $('.year').text(nextsemester);

    // alert(gameid+" "+nextsemester);
    $.ajax({
      method: "POST",
      url: "/endturn/updateyear.php",
      data: {pNextsemester: nextsemester, pGameid:gameid},
      success: function(data){
        //success
        // alert("success");
        updateyearvar = 1;
      }
    });
  }
}


$('.autoChildMarriageRange').change(function(){
  var ACMrangeVal = $('.autoChildMarriageRange').val();
  $('.autoChildMarriageNumber').val(ACMrangeVal);
});
$('.autoChildMarriageNumber').change(function(){
  var ACMnumberVal = $('.autoChildMarriageNumber').val();
  $('.autoChildMarriageRange').val(ACMnumberVal);
});

$('.autoNaturalDisasterRange').change(function(){
  var ANDrangeVal = $('.autoNaturalDisasterRange').val();
  $('.autoNaturalDisasterNumber').val(ANDrangeVal);
});
$('.autoNaturalDisasterNumber').change(function(){
  var ANDnumberVal = $('.autoNaturalDisasterNumber').val();
  $('.autoNaturalDisasterRange').val(ANDnumberVal);
});
deathsarray = [];

updateagesvar = 1;
function updateages(){
  if(updateagesvar == 1){
    updateagesvar = 0;
    var currentyear     = $('.year').text(),
        currentyear     = parseFloat(currentyear);
    $('.dob').each(function(){
      var link = $(this).parent().parent(),
          alive = link.find(".alive").val();
      if(alive == 1){
        var dob = $(this).val(),
            age = currentyear - dob;
        if(age == 50){
          //turn to old portrait
          var thisimg = link.find("img");
          if(thisimg.hasClass("bigimg")){
            var portrait  = $(this).parent().find(".portrait").val(),
                imgsrc    = "/img/roman/old/"+portrait+".png";
            thisimg.attr("src",imgsrc);
          }
        }
        if(age == 14){
          //turn to old portrait
          var thisimg     = link.find("img"),
              thisgender  = link.find(".gender").val(),
              personid    = link.find(".personid").val();
          if(thisgender == 1){
            var portrait  = $(this).parent().find(".portrait").val(),
                imgsrc    = "/img/roman/young/"+portrait+".png";
            thisimg.attr("src",imgsrc);
            link.find(".parentLinkSmall").addClass("parentLinkBig").removeClass("parentLinkSmall");
            thisimg.removeClass("smallimg").addClass("bigimg");
            link.find(".charinfo").append('<input type="text" class="bachelor" value="'+personid+'">');
          }else{
            var imgsrc    = "/img/roman/family/wife.png";
            thisimg.attr("src",imgsrc);
            link.find(".charinfo").append('<input type="text" class="bachelorette" value="'+personid+'">');
          }
        }

        if(age > 50){
          var deathchance; //old age
          switch (true) {
            case (age >= 50 && age < 55)://deathchance = 1%;
              // alert("50-59");
              deathchance = 1;
              break;
            case (age >= 55 && age < 60)://deathchance = 2%;
              // alert("50-59");
              deathchance = 1;
              break;
            case (age >= 60 && age < 70)://deathchance = 4%;
              // alert("60-69");
              deathchance = 4;
              break;
            case (age >= 70 && age < 80)://deathchance = 8%;
              // alert("70-79");
              deathchance = 6;
              break;
            case (age >= 80 && age < 90)://deathchance = 14%;
              // alert("80-89");
              deathchance = 8;
              break;
            case (age >= 90 && age < 100)://deathchance = 20%;
              // alert("90-99");
              deathchance = 10;
              break;
            case (age >= 100)://deathchance = 35%;
              deathchance = 20;
              // alert("100+");
              break;
            default:
              deathchance = 0;
              // alert("younger than 50");
              break;
          }
          var grimreaper = Math.floor((Math.random() * 100) + 1);
          // alert(grimreaper+" "+deathchance);
          if(grimreaper <= deathchance){
            // process death of this character
            var thisimg     = link.find("img"),
                personid   = link.find(".personid").val();

            link.find(".alive").val("0");
            if(thisimg.hasClass("bigimg")){
              var portrait  = $(this).parent().find(".portrait").val(),
                  imgsrc    = "/img/roman/dead/"+portrait+".png";
              thisimg.attr("src",imgsrc);
            }else{//assume smallimg
              var imgsrc    = "/img/roman/family/dead/wife.png";
              thisimg.attr("src",imgsrc);
            }
            var gameid = $('.gameid').val(),
                deathyear     = $('.year').text(),
                deathyear     = parseFloat(deathyear) - 0.5;
            link.find('.deathyear').val(deathyear);

            var firstname = link.find('.firstname').val(),
                middlename = link.find('.middlename').val(), 
                lastname = link.find('.lastname').val(),
                fullname = firstname+" "+middlename+" "+lastname;

            deathsarray[deathsarray.length] = '<li value="'+personid+'">'+fullname+'</li>';


            $.ajax({
              method: "POST",
              url: "/endturn/death.php",
              data: {pGameid: gameid, pPerson_id: personid, pDeathyear:deathyear },
              success: function(data){
                //success
                // alert("success");
              }
            });
          }
        }
      }
    });  
    updateagesvar = 1;
  }
}
newmarriagearray = [];

marriagecheckvar = 1;
function marriagecheck(marryMe){
  if(marriagecheckvar == 1){
    marriagecheckvar = 0;
    $('.bachelor').each(function(){
      var matchmaker = Math.floor((Math.random() * 100) + 1);

      if(marryMe != undefined){
        if(marryMe == $(this).val()){
          matchmaker = 100;
        }else{
          matchmaker = 0;
        }
      }
      
      if(matchmaker >= 80){

        var personid      = $(this).val(),
            dob           = $(this).parent().find(".dob").val(),
            currentyear   = $('.year').text(),
            currentyear   = parseFloat(currentyear),
            age           = currentyear - dob,
            gameid        = $('.gameid').val();

        // links = $(this).parent().parent();

        $(this).remove();
        $.ajax({
          method: "POST",
          url: "/endturn/marrybachelor.php",
          data: { pPerson_id: personid, pAge: age, pCurrentyear: currentyear, pGameid: gameid },
          dataType: "JSON",
          success: function(data){
            var personiddata   = data["value1"],
                newchardata    = data["value2"],
                marriagename   = data["value3"];

            var personidclass = $('.personid').filter(function(){ return this.value==personiddata });

            var links = personidclass.parent().parent();
            links.after(newchardata);
            links.find('.bigimg').after('<div class="coupleLink"></div>');

            // add to married list
            newmarriagearray[newmarriagearray.length] = '<li value="'+personiddata+'">'+marriagename+'</li>';
            
          }
        });
      }
    });

    $('.bachelorette').each(function(){
      var matchmaker = Math.floor((Math.random() * 100) + 1);
      if(marryMe != undefined){
        if(marryMe == $(this).val()){
          matchmaker = 100;
        }else{
          matchmaker = 0;
        }
      }
      if(matchmaker >= 80){//50

        var personid      = $(this).val(),
            dob           = $(this).parent().find(".dob").val(),
            currentyear   = $('.year').text(),
            currentyear   = parseFloat(currentyear),
            age           = currentyear - dob,
            gameid        = $('.gameid').val();

        // links = $(this).parent().parent();

        $(this).remove();
        $.ajax({
          method: "POST",
          url: "/endturn/marrybachelorette.php",
          data: { pPerson_id: personid, pAge: age, pCurrentyear: currentyear, pGameid: gameid },
          dataType: "JSON",
          success: function(data){
            var personiddata   = data["value1"],
                newchardata    = data["value2"],
                marriagename   = data["value3"];

            var personidclass = $('.personid').filter(function(){ return this.value==personiddata });

            var personOrCouple = personidclass.parent().parent().parent();
            personOrCouple.prepend(newchardata);
            personOrCouple.find('.bigimg').after('<div class="coupleLink"></div>');

            newmarriagearray[newmarriagearray.length] = '<li value="'+personiddata+'">'+marriagename+'</li>';

            // add to married list
          }
        });
      }
    });
    //bachelorette
    marriagecheckvar = 1;
  }
}


newbabyarray = [];
function makebaby(fatherid, motherid, fatherlastname, gender, currentLinkNumber){
  // alert('makebaby');
  var fatherclass = 'input.personid[value="'+fatherid+'"]',
      children    = $(fatherclass).parent().find(".children").val();
  if(children == 0){//first child - give link
    passLink = parseInt(currentLinkNumber)+1;
    $('.currentLinkNumber').val(passLink);
  }else{
    passLink = 0;
  }
  var children = parseInt(children)+1;
  $(fatherclass).parent().find(".children").val(children);

  // var temp = $(fatherclass).parent().find(".children").val();
  // alert(temp);

  // alert('started');
  if(gender == undefined){
    var gender = getRandomInt(1,3);
  }else if(gender >= 3){
    var gender = getRandomInt(1,3);
  }else if(gender <= 0){
    var gender = getRandomInt(1,3);
  }
  var gameid        = $('.gameid').val(),
      currentyear   = $('.year').text(),
      currentyear   = parseFloat(currentyear);

  // alert('ajax');
  $.ajax({
    method: "POST",
    url: "/endturn/makebaby.php",
    data: { pFatherid: fatherid, pMotherid: motherid, pFatherlastname: fatherlastname, pGameid: gameid, pGender: gender, pCurrentyear: currentyear, pPassLink: passLink },
    dataType: "JSON",
    success: function(data){
      var fullname = data["value1"],
          maindata = data["value2"],
          personid = data["value3"],
          lineLink = data["value4"]; 
      // alert(fullname+maindata+personid);

      //success
      // alert("success");
      // alert(data);
      var fatherclass = 'input.personid[value="'+fatherid+'"]',
          children    = $(fatherclass).parent().find(".children").val(),
          lielement   = $(fatherclass).parent().parent().parent().parent();
      if(children == 1){
        lielement.append("<ul></ul>");
        var lineLinkFamily = "lineLinkFamily"+lineLink;
        lielement.find(".links").first().append('<div class="coupleFamilyLink '+lineLinkFamily+'"></div>');
      }
      
      lielement.find("ul").first().append(maindata);

      newbabyarray[newbabyarray.length] = '<li value="'+personid+'">'+fullname+'</li>';
      // add to new kid list
    }
  });
}

childbirthvar = 1;
function childbirth(){
  if(childbirthvar == 1){
    childbirthvar = 0;

    babyMasterTuner = 0.5;//this is divided//lower to decrease birthrates
    $('.personOrCouple').each(function(){
      var charinfo   = $(this).find('.charinfo');
      tempChild = [];
      charinfo.each(function(){
        var personid      = $(this).find(".personid").val(),
            firstname     = $(this).find(".firstname").val(),
            middlename    = $(this).find(".middlename").val(),
            lastname      = $(this).find(".lastname").val(),
            dob           = $(this).find(".dob").val(),
            alive         = $(this).find(".alive").first().val(),
            fertility     = $(this).find(".fertility").val(),
            children      = $(this).find(".children").val();
        tempChild[tempChild.length] = {
          "personid":     personid,
          "firstname":    firstname,
          "middlename":   middlename,
          "lastname":     lastname,
          "dob":          dob,
          "alive":        alive,
          "fertility":    fertility,
          "children":     children  
        };
      });

      if(tempChild.length >= 2){
        var alive1 = tempChild[0]['alive'],
            alive2 = tempChild[1]['alive'];
      }else{
        var alive1 = 0,
            alive2 = 0;
      }
      //     alert(alive1+" "+alive2);
      if(alive1 == "1" && alive2 == "1"){
        // alert("both alive");
        var currentyear   = $('.year').text(),
            currentyear   = parseFloat(currentyear), 
            personid1     = tempChild[0]['personid'],
            firstname1    = tempChild[0]['firstname'],
            middlename1   = tempChild[0]['middlename'],
            lastname1     = tempChild[0]['lastname'],
            fertility1    = tempChild[0]['fertility'],
            dob1          = tempChild[0]['dob'],
            age1          = currentyear - dob1,
            personid2     = tempChild[1]['personid'],
            firstname2    = tempChild[1]['firstname'],
            middlename2   = tempChild[1]['middlename'],
            lastname2     = tempChild[1]['lastname'],
            fertility2    = tempChild[0]['fertility'],
            dob2          = tempChild[1]['dob'],
            age2          = currentyear - dob2,
            children      = tempChild[0]['children'];

        //baby makin formula

        

        var ACMnumberModified = $('.autoChildMarriageNumber').val();
        switch (true) {
          case (ACMnumberModified == 1): ACMnumberModified = 10; break;
          case (ACMnumberModified == 2): ACMnumberModified = 9; break;
          case (ACMnumberModified == 3): ACMnumberModified = 8; break;
          case (ACMnumberModified == 4): ACMnumberModified = 7; break;
          case (ACMnumberModified == 5): ACMnumberModified = 6; break;
          case (ACMnumberModified == 6): ACMnumberModified = 5; break;
          case (ACMnumberModified == 7): ACMnumberModified = 4; break;
          case (ACMnumberModified == 8): ACMnumberModified = 3; break;
          case (ACMnumberModified == 9): ACMnumberModified = 2; break;
          case (ACMnumberModified == 10): ACMnumberModified = 1; break;
          default: ACMnumberModified = 0; break;
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
            case (age2 >= 40 && age2 < 50):
              agebabychance = getRandomInt(2,5);
              break;
            case (age2 >= 50 && age2 < 60):
              agebabychance = getRandomInt(4,10);
              break;
            case (age2 >= 60):
              agebabychance = getRandomInt(10,20);
              break;
            default:
              agebabychance = getRandomInt(0,3);
              break;
          }
          var childrenbabychance;
          switch (true) {
            case (children == 0):
              childrenbabychance = 0;
              break;
            case (children >= 1 && children < 3):
              childrenbabychance = getRandomInt(1,4);
              break;
            case (children >= 3 && children < 4):
              childrenbabychance = getRandomInt(3,7);
              break;
            case (children >= 4 && children < 6):
              childrenbabychance = getRandomInt(4,9);
              break;
            case (children >= 6 && children < 9):
              childrenbabychance = getRandomInt(8,16);
              break;
            case (children >= 9 && children < 12):
              childrenbabychance = getRandomInt(8,24);
              break;
            default:
              childrenbabychance = getRandomInt(12,36);
              break;
          }
              
          // already declared, this is for clarification
          // var fertility1 = 4,
          // fertility2 = 4;// 0=sterile 4=average 1=Min 7=Max
          var currentLinkNumber = $('.currentLinkNumber').val();

          var firstMulti = (((agebabychance+childrenbabychance)*2)+20)*ACMnumberModified,
              firstMulti = (firstMulti/fertility1)/fertility2,
              firstMulti = firstMulti/babyMasterTuner,
              firstBaby = getRandomInt(1,firstMulti);
          if(firstBaby == 1){//first baby
            makebaby(personid1, personid2, lastname1, undefined, currentLinkNumber);
          }

          var secondMulti = (((agebabychance+childrenbabychance)*20)+200)*ACMnumberModified,
              secondMulti = (secondMulti/fertility1)/fertility2,
              secondMulti = secondMulti/babyMasterTuner,
              secondBaby = getRandomInt(1,secondMulti);
          if(secondBaby == 1){//secondary baby
            makebaby(personid1, personid2, lastname1, undefined, currentLinkNumber);
          }

          var thirdMulti = (((agebabychance+childrenbabychance)*80)+800)*ACMnumberModified,
              thirdMulti = (thirdMulti/fertility1)/fertility2,
              thirdMulti = thirdMulti/babyMasterTuner,
              thirdBaby = getRandomInt(1,thirdMulti);
          if(thirdBaby == 1){//third baby
            makebaby(personid1, personid2, lastname1, undefined, currentLinkNumber);
          }

          var fourthMulti = (((agebabychance+childrenbabychance)*160)+1600)*ACMnumberModified,
              fourthMulti = (fourthMulti/fertility1)/fertility2,
              fourthMulti = fourthMulti/babyMasterTuner,
              fourthBaby = getRandomInt(1,fourthMulti);
          if(fourthBaby == 1){//fourth baby
            makebaby(personid1, personid2, lastname1, undefined, currentLinkNumber);
          }
        }//if not 0
      }//if both alive
    });
  childbirthvar = 1;
  }
}
function naturalDisasters(){
  autoNaturalDisasterNumber = $('.autoNaturalDisasterNumber').val(),
  autoNaturalDisasterNumber = parseInt(autoNaturalDisasterNumber);
  if(autoNaturalDisasterNumber != 0){
    $('.aliveDisaster').each(function(){
      var gender      = $(this).find(".gender").val();

      if(gender == 1){//male
        random  = getRandomInt(0,1195);
      }else{//female
        random  = getRandomInt(0,1205);
      }

      var temp    = autoNaturalDisasterNumber*8,
          temp2   = (autoNaturalDisasterNumber*10)-temp,
          random  = random + temp2;

      if(random >= 1200){
        var personid    = $(this).find(".personid").val(),
            firstname   = $(this).find(".firstname").val(),
            middlename  = $(this).find(".middlename").val(),
            lastname    = $(this).find(".lastname").val(),
            fullname    = firstname+" "+middlename+" "+lastname+" Random: "+random;
            deathsarray[deathsarray.length] = '<li value="'+personid+'">'+fullname+'</li>';

        var gameid        = $('.gameid').val(),
            gameyear      = $('.year').text(),
            deathyear     = parseFloat(gameyear) - 0.5,
            dob           = $(this).find(".dob").val(),
            age           = gameyear - dob;
        

        var deathcause  = getRandomInt(0,65),
            deathdesc   = "";

        switch(true){
          case (deathcause >= 0 && deathcause < 15):
          deathdesc = "Died of the plague";
          break;
          case (deathcause >= 15 && deathcause < 30):
          deathdesc = "Died from illness";
          break;
          case (deathcause >= 30 && deathcause < 50):
          deathdesc = "Assassinated";
          break;
          default:
          deathdesc = "Died from unknown causes";
          break;
        }  
        //change picture
        if(gender == 1){//male
          if(age >= 14){
            portrait = $(this).find(".portrait").val(),
            portraitsrc = "/img/roman/dead/"+portrait+".png";
          }else{
            portraitsrc = "/img/roman/family/dead/son.png";
          }
        }else{//female
          if(age >= 14){
            portraitsrc = "/img/roman/family/dead/wife.png";
          }else{
            portraitsrc = "/img/roman/family/dead/daughter.png";
          }
        }
        $(this).find('img').attr("src",portraitsrc);
        $(this).find('.alive').val(0);
        $(this).find('.deathyear').val(deathyear);
        $(this).find('.deathdesc').val(deathdesc);
        // plague
        // sickness
        // earthquake
        // fire 
        // flood
        // assassin

        $.ajax({
          method: "POST",
          url: "/endturn/death.php",
          data: {pGameid: gameid, pPerson_id: personid, pDeathyear:deathyear, pDeathdesc:deathdesc },
          success: function(data){
            //success
            // alert("success");
          }
        });
      }
    });
  }
}

function endturn(){
  $('.personInfoMain').slideUp(200);
  $('.factionAnnoucements').slideUp(200);
  updateyear();
  updateages();
  marriagecheck();
  childbirth();
  naturalDisasters();
}

function factionAnnoucements(){
  // alert('factionAnnoucments');

  if(newmarriagearray.length >= 1){
    // alert('passed: '+newmarriagearray[1]);
    $('.marriagesHeader').show();
    $('.marriages').show();
    $('.marriages').find("li").remove();
    for (var i = 0; i < newmarriagearray.length; i++) {
      var temp = newmarriagearray[i];
      $('.marriages').append(temp);
      // alert('appended');
    };
    newmarriagearray = [];
  }else{
    // alert('did not pass: '+newmarriagearray[1]);
    $('.marriages').find("li").remove();
    $('.marriagesHeader').hide();
    $('.marriages').hide();
  }

  if(newbabyarray.length >= 1){
    // alert('passed: '+newbabyarray[1]);
    $('.birthsHeader').show();
    $('.births').show();
    $('.births').find("li").remove();
    for (var i = 0; i < newbabyarray.length; i++) {
      var temp = newbabyarray[i];
      $('.births').append(temp);
      // alert('appended');
    };
    newbabyarray = [];
  }else{
    // alert('did not pass: '+newbabyarray[1]);
    $('.births').find("li").remove();
    $('.birthsHeader').hide();
    $('.births').hide();
  }


  if(deathsarray.length >= 1){
    $('.deathsHeader').show();
    $('.deaths').show();
    $('.deaths').find("li").remove();
    for (var i = 0; i < deathsarray.length; i++) {
      var temp = deathsarray[i];
      $('.deaths').append(temp);
      // alert('appended');
    };
    deathsarray = [];
  }else{
    $('.deaths').find("li").remove();
    $('.deathsHeader').hide();
    $('.deaths').hide();
  }




  var marriagesLiCount    = $('.marriages').find("li").length,
      birthsLiCount       = $('.births').find("li").length,
      deathsLiCount       = $('.deaths').find("li").length;

  if(marriagesLiCount >= 1 || birthsLiCount >= 1 || deathsLiCount >= 1){
    $('.noFactionUpdates').hide();
    $('.factionAnnoucements').slideDown(200);
  }else{
    $('.noFactionUpdates').show();
  }
}


turnchecker = 1;
$('.endTurnButton').on("click",function(){
  if(turnchecker == 1){
    turnchecker = 0;
    $('.grayScreen').fadeIn(100);
    endturn();
    intervalSetter = setInterval(function(){ intervalchecker() }, 250);
  }
});
$('body').keyup(function(e){
  if(e.keyCode == 32){
    if(!$('input').is(':focus') && !$('textarea').is(':focus')){
      if(turnchecker == 1){
        turnchecker = 0;
        $('.grayScreen').fadeIn(100);
        endturn();
        intervalSetter = setInterval(function(){ intervalchecker() }, 250);
      }
    }
  }
});

function intervalchecker(){
  if(updateyearvar == 1 && updateagesvar == 1 && marriagecheckvar == 1 && childbirthvar == 1){
    clearInterval(intervalSetter);
    turnchecker = 1;
    $('.grayScreen').fadeOut(100);
    factionAnnoucements();
    loadAllLines();
  }
}
loadAllLines();





















