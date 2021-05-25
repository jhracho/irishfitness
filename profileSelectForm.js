function handleSelection(choice) {
    document.getElementById("residence-div").style.display="none";
    document.getElementById("goal-div").style.display="none";
    document.getElementById("height-div").style.display="none";
    document.getElementById("weight-div").style.display="none";
    if (choice === "edit-residence"){
        document.getElementById("residence-div").style.display="block";
    }
    else if (choice == "edit-goal"){
        document.getElementById("goal-div").style.display="block";
    }
    else if (choice == "edit-height"){
        document.getElementById("height-div").style.display="block";
    }
    else if (choice == "edit-weight"){
        document.getElementById("weight-div").style.display="block";
    }
}