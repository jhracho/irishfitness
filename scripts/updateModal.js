function updateBreakfast(location){
    switch(location){
        case "North Dining Hall":
            loadBreakfastData(1);
            break;
        case "South Dining Hall":
            loadBreakfastData(2);
            break;
        case "Custom Food":
			loadBreakfastData(3);
            break;
		case "Pre-Saved Breakfast":
			loadBreakfastData(4);
			break;
    }
}

function loadBreakfastData(val){
     switch(val){
        case 1:
            $('#breakfast-food-selection').load('scripts/getMealModalContent.php?meal=B&location=NDH',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
        case 2:
            $('#breakfast-food-selection').load('scripts/getMealModalContent.php?meal=B&location=SDH',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
        case 3:
			$('#breakfast-food-selection').load('scripts/getMealModalContent.php?meal=B&location=Custom',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 4:
			$('#breakfast-food-selection').load('scripts/getMealModalContent.php?location=Saved',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
    }
}

function updateLunch(location){
	//alert("updateLunch");
    switch(location){
        case "North Dining Hall":
            loadLunchData(1);
            break;
        case "South Dining Hall":
            loadLunchData(2);
            break;
        case "Custom Food":
			loadLunchData(3);
            break;
		case "Pre-Saved Lunch":
			loadLunchData(4);
			break;
		case "Smashburger":
			loadLunchData(5);
			break;
		case "Taco Bell":
			loadLunchData(6);
			break;
		case "Modern Market":
			loadLunchData(7);
			break;
		case "Star Ginger":
			loadLunchData(8);
			break;
		case "Subway":
			loadLunchData(9);
			break;
    }
}

function loadLunchData(val){
     switch(val){
        case 1:
            $('#lunch-food-selection').load('scripts/getMealModalContent.php?meal=L&location=NDH',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
        case 2:
            $('#lunch-food-selection').load('scripts/getMealModalContent.php?meal=L&location=SDH',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
        case 3:
			$('#lunch-food-selection').load('scripts/getMealModalContent.php?meal=L&location=Custom',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 4:
			$('#lunch-food-selection').load('scripts/getMealModalContent.php?location=Saved',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 5:
			$('#lunch-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=L&location=Smashburger',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 6:
			$('#lunch-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=L&location=TacoBell',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 7:
			$('#lunch-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=L&location=ModMark',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 8:
			$('#lunch-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=L&location=StarGinger',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 9:
			$('#lunch-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=L&location=Subway',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
    }
}

function updateDinner(location){
    switch(location){
        case "North Dining Hall":
            loadDinnerData(1);
            break;
        case "South Dining Hall":
            loadDinnerData(2);
            break;
        case "Custom Food":
			loadDinnerData(3);
            break;
		case "Pre-Saved Dinner":
			loadDinnerData(4);
			break;
		case "Smashburger":
			loadDinnerData(5);
			break;
		case "Taco Bell":
			loadDinnerData(6);
			break;
		case "Modern Market":
			loadDinnerData(7);
			break;
		case "Star Ginger":
			loadDinnerData(8);
			break;
		case "Subway":
			loadDinnerData(9);
			break;
    }
}

function loadDinnerData(val){
     switch(val){
        case 1:
            $('#dinner-food-selection').load('scripts/getMealModalContent.php?meal=D&location=NDH',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
        case 2:
            $('#dinner-food-selection').load('scripts/getMealModalContent.php?meal=D&location=SDH',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
        case 3:
			$('#dinner-food-selection').load('scripts/getMealModalContent.php?meal=D&location=Custom',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 4:
			$('#dinner-food-selection').load('scripts/getMealModalContent.php?location=Saved',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 5:
			$('#dinner-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=D&location=Smashburger',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 6:
			$('#dinner-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=D&location=TacoBell',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 7:
			$('#dinner-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=D&location=ModMark',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 8:
			$('#dinner-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=D&location=StarGinger',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 9:
			$('#dinner-food-selection').load('scripts/getMealModalContent.php?flex=1&meal=D&location=Subway',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
    }
}

function updateSnack(location){
    switch(location){
        case "Custom Food":
			loadSnackData(3);
            break;
		case "Pre-Saved Breakfast":
			loadSnackData(4);
			break;
    }
}

function loadSnackData(val){
     switch(val){
        case 3:
			$('#snack-food-selection').load('scripts/getMealModalContent.php?meal=S&location=Custom',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
		case 4:
			$('#snack-food-selection').load('scripts/getMealModalContent.php?location=Saved',function(){
                //$('#breakfast-modal').modal({show:true});
            });
            break;
    }
}
